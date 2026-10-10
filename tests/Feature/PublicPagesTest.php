<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_renders(): void
    {
        $this->get(route('home'))
            ->assertOk()
            ->assertSee(config('company.name'))
            ->assertSee('Layanan kami');
    }

    public function test_about_services_and_contact_pages_render(): void
    {
        $this->get(route('about'))->assertOk()->assertSee('Tentang');
        $this->get(route('services'))->assertOk()->assertSee('Pembuatan Website');
        $this->get(route('contact'))->assertOk()->assertSee('Kirim pesan');
    }
}

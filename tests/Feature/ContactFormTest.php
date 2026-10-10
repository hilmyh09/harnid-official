<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    private function validPayload(array $overrides = []): array
    {
        return array_merge([
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'phone' => '08123456789',
            'subject' => 'Tanya penawaran',
            'message' => 'Saya ingin membuat website profil perusahaan.',
        ], $overrides);
    }

    public function test_valid_message_is_stored(): void
    {
        $this->post(route('contact.store'), $this->validPayload())
            ->assertRedirect(route('contact'))
            ->assertSessionHas('status');

        $this->assertDatabaseHas('contact_messages', [
            'email' => 'budi@example.com',
            'subject' => 'Tanya penawaran',
            'read_at' => null,
        ]);
    }

    public function test_invalid_message_is_rejected(): void
    {
        $this->from(route('contact'))
            ->post(route('contact.store'), $this->validPayload(['email' => 'bukan-email', 'message' => 'pendek']))
            ->assertRedirect(route('contact'))
            ->assertSessionHasErrors(['email', 'message']);

        $this->assertSame(0, ContactMessage::count());
    }

    public function test_honeypot_blocks_bots(): void
    {
        $this->post(route('contact.store'), $this->validPayload(['website' => 'http://spam.example']))
            ->assertSessionHasErrors('website');

        $this->assertSame(0, ContactMessage::count());
    }
}

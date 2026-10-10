<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_renders(): void
    {
        $this->get(route('login'))->assertOk()->assertSee('Masuk');
    }

    public function test_user_can_login_with_correct_credentials(): void
    {
        $user = User::factory()->create(['password' => 'rahasia123']);

        $this->post(route('login.store'), ['email' => $user->email, 'password' => 'rahasia123'])
            ->assertRedirect(route('admin.dashboard'));

        $this->assertAuthenticatedAs($user);
    }

    public function test_login_fails_with_wrong_password(): void
    {
        $user = User::factory()->create(['password' => 'rahasia123']);

        $this->from(route('login'))
            ->post(route('login.store'), ['email' => $user->email, 'password' => 'salah'])
            ->assertRedirect(route('login'))
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_login_is_rate_limited_after_five_failures(): void
    {
        $user = User::factory()->create(['password' => 'rahasia123']);

        for ($i = 0; $i < 5; $i++) {
            $this->post(route('login.store'), ['email' => $user->email, 'password' => 'salah']);
        }

        $this->post(route('login.store'), ['email' => $user->email, 'password' => 'rahasia123'])
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_dashboard_requires_authentication(): void
    {
        $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
    }

    public function test_authenticated_user_sees_dashboard_and_messages(): void
    {
        $user = User::factory()->create();
        ContactMessage::factory()->create(['subject' => 'Subjek uji dashboard']);

        $this->actingAs($user)
            ->get(route('admin.messages.index'))
            ->assertOk()
            ->assertSee('Subjek uji dashboard')
            ->assertSee('belum dibaca');
    }

    public function test_authenticated_user_can_mark_message_as_read(): void
    {
        $user = User::factory()->create();
        $message = ContactMessage::factory()->create();

        $this->actingAs($user)
            ->patch(route('admin.messages.read', $message))
            ->assertRedirect();

        $this->assertNotNull($message->fresh()->read_at);
    }

    public function test_guest_cannot_mark_message_as_read(): void
    {
        $message = ContactMessage::factory()->create();

        $this->patch(route('admin.messages.read', $message))->assertRedirect(route('login'));

        $this->assertNull($message->fresh()->read_at);
    }

    public function test_user_can_logout(): void
    {
        $user = User::factory()->create();

        $this->actingAs($user)->post(route('admin.logout'))->assertRedirect(route('home'));

        $this->assertGuest();
    }
}

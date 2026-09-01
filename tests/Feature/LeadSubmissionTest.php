<?php

namespace Tests\Feature;

use App\Livewire\ContactForm;
use App\Models\User;
use App\Notifications\NewLeadNotification;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification;
use Livewire\Livewire;
use Tests\TestCase;

class LeadSubmissionTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_form_requires_name_and_phone(): void
    {
        Livewire::test(ContactForm::class)
            ->set('name', '')
            ->set('phone', '')
            ->call('submit')
            ->assertHasErrors(['name', 'phone']);

        $this->assertDatabaseCount('leads', 0);
    }

    public function test_contact_form_rejects_invalid_email(): void
    {
        Livewire::test(ContactForm::class)
            ->set('name', 'Jane Doe')
            ->set('phone', '+201234567890')
            ->set('email', 'not-an-email')
            ->call('submit')
            ->assertHasErrors(['email']);

        $this->assertDatabaseCount('leads', 0);
    }

    public function test_valid_submission_stores_lead_and_notifies_admins(): void
    {
        Notification::fake();

        $admin = User::factory()->superAdmin()->create();

        Livewire::test(ContactForm::class)
            ->set('name', 'Jane Doe')
            ->set('phone', '+201234567890')
            ->set('email', 'jane@example.com')
            ->set('message', 'I am interested in a property.')
            ->call('submit')
            ->assertSet('submitted', true)
            ->assertHasNoErrors();

        $this->assertDatabaseHas('leads', [
            'name' => 'Jane Doe',
            'phone' => '+201234567890',
            'email' => 'jane@example.com',
            'message' => 'I am interested in a property.',
            'source' => 'contact',
            'status' => 'new',
        ]);

        Notification::assertSentTo($admin, NewLeadNotification::class);
    }

    public function test_honeypot_field_prevents_lead_creation(): void
    {
        Notification::fake();

        User::factory()->superAdmin()->create();

        Livewire::test(ContactForm::class)
            ->set('website', 'https://spam.example')
            ->set('name', 'Bot User')
            ->set('phone', '+201111111111')
            ->call('submit')
            ->assertSet('submitted', true);

        $this->assertDatabaseCount('leads', 0);
        Notification::assertNothingSent();
    }

    public function test_contact_form_is_rate_limited_after_five_submissions(): void
    {
        Notification::fake();

        User::factory()->superAdmin()->create();

        for ($i = 0; $i < 5; $i++) {
            Livewire::test(ContactForm::class)
                ->set('name', 'Jane Doe '.$i)
                ->set('phone', '+20123456789'.$i)
                ->call('submit')
                ->assertHasNoErrors();
        }

        Livewire::test(ContactForm::class)
            ->set('name', 'Jane Doe')
            ->set('phone', '+201234567890')
            ->call('submit')
            ->assertHasErrors(['phone']);

        $this->assertDatabaseCount('leads', 5);
        Notification::assertSentTimes(NewLeadNotification::class, 5);
    }
}

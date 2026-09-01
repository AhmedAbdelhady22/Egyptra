<?php

namespace App\Livewire;

use App\Enums\LeadStatus;
use App\Http\Requests\ContactFormRequest;
use App\Models\Lead;
use App\Models\User;
use App\Notifications\NewLeadNotification;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\RateLimiter;
use Livewire\Component;

class ContactForm extends Component
{
    public string $name = '';

    public string $phone = '';

    public string $email = '';

    public string $message = '';

    public string $website = '';

    public ?int $propertyId = null;

    public bool $submitted = false;

    public function mount(?int $propertyId = null): void
    {
        $this->propertyId = $propertyId;
    }

    public function submit(): void
    {
        if ($this->website !== '') {
            $this->submitted = true;

            return;
        }

        $rateLimitKey = 'contact-form:'.request()->ip();

        if (RateLimiter::tooManyAttempts($rateLimitKey, 5)) {
            $this->addError('phone', __('Too many submissions. Please try again in a minute.'));

            return;
        }

        $rules = (new ContactFormRequest)->rules();
        unset($rules['property_id']);

        $validated = $this->validate($rules);

        RateLimiter::hit($rateLimitKey, 60);

        $lead = Lead::query()->create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'] ?? null,
            'message' => $validated['message'] ?? null,
            'property_id' => $this->propertyId,
            'status' => LeadStatus::New,
            'source' => $this->propertyId ? 'property' : 'contact',
        ]);

        User::query()
            ->where('is_super_admin', true)
            ->each(fn (User $user) => $user->notify(new NewLeadNotification($lead)));

        $this->reset(['name', 'phone', 'email', 'message', 'website']);
        $this->submitted = true;
    }

    public function render(): View
    {
        return view('livewire.contact-form');
    }
}

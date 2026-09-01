<div>
    @if ($submitted)
        <div class="rounded-sm border border-teal-200 bg-teal-50 px-4 py-3 text-sm text-teal-800">
            {{ __('Thank you! We will contact you shortly.') }}
        </div>
    @else
        <form wire:submit="submit" class="space-y-4">
            <div class="absolute -left-[9999px]" aria-hidden="true">
                <label for="website">{{ __('Website') }}</label>
                <input type="text" id="website" wire:model="website" tabindex="-1" autocomplete="off">
            </div>

            <div>
                <label for="contact-name" class="mb-1.5 block text-sm font-medium text-ink-700">{{ __('Name') }} *</label>
                <input type="text" id="contact-name" wire:model="name"
                       class="input-brand">
                @error('name') <p class="mt-1 text-xs text-accent">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="contact-phone" class="mb-1.5 block text-sm font-medium text-ink-700">{{ __('Phone') }} *</label>
                <input type="tel" id="contact-phone" wire:model="phone"
                       class="input-brand">
                @error('phone') <p class="mt-1 text-xs text-accent">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="contact-email" class="mb-1.5 block text-sm font-medium text-ink-700">{{ __('Email') }}</label>
                <input type="email" id="contact-email" wire:model="email"
                       class="input-brand">
                @error('email') <p class="mt-1 text-xs text-accent">{{ $message }}</p> @enderror
            </div>

            <div>
                <label for="contact-message" class="mb-1.5 block text-sm font-medium text-ink-700">{{ __('Message') }}</label>
                <textarea id="contact-message" wire:model="message" rows="4"
                          class="input-brand"></textarea>
                @error('message') <p class="mt-1 text-xs text-accent">{{ $message }}</p> @enderror
            </div>

            <button type="submit"
                    wire:loading.attr="disabled"
                    class="btn-primary w-full disabled:opacity-60">
                <span wire:loading.remove>{{ __('Send Message') }}</span>
                <span wire:loading>{{ __('Sending...') }}</span>
            </button>
        </form>
    @endif
</div>

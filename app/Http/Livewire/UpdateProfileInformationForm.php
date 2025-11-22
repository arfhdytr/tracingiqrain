<?php
// app/Http/Livewire/UpdateProfileInformationForm.php

namespace App\Http\Livewire;

use Illuminate\Support\Facades\Auth;
use Laravel\Jetstream\Http\Livewire\UpdateProfileInformationForm as JetstreamUpdateProfileInformationForm;

class UpdateProfileInformationForm extends JetstreamUpdateProfileInformationForm
{
    /**
     * Prepare the component.
     */
    public function mount(): void
    {
        $user = Auth::user();

        $this->state = $user->withoutRelations()->toArray();

        // Pastikan email ada di state (untuk mentor)
        if ($user->hasRole('mentor')) {
            $this->state['email'] = $user->mentor->email ?? '';
            $this->state['no_wa'] = $user->mentor->no_wa ?? '';
        }
    }

    /**
     * Update the user's profile information.
     */
    public function updateProfileInformation(\Laravel\Fortify\Contracts\UpdatesUserProfileInformation $updater): void
    {
        $this->resetErrorBag();

        $updater->update(
            Auth::user(),
            $this->photo
                ? array_merge($this->state, ['photo' => $this->photo])
                : $this->state
        );

        if (isset($this->photo)) {
            return;
        }

        $this->dispatch('saved');

        $this->dispatch('refresh-navigation-menu');
    }

    /**
     * Get the current user of the application.
     */
    public function getUserProperty(): mixed
    {
        return Auth::user();
    }
}

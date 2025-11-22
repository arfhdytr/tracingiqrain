{{-- resources/views/profile/update-profile-information-form.blade.php --}}
<x-form-section submit="updateProfileInformation">
    <x-slot name="title">
        {{ __('Informasi Profil') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Perbarui informasi profil akun Anda.') }}
    </x-slot>

    <x-slot name="form">
        {{-- Photo Upload --}}
        @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
            <div x-data="{photoName: null, photoPreview: null}" class="col-span-6 sm:col-span-4">
                <input type="file" id="photo" class="hidden"
                            wire:model.live="photo"
                            x-ref="photo"
                            x-on:change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => {
                                        photoPreview = e.target.result;
                                    };
                                    reader.readAsDataURL($refs.photo.files[0]);
                            " />

                <x-label for="photo" value="{{ __('Foto Profil') }}" />

                {{-- Current Photo --}}
                <div class="mt-2" x-show="! photoPreview">
                    <img src="{{ $this->user->getAvatarUrlAttribute() }}" alt="{{ $this->user->username }}" class="rounded-full h-20 w-20 object-cover" lazyload>
                </div>

                {{-- Photo Preview --}}
                <div class="mt-2" x-show="photoPreview" style="display: none;">
                    <span class="block rounded-full w-20 h-20 bg-cover bg-no-repeat bg-center"
                          x-bind:style="'background-image: url(\'' + photoPreview + '\');'">
                    </span>
                </div>
                
                {{-- Select New Photo Button --}}
                <button 
                    type="button" 
                    class="hover:cursor-pointer inline-flex items-center px-4 py-2 bg-pink-500 text-white border border-pink-500 rounded-md font-semibold text-xs uppercase tracking-widest shadow-sm hover:bg-pink-600 hover:border-pink-600 focus:outline-none focus:ring-2 focus:ring-pink-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 disabled:opacity-25 transition ease-in-out duration-150 mt-2 me-2" 
                    x-on:click.prevent="$refs.photo.click()">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 me-1 -ms-1" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4.586-4.586a2 2 0 012.828 0L14 13.172V5h2v10zM5 7a1 1 0 100-2 1 1 0 000 2z" clip-rule="evenodd" />
                    </svg>
                    {{ __('Pilih Foto Baru') }}
                </button>

                {{-- Remove Photo Button --}}
                @if ($this->user->profile_photo_path)
                    <x-secondary-button type="button" class="mt-2" wire:click="deleteProfilePhoto">
                        <i class="fas fa-trash mr-2"></i>
                        {{ __('Hapus Foto') }}
                    </x-secondary-button>
                @endif

                <x-input-error for="photo" class="mt-2" />
            </div>
        @endif

        {{-- Username Field --}}
        <div class="col-span-6 sm:col-span-4">
            <x-label for="username" value="{{ __('Username') }}" />
            <x-input id="username" type="text" class="mt-1 block w-full" wire:model="state.username" required autocomplete="username" />
            <x-input-error for="username" class="mt-2" />
            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                <i class="fas fa-info-circle mr-1"></i>
                Username hanya boleh mengandung huruf, angka, dash, dan underscore.
            </p>
        </div>

        {{-- No WhatsApp Field (Only for Mentor) --}}
        @if(Auth::user()->hasRole('mentor'))
            <div class="col-span-6 sm:col-span-4">
                <x-label for="no_wa" value="{{ __('Nomor WhatsApp') }}" />
                <x-input id="no_wa" type="text" class="mt-1 block w-full" wire:model="state.no_wa" autocomplete="tel" placeholder="Contoh: 081234567890" />
                <x-input-error for="no_wa" class="mt-2" />
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                    <i class="fas fa-phone mr-1"></i>
                    Format: 08xxxx atau +62xxxx
                </p>
            </div>
        @endif

        {{-- Email Field (Readonly for Mentor) --}}
        @if(Auth::user()->hasRole('mentor'))
            <div class="col-span-6 sm:col-span-4">
                <x-label for="email" value="{{ __('Email') }}" />
                
                {{-- Pakai wire:model dengan disabled agar value ter-bind --}}
                <input 
                    id="email" 
                    type="email" 
                    class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm mt-1 block w-full bg-gray-100 dark:bg-gray-700 cursor-not-allowed opacity-75" 
                    wire:model="state.email" 
                    disabled 
                    readonly 
                />
                
                <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                    <i class="fas fa-lock mr-1"></i>
                    Email tidak dapat diubah setelah registrasi.
                </p>

                {{-- Email Verification Notice --}}
                @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::emailVerification()) && ! $this->user->hasVerifiedEmail())
                    <div class="mt-2 p-3 bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg">
                        <p class="text-sm text-yellow-800 dark:text-yellow-200">
                            <i class="fas fa-exclamation-triangle mr-2"></i>
                            {{ __('Alamat email Anda belum diverifikasi.') }}
                        </p>

                        <button type="button" class="mt-2 underline text-sm text-yellow-700 dark:text-yellow-300 hover:text-yellow-900 dark:hover:text-yellow-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500 dark:focus:ring-offset-gray-800" wire:click.prevent="sendEmailVerification">
                            {{ __('Klik di sini untuk mengirim ulang email verifikasi.') }}
                        </button>

                        @if ($this->verificationLinkSent)
                            <p class="mt-2 font-medium text-sm text-green-700 dark:text-green-400">
                                <i class="fas fa-check-circle mr-1"></i>
                                {{ __('Tautan verifikasi baru telah dikirim ke alamat email Anda.') }}
                            </p>
                        @endif
                    </div>
                @endif
            </div>
        @endif

        {{-- Role Info (Readonly) --}}
        <div class="col-span-6 sm:col-span-4">
            <x-label value="{{ __('Role') }}" />
            <div class="mt-1 px-4 py-2 bg-gray-100 dark:bg-gray-700 border border-gray-200 dark:border-gray-600 rounded-lg cursor-not-allowed">
                <p class="text-sm font-medium text-gray-900 dark:text-white">
                    @if(Auth::user()->hasRole('admin'))
                        <i class="fas fa-user-shield text-red-500 mr-2"></i>
                        Administrator
                    @elseif(Auth::user()->hasRole('mentor'))
                        <i class="fas fa-chalkboard-teacher text-blue-500 mr-2"></i>
                        Mentor
                    @elseif(Auth::user()->hasRole('murid'))
                        <i class="fas fa-user-graduate text-green-500 mr-2"></i>
                        Murid
                    @endif
                </p>
            </div>
            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                <i class="fas fa-lock mr-1"></i>
                Role tidak dapat diubah.
            </p>
        </div>
    </x-slot>

    <x-slot name="actions">
        <x-action-message class="me-3" on="saved">
            <i class="fas fa-check-circle text-green-500 mr-1"></i>
            {{ __('Tersimpan.') }}
        </x-action-message>

        <x-button wire:loading.attr="disabled" wire:target="photo">
            <span wire:loading.remove wire:target="updateProfileInformation">
                <i class="fas fa-save mr-2"></i>
                {{ __('Simpan') }}
            </span>
            <span wire:loading wire:target="updateProfileInformation">
                <i class="fas fa-spinner fa-spin mr-2"></i>
                {{ __('Menyimpan...') }}
            </span>
        </x-button>
    </x-slot>
</x-form-section>
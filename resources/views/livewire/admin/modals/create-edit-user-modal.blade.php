<div>
    {{-- resources/views/livewire/admin/modals/create-edit-user-modal.blade.php --}}
    <div x-data="{ show: @entangle('show') }" x-show="show" x-cloak class="fixed inset-0 z-50"
        x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0">

        {{-- Overlay avec backdrop blur --}}
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity" @click="$wire.close()">
        </div>

        {{-- Modal Container --}}
        <div class="flex min-h-screen items-center justify-center p-4">
            <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-4xl transform transition-all"
                x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 scale-95"
                x-transition:enter-end="opacity-100 scale-100" x-transition:leave="transition ease-in duration-200"
                x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                @click.stop>

                {{-- Header Premium --}}
                <div
                    class="relative bg-gradient-to-r from-green-600 via-green-700 to-emerald-600 px-6 sm:px-8 py-6 rounded-t-3xl overflow-hidden">
                    {{-- Pattern Background --}}
                    <div class="absolute inset-0 opacity-10"
                        style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.4\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');">
                    </div>

                    <div class="relative flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-14 h-14 bg-white/20 backdrop-blur-md rounded-2xl flex items-center justify-center shadow-lg">
                                <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    @if ($userId)
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                        </path>
                                    @else
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z">
                                        </path>
                                    @endif
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-2xl font-bold text-white">
                                    {{ $userId ? __('users.edit_title') : __('users.create_title') }}
                                </h3>
                                <p class="text-sm text-green-100 mt-1">
                                    {{ $userId ? __('users.edit_subtitle') : __('users.create_subtitle') }}
                                </p>
                            </div>
                        </div>
                        <button @click="$wire.close()"
                            class="text-white/80 hover:text-white hover:bg-white/20 rounded-xl p-2.5 transition-all">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </button>
                    </div>
                </div>

                {{-- Body avec scroll --}}
                <div class="max-h-[calc(100vh-200px)] overflow-y-auto custom-scrollbar">
                    <form wire:submit="save" class="p-6 sm:p-8 space-y-8">

                        {{-- Section Avatar --}}
                        <div class="flex flex-col items-center space-y-4">
                            <div class="relative group">
                                @if ($avatar)
                                    <img src="{{ $avatar->temporaryUrl() }}"
                                        class="w-28 h-28 rounded-2xl ring-4 ring-green-100 object-cover shadow-lg"
                                        alt="{{ __('users.avatar_alt') }}">
                                @elseif($currentAvatar)
                                    <img src="{{ $currentAvatar }}"
                                        class="w-28 h-28 rounded-2xl ring-4 ring-green-100 object-cover shadow-lg"
                                        alt="{{ __('users.avatar_alt') }}">
                                @else
                                    <div
                                        class="w-28 h-28 rounded-2xl ring-4 ring-green-100 bg-gradient-to-br from-green-500 to-emerald-600 flex items-center justify-center shadow-lg">
                                        <svg class="w-14 h-14 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                            </path>
                                        </svg>
                                    </div>
                                @endif

                                <label
                                    class="absolute -bottom-2 -right-2 bg-gradient-to-r from-green-600 to-emerald-600 hover:from-green-700 hover:to-emerald-700 text-white rounded-xl p-3 cursor-pointer shadow-lg hover:shadow-xl transition-all hover:scale-110">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                    <input type="file" wire:model="avatar" accept="image/*" class="hidden">
                                </label>
                            </div>
                            <div class="text-center">
                                <p class="text-sm font-semibold text-gray-700">{{ __('users.profile_photo') }}</p>
                                <p class="text-xs text-gray-500 mt-1">{{ __('users.avatar_format') }}</p>
                            </div>
                            @error('avatar')
                                <div
                                    class="flex items-center gap-2 px-4 py-2 bg-red-50 border border-red-200 rounded-lg text-red-700 text-sm">
                                    <svg class="w-4 h-4 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd"
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"
                                            clip-rule="evenodd"></path>
                                    </svg>
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Section Informations Personnelles --}}
                        <div class="space-y-6">
                            <div class="flex items-center gap-3 pb-4 border-b-2 border-gray-100">
                                <div class="w-10 h-10 bg-green-100 rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                        </path>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-bold text-gray-900">{{ __('users.personal_info') }}</h4>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                {{-- Nom complet --}}
                                <div class="space-y-1.5">
                                    <label class="block text-sm font-bold text-gray-800 ml-1">
                                        {{ __('users.full_name') }}
                                        <span class="text-red-500 ml-1">*</span>
                                    </label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                                </path>
                                            </svg>
                                        </div>
                                        <input type="text" wire:model="name"
                                            class="w-full border border-gray-200 rounded-xl shadow-sm py-2.5 px-3 pl-12 bg-gray-50 text-gray-700 placeholder-gray-400 transition-all duration-200 focus:bg-white focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:ring-opacity-50"
                                            placeholder="{{ __('users.full_name_placeholder') }}">
                                    </div>
                                    @error('name')
                                        <p class="text-red-500 text-xs font-medium mt-1 ml-1 flex items-center gap-1">
                                            <span>⚠</span>{{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                {{-- Email --}}
                                <div class="space-y-1.5">
                                    <label class="block text-sm font-bold text-gray-800 ml-1">
                                        {{ __('users.email') }}
                                        <span class="text-red-500 ml-1">*</span>
                                    </label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                        </div>
                                        <input type="email" wire:model="email"
                                            class="w-full border border-gray-200 rounded-xl shadow-sm py-2.5 px-3 pl-12 bg-gray-50 text-gray-700 placeholder-gray-400 transition-all duration-200 focus:bg-white focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:ring-opacity-50"
                                            placeholder="{{ __('users.email_placeholder') }}">
                                    </div>
                                    @error('email')
                                        <p class="text-red-500 text-xs font-medium mt-1 ml-1 flex items-center gap-1">
                                            <span>⚠</span>{{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                {{-- Téléphone --}}
                                <div class="space-y-1.5">
                                    <label class="block text-sm font-bold text-gray-800 ml-1">
                                        {{ __('users.phone') }}
                                        <span class="text-red-500 ml-1">*</span>
                                    </label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                                </path>
                                            </svg>
                                        </div>
                                        <input type="tel" wire:model="phone"
                                            class="w-full border border-gray-200 rounded-xl shadow-sm py-2.5 px-3 pl-12 bg-gray-50 text-gray-700 placeholder-gray-400 transition-all duration-200 focus:bg-white focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:ring-opacity-50"
                                            placeholder="{{ __('users.phone_placeholder') }}">
                                    </div>
                                    @error('phone')
                                        <p class="text-red-500 text-xs font-medium mt-1 ml-1 flex items-center gap-1">
                                            <span>⚠</span>{{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                {{-- Rôle --}}
                                <div class="space-y-1.5">
                                    <label class="block text-sm font-bold text-gray-800 ml-1">
                                        {{ __('users.role') }}
                                        <span class="text-red-500 ml-1">*</span>
                                    </label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z">
                                                </path>
                                            </svg>
                                        </div>
                                        <select wire:model="role"
                                            class="w-full border border-gray-200 rounded-xl shadow-sm py-2.5 px-3 pl-12 bg-gray-50 text-gray-700 transition-all duration-200 focus:bg-white focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:ring-opacity-50">
                                            <option value="">{{ __('users.select_role') }}</option>
                                            @foreach (App\Models\Role::all() as $role)
                                                @if ($role->id == 1)
                                                    <option value="{{ $role->id }}">👨‍💼 {{ __('users.admin') }}</option>
                                                @elseif ($role->id == 2)
                                                    <option value="{{ $role->id }}">👨‍🌾 {{ __('users.producer') }}</option>
                                                @else
                                                    <option value="{{ $role->id }}">🛒 {{ __('users.consumer') }}</option>
                                                @endif
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('role')
                                        <p class="text-red-500 text-xs font-medium mt-1 ml-1 flex items-center gap-1">
                                            <span>⚠</span>{{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Section Localisation --}}
                        <div class="space-y-6">
                            <div class="flex items-center gap-3 pb-4 border-b-2 border-gray-100">
                                <div class="w-10 h-10 bg-blue-100 rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-bold text-gray-900">{{ __('users.location') }}</h4>
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                {{-- Région --}}
                                <div class="space-y-1.5">
                                    <label class="block text-sm font-bold text-gray-800 ml-1">
                                        {{ __('users.region') }}
                                        <span class="text-red-500 ml-1">*</span>
                                    </label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 20l-5.447-2.724A1 1 0 013 16.382V5.618a1 1 0 011.447-.894L9 7m0 13l6-3m-6 3V7m6 10l4.553 2.276A1 1 0 0021 18.382V7.618a1 1 0 00-.553-.894L15 4m0 13V4m0 0L9 7">
                                                </path>
                                            </svg>
                                        </div>
                                        <select wire:model="region"
                                            class="w-full border border-gray-200 rounded-xl shadow-sm py-2.5 px-3 pl-12 bg-gray-50 text-gray-700 transition-all duration-200 focus:bg-white focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:ring-opacity-50">
                                            <option value="">{{ __('users.select_region') }}</option>
                                            @foreach (['Adamaoua', 'Centre', 'Est', 'Extrême-Nord', 'Littoral', 'Nord', 'Nord-Ouest', 'Ouest', 'Sud', 'Sud-Ouest'] as $r)
                                                <option value="{{ $r }}">{{ $r }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('region')
                                        <p class="text-red-500 text-xs font-medium mt-1 ml-1 flex items-center gap-1">
                                            <span>⚠</span>{{ $message }}
                                        </p>
                                    @enderror
                                </div>

                                {{-- Ville --}}
                                <div class="space-y-1.5">
                                    <label class="block text-sm font-bold text-gray-800 ml-1">
                                        {{ __('users.city') }}
                                        <span class="text-red-500 ml-1">*</span>
                                    </label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                                </path>
                                            </svg>
                                        </div>
                                        <input type="text" wire:model="city"
                                            class="w-full border border-gray-200 rounded-xl shadow-sm py-2.5 px-3 pl-12 bg-gray-50 text-gray-700 placeholder-gray-400 transition-all duration-200 focus:bg-white focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:ring-opacity-50"
                                            placeholder="{{ __('users.city_placeholder') }}">
                                    </div>
                                    @error('city')
                                        <p class="text-red-500 text-xs font-medium mt-1 ml-1 flex items-center gap-1">
                                            <span>⚠</span>{{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- Section Activité Professionnelle --}}
                        <div class="space-y-6">
                            <div class="flex items-center gap-3 pb-4 border-b-2 border-gray-100">
                                <div class="w-10 h-10 bg-purple-100 rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-purple-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-bold text-gray-900">{{ __('users.professional_activity') }}</h4>
                            </div>

                            {{-- Activité --}}
                            <div class="space-y-1.5">
                                <label class="block text-sm font-bold text-gray-800 ml-1">
                                    {{ __('users.activity') }}
                                    <span class="text-red-500 ml-1">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                            </path>
                                        </svg>
                                    </div>
                                    <input type="text" wire:model="activity"
                                        class="w-full border border-gray-200 rounded-xl shadow-sm py-2.5 px-3 pl-12 bg-gray-50 text-gray-700 placeholder-gray-400 transition-all duration-200 focus:bg-white focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:ring-opacity-50"
                                        placeholder="{{ __('users.activity_placeholder') }}">
                                </div>
                                @error('activity')
                                    <p class="text-red-500 text-xs font-medium mt-1 ml-1 flex items-center gap-1">
                                        <span>⚠</span>{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            {{-- Biographie --}}
                            <div class="space-y-1.5">
                                <label class="block text-sm font-bold text-gray-800 ml-1">
                                    {{ __('users.bio') }}
                                    <span class="text-gray-400 text-sm font-normal ml-2">{{ __('users.optional') }}</span>
                                </label>
                                <textarea wire:model="bio" rows="4"
                                    class="w-full border border-gray-200 rounded-xl shadow-sm py-2.5 px-3 bg-gray-50 text-gray-700 placeholder-gray-400 transition-all duration-200 focus:bg-white focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:ring-opacity-50 resize-y min-h-[100px]"
                                    placeholder="{{ __('users.bio_placeholder') }}"></textarea>
                                @error('bio')
                                    <p class="text-red-500 text-xs font-medium mt-1 ml-1 flex items-center gap-1">
                                        <span>⚠</span>{{ $message }}
                                    </p>
                                @enderror
                                <p class="text-xs text-gray-500 mt-2">{{ __('users.bio_visibility') }}</p>
                            </div>
                        </div>

                        {{-- Section Statut du Compte --}}
                        <div class="space-y-6" x-data="{ selectedStatus: @entangle('status') }">
                            <div class="flex items-center gap-3 pb-4 border-b-2 border-gray-100">
                                <div class="w-10 h-10 bg-orange-100 rounded-xl flex items-center justify-center">
                                    <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                        </path>
                                    </svg>
                                </div>
                                <h4 class="text-lg font-bold text-gray-900">{{ __('users.account_status') }}</h4>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                                {{-- Actif --}}
                                <label class="border-2 rounded-2xl transition-all duration-200 group cursor-pointer"
                                    :class="selectedStatus === 'active' ? 'border-green-500 bg-green-50' :
                                        'border-gray-200 hover:border-green-300'">
                                    <input type="radio" wire:model="status" value="active" class="sr-only">
                                    <div class="flex flex-col items-center gap-3 p-4">
                                        <div class="w-12 h-12 rounded-xl flex items-center justify-center transition-all"
                                            :class="selectedStatus === 'active' ? 'bg-green-100' :
                                                'bg-gray-100 group-hover:bg-green-50'">
                                            <svg class="w-6 h-6 transition-colors"
                                                :class="selectedStatus === 'active' ? 'text-green-600' :
                                                    'text-gray-400 group-hover:text-green-500'"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div class="text-center">
                                            <p class="font-bold transition-colors"
                                                :class="selectedStatus === 'active' ? 'text-green-700' :
                                                    'text-gray-700 group-hover:text-green-700'">
                                                {{ __('users.status_active') }}</p>
                                            <p class="text-xs text-gray-500 mt-1">{{ __('users.status_active_desc') }}</p>
                                        </div>
                                    </div>
                                </label>

                                {{-- Suspendu --}}
                                <label class="border-2 rounded-2xl transition-all duration-200 group cursor-pointer"
                                    :class="selectedStatus === 'suspended' ? 'border-orange-500 bg-orange-50' :
                                        'border-gray-200 hover:border-orange-300'">
                                    <input type="radio" wire:model="status" value="suspended" class="sr-only">
                                    <div class="flex flex-col items-center gap-3 p-4">
                                        <div class="w-12 h-12 rounded-xl flex items-center justify-center transition-all"
                                            :class="selectedStatus === 'suspended' ? 'bg-orange-100' :
                                                'bg-gray-100 group-hover:bg-orange-50'">
                                            <svg class="w-6 h-6 transition-colors"
                                                :class="selectedStatus === 'suspended' ? 'text-orange-600' :
                                                    'text-gray-400 group-hover:text-orange-500'"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z">
                                                </path>
                                            </svg>
                                        </div>
                                        <div class="text-center">
                                            <p class="font-bold transition-colors"
                                                :class="selectedStatus === 'suspended' ? 'text-orange-700' :
                                                    'text-gray-700 group-hover:text-orange-700'">
                                                {{ __('users.status_suspended') }}</p>
                                            <p class="text-xs text-gray-500 mt-1">{{ __('users.status_suspended_desc') }}</p>
                                        </div>
                                    </div>
                                </label>

                                {{-- Banni --}}
                                <label class="border-2 rounded-2xl transition-all duration-200 group cursor-pointer"
                                    :class="selectedStatus === 'banned' ? 'border-red-500 bg-red-50' :
                                        'border-gray-200 hover:border-red-300'">
                                    <input type="radio" wire:model="status" value="banned" class="sr-only">
                                    <div class="flex flex-col items-center gap-3 p-4">
                                        <div class="w-12 h-12 rounded-xl flex items-center justify-center transition-all"
                                            :class="selectedStatus === 'banned' ? 'bg-red-100' :
                                                'bg-gray-100 group-hover:bg-red-50'">
                                            <svg class="w-6 h-6 transition-colors"
                                                :class="selectedStatus === 'banned' ? 'text-red-600' :
                                                    'text-gray-400 group-hover:text-red-500'"
                                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636">
                                                </path>
                                            </svg>
                                        </div>
                                        <div class="text-center">
                                            <p class="font-bold transition-colors"
                                                :class="selectedStatus === 'banned' ? 'text-red-700' :
                                                    'text-gray-700 group-hover:text-red-700'">
                                                {{ __('users.status_banned') }}</p>
                                            <p class="text-xs text-gray-500 mt-1">{{ __('users.status_banned_desc') }}</p>
                                        </div>
                                    </div>
                                </label>
                            </div>
                            @error('status')
                                <p
                                    class="text-red-500 text-xs font-medium mt-2 text-center flex items-center justify-center gap-1">
                                    <span>⚠</span>{{ $message }}
                                </p>
                            @enderror
                        </div>

                        {{-- Section Sécurité (Uniquement pour la création) --}}
                        @if (!$userId)
                            <div class="space-y-6">
                                <div class="flex items-center gap-3 pb-4 border-b-2 border-gray-100">
                                    <div class="w-10 h-10 bg-red-100 rounded-xl flex items-center justify-center">
                                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                            </path>
                                        </svg>
                                    </div>
                                    <h4 class="text-lg font-bold text-gray-900">{{ __('users.security') }}</h4>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    {{-- Mot de passe --}}
                                    <div class="space-y-1.5">
                                        <label class="block text-sm font-bold text-gray-800 ml-1">
                                            {{ __('users.password') }} <span class="text-red-500 ml-1">*</span>
                                        </label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                                <svg class="w-5 h-5 text-gray-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <input type="password" wire:model="password"
                                                class="w-full border border-gray-200 rounded-xl shadow-sm py-2.5 px-3 pl-12 bg-gray-50 text-gray-700 placeholder-gray-400 transition-all duration-200 focus:bg-white focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:ring-opacity-50"
                                                placeholder="••••••••">
                                        </div>
                                        @error('password')
                                            <p class="text-red-500 text-xs font-medium mt-1 ml-1 flex items-center gap-1">
                                                <span>⚠</span>{{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    {{-- Confirmation Mot de passe --}}
                                    <div class="space-y-1.5">
                                        <label class="block text-sm font-bold text-gray-800 ml-1">
                                            {{ __('users.password_confirmation') }} <span class="text-red-500 ml-1">*</span>
                                        </label>
                                        <div class="relative">
                                            <div
                                                class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                                <svg class="w-5 h-5 text-gray-400" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                            </div>
                                            <input type="password" wire:model="password_confirmation"
                                                class="w-full border border-gray-200 rounded-xl shadow-sm py-2.5 px-3 pl-12 bg-gray-50 text-gray-700 placeholder-gray-400 transition-all duration-200 focus:bg-white focus:border-green-500 focus:ring-2 focus:ring-green-200 focus:ring-opacity-50"
                                                placeholder="••••••••">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif

                        {{-- Vérification Email --}}
                        <div class="bg-blue-50 border border-blue-100 rounded-2xl p-4 flex items-start gap-4">
                            <div class="flex h-6 items-center">
                                <input type="checkbox" wire:model="emailVerified" id="emailVerified"
                                    class="h-5 w-5 rounded border-gray-300 text-green-600 focus:ring-green-600 cursor-pointer">
                            </div>
                            <div class="text-sm">
                                <label for="emailVerified"
                                    class="font-medium text-blue-900 cursor-pointer select-none">
                                    {{ __('users.mark_email_verified') }}
                                </label>
                                <p class="text-blue-700 mt-1">{{ __('users.mark_email_verified_help') }}</p>
                            </div>
                        </div>

                        {{-- Footer Actions --}}
                        <div
                            class="sticky bottom-0 -mx-8 -mb-8 px-8 py-6 bg-gray-50 border-t border-gray-200 flex items-center justify-end gap-4 mt-8 rounded-b-3xl">
                            <button type="button" @click="$wire.close()"
                                class="px-6 py-2.5 border border-gray-300 text-gray-700 font-semibold rounded-xl hover:bg-white hover:shadow-sm transition-all focus:ring-2 focus:ring-gray-200">
                                {{ __('users.cancel') }}
                            </button>

                            <button type="submit"
                                class="px-8 py-2.5 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-semibold rounded-xl shadow-lg shadow-green-500/30 hover:shadow-green-500/40 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center gap-2 disabled:opacity-70 disabled:cursor-not-allowed">
                                <span wire:loading.remove wire:target="save">
                                    {{ $userId ? __('users.update') : __('users.create_account') }}
                                </span>
                                <span wire:loading wire:target="save" class="flex items-center gap-2">
                                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg"
                                        fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10"
                                            stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor"
                                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                        </path>
                                    </svg>
                                    {{ __('users.processing') }}
                                </span>
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
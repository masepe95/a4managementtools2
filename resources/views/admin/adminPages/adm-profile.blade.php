{{-- Profile block. --}}
<div id="profile-block" class="collapse h-0 page-block max-w-4xl mx-auto my-0 px-6">
    <div class="border-0">
        <h1 class="text-3xl px-4 py-3 border-b-2 a4-bord-shade-100">{{ __('admin/adm-profile.title') }}</h1>
        <form id="profile-form" name="profile-form" class="p-4">
            @csrf
            <p class="text-sm mb-4">{{ __('admin/adm-profile.description') }}</p>

            <x-error-message id="profile-errors" class="hidden" data-sql-error="{{ __('admin/adm-profile.sql-error') }}"></x-error-message>

            <div class="grid grid-cols-2 gap-x-4 gap-y-2">
                <div class="relative mb-3" data-te-input-wrapper-init="">
                    <x-admin.admin-text-input type="text" id="profile-firstname" name="profile-firstname" placeholder="{{ __('admin/adm-profile.firstname') }}" aria-required="true" class="invalid:a4-text-dark-red" title="" data-title="{{ __('globals.fill-out-field-tooltip') }}" pattern="^\s*[a-zA-Z].*$" maxlength="64" required="required" />
                    <x-admin.admin-input-label for="profile-firstname">
                        {{ __('admin/adm-profile.firstname') }}
                    </x-admin.admin-input-label>
                </div>
                <div class="relative mb-3" data-te-input-wrapper-init="">
                    <x-admin.admin-text-input type="text" id="profile-lastname" name="profile-lastname" placeholder="{{ __('admin/adm-profile.lastname') }}" aria-required="true" class="invalid:a4-text-dark-red" title="" data-title="{{ __('globals.fill-out-field-tooltip') }}" pattern="^\s*[a-zA-Z].*$" maxlength="64" required="required" />
                    <x-admin.admin-input-label for="profile-lastname">
                        {{ __('admin/adm-profile.lastname') }}
                    </x-admin.admin-input-label>
                </div>

                <div class="relative mb-3" data-te-input-wrapper-init="">
                    <x-admin.admin-text-input type="text" id="profile-acronym" name="profile-acronym" data-nullable="yes" placeholder="{{ __('admin/adm-profile.acronym') }}" disabled />
                    <x-admin.admin-input-label for="profile-acronym">
                        {{ __('admin/adm-profile.acronym') }}
                    </x-admin.admin-input-label>
                </div>
                <div class="relative mb-3" data-te-input-wrapper-init="">
                    <x-admin.admin-text-input type="text" id="profile-id" name="profile-id" data-nullable="yes" placeholder="{{ __('admin/adm-profile.employee-id') }}" disabled />
                    <x-admin.admin-input-label for="profile-id">
                        {{ __('admin/adm-profile.employee-id') }}
                    </x-admin.admin-input-label>
                </div>

                <div class="relative mb-3" data-te-input-wrapper-init="">
                    <x-admin.admin-text-input type="tel" id="profile-mobile-phone" name="profile-mobile-phone" placeholder="{{ __('admin/adm-profile.mobile-phone') }}" maxlength="32" />
                    <x-admin.admin-input-label for="profile-mobile-phone">
                        {{ __('admin/adm-profile.mobile-phone') }}
                    </x-admin.admin-input-label>
                </div>
                <div class="relative mb-3" data-te-input-wrapper-init="">
                    <x-admin.admin-text-input type="tel" id="profile-phone" name="profile-phone" placeholder="{{ __('admin/adm-profile.phone') }}" maxlength="32" />
                    <x-admin.admin-input-label for="profile-phone">
                        {{ __('admin/adm-profile.phone') }}
                    </x-admin.admin-input-label>
                </div>

                <div class="relative mb-3" data-te-input-wrapper-init="">
                    <x-admin.admin-text-input type="email" id="profile-email" name="profile-email" placeholder="{{ __('admin/adm-profile.email') }}" aria-required="true"
                           class="invalid:a4-text-dark-red"
                           data-title="{{ __('globals.fill-out-field-tooltip') }}" maxlength="128" required="required" />
                    <x-admin.admin-input-label for="profile-email">
                        {{ __('admin/adm-profile.email') }}
                    </x-admin.admin-input-label>
                </div>
                <div class="mb-3">
                    <x-admin.admin-select id="profile-language-code" name="profile-language-code" title="{{ __('admin/adm-profile.language-tooltip') }}">
                      @foreach ($languages as $language)
                        <option value="{{ $language->code }}">{{ $language->name }}</option>
                      @endforeach
                    </x-admin.admin-select>
                    <label data-te-select-label-ref="">{{ __('admin/adm-profile.language') }}</label>
                </div>

                <div class="relative mb-3 pw-container" data-te-input-wrapper-init="">
                    <x-admin.admin-text-input type="password" id="profile-password" name="profile-password" placeholder="{{ __('admin/adm-profile.curr-password') }}" title="{{ __('admin/adm-profile.curr-password-tooltip') }}" maxlength="64" />
                    <x-admin.admin-input-label for="profile-password">
                        {{ __('admin/adm-profile.curr-password') }}
                    </x-admin.admin-input-label>
                </div>
                <div class="relative mb-3 pw-container" data-te-input-wrapper-init="">
                    <x-admin.admin-text-input type="password" id="profile-password-new" name="profile-password-new" placeholder="{{ __('admin/adm-profile.new-password') }}" title="{{ __('admin/adm-profile.new-password-tooltip') }}" maxlength="64" />
                    <x-admin.admin-input-label for="profile-password-new">
                        {{ __('admin/adm-profile.new-password') }}
                    </x-admin.admin-input-label>
                </div>

                <div class="relative mb-3" data-te-input-wrapper-init="">
                    <x-admin.admin-text-input type="text" id="profile-job-title" name="profile-job-title" data-nullable="yes" placeholder="{{ __('admin/adm-profile.job-title') }}" disabled />
                    <x-admin.admin-input-label for="profile-job-title">
                        {{ __('admin/adm-profile.job-title') }}
                    </x-admin.admin-input-label>
                </div>
                <div class="mb-3">
                    <x-admin.admin-select id="profile-role" name="profile-role" disabled>
                    </x-admin.admin-select>
                    <label data-te-select-label-ref="">{{ __('admin/adm-profile.role') }}</label>
                </div>

                <div class="grid justify-items-center pl-3 pr-10 min-h-[270px]">
                    <input type="file" id="profile-photo" name="profile-photo" class="w-0 h-0 opacity-0 overflow-hidden absolute -z-10 outline-0" accept="image/gif,image/jpeg,image/png,image/svg+xml" />
                    <div class="grid grid-cols-[1.75rem_1fr] items-center gap-x-0">
                        <div id="profile-photo-delete" class="mr-2 cursor-pointer" title="{{ __('admin/adm-profile.profile-photo-delete') }}"><svg class="w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg"><path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"></path><path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"></path></svg></div>
                        <div class="profile-image-box grid justify-items-center items-center text-center w-[200px] h-[270px] p-0 border-2 a4-bord-shade-100"
                             title="{!! __('admin/adm-profile.profile-photo-tooltip') !!}">
                            <label id="profile-photo-label" for="profile-photo" class="flex justify-center items-center w-full h-full cursor-pointer">
                                <span>{!! __('admin/adm-profile.profile-photo') !!}</span>
                                <img id="profile-photo-image" src="" class="hidden w-[200px]" />
                            </label>
                        </div>
                    </div>
                </div>
                <div class="grid justify-items-end">
                    <x-admin.admin-button id="save-profile" class="self-end">
                        {{ __('globals.save-button') }}
                    </x-admin.admin-button>
                </div>
            </div>
        </form>
    </div>
</div>

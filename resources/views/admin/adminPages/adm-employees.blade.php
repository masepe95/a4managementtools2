{{-- Employees block. --}}
<div id="employees-block" class="collapse h-0 page-block max-w-4xl mx-auto my-0 px-6">
    <div class="border-0">
        <h1 class="text-3xl px-4 py-3 border-b-2 a4-bord-shade-100">{!! __('admin/adm-employees.title') . (($user->role == 'siteAdmin') ? ' &nbsp;<span class="a4-text-shade-300 text-[60%]">«<span id="employees-customer-name" title="' . __('admin/adm-employees.title-tooltip') . '"></span>»</span>' : '') !!}</h1>
        <form id="employees-form" name="employees-form" class="p-4">
            @csrf
            <p class="text-sm mb-4">{{ __('admin/adm-employees.description') }}</p>

            <x-error-message id="employees-errors" class="hidden" data-sql-error="{{ __('admin/adm-employees.sql-error') }}"></x-error-message>

            <div class="grid grid-cols-2 gap-x-4 gap-y-2">
                <div class="mb-2 col-span-2">
                    <x-admin.admin-select id="employee-names" name="employee-names" data-te-select-visible-options="10"
                            title="{{ __('admin/adm-employees.employee-tooltip') }}">
                    </x-admin.admin-select>
                    <label data-te-select-label-ref="">{{ __('admin/adm-employees.employee') }}</label>
                </div>

                <div class="mb-3 col-span-2 flex flex-row gap-x-3 justify-end">
                    <x-admin.admin-button id="edit-employee" class="w-32"
                            title="{{ __('admin/adm-employees.update-button-tooltip', ['employee' => __('admin/adm-employees.employee')]) }}">
                        {{ __('globals.update-button') }}
                    </x-admin.admin-button>
                    <x-admin.admin-button id="add-employee" class="w-32"
                            title="{{ __('admin/adm-employees.add-button-tooltip') }}">
                        {{ __('globals.add-button') }}
                    </x-admin.admin-button>
                    <x-admin.admin-button id="delete-employee" class="w-32"
                            title="{{ __('admin/adm-employees.delete-button-tooltip', ['employee' => __('admin/adm-employees.employee')]) }}"
                            data-delete-title="{{ __('admin/adm-employees.delete-title') }}"
                            data-delete-body="{{ __('admin/adm-employees.delete-body') }}">
                        {{ __('globals.delete-button') }}
                    </x-admin.admin-button>
                </div>

                <div class="relative mb-3" data-te-input-wrapper-init="">
                    <x-admin.admin-text-input type="text" id="employee-firstname" name="employee-firstname" placeholder="Nome" aria-required="true" class="invalid:a4-text-dark-red" data-title="{{ __('globals.fill-out-field-tooltip') }}" maxlength="64" pattern="^\s*[a-zA-Z].*$" required="required" />
                    <x-admin.admin-input-label for="employee-firstname">
                        {{ __('admin/adm-employees.firstname') }}
                    </x-admin.admin-input-label>
                </div>
                <div class="relative mb-3" data-te-input-wrapper-init="">
                    <x-admin.admin-text-input type="text" id="employee-lastname" name="employee-lastname" placeholder="Cognome" aria-required="true" class="invalid:a4-text-dark-red" data-title="{{ __('globals.fill-out-field-tooltip') }}" maxlength="64" pattern="^\s*[a-zA-Z].*$" required="required" />
                    <x-admin.admin-input-label for="employee-lastname">
                        {{ __('admin/adm-employees.lastname') }}
                    </x-admin.admin-input-label>
                </div>

                <div class="relative mb-3" data-te-input-wrapper-init="">
                    <x-admin.admin-text-input type="text" id="employee-acronym" name="employee-acronym" value=" " placeholder="Acronimo" maxlength="32" />
                    <x-admin.admin-input-label for="employee-acronym">
                        {{ __('admin/adm-employees.acronym') }}
                    </x-admin.admin-input-label>
                </div>
                <div class="relative mb-3" data-te-input-wrapper-init="">
                    <x-admin.admin-text-input type="text" id="employee-employee-id" name="employee-employee-id" value=" " placeholder="ID" maxlength="32" />
                    <x-admin.admin-input-label for="employee-employee-id">
                        {{ __('admin/adm-employees.employee-id') }}
                    </x-admin.admin-input-label>
                </div>

                <div class="relative mb-3" data-te-input-wrapper-init="">
                    <x-admin.admin-text-input type="tel" id="employee-mobile-phone" name="employee-mobile-phone" placeholder="Cellulare" maxlength="32" />
                    <x-admin.admin-input-label for="employee-mobile-phone">
                        {{ __('admin/adm-employees.mobile-phone') }}
                    </x-admin.admin-input-label>
                </div>
                <div class="relative mb-3" data-te-input-wrapper-init="">
                    <x-admin.admin-text-input type="tel" id="employee-phone" name="employee-phone" placeholder="Telefono" maxlength="32" />
                    <x-admin.admin-input-label for="employee-phone">
                        {{ __('admin/adm-employees.phone') }}
                    </x-admin.admin-input-label>
                </div>

                <div class="relative mb-3" data-te-input-wrapper-init="">
                    <x-admin.admin-text-input type="email" id="employee-email" name="employee-email" placeholder="E-mail" aria-required="true" class="invalid:a4-text-dark-red" data-title="{{ __('globals.fill-out-field-tooltip') }}" maxlength="128" required="required" />
                    <x-admin.admin-input-label for="employee-email">
                        {{ __('admin/adm-employees.email') }}
                    </x-admin.admin-input-label>
                </div>
                <div class="mb-3">
                    <x-admin.admin-select id="employee-language-code" name="employee-language-code"
                            title="{{ __('admin/adm-employees.language-tooltip') }}">
                      @foreach ($languages as $language)
                        <option value="{{ $language->code }}">{{ $language->name }}</option>
                      @endforeach
                    </x-admin.admin-select>
                    <label data-te-select-label-ref="">{{ __('admin/adm-employees.language') }}</label>
                </div>

                <div class="relative mb-3 pw-container" data-te-input-wrapper-init="">
                    <x-admin.admin-text-input type="password" id="employee-password" name="employee-password"
                           placeholder="{{ __('admin/adm-employees.curr-password') }}"
                           title="{{ __('admin/adm-employees.curr-password-tooltip') }}" maxlength="64" />
                    <x-admin.admin-input-label for="employee-password">
                        {{ __('admin/adm-employees.curr-password') }}
                    </x-admin.admin-input-label>
                </div>
                <div class="relative mb-3 pw-container" data-te-input-wrapper-init="">
                    <x-admin.admin-text-input type="password" id="employee-password-new" name="employee-password-new"
                           placeholder="{{ __('admin/adm-employees.new-password') }}"
                           title="{{ __('admin/adm-employees.new-password-tooltip') }}" maxlength="64" />
                    <x-admin.admin-input-label for="employee-password-new">
                        {{ __('admin/adm-employees.new-password') }}
                    </x-admin.admin-input-label>
                </div>

                <div class="relative mb-3" data-te-input-wrapper-init="">
                    <x-admin.admin-text-input type="text" id="employee-job-title" name="employee-job-title" value=" "
                           placeholder="{{ __('admin/adm-employees.job-title') }}" maxlength="64" />
                    <x-admin.admin-input-label for="employee-job_title">
                        {{ __('admin/adm-employees.job-title') }}
                    </x-admin.admin-input-label>
                </div>
                <div class="mb-3">
                    <x-admin.admin-select id="employee-role" name="employee-role">
                        <option value="employee" selected>{{ __('globals.employee-role')['employee'] }}</option>
                        <option value="customerAdmin">{{ __('globals.employee-role')['customerAdmin'] }}</option>
                      @if ($user->role == 'siteAdmin')
                        <option value="siteAdmin">{{ __('globals.employee-role')['siteAdmin'] }}</option>
                      @endif
                    </x-admin.admin-select>
                    <label data-te-select-label-ref="">{{ __('admin/adm-employees.role') }}</label>
                </div>

                <div class="grid grid-cols-[1fr_auto] gap-x-4">
                    <div class="relative mb-3" data-te-input-wrapper-init="">
                        <x-admin.admin-text-input type="text" id="employee-failed-passwords" name="employee-failed-passwords"
                               placeholder="{{ __('admin/adm-employees.failed-passwords') }}"
                               title="{{ __('admin/adm-employees.failed-passwords-tooltip', ['reset' => __('admin/adm-employees.reset-failed-passwords')]) }}" readonly="readonly" />
                        <x-admin.admin-input-label for="employee-failed-passwords">
                            {{ __('admin/adm-employees.failed-passwords') }}
                        </x-admin.admin-input-label>
                    </div>
                    <div>
                        <x-admin.admin-button id="reset-failed-passwords"
                                title="{{ __('admin/adm-employees.reset-failed-passwords-tooltip') }}">
                            {{ __('admin/adm-employees.reset-failed-passwords') }}
                        </x-admin.admin-button>
                    </div>
                </div>
                <div class="mb-3">
                    <x-admin.admin-select id="employee-status" name="employee-status">
                        <option value="enabled" selected>{{ __('globals.employee-status')['enabled'] }}</option>
                        <option value="disabled">{{ __('globals.employee-status')['disabled'] }}</option>
                    </x-admin.admin-select>
                    <label data-te-select-label-ref="">{{ __('admin/adm-employees.status') }}</label>
                </div>

                <div class="grid justify-items-center pl-3 pr-10 min-h-[270px]">
                    <input type="file" id="employee-photo" name="employee-photo" class="w-0 h-0 opacity-0 overflow-hidden absolute -z-10 outline-0" accept="image/gif,image/jpeg,image/png,image/svg+xml" />
                    <div class="grid grid-cols-[1.75rem_1fr] items-center gap-x-0">
                        <div id="employee-photo-delete" class="mr-2 cursor-pointer" title="{{ __('admin/adm-employees.employee-photo-delete') }}"><svg class="w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg"><path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"></path><path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"></path></svg></div>
                        <div class="employee-image-box grid justify-items-center items-center text-center w-[200px] h-[270px] p-0 border-2 a4-bord-shade-100"
                             title="{!! __('admin/adm-employees.employee-photo-tooltip') !!}">
                            <label id="employee-photo-label" for="employee-photo" class="flex justify-center items-center w-full h-full cursor-pointer">
                                <span>{!! __('admin/adm-employees.employee-photo') !!}</span>
                                <img id="employee-photo-image" src="" class="hidden w-[200px]" />
                            </label>
                        </div>
                    </div>
                </div>
                <div id="employee-tools-block" class="relative" data-te-dropdown-ref="">
                    <x-admin.admin-button id="dropdown-employee-tools"
                            data-te-dropdown-toggle-ref="" data-te-auto-close="outside" aria-expanded="false">
                        {{ __('admin/adm-employees.tools-visibility') }}
                        <span class="absolute right-3 w-5">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path>
                            </svg>
                        </span>
                    </x-admin.admin-button>
                    <ul class="absolute z-[1000] float-left m-0 hidden list-none min-w-full max-h-56 overflow-x-hidden overflow-y-auto rounded-lg border border-neutral-300 bg-white bg-clip-padding text-left text-base shadow-lg dark:bg-neutral-700 [&[data-te-dropdown-show]]:block"
                        aria-labelledby="dropdown-employee-tools" data-te-dropdown-menu-ref="">
                    </ul>
                </div>
            </div>
        </form>
    </div>
</div>

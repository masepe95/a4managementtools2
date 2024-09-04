{{-- Global options block. --}}
<div id="global-options-block" class="collapse h-0 page-block max-w-4xl mx-auto my-0 px-6">
    <div class="border-0">
        <h1 class="text-3xl px-4 py-3 border-b-2 a4-bord-shade-100">{{ __('admin/adm-global-options.title') }}</h1>
        <form id="global-options-form" name="global-options-form" class="p-4">
            @csrf
            <p class="text-sm mb-4">{{ __('admin/adm-global-options.description') }}</p>

            <x-error-message id="global-options-errors" class="hidden"></x-error-message>

            <div class="grid grid-cols-2 gap-x-4 gap-y-2">
                <div class="mb-3">
                    <x-admin.admin-select id="glb-default-lang-code" name="glb-default-lang-code"
                            title="{{ __('admin/adm-global-options.default-language-tooltip') }}">
                        <option value="en">English</option>
                        <option value="it">Italiano</option>
                        <option value="fr">Français</option>
                        <option value="de">Deutsch</option>
                    </x-admin.admin-select>
                    <label data-te-select-label-ref="">{{ __('admin/adm-global-options.default-language') }}</label>
                </div>
                <div class="relative mb-3" data-te-input-wrapper-init="">
                    <x-admin.admin-text-input type="number" id="glb-signup-pending-timeout" name="glb-signup-pending-timeout" value="60"
                           aria-required="true" class="invalid:a4-text-dark-red"
                           data-title="{!! __('admin/adm-global-options.signup-pending-timeout-tooltip') !!}"
                           min="10" required="required" />
                    <x-admin.admin-input-label for="glb-signup-pending-timeout">
                        {{ __('admin/adm-global-options.signup-pending-timeout') }}
                    </x-admin.admin-input-label>
                </div>

                <div class="relative mb-3" data-te-input-wrapper-init="">
                    <x-admin.admin-text-input type="number" id="glb-minimum-password-length" name="glb-minimum-password-length" value="16"
                           aria-required="true" class="invalid:a4-text-dark-red"
                           data-title="{{ __('admin/adm-global-options.min-password-length-tooltip') }}"
                           min="8" required="required" />
                    <x-admin.admin-input-label for="glb-minimum-password-length">
                        {{ __('admin/adm-global-options.min-password-length') }}
                    </x-admin.admin-input-label>
                </div>
                <div class="relative mb-3" data-te-input-wrapper-init="">
                    <x-admin.admin-text-input type="number" id="glb-max-password-failures" name="glb-max-password-failures" value="5"
                           aria-required="true" class="invalid:a4-text-dark-red"
                           data-title="{!! __('admin/adm-global-options.max-password-failures-tooltip', ['recovering' => __('admin/adm-global-options.recovering-access-delay')]) !!}"
                           data-title-error="{{ __('admin/adm-global-options.max-password-failures-error') }}"
                           min="0" required="required" />
                    <x-admin.admin-input-label for="glb-max-password-failures">
                        {{ __('admin/adm-global-options.max-password-failures') }}
                    </x-admin.admin-input-label>
                </div>

                <div class="relative mb-3" data-te-input-wrapper-init="">
                    <x-admin.admin-text-input type="number" id="glb-recovering-access-delay" name="glb-recovering-access-delay" value="30"
                           aria-required="true" class="invalid:a4-text-dark-red"
                           data-title="{{ __('admin/adm-global-options.recovering-access-delay-tooltip') }}"
                           data-title-error="{{ __('admin/adm-global-options.recovering-access-delay-error') }}" min="0" required="required" />
                    <x-admin.admin-input-label for="glb-recovering-access-delay">
                        {{ __('admin/adm-global-options.recovering-access-delay') }}
                    </x-admin.admin-input-label>
                </div>
                <div class="relative mb-3" data-te-input-wrapper-init="">
                    <x-admin.admin-text-input type="email" id="glb-support-admin-email" name="glb-support-admin-email" value=""
                           placeholder="{{ __('admin/adm-global-options.support-email') }}" class="invalid:a4-text-dark-red"
                           data-title="{{ __('admin/adm-global-options.support-email-tooltip') }}" />
                    <x-admin.admin-input-label for="glb-support-admin-email">
                        {{ __('admin/adm-global-options.support-email') }}
                    </x-admin.admin-input-label>
                </div>

                <div class="mb-3">
                    <x-admin.admin-select id="glb-under-maintenance" name="glb-under-maintenance"
                            title="{{ __('admin/adm-global-options.maintenance-tooltip') }}">
                        <option value="maintenance">{{ __('admin/adm-global-options.maintenance-on') }}</option>
                        <option value="redirect">{{ __('admin/adm-global-options.maintenance-redirect') }}</option>
                        <option value="off">{{ __('admin/adm-global-options.maintenance-off') }}</option>
                    </x-admin.admin-select>
                    <label data-te-select-label-ref="">{{ __('admin/adm-global-options.maintenance') }}</label>
                </div>
                <div class="relative mb-3" data-te-input-wrapper-init="">
                    <x-admin.admin-text-input type="url" id="glb-redirect-url" name="glb-redirect-url"
                           placeholder="{{ __('admin/adm-global-options.redirect-url') }}"
                           title="{{ __('admin/adm-global-options.redirect-url-tooltip',
                                        ['maintenance' => __('admin/adm-global-options.maintenance'),
                                         'redirect' => __('admin/adm-global-options.maintenance-redirect')]) }}" />
                    <x-admin.admin-input-label for="glb-redirect-url">
                        {{ __('admin/adm-global-options.redirect-url') }}
                    </x-admin.admin-input-label>
                </div>

                <div class="relative">
                    <x-admin.admin-select id="glb-maintenance-banner" name="glb-maintenance-banner"
                            title="{{ __('admin/adm-global-options.banner-tooltip') }}">
                        <option value="Y">{{ __('admin/adm-global-options.banner-yes') }}</option>
                        <option value="N">{{ __('admin/adm-global-options.banner-no') }}</option>
                    </x-admin.admin-select>
                    <label data-te-select-label-ref="">{{ __('admin/adm-global-options.banner') }}</label>
                </div>
                <div id="date-time-data" class="relative grid grid-cols-2 gap-x-2" data-dt-lang="it">
                    <div class="relative" data-te-input-wrapper-init="">
                        <x-admin.admin-text-input type="datetime" id="glb-maintenance-period-start" name="glb-maintenance-period-start" value=" "
                               title="{{ __('admin/adm-global-options.maintenance-start-tooltip') }}" data-datetimepicker="true" readonly="readonly" />
                        <x-admin.admin-input-label for="glb-maintenance-period-start">
                            {{ __('admin/adm-global-options.maintenance-start') }}
                        </x-admin.admin-input-label>
                    </div>
                    <div class="relative" data-te-input-wrapper-init="">
                        <x-admin.admin-text-input type="datetime" id="glb-maintenance-period-end" name="glb-maintenance-period-end" value=" "
                               title="{{ __('admin/adm-global-options.maintenance-end-tooltip') }}" data-datetimepicker="true" readonly="readonly" />
                        <x-admin.admin-input-label for="glb-maintenance-period-end">
                            {{ __('admin/adm-global-options.maintenance-end') }}
                        </x-admin.admin-input-label>
                    </div>
                </div>

                <div class="col-span-2 grid justify-items-end mt-2">
                    <x-admin.admin-button id="save-global-options" class="self-end">
                        Salva
                    </x-admin.admin-button>
                </div>
            </div>
        </form>
    </div>
</div>

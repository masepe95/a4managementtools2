{{-- Customer contacts block. --}}
<div id="customer-contacts-block" class="collapse h-0 page-block max-w-4xl mx-auto my-0 px-6">
    <div class="border-0">
        <h1 class="text-3xl px-4 py-3 border-b-2 a4-bord-shade-100">{!! __('admin/adm-customer-contacts.title') . (($user->role == 'siteAdmin') ? ' &nbsp;<span class="a4-text-shade-300 text-[60%]">«<span id="contacts-customer-name" title="' . __('admin/adm-customer-contacts.title-tooltip') . '"></span>»</span>' : '') !!}</h1>
        <form id="customer-contacts-form" name="customer-contacts-form" class="p-4">
            @csrf
            <p class="text-sm mb-4">{{ __('admin/adm-customer-contacts.description') }}</p>

            <x-error-message id="customer-contacts-errors" class="hidden" data-sql-error="{{ __('admin/adm-customer-contacts.sql-error') }}"></x-error-message>

            <div class="grid grid-cols-2 gap-x-4 gap-y-2">
                <div class="mb-2 col-span-2">
                    <x-admin.admin-select id="customer-contact-names" name="customer-contact-names"
                            data-te-select-visible-options="10" title="{{ __('admin/adm-customer-contacts.contact-tooltip') }}">
                    </x-admin.admin-select>
                    <label data-te-select-label-ref="">{{ __('admin/adm-customer-contacts.contact') }}</label>
                </div>

                <div class="mb-3 col-span-2 flex flex-row gap-x-3 justify-end">
                    <x-admin.admin-button id="edit-customer-contact" class="w-32"
                            title="{{ __('admin/adm-customer-contacts.update-button-tooltip', ['contact' => __('admin/adm-customer-contacts.contact')]) }}">
                        {{ __('globals.update-button') }}
                    </x-admin.admin-button>
                    <x-admin.admin-button id="add-customer-contact" class="w-32"
                            title="{{ __('admin/adm-customer-contacts.add-button-tooltip') }}">
                        {{ __('globals.add-button') }}
                    </x-admin.admin-button>
                    <x-admin.admin-button id="delete-customer-contact" class="w-32"
                            title="{{ __('admin/adm-customer-contacts.delete-button-tooltip', ['contact' => __('admin/adm-customer-contacts.contact')]) }}"
                            data-delete-title="{{ __('admin/adm-customer-contacts.delete-title') }}"
                            data-delete-body="{{ __('admin/adm-customer-contacts.delete-body') }}">
                        {{ __('globals.delete-button') }}
                    </x-admin.admin-button>
                </div>

                <div class="relative mb-3" data-te-input-wrapper-init="">
                    <x-admin.admin-text-input type="text" id="contact-firstname" name="contact-firstname" placeholder="{{ __('admin/adm-customer-contacts.firstname') }}" aria-required="true" class="invalid:a4-text-dark-red" title="" data-title="{{ __('globals.fill-out-field-tooltip') }}" maxlength="64" pattern="^\s*[a-zA-Z].*$" required="required" />
                    <x-admin.admin-input-label for="contact-firstname">
                        {{ __('admin/adm-customer-contacts.firstname') }}
                    </x-admin.admin-input-label>
                </div>
                <div class="relative mb-3" data-te-input-wrapper-init="">
                    <x-admin.admin-text-input type="text" id="contact-lastname" name="contact-lastname" placeholder="{{ __('admin/adm-customer-contacts.lastname') }}" aria-required="true" class="invalid:a4-text-dark-red" title="" data-title="{{ __('globals.fill-out-field-tooltip') }}" maxlength="64" pattern="^\s*[a-zA-Z].*$" required="required" />
                    <x-admin.admin-input-label for="contact-lastname">
                        {{ __('admin/adm-customer-contacts.lastname') }}
                    </x-admin.admin-input-label>
                </div>

                <div class="relative mb-3" data-te-input-wrapper-init="">
                    <x-admin.admin-text-input type="email" id="contact-email" name="contact-email" placeholder="{{ __('admin/adm-customer-contacts.email') }}" aria-required="true" class="invalid:a4-text-dark-red" title="" data-title="{{ __('globals.fill-out-field-tooltip') }}" maxlength="128" required="required" />
                    <x-admin.admin-input-label for="contact-email">
                        {{ __('admin/adm-customer-contacts.email') }}
                    </x-admin.admin-input-label>
                </div>
                <div class="relative mb-3" data-te-input-wrapper-init="">
                    <x-admin.admin-text-input type="text" id="contact-additional-name" name="contact-additional-name" placeholder="{{ __('admin/adm-customer-contacts.addictional-name') }}" maxlength="64" />
                    <x-admin.admin-input-label for="contact-additional-name">
                        {{ __('admin/adm-customer-contacts.additional-name') }}
                    </x-admin.admin-input-label>
                </div>

                <div class="relative mb-3" data-te-input-wrapper-init="">
                    <x-admin.admin-text-input type="tel" id="contact-mobile-phone" name="contact-mobile-phone" placeholder="{{ __('admin/adm-customer-contacts.mobile-phone') }}" maxlength="32" />
                    <x-admin.admin-input-label for="contact-mobile-phone">
                        {{ __('admin/adm-customer-contacts.mobile-phone') }}
                    </x-admin.admin-input-label>
                </div>
                <div class="relative mb-3" data-te-input-wrapper-init="">
                    <x-admin.admin-text-input type="tel" id="contact-phone" name="contact-phone" placeholder="{{ __('admin/adm-customer-contacts.phone') }}" maxlength="32" />
                    <x-admin.admin-input-label for="contact-phone">
                        {{ __('admin/adm-customer-contacts.phone') }}
                    </x-admin.admin-input-label>
                </div>

                <div>
                    <div class="relative" data-te-input-wrapper-init="">
                        <x-admin.admin-text-input type="text" id="contact-job-title" name="contact-job-title" placeholder="{{ __('admin/adm-customer-contacts.job-title') }}o" maxlength="64" />
                        <x-admin.admin-input-label for="contact-job-title">
                            {{ __('admin/adm-customer-contacts.job-title') }}
                        </x-admin.admin-input-label>
                    </div>
                </div>
                <div class="relative bg-white pt-2" data-te-input-wrapper-init="">
                    <x-admin.admin-textarea id="contact-notes" name="contact-notes"
                              placeholder="{{ __('admin/adm-customer-contacts.notes') }}"
                              style="overflow-wrap: normal" data-resize="none"></x-admin.admin-textarea>
                    <x-admin.admin-textarea-label for="contact-notes">
                        {{ __('admin/adm-customer-contacts.notes') }}
                    </x-admin.admin-textarea-label>
                </div>
            </div>
        </form>
    </div>
</div>

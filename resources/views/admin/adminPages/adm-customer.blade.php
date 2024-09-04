{{-- Customer's modal warning. --}}
{{-- Customer's button trigger modal --}}
<div id="customer-tool-warning" data-te-modal-init="" data-te-backdrop="static" data-te-keyboard="true"
     class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
     tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div data-te-modal-dialog-ref=""
         class="pointer-events-none relative w-auto translate-y-[-50px] opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-12 min-[576px]:max-w-[520px]">
        <div class="min-[576px]:shadow-[0_0.5rem_1rem_rgba(#000, 0.15)] pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none dark:bg-neutral-600">
            <div class="flex flex-shrink-0 items-center justify-between rounded-t-md bg-[#ffd630] border-b border-neutral-300 border-opacity-100 p-4 dark:border-opacity-50">
                <!--Modal title-->
                <h5 id="tool-warning-title" class="text-xl font-medium leading-normal text-black dark:text-neutral-200">
                    {{ __('admin/adm-customer.modal-title') }}
                </h5>
                <!--Close button-->
                <button type="button" data-te-modal-dismiss="" aria-label="Close"
                        class="box-content rounded-none border-none hover:no-underline hover:opacity-75 focus:opacity-100 focus:shadow-none focus:outline-none">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke-width="1.5" stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <!--Modal body-->
            <div data-te-modal-body-ref="" class="relative text-sm px-5 py-4 grid grid-cols-[auto_1fr]">
                <div class="mr-4 self-center">
                    <svg class="w-16 h-16" viewBox="0 0 122.88 111.24" xmlns="http://www.w3.org/2000/svg"><path d="M2.5,85l43-74.41h0a22.59,22.59,0,0,1,8-8.35,15.72,15.72,0,0,1,16,0,22.52,22.52,0,0,1,7.93,8.38l.23.44,42.08,73.07a20.91,20.91,0,0,1,3,10.84A16.44,16.44,0,0,1,121,102.4a15.45,15.45,0,0,1-5.74,6,21,21,0,0,1-11.35,2.78v0H17.7c-.21,0-.43,0-.64,0a19,19,0,0,1-7.83-1.74,15.83,15.83,0,0,1-6.65-5.72A16.26,16.26,0,0,1,0,95.18a21.66,21.66,0,0,1,2.2-9.62c.1-.2.2-.4.31-.59Z"></path><path fill="#ffd630" fill-rule="evenodd" d="M9.09,88.78l43-74.38c5.22-8.94,13.49-9.2,18.81,0l42.32,73.49c4.12,6.79,2.41,15.9-9.31,15.72H17.7C9.78,103.79,5,97.44,9.09,88.78Z"></path><path fill="#010101" d="M57.55,83.15a5.47,5.47,0,0,1,5.85-1.22,5.65,5.65,0,0,1,2,1.3A5.49,5.49,0,0,1,67,86.77a5.12,5.12,0,0,1-.08,1.4,5.22,5.22,0,0,1-.42,1.34,5.51,5.51,0,0,1-5.2,3.25,5.63,5.63,0,0,1-2.26-.53,5.51,5.51,0,0,1-2.81-2.92A6,6,0,0,1,55.9,88a5.28,5.28,0,0,1,0-1.31h0a6,6,0,0,1,.56-2,4.6,4.6,0,0,1,1.14-1.56Zm8.12-10.21c-.19,4.78-8.28,4.78-8.46,0-.82-8.19-2.92-27.63-2.85-35.32.07-2.37,2-3.78,4.55-4.31a11.65,11.65,0,0,1,2.48-.25,12.54,12.54,0,0,1,2.5.25c2.59.56,4.63,2,4.63,4.43V38l-2.84,35Z"></path></svg>
                </div>
                <div>
                    <p>{!! __('admin/adm-customer.modal-body1') !!}</p>
                    <div class="warning-list mt-2 ml-4 text-red-500"></div>
                    <p class="mt-2">{!! __('admin/adm-customer.modal-body2') !!}</p>
                </div>
            </div>
            <!--Modal footer-->
            <div class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md border-t border-neutral-300 border-opacity-100 px-5 py-4 dark:border-opacity-50">
                <button type="button" id="close-tool-warning" data-te-modal-dismiss="" data-te-ripple-init="" data-te-ripple-color="light"
                        class="disabled:pointer-events-none disabled:opacity-60 relative inline-block rounded a4-bg-shade-100 px-6 pb-2 pt-2.5 text-xs font-medium tracking-widest uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-500 ease-in-out hover:bg-primary-800 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-800 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-900 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                    {{ __('globals.save-button') }}
                </button>
                <button type="button" data-te-modal-dismiss="" data-te-ripple-init="" data-te-ripple-color="light"
                        class="disabled:pointer-events-none disabled:opacity-60 relative ml-3 inline-block rounded bg-primary-100 px-6 pb-2 pt-2.5 text-xs font-medium tracking-widest uppercase leading-normal text-primary-700 transition duration-500 ease-in-out hover:bg-primary-accent-100 focus:bg-primary-accent-100 focus:outline-none focus:ring-0 active:bg-primary-accent-200">
                    {{ __('globals.close-button') }}
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Customer block. --}}
<div id="customer-block" class="collapse h-0 page-block max-w-4xl mx-auto my-0 px-6">
    <div class="border-0">
        <h1 class="text-3xl px-4 py-3 border-b-2 a4-bord-shade-100">{!! __('admin/adm-customer.title') . (($user->role == 'siteAdmin') ? ' &nbsp;<span class="a4-text-shade-300 text-[60%]">«<span id="customer-customer-name" title="' . __('admin/adm-customer.title-tooltip') . '"></span>»</span>' : '') !!}</h1>
        <form id="customer-form" name="customer-form" class="p-4">
            @csrf
            <p class="text-sm mb-4">{{ __('admin/adm-customer.description') }}</p>

            <x-error-message id="customer-errors" class="hidden"></x-error-message>

            <div class="grid grid-cols-2 gap-x-4 gap-y-2">
                <div class="relative mb-3" data-te-input-wrapper-init="">
                    <x-admin.admin-text-input type="text" id="customer-name" name="customer-name" placeholder="{{ __('admin/adm-customer.name') }}" aria-required="true" class="invalid:a4-text-dark-red" title="" data-title="{{ __('globals.fill-out-field-tooltip') }}" pattern="^\s*[a-zA-Z].*$" maxlength="64" required="required" />
                    <x-admin.admin-input-label for="customer-name">
                        {{ __('admin/adm-customer.name') }}
                    </x-admin.admin-input-label>
                </div>
                <div class="relative mb-3" data-te-input-wrapper-init="">
                    <x-admin.admin-text-input type="text" id="customer-company-uid" name="customer-company-uid" placeholder="{{ __('admin/adm-customer.company-uid') }}" maxlength="32" />
                    <x-admin.admin-input-label for="customer-company-uid">
                        {{ __('admin/adm-customer.company-uid') }}
                    </x-admin.admin-input-label>
                </div>
                <div class="relative mb-3" data-te-input-wrapper-init="">
                    <x-admin.admin-text-input type="text" id="customer-address1" name="customer-address1" placeholder="{{ __('admin/adm-customer.address1') }}" maxlength="128" />
                    <x-admin.admin-input-label for="customer-address1">
                        {{ __('admin/adm-customer.address1') }}
                    </x-admin.admin-input-label>
                </div>
                <div class="relative mb-3" data-te-input-wrapper-init="">
                    <x-admin.admin-text-input type="text" id="customer-address2" name="customer-address2" placeholder="{{ __('admin/adm-customer.address2') }}" maxlength="128" />
                    <x-admin.admin-input-label for="customer-address2">
                        {{ __('admin/adm-customer.address2') }}
                    </x-admin.admin-input-label>
                </div>
                <div class="relative mb-3" data-te-input-wrapper-init="">
                    <x-admin.admin-text-input type="text" id="customer-city" name="customer-city" placeholder="{{ __('admin/adm-customer.city') }}" maxlength="64" />
                    <x-admin.admin-input-label for="customer-city">
                        {{ __('admin/adm-customer.city') }}
                    </x-admin.admin-input-label>
                </div>
                <div class="relative mb-3" data-te-input-wrapper-init="">
                    <x-admin.admin-text-input type="text" id="customer-zip" name="customer-zip" placeholder="{{ __('admin/adm-customer.zip') }}" maxlength="32" />
                    <x-admin.admin-input-label for="customer-zip">
                        {{ __('admin/adm-customer.zip') }}
                    </x-admin.admin-input-label>
                </div>
                <input type="hidden" id="country-loaded" name="country-loaded" value="no" />
                <div class="mb-3">
                    <x-admin.admin-select id="customer-country" name="customer-country"
                            data-te-select-visible-options="8" data-te-select-clear-button="true">
                    </x-admin.admin-select>
                    <label data-te-select-label-ref="">{{ __('admin/adm-customer.country') }}</label>
                </div>
                <div class="mb-3">
                    <x-admin.admin-select id="customer-country-state" name="customer-country-state" data-te-select-visible-options="8">
                    </x-admin.admin-select>
                    <label data-te-select-label-ref="">{{ __('admin/adm-customer.country-state') }}</label>
                </div>
                <div class="relative mb-3" data-te-input-wrapper-init="">
                    <x-admin.admin-text-input type="text" id="customer-vat" name="customer-vat" placeholder="{{ __('admin/adm-customer.vat') }}" maxlength="128" />
                    <x-admin.admin-input-label for="customer-vat">
                        {{ __('admin/adm-customer.vat') }}
                    </x-admin.admin-input-label>
                </div>
                <div class="mb-3">
                    <x-admin.admin-select id="customer-number-users" name="customer-number-users"
                            data-te-select-visible-options="7" data-te-select-clear-button="true">
                        <option value="" hidden></option>
                        <option value="usr1">{{ __('admin/adm-customer.usr1') }}</option>
                        <option value="usr10">{{ __('admin/adm-customer.usr10') }}</option>
                        <option value="usr50">{{ __('admin/adm-customer.usr50') }}</option>
                        <option value="usr100">{{ __('admin/adm-customer.usr100') }}</option>
                        <option value="usr500">{{ __('admin/adm-customer.usr500') }}</option>
                        <option value="usr1000">{{ __('admin/adm-customer.usr1000') }}</option>
                        <option value="usr2000">{{ __('admin/adm-customer.usr2000') }}</option>
                        <option value="usr3000">{{ __('admin/adm-customer.usr3000') }}</option>
                        <option value="usr5000">{{ __('admin/adm-customer.usr5000') }}</option>
                        <option value="usr10000">{{ __('admin/adm-customer.usr10000') }}</option>
                        <option value="usr15000">{{ __('admin/adm-customer.usr15000') }}</option>
                        <option value="usr20000">{{ __('admin/adm-customer.usr20000') }}</option>
                        <option value="usrUnlimited">{{ __('admin/adm-customer.usrUnlimited') }}</option>
                    </x-admin.admin-select>
                    <label data-te-select-label-ref="">{{ __('admin/adm-customer.number-users') }}</label>
                </div>
                <div class="grid justify-items-start pl-3 pr-10 min-h-[270px]">
                    <input type="file" id="customer-logo" name="customer-logo" class="w-0 h-0 opacity-0 overflow-hidden absolute -z-10 outline-0" accept="image/gif,image/jpeg,image/png,image/svg+xml" />
                    <div class="grid grid-cols-[1.75rem_1fr] items-center gap-x-0 w-full">
                        <div id="customer-logo-delete" class="mr-2 cursor-pointer" title="{{ __('admin/adm-customer.customer-logo-delete') }}"><svg class="w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg"><path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"></path><path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"></path></svg></div>
                        <div class="customer-image-box grid justify-items-center items-center text-center w-full h-full p-0 border-2 a4-bord-shade-100" title="{!! __('admin/adm-customer.customer-logo-tooltip') !!}">
                            <label id="customer-logo-label" for="customer-logo" class="flex justify-center items-center w-full h-full cursor-pointer">
                                <span>{!! __('admin/adm-customer.customer-logo') !!}</span>
                                <img id="customer-logo-image" src="" class="hidden w-full" />
                            </label>
                        </div>
                    </div>
                </div>
                <div class="grid grid-rows-[auto_auto_auto_auto_1fr] grid-cols-1 gap-y-2">
                  @if ($user->role == 'siteAdmin')
                    <div class="relative left-[-1.6rem] grid grid-cols-[1.6rem_100%] items-center mb-3">
                        <div class="mr-[0.1rem]" title="{{ __('admin/adm-customer.super-admin-tooltip') }}">
                            <svg class="w-[1.5rem] h-[1.5rem] fill-yellow-500" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M18 12h-2.18c-.17.7-.44 1.35-.81 1.93l1.54 1.54-2.1 2.1-1.54-1.54c-.58.36-1.23.63-1.91.79V19H8v-2.18c-.68-.16-1.33-.43-1.91-.79l-1.54 1.54-2.12-2.12 1.54-1.54c-.36-.58-.63-1.23-.79-1.91H1V9.03h2.17c.16-.7.44-1.35.8-1.94L2.43 5.55l2.1-2.1 1.54 1.54c.58-.37 1.24-.64 1.93-.81V2h3v2.18c.68.16 1.33.43 1.91.79l1.54-1.54 2.12 2.12-1.54 1.54c.36.59.64 1.24.8 1.94H18V12zm-8.5 1.5c1.66 0 3-1.34 3-3s-1.34-3-3-3-3 1.34-3 3 1.34 3 3 3z"></path></svg>
                        </div>
                        <div id="customer-tools-block" class="relative" data-te-dropdown-ref=""
                             data-assigned="{{ __('admin/adm-customer.customer-tools-choices')['yes']['label'] }}"
                             data-assigned-tooltip="{{ __('admin/adm-customer.customer-tools-choices')['yes']['tooltip'] }}"
                             data-unassigned="{{ __('admin/adm-customer.customer-tools-choices')['no']['label'] }}"
                             data-unassigned-tooltip="{{ __('admin/adm-customer.customer-tools-choices')['no']['tooltip'] }}"
                             data-disabled="{{ __('admin/adm-customer.customer-tools-choices')['disabled']['label'] }}"
                             data-disabled-tooltip="{{ __('admin/adm-customer.customer-tools-choices')['disabled']['tooltip'] }}"
                             data-job-count="{{ __('admin/adm-customer.job-count') }}">
                            <x-admin.admin-button id="dropdown-customer-tools"
                                    data-te-dropdown-toggle-ref="" data-te-auto-close="outside" aria-expanded="false">
                                {{ __('admin/adm-customer.customer-tools') }}
                                <span class="absolute right-3 w-5">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path>
                                    </svg>
                                </span>
                            </x-admin.admin-button>
                            <ul id="customer-tools-dropdown" class="absolute z-[1000] float-left m-0 hidden list-none min-w-full max-h-56 overflow-x-hidden overflow-y-auto rounded-lg border border-neutral-300 bg-white bg-clip-padding text-left text-base shadow-lg dark:bg-neutral-700 [&[data-te-dropdown-show]]:block"
                                aria-labelledby="dropdown-customer-tools" data-te-dropdown-menu-ref="">
                            </ul>
                        </div>
                    </div>
                    <div class="relative left-[-1.6rem] grid grid-cols-[1.6rem_100%] items-center mb-3">
                        <div class="mr-[0.1rem]" title="{{ __('admin/adm-customer.super-admin-tooltip') }}">
                            <svg class="w-[1.5rem] h-[1.5rem] fill-yellow-500" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M18 12h-2.18c-.17.7-.44 1.35-.81 1.93l1.54 1.54-2.1 2.1-1.54-1.54c-.58.36-1.23.63-1.91.79V19H8v-2.18c-.68-.16-1.33-.43-1.91-.79l-1.54 1.54-2.12-2.12 1.54-1.54c-.36-.58-.63-1.23-.79-1.91H1V9.03h2.17c.16-.7.44-1.35.8-1.94L2.43 5.55l2.1-2.1 1.54 1.54c.58-.37 1.24-.64 1.93-.81V2h3v2.18c.68.16 1.33.43 1.91.79l1.54-1.54 2.12 2.12-1.54 1.54c.36.59.64 1.24.8 1.94H18V12zm-8.5 1.5c1.66 0 3-1.34 3-3s-1.34-3-3-3-3 1.34-3 3 1.34 3 3 3z"></path></svg>
                        </div>
                        <x-admin.admin-select id="customer-type" name="customer-type">
                        </x-admin.admin-select>
                        <label data-te-select-label-ref="">{{ __('admin/adm-customer.customer-type') }}</label>
                    </div>
                    <div class="relative left-[-1.6rem] grid grid-cols-[1.6rem_100%] items-center mb-3">
                        <div class="mr-[0.1rem]" title="{{ __('admin/adm-customer.super-admin-tooltip') }}">
                            <svg class="w-[1.5rem] h-[1.5rem] fill-yellow-500" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M18 12h-2.18c-.17.7-.44 1.35-.81 1.93l1.54 1.54-2.1 2.1-1.54-1.54c-.58.36-1.23.63-1.91.79V19H8v-2.18c-.68-.16-1.33-.43-1.91-.79l-1.54 1.54-2.12-2.12 1.54-1.54c-.36-.58-.63-1.23-.79-1.91H1V9.03h2.17c.16-.7.44-1.35.8-1.94L2.43 5.55l2.1-2.1 1.54 1.54c.58-.37 1.24-.64 1.93-.81V2h3v2.18c.68.16 1.33.43 1.91.79l1.54-1.54 2.12 2.12-1.54 1.54c.36.59.64 1.24.8 1.94H18V12zm-8.5 1.5c1.66 0 3-1.34 3-3s-1.34-3-3-3-3 1.34-3 3 1.34 3 3 3z"></path></svg>
                        </div>
                        <x-admin.admin-select id="customer-status" name="customer-status">
                        </x-admin.admin-select>
                        <label data-te-select-label-ref="">{{ __('admin/adm-customer.customer-status') }}</label>
                    </div>
                    <div class="relative left-[-1.6rem] grid grid-cols-[1.6rem_100%] items-center mb-3">
                        <div class="mr-[0.1rem]" title="{{ __('admin/adm-customer.super-admin-tooltip') }}">
                            <svg class="w-[1.5rem] h-[1.5rem] fill-yellow-500" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M18 12h-2.18c-.17.7-.44 1.35-.81 1.93l1.54 1.54-2.1 2.1-1.54-1.54c-.58.36-1.23.63-1.91.79V19H8v-2.18c-.68-.16-1.33-.43-1.91-.79l-1.54 1.54-2.12-2.12 1.54-1.54c-.36-.58-.63-1.23-.79-1.91H1V9.03h2.17c.16-.7.44-1.35.8-1.94L2.43 5.55l2.1-2.1 1.54 1.54c.58-.37 1.24-.64 1.93-.81V2h3v2.18c.68.16 1.33.43 1.91.79l1.54-1.54 2.12 2.12-1.54 1.54c.36.59.64 1.24.8 1.94H18V12zm-8.5 1.5c1.66 0 3-1.34 3-3s-1.34-3-3-3-3 1.34-3 3 1.34 3 3 3z"></path></svg>
                        </div>
                        <x-admin.admin-select id="customer-use-saml" name="customer-use-saml">
                            <option value="N">{{ __('admin/adm-customer.use-saml-no') }}</option>
                            <option value="Y">{{ __('admin/adm-customer.use-saml-yes') }}</option>
                        </x-admin.admin-select>
                        <label data-te-select-label-ref="">{{ __('admin/adm-customer.use-saml') }}</label>
                    </div>
                  @else
                    <div></div><div></div><div></div><div></div>
                  @endif
                    <div class="grid justify-items-end self-end">
                        <x-admin.admin-button id="save-customer" class="self-end">
                            {{ __('globals.save-button') }}
                        </x-admin.admin-button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

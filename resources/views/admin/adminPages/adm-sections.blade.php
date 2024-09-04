{{-- Screen modale per il sample dell'organizzazione gerarchica. --}}
<div id="section-sample-preview" tabindex="-1" data-te-modal-init=""
     aria-labelledby="section-sample-preview-label" aria-hidden="true"
     class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none">
    <div data-te-modal-dialog-ref=""
         class="pointer-events-none relative w-auto translate-y-[-50px] opacity-0 transition-all duration-300 ease-in-out min-[0px]:m-0 min-[0px]:h-full min-[0px]:max-w-none">
        <div class="pointer-events-auto relative flex w-full flex-col bg-white bg-clip-padding text-current shadow-lg outline-none dark:bg-neutral-600 min-[0px]:h-full min-[0px]:rounded-none min-[0px]:border-0">
            <div class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50 min-[0px]:rounded-none">
                <!-- Modal title -->
                <h5 id="section-sample-preview-label" class="text-xl font-medium leading-normal text-neutral-800 dark:text-neutral-200">
                    {{ __('admin/adm-sections.modal-title') }}
                </h5>
                <!-- Close button -->
                <button type="button" data-te-modal-dismiss="" aria-label="Close"
                        class="box-content rounded-none border-none hover:no-underline hover:opacity-75 focus:opacity-100 focus:shadow-none focus:outline-none">
                    <svg class="h-6 w-6" viewBox="0 0 24 24" fill="none" stroke-width="1.5" stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <!-- Modal body -->
            <div class="relative p-4 min-[0px]:overflow-y-auto">
                <p class="px-4 text-justify leading-6 mb-0.5">{!! __('admin/adm-sections.modal-body1') !!}</p>
                <p class="px-4 text-justify leading-6 mb-0.5">{!! __('admin/adm-sections.modal-body2') !!}</p>
                <p class="px-4 text-justify leading-6 mb-2">{!! __('admin/adm-sections.modal-body3') !!}</p>
                <div class="px-8"><img src="images/sectionSample.svg" /></div>
            </div>

            <!-- Modal footer -->
            <div class="mt-auto flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md border-t-2 border-neutral-100 border-opacity-100 p-4 dark:border-opacity-50 min-[0px]:rounded-none">
                <button type="button" data-te-modal-dismiss="" data-te-ripple-init="" data-te-ripple-color="light"
                        class="relative inline-block rounded bg-primary-100 px-6 pb-2 pt-2.5 text-xs font-medium tracking-widest uppercase leading-normal text-primary-700 transition duration-500 ease-in-out hover:bg-primary-accent-100 focus:bg-primary-accent-100 focus:outline-none focus:ring-0 active:bg-primary-accent-200">
                    {{ __('globals.close-button') }}
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Sections block. --}}
<div id="sections-block" class="collapse h-0 page-block max-w-4xl mx-auto my-0 px-6">
    <div class="border-0">
        <h1 class="text-3xl px-4 py-3 border-b-2 a4-bord-shade-100">{!! __('admin/adm-sections.title') . (($user->role == 'siteAdmin') ? ' &nbsp;<span class="a4-text-shade-300 text-[60%]">«<span id="sections-customer-name" title="' . __('admin/adm-sections.title-tooltip') . '"></span>»</span>' : '') !!}</h1>
        <form id="sections-form" name="sections-form" class="p-4">
            @csrf
            <div class="text-sm leading-5 mb-4">{!! __('admin/adm-sections.description') !!}</div>

            <x-error-message id="sections-errors" class="hidden" data-sql-error="{{ __('admin/adm-sections.sql-error') }}"></x-error-message>

            <div>
                <div class="grid grid-cols-[auto_1fr] items-center">
                    <span id="org-level-add" class="cursor-pointer" title="{{ __('admin/adm-sections.add-level-tooltip') }}"><svg class="w-6 h-6 fill-neutral-800 hover:a4-fill-shade-300 transition-all duration-300 ease-linear" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg"><path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"></path><path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"></path></svg></span>
                    <div class="grid justify-items-end">
                        <x-admin.admin-button id="save-sections" class="self-end">
                            {{ __('globals.save-button') }}
                        </x-admin.admin-button>
                    </div>
                </div>

                <div id="org-levels-container"
                     data-level-label="{{ __('admin/adm-sections.level-label') }}"
                     data-level-section-label="{{ __('admin/adm-sections.level-section-label') }}"
                     data-level-delete-tooltip="{{ __('admin/adm-sections.level-delete-tooltip') }}"
                     data-add-section-tooltip="{{ __('admin/adm-sections.add-section-tooltip') }}"
                     data-level-error-tooltip="{{ __('admin/adm-sections.level-error-tooltip') }}"
                     data-section-error-tooltip="{{ __('admin/adm-sections.section-error-tooltip') }}"
                     data-section-label="{{ __('admin/adm-sections.section-label') }}"
                     data-section-delete-tooltip="{{ __('admin/adm-sections.section-delete-tooltip') }}"
                     data-parent-section-label="{{ __('admin/adm-sections.parent-section-label') }}"
                     data-section-parent-hover-classes="bg-amber-200"
                     data-section-languages="{{ $languageList }}">
                </div>
            </div>
        </form>
    </div>
</div>

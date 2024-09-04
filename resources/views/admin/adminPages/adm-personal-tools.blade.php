{{-- Personal tools' modal warning. --}}
{{-- Personal tools' button trigger modal --}}
<div id="personal-tool-warning" data-te-modal-init="" data-te-backdrop="static" data-te-keyboard="true"
     class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
     tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div data-te-modal-dialog-ref=""
         class="pointer-events-none relative w-auto translate-y-[-50px] opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-12 min-[576px]:max-w-[520px]">
        <div class="min-[576px]:shadow-[0_0.5rem_1rem_rgba(#000, 0.15)] pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none dark:bg-neutral-600">
            <div class="flex flex-shrink-0 items-center justify-between rounded-t-md bg-[#ffd630] border-b border-neutral-300 border-opacity-100 p-4 dark:border-opacity-50">
                <!--Modal title-->
                <h5 id="personal-tool-warning-title" class="text-xl font-medium leading-normal text-black dark:text-neutral-200">
                    {{ __('admin/adm-personal-tools.modal-title') }}
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
                    <p>{!! __('admin/adm-personal-tools.modal-body1') !!}</p>

                    <div class="warning-list mt-2 ml-4 text-red-500"></div>

                    <p class="mt-2">{!! __('admin/adm-personal-tools.modal-body2') !!}</p>
                </div>
            </div>

            <!--Modal footer-->
            <div class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md border-t border-neutral-300 border-opacity-100 px-5 py-4 dark:border-opacity-50">
                <button type="button" id="close-personal-tool-warning" data-te-modal-dismiss="" data-te-ripple-init="" data-te-ripple-color="light"
                        class="disabled:pointer-events-none disabled:opacity-60 relative inline-block rounded a4-bg-shade-100 px-6 pb-2 pt-2.5 text-xs font-medium tracking-widest uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-500 ease-in-out hover:bg-primary-800 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-800 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-900 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                    {{ __('globals.save-button') }}
                </button>
                <button type="button" data-te-modal-dismiss="" data-te-ripple-init="" data-te-ripple-color="light"
                        class="disabled:pointer-events-none disabled:opacity-60 relative ml-3 inline-block rounded bg-primary-100 px-6 pt-2.5 pb-2 text-xs font-medium tracking-widest uppercase leading-normal text-primary-700 transition duration-500 ease-in-out hover:bg-primary-accent-100 focus:bg-primary-accent-100 focus:outline-none focus:ring-0 active:bg-primary-accent-200">
                    {{ __('globals.close-button') }}
                </button>
            </div>
        </div>
    </div>
</div>

{{-- Personal tools block. --}}
<div id="personal-tools-block" class="collapse h-0 page-block max-w-4xl mx-auto my-0 px-6">
    <div class="border-0">
    <h1 class="text-3xl px-4 py-3 border-b-2 a4-bord-shade-100">{{ __('admin/adm-personal-tools.title') }}</h1>
        <form id="personal-tools-form" name="personal-tools-form" class="p-4">
            @csrf
            <p class="text-sm mb-4">{{ __('admin/adm-personal-tools.description') }}</p>

            <x-error-message id="personal-tools-errors" class="hidden"></x-error-message>

            <div class="grid grid-cols-[55%_45%] gap-x-4 gap-y-2">
                <div class="mb-1 col-span-2">
                    {{-- data-te-select-option-height="52" --}}
                    <x-admin.admin-select id="personal-tool-employee-names" name="personal-tool-employee-names"
                            data-te-select-visible-options="10" data-te-select-option-height="52"
                            title="{{ __('admin/adm-personal-tools.employee-tooltip') }}">
                    </x-admin.admin-select>
                    <label data-te-select-label-ref="">{{ __('admin/adm-personal-tools.employee') }}</label>
                </div>

                <div id="employee-personal-tools-block" class="relative" data-te-dropdown-ref=""
                     title="{{ __('admin/adm-personal-tools.tools-visibility-tooltip') }}">
                    <x-admin.admin-button id="dropdown-personal-tools-tools"
                            data-te-dropdown-toggle-ref="" data-te-auto-close="outside" aria-expanded="false">
                        {{ __('admin/adm-personal-tools.tools-visibility') }}
                        <span class="absolute right-3 w-5">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path>
                            </svg>
                        </span>
                    </x-admin.admin-button>
                    <ul id="personal-tools-dropdown" class="absolute z-[1000] float-left m-0 hidden list-none min-w-full max-h-56 overflow-x-hidden overflow-y-auto rounded-lg border border-neutral-300 bg-white bg-clip-padding text-left text-base shadow-lg dark:bg-neutral-700 [&[data-te-dropdown-show]]:block"
                        aria-labelledby="dropdown-personal-tools-tools" data-te-dropdown-menu-ref="">
                    </ul>
                </div>
                <div class="grid justify-items-end">
                    <x-admin.admin-button id="save-personal-tools" class="self-end">
                        {{ __('globals.save-button') }}
                    </x-admin.admin-button>
                </div>
            </div>
        </form>
    </div>
</div>

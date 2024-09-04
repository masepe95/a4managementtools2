{{-- Tools tags block. --}}
<div id="tools-tags-block" class="collapse h-0 page-block max-w-4xl mx-auto my-0 px-6">
    <div class="border-0">
        <h1 class="text-3xl px-4 py-3 border-b-2 a4-bord-shade-100">{{ __('admin/adm-tools-tags.title') }}</h1>
        <form id="tools-tags-form" name="tools-tags-form" class="p-4">
            @csrf
            <p class="text-sm mb-4">{!! __('admin/adm-tools-tags.description-tool') !!}</p>

            <x-error-message id="tools-tags-errors" class="hidden"></x-error-message>

            <div class="grid grid-cols-1 gap-y-2">
                <div class="mb-1">
                    <x-admin.admin-select id="tool-to-tag-names" name="tool-to-tag-names"
                            data-te-select-visible-options="10" title="{{ __('admin/adm-tools-tags.tool-tooltip') }}">
                    </x-admin.admin-select>
                    <label data-te-select-label-ref="">{{ __('admin/adm-tools-tags.tool') }}</label>
                </div>

                <div class="w-8 h-8 justify-self-center">
                    <svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="currentColor"><path fill-rule="evenodd" d="M1.646 6.646a.5.5 0 0 1 .708 0L8 12.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"></path><path fill-rule="evenodd" d="M1.646 2.646a.5.5 0 0 1 .708 0L8 8.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"></path></svg>
                </div>

                <div class="mb-1">
                    <div id="tag-checks-block" class="relative" data-te-dropdown-ref="">
                        <x-admin.admin-button id="dropdown-tool-tags"
                                data-te-dropdown-toggle-ref="" data-te-auto-close="outside" aria-expanded="false"
                                title="{{ __('admin/adm-tools-tags.tool-tags-tooltip') }}">
                            {{ __('admin/adm-tools-tags.tool-tags') }}<span id="tags-info" class="text-[90%] pl-3 text-cyan-100">(3 Tags selected out of 56)</span>
                            <span class="absolute right-3 w-5">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path>
                                </svg>
                            </span>
                        </x-admin.admin-button>
                        <ul id="tool-tags-dropdown" class="absolute z-[1000] float-left m-0 hidden list-none max-w-full min-w-full max-h-56 overflow-x-hidden overflow-y-auto rounded-lg border border-neutral-300 bg-white bg-clip-padding text-left text-base shadow-lg dark:bg-neutral-700 [&[data-te-dropdown-show]]:block"
                            aria-labelledby="dropdown-tool-tags" data-te-dropdown-menu-ref="">
                        </ul>
                    </div>
                </div>

                <div class="pb-6 border-b-2 a4-bord-shade-100">
                    <div class="grid justify-items-end">
                        <x-admin.admin-button id="save-tool-tags" class="self-end">
                            {{ __('globals.save-button') }}
                        </x-admin.admin-button>
                    </div>
                </div>
            </div>

            <p class="text-sm my-4">{{ __('admin/adm-tools-tags.description-tag') }}</p>

            <div class="grid grid-cols-1 gap-y-2">
                <div class="mb-1">
                    <x-admin.admin-select id="tag-to-tool-names" name="tag-to-tool-names"
                            data-te-select-visible-options="10"
                            title="{{ __('admin/adm-tools-tags.tag-tooltip') }}">
                    </x-admin.admin-select>
                    <label data-te-select-label-ref="">{{ __('admin/adm-tools-tags.tag') }}</label>
                </div>

                <div class="w-8 h-8 justify-self-center">
                    <svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="currentColor"><path fill-rule="evenodd" d="M1.646 6.646a.5.5 0 0 1 .708 0L8 12.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"></path><path fill-rule="evenodd" d="M1.646 2.646a.5.5 0 0 1 .708 0L8 8.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"></path></svg>
                </div>

                <div class="mb-1">
                    <div id="tool-checks-block" class="relative" data-te-dropdown-ref="">
                        <x-admin.admin-button id="dropdown-tag-tools"
                                data-te-dropdown-toggle-ref="" data-te-auto-close="outside" aria-expanded="false"
                                title="{{ __('admin/adm-tools-tags.tag-tools-tooltip') }}">
                            {{ __('admin/adm-tools-tags.tag-tools') }}<span id="tools-info" class="text-[90%] pl-3 text-cyan-100">(3 Tools selected out of 56)</span>
                            <span class="absolute right-3 w-5">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path>
                                </svg>
                            </span>
                        </x-admin.admin-button>
                        <ul id="tag-tools-dropdown" class="absolute z-[1000] float-left m-0 hidden list-none max-w-full min-w-full max-h-56 overflow-x-hidden overflow-y-auto rounded-lg border border-neutral-300 bg-white bg-clip-padding text-left text-base shadow-lg dark:bg-neutral-700 [&[data-te-dropdown-show]]:block"
                            aria-labelledby="dropdown-tag-tools" data-te-dropdown-menu-ref="">
                        </ul>
                    </div>
                </div>

                <div>
                    <div class="grid justify-items-end">
                        <x-admin.admin-button id="save-tag-tools" class="self-end">
                            {{ __('globals.save-button') }}
                        </x-admin.admin-button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

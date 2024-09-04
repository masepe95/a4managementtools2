{{-- Tool datas block. --}}
<div id="tool-datas-block" class="collapse h-0 page-block max-w-4xl mx-auto my-0 px-6">
    <div class="border-0">
        <h1 class="text-3xl px-4 py-3 border-b-2 a4-bord-shade-100">{{ __('admin/adm-tool-datas.title') }}</h1>
        <form id="tool-datas-form" name="tool-datas-form" class="p-4">
            @csrf
            <p class="text-sm mb-4">{!! __('admin/adm-tool-datas.description') !!}</p>

            <x-error-message id="tool-datas-errors" class="hidden"></x-error-message>

            <div class="grid grid-cols-2 gap-x-4 gap-y-2">
                <div class="mb-2">
                    <x-admin.admin-select id="tool-datas-tool" name="tool-datas-tool"
                            data-te-select-visible-options="10" title="{{ __('admin/adm-tool-datas.tool-tooltip') }}">
                    </x-admin.admin-select>
                    <label data-te-select-label-ref="">{{ __('admin/adm-tool-datas.tool') }}</label>
                </div>
                <div class="mb-2">
                    <x-admin.admin-select id="tool-datas-lang" name="tool-datas-lang"
                            data-te-select-visible-options="10" title="{{ __('admin/adm-tool-datas.language-tooltip') }}">
                          @foreach ($languages as $language)
                            <option value="{{ $language->code }}" @selected($language->code == $currentLanguage)>{{ $language->name }}</option>
                          @endforeach
                    </x-admin.admin-select>
                    <label data-te-select-label-ref="">{{ __('admin/adm-tool-datas.language') }}</label>
                </div>

                <div class="col-span-2 flex flex-row justify-end">
                    <x-admin.admin-button id="save-tool-datas" class="w-32"
                            title="{{ __('admin/adm-tool-datas.save-button-tooltip', ['tool' => __('admin/adm-tool-datas.tool'), 'language' => __('admin/adm-tool-datas.language')]) }}">
                        {{ __('globals.save-button') }}
                    </x-admin.admin-button>
                </div>
            </div>

            <div class="data-blk mt-4" data-expand-tooltip="{{ __('globals.expand') }}" data-collapse-tooltip="{{ __('globals.collapse') }}">
                <h1 class="text-xl a4-text-shade-100 border-b-2">
                    <span class="data-expander flex items-center cursor-pointer" title="{{ __('globals.expand') }}" data-expander-name="presentation">
                        <span class="exp-arrow h-5 w-5 shrink-0 transition-transform duration-500 ease-in-out">
                            <svg class="h-5 w-5 stroke-neutral-800 hover:a4-stroke-shade-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path>
                            </svg>
                        </span>
                        <span class="pl-1">{{ __('admin/adm-tool-datas.presentation') }}</span>
                    </span>
                </h1>
                <div class="data-content delayed-hidden pl-6">
                    <div class="data-text-container grid grid-cols-[auto_1fr] gap-x-2">
                        <div class="pt-2 mt-4 flex flex-wrap gap-y-3 self-start w-5">
                            <span class="data-preview" title="{{ __('admin/adm-tool-datas.data-preview') }}">
                                <svg class="w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 1h17v2h-17v-2zm0 7h17v-2h-17v2zm0 5h17v-2h-17v2zm0 5h17v-2h-17v2zm0 5h17v-2h-17v2zm-5-22c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 9c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 9c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2z"></path>
                                </svg>
                            </span>
                            <span class="data-word-wrap cursor-pointer" title="{{ __('admin/adm-tool-datas.data-word-wrap') }}">
                                <svg class="w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <g transform="matrix(0.42 0 0 0.42 12 12)"><g><g transform="matrix(1 0 0 1 0 0)"><path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: inherit; fill-rule: nonzero; opacity: 1;" transform=" translate(-24, -24)" d="M 6 8 L 42 8 L 42 12 L 6 12 z M 6 36 L 16 36 L 16 40 L 6 40 z M 33 40 L 26 40 L 26 36 L 33 36 C 35.8 36 38 33.8 38 31 C 38 28.200000000000003 35.8 26 33 26 L 6 26 L 6 22 L 33 22 C 38 22 42 26 42 31 C 42 36 38 40 33 40 z" stroke-linecap="round"></path></g><g transform="matrix(1 0 0 1 -1 14)"><path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: inherit; fill-rule: nonzero; opacity: 1;" transform=" translate(-23, -38)" d="M 26 44 L 20 38 L 26 32 z" stroke-linecap="round"></path></g></g></g>
                                </svg>
                            </span>
                            <span class="data-reset-height cursor-pointer" title="{{ __('admin/adm-tool-datas.data-reset-height') }}">
                                <svg class="w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300" viewBox="0 0 20 24" clip-rule="evenodd" fill-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2" xmlns="http://www.w3.org/2000/svg">
                                    <path d="m3.508 6.726c1.765-2.836 4.911-4.726 8.495-4.726 5.518 0 9.997 4.48 9.997 9.997 0 5.519-4.479 9.999-9.997 9.999-5.245 0-9.553-4.048-9.966-9.188-.024-.302.189-.811.749-.811.391 0 .715.3.747.69.351 4.369 4.012 7.809 8.47 7.809 4.69 0 8.497-3.808 8.497-8.499 0-4.689-3.807-8.497-8.497-8.497-3.037 0-5.704 1.597-7.206 3.995l1.991.005c.414 0 .75.336.75.75s-.336.75-.75.75h-4.033c-.414 0-.75-.336-.75-.75v-4.049c0-.414.336-.75.75-.75s.75.335.75.75zm8.492 2.272c1.656 0 3 1.344 3 3s-1.344 3-3 3-3-1.344-3-3 1.344-3 3-3z" fill-rule="nonzero"></path>
                                </svg>
                            </span>
                        </div>
                        <div class="relative bg-white pt-2 mt-4" data-te-input-wrapper-init="">
                            <x-admin.admin-textarea id="data-alphabetical-index" name="data-alphabetical-index"
                                    placeholder="{{ __('admin/adm-tool-datas.presentation-alphabetical-index') }}" style="overflow-wrap: normal"></x-admin.admin-textarea>
                            <x-admin.admin-textarea-label for="data-alphabetical-index">
                                {{ __('admin/adm-tool-datas.presentation-alphabetical-index') }}
                            </x-admin.admin-textarea-label>
                        </div>
                    </div>

                    <div class="data-text-container grid grid-cols-[auto_1fr] gap-x-2">
                        <div class="pt-2 mt-4 flex flex-wrap gap-y-3 self-start w-5">
                            <span class="data-preview" title="{{ __('admin/adm-tool-datas.data-preview') }}">
                                <svg class="w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 1h17v2h-17v-2zm0 7h17v-2h-17v2zm0 5h17v-2h-17v2zm0 5h17v-2h-17v2zm0 5h17v-2h-17v2zm-5-22c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 9c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 9c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2z"></path>
                                </svg>
                            </span>
                            <span class="data-word-wrap cursor-pointer" title="{{ __('admin/adm-tool-datas.data-word-wrap') }}">
                                <svg class="w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <g transform="matrix(0.42 0 0 0.42 12 12)"><g><g transform="matrix(1 0 0 1 0 0)"><path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: inherit; fill-rule: nonzero; opacity: 1;" transform=" translate(-24, -24)" d="M 6 8 L 42 8 L 42 12 L 6 12 z M 6 36 L 16 36 L 16 40 L 6 40 z M 33 40 L 26 40 L 26 36 L 33 36 C 35.8 36 38 33.8 38 31 C 38 28.200000000000003 35.8 26 33 26 L 6 26 L 6 22 L 33 22 C 38 22 42 26 42 31 C 42 36 38 40 33 40 z" stroke-linecap="round"></path></g><g transform="matrix(1 0 0 1 -1 14)"><path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: inherit; fill-rule: nonzero; opacity: 1;" transform=" translate(-23, -38)" d="M 26 44 L 20 38 L 26 32 z" stroke-linecap="round"></path></g></g></g>
                                </svg>
                            </span>
                            <span class="data-reset-height cursor-pointer" title="{{ __('admin/adm-tool-datas.data-reset-height') }}">
                                <svg class="w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300" viewBox="0 0 20 24" clip-rule="evenodd" fill-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2" xmlns="http://www.w3.org/2000/svg">
                                    <path d="m3.508 6.726c1.765-2.836 4.911-4.726 8.495-4.726 5.518 0 9.997 4.48 9.997 9.997 0 5.519-4.479 9.999-9.997 9.999-5.245 0-9.553-4.048-9.966-9.188-.024-.302.189-.811.749-.811.391 0 .715.3.747.69.351 4.369 4.012 7.809 8.47 7.809 4.69 0 8.497-3.808 8.497-8.499 0-4.689-3.807-8.497-8.497-8.497-3.037 0-5.704 1.597-7.206 3.995l1.991.005c.414 0 .75.336.75.75s-.336.75-.75.75h-4.033c-.414 0-.75-.336-.75-.75v-4.049c0-.414.336-.75.75-.75s.75.335.75.75zm8.492 2.272c1.656 0 3 1.344 3 3s-1.344 3-3 3-3-1.344-3-3 1.344-3 3-3z" fill-rule="nonzero"></path>
                                </svg>
                            </span>
                        </div>
                        <div class="relative bg-white pt-2 mt-4" data-te-input-wrapper-init="">
                            <x-admin.admin-textarea id="data-subtitle" name="data-subtitle"
                                      placeholder="{{ __('admin/adm-tool-datas.presentation-subtitle') }}" style="overflow-wrap: normal"></x-admin.admin-textarea>
                            <x-admin.admin-textarea-label for="data-subtitle">
                                {{ __('admin/adm-tool-datas.presentation-subtitle') }}
                            </x-admin.admin-textarea-label>
                        </div>
                    </div>

                    <div class="data-text-container grid grid-cols-[auto_1fr] gap-x-2">
                        <div class="pt-2 mt-4 flex flex-wrap gap-y-3 self-start w-5">
                            <span class="data-preview" title="{{ __('admin/adm-tool-datas.data-preview') }}">
                                <svg class="w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 1h17v2h-17v-2zm0 7h17v-2h-17v2zm0 5h17v-2h-17v2zm0 5h17v-2h-17v2zm0 5h17v-2h-17v2zm-5-22c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 9c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 9c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2z"></path>
                                </svg>
                            </span>
                            <span class="data-word-wrap cursor-pointer" title="{{ __('admin/adm-tool-datas.data-word-wrap') }}">
                                <svg class="w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <g transform="matrix(0.42 0 0 0.42 12 12)"><g><g transform="matrix(1 0 0 1 0 0)"><path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: inherit; fill-rule: nonzero; opacity: 1;" transform=" translate(-24, -24)" d="M 6 8 L 42 8 L 42 12 L 6 12 z M 6 36 L 16 36 L 16 40 L 6 40 z M 33 40 L 26 40 L 26 36 L 33 36 C 35.8 36 38 33.8 38 31 C 38 28.200000000000003 35.8 26 33 26 L 6 26 L 6 22 L 33 22 C 38 22 42 26 42 31 C 42 36 38 40 33 40 z" stroke-linecap="round"></path></g><g transform="matrix(1 0 0 1 -1 14)"><path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: inherit; fill-rule: nonzero; opacity: 1;" transform=" translate(-23, -38)" d="M 26 44 L 20 38 L 26 32 z" stroke-linecap="round"></path></g></g></g>
                                </svg>
                            </span>
                            <span class="data-reset-height cursor-pointer" title="{{ __('admin/adm-tool-datas.data-reset-height') }}">
                                <svg class="w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300" viewBox="0 0 20 24" clip-rule="evenodd" fill-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2" xmlns="http://www.w3.org/2000/svg">
                                    <path d="m3.508 6.726c1.765-2.836 4.911-4.726 8.495-4.726 5.518 0 9.997 4.48 9.997 9.997 0 5.519-4.479 9.999-9.997 9.999-5.245 0-9.553-4.048-9.966-9.188-.024-.302.189-.811.749-.811.391 0 .715.3.747.69.351 4.369 4.012 7.809 8.47 7.809 4.69 0 8.497-3.808 8.497-8.499 0-4.689-3.807-8.497-8.497-8.497-3.037 0-5.704 1.597-7.206 3.995l1.991.005c.414 0 .75.336.75.75s-.336.75-.75.75h-4.033c-.414 0-.75-.336-.75-.75v-4.049c0-.414.336-.75.75-.75s.75.335.75.75zm8.492 2.272c1.656 0 3 1.344 3 3s-1.344 3-3 3-3-1.344-3-3 1.344-3 3-3z" fill-rule="nonzero"></path>
                                </svg>
                            </span>
                        </div>
                        <div class="relative bg-white pt-2 mt-4" data-te-input-wrapper-init="">
                            <x-admin.admin-textarea id="data-introduction" name="data-introduction"
                                      placeholder="{{ __('admin/adm-tool-datas.presentation-introduction') }}" style="overflow-wrap: normal"></x-admin.admin-textarea>
                            <x-admin.admin-textarea-label for="data-introduction">
                                {{ __('admin/adm-tool-datas.presentation-introduction') }}
                            </x-admin.admin-textarea-label>
                        </div>
                    </div>

                    <div class="data-text-container grid grid-cols-[auto_1fr] gap-x-2">
                        <div class="pt-2 mt-4 flex flex-wrap gap-y-3 self-start w-5">
                            <span class="data-preview" title="{{ __('admin/adm-tool-datas.data-preview') }}">
                                <svg class="w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 1h17v2h-17v-2zm0 7h17v-2h-17v2zm0 5h17v-2h-17v2zm0 5h17v-2h-17v2zm0 5h17v-2h-17v2zm-5-22c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 9c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 9c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2z"></path>
                                </svg>
                            </span>
                            <span class="data-word-wrap cursor-pointer" title="{{ __('admin/adm-tool-datas.data-word-wrap') }}">
                                <svg class="w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <g transform="matrix(0.42 0 0 0.42 12 12)"><g><g transform="matrix(1 0 0 1 0 0)"><path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: inherit; fill-rule: nonzero; opacity: 1;" transform=" translate(-24, -24)" d="M 6 8 L 42 8 L 42 12 L 6 12 z M 6 36 L 16 36 L 16 40 L 6 40 z M 33 40 L 26 40 L 26 36 L 33 36 C 35.8 36 38 33.8 38 31 C 38 28.200000000000003 35.8 26 33 26 L 6 26 L 6 22 L 33 22 C 38 22 42 26 42 31 C 42 36 38 40 33 40 z" stroke-linecap="round"></path></g><g transform="matrix(1 0 0 1 -1 14)"><path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: inherit; fill-rule: nonzero; opacity: 1;" transform=" translate(-23, -38)" d="M 26 44 L 20 38 L 26 32 z" stroke-linecap="round"></path></g></g></g>
                                </svg>
                            </span>
                            <span class="data-reset-height cursor-pointer" title="{{ __('admin/adm-tool-datas.data-reset-height') }}">
                                <svg class="w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300" viewBox="0 0 20 24" clip-rule="evenodd" fill-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2" xmlns="http://www.w3.org/2000/svg">
                                    <path d="m3.508 6.726c1.765-2.836 4.911-4.726 8.495-4.726 5.518 0 9.997 4.48 9.997 9.997 0 5.519-4.479 9.999-9.997 9.999-5.245 0-9.553-4.048-9.966-9.188-.024-.302.189-.811.749-.811.391 0 .715.3.747.69.351 4.369 4.012 7.809 8.47 7.809 4.69 0 8.497-3.808 8.497-8.499 0-4.689-3.807-8.497-8.497-8.497-3.037 0-5.704 1.597-7.206 3.995l1.991.005c.414 0 .75.336.75.75s-.336.75-.75.75h-4.033c-.414 0-.75-.336-.75-.75v-4.049c0-.414.336-.75.75-.75s.75.335.75.75zm8.492 2.272c1.656 0 3 1.344 3 3s-1.344 3-3 3-3-1.344-3-3 1.344-3 3-3z" fill-rule="nonzero"></path>
                                </svg>
                            </span>
                        </div>
                        <div class="relative bg-white pt-2 mt-4" data-te-input-wrapper-init="">
                            <x-admin.admin-textarea id="data-presentation" name="data-presentation"
                                      placeholder="{{ __('admin/adm-tool-datas.presentation-presentation') }}" style="overflow-wrap: normal"></x-admin.admin-textarea>
                            <x-admin.admin-textarea-label for="data-presentation">
                                {{ __('admin/adm-tool-datas.presentation-presentation') }}
                            </x-admin.admin-textarea-label>
                        </div>
                    </div>

                    <div class="data-text-container grid grid-cols-[auto_1fr] gap-x-2">
                        <div class="pt-2 mt-4 flex flex-wrap gap-y-3 self-start w-5">
                            <span class="data-preview" title="{{ __('admin/adm-tool-datas.data-preview') }}">
                                <svg class="w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 1h17v2h-17v-2zm0 7h17v-2h-17v2zm0 5h17v-2h-17v2zm0 5h17v-2h-17v2zm0 5h17v-2h-17v2zm-5-22c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 9c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 9c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2z"></path>
                                </svg>
                            </span>
                            <span class="data-word-wrap cursor-pointer" title="{{ __('admin/adm-tool-datas.data-word-wrap') }}">
                                <svg class="w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <g transform="matrix(0.42 0 0 0.42 12 12)"><g><g transform="matrix(1 0 0 1 0 0)"><path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: inherit; fill-rule: nonzero; opacity: 1;" transform=" translate(-24, -24)" d="M 6 8 L 42 8 L 42 12 L 6 12 z M 6 36 L 16 36 L 16 40 L 6 40 z M 33 40 L 26 40 L 26 36 L 33 36 C 35.8 36 38 33.8 38 31 C 38 28.200000000000003 35.8 26 33 26 L 6 26 L 6 22 L 33 22 C 38 22 42 26 42 31 C 42 36 38 40 33 40 z" stroke-linecap="round"></path></g><g transform="matrix(1 0 0 1 -1 14)"><path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: inherit; fill-rule: nonzero; opacity: 1;" transform=" translate(-23, -38)" d="M 26 44 L 20 38 L 26 32 z" stroke-linecap="round"></path></g></g></g>
                                </svg>
                            </span>
                            <span class="data-reset-height cursor-pointer" title="{{ __('admin/adm-tool-datas.data-reset-height') }}">
                                <svg class="w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300" viewBox="0 0 20 24" clip-rule="evenodd" fill-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2" xmlns="http://www.w3.org/2000/svg">
                                    <path d="m3.508 6.726c1.765-2.836 4.911-4.726 8.495-4.726 5.518 0 9.997 4.48 9.997 9.997 0 5.519-4.479 9.999-9.997 9.999-5.245 0-9.553-4.048-9.966-9.188-.024-.302.189-.811.749-.811.391 0 .715.3.747.69.351 4.369 4.012 7.809 8.47 7.809 4.69 0 8.497-3.808 8.497-8.499 0-4.689-3.807-8.497-8.497-8.497-3.037 0-5.704 1.597-7.206 3.995l1.991.005c.414 0 .75.336.75.75s-.336.75-.75.75h-4.033c-.414 0-.75-.336-.75-.75v-4.049c0-.414.336-.75.75-.75s.75.335.75.75zm8.492 2.272c1.656 0 3 1.344 3 3s-1.344 3-3 3-3-1.344-3-3 1.344-3 3-3z" fill-rule="nonzero"></path>
                                </svg>
                            </span>
                        </div>
                        <div class="relative bg-white pt-2 mt-4" data-te-input-wrapper-init="">
                            <x-admin.admin-textarea id="data-potential" name="data-potential"
                                      placeholder="{{ __('admin/adm-tool-datas.presentation-potential') }}" style="overflow-wrap: normal"></x-admin.admin-textarea>
                            <x-admin.admin-textarea-label for="data-potential">
                                {{ __('admin/adm-tool-datas.presentation-potential') }}
                            </x-admin.admin-textarea-label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="data-blk mt-4">
                <h1 class="text-xl a4-text-shade-100 border-b-2">
                    <span class="data-expander flex items-center cursor-pointer" title="{{ __('globals.expand') }}" data-expander-name="solved-problems">
                        <span class="exp-arrow transition-transform duration-500 ease-in-out">
                            <svg class="h-5 w-5 stroke-neutral-800 hover:a4-stroke-shade-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path>
                            </svg>
                        </span>
                        <span class="pl-1">{{ __('admin/adm-tool-datas.problems') }}</span>
                    </span>
                </h1>
                <div class="data-content delayed-hidden pl-6">
                    <div class="data-text-container grid grid-cols-[auto_1fr] gap-x-2">
                        <div class="pt-2 mt-4 flex flex-wrap gap-y-3 self-start w-5">
                            <span class="data-preview" title="{{ __('admin/adm-tool-datas.data-preview') }}">
                                <svg class="w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 1h17v2h-17v-2zm0 7h17v-2h-17v2zm0 5h17v-2h-17v2zm0 5h17v-2h-17v2zm0 5h17v-2h-17v2zm-5-22c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 9c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 9c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2z"></path>
                                </svg>
                            </span>
                            <span class="data-word-wrap cursor-pointer" title="{{ __('admin/adm-tool-datas.data-word-wrap') }}">
                                <svg class="w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <g transform="matrix(0.42 0 0 0.42 12 12)"><g><g transform="matrix(1 0 0 1 0 0)"><path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: inherit; fill-rule: nonzero; opacity: 1;" transform=" translate(-24, -24)" d="M 6 8 L 42 8 L 42 12 L 6 12 z M 6 36 L 16 36 L 16 40 L 6 40 z M 33 40 L 26 40 L 26 36 L 33 36 C 35.8 36 38 33.8 38 31 C 38 28.200000000000003 35.8 26 33 26 L 6 26 L 6 22 L 33 22 C 38 22 42 26 42 31 C 42 36 38 40 33 40 z" stroke-linecap="round"></path></g><g transform="matrix(1 0 0 1 -1 14)"><path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: inherit; fill-rule: nonzero; opacity: 1;" transform=" translate(-23, -38)" d="M 26 44 L 20 38 L 26 32 z" stroke-linecap="round"></path></g></g></g>
                                </svg>
                            </span>
                            <span class="data-reset-height cursor-pointer" title="{{ __('admin/adm-tool-datas.data-reset-height') }}">
                                <svg class="w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300" viewBox="0 0 20 24" clip-rule="evenodd" fill-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2" xmlns="http://www.w3.org/2000/svg">
                                    <path d="m3.508 6.726c1.765-2.836 4.911-4.726 8.495-4.726 5.518 0 9.997 4.48 9.997 9.997 0 5.519-4.479 9.999-9.997 9.999-5.245 0-9.553-4.048-9.966-9.188-.024-.302.189-.811.749-.811.391 0 .715.3.747.69.351 4.369 4.012 7.809 8.47 7.809 4.69 0 8.497-3.808 8.497-8.499 0-4.689-3.807-8.497-8.497-8.497-3.037 0-5.704 1.597-7.206 3.995l1.991.005c.414 0 .75.336.75.75s-.336.75-.75.75h-4.033c-.414 0-.75-.336-.75-.75v-4.049c0-.414.336-.75.75-.75s.75.335.75.75zm8.492 2.272c1.656 0 3 1.344 3 3s-1.344 3-3 3-3-1.344-3-3 1.344-3 3-3z" fill-rule="nonzero"></path>
                                </svg>
                            </span>
                        </div>
                        <div class="relative bg-white pt-2 mt-4" data-te-input-wrapper-init="">
                            <x-admin.admin-textarea id="data-solved-problem" name="data-solved-problem"
                                      placeholder="{{ __('admin/adm-tool-datas.problems-solved') }}" style="overflow-wrap: normal"></x-admin.admin-textarea>
                            <x-admin.admin-textarea-label for="data-solved-problem">
                                {{ __('admin/adm-tool-datas.problems-solved') }}
                            </x-admin.admin-textarea-label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="data-blk mt-4">
                <h1 class="text-xl a4-text-shade-100 border-b-2">
                    <span class="data-expander flex items-center cursor-pointer" title="{{ __('globals.expand') }}" data-expander-name="instructions">
                        <span class="exp-arrow transition-transform duration-500 ease-in-out">
                            <svg class="h-5 w-5 stroke-neutral-800 hover:a4-stroke-shade-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path>
                            </svg>
                        </span>
                        <span class="pl-1">{{ __('admin/adm-tool-datas.instructions') }}</span>
                    </span>
                </h1>
                <div class="data-content delayed-hidden pl-6">
                    <div class="data-text-container grid grid-cols-[auto_1fr] gap-x-2">
                        <div class="pt-2 mt-4 flex flex-wrap gap-y-3 self-start w-5">
                            <span class="data-preview" title="{{ __('admin/adm-tool-datas.data-preview') }}">
                                <svg class="w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 1h17v2h-17v-2zm0 7h17v-2h-17v2zm0 5h17v-2h-17v2zm0 5h17v-2h-17v2zm0 5h17v-2h-17v2zm-5-22c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 9c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 9c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2z"></path>
                                </svg>
                            </span>
                            <span class="data-word-wrap cursor-pointer" title="{{ __('admin/adm-tool-datas.data-word-wrap') }}">
                                <svg class="w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <g transform="matrix(0.42 0 0 0.42 12 12)"><g><g transform="matrix(1 0 0 1 0 0)"><path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: inherit; fill-rule: nonzero; opacity: 1;" transform=" translate(-24, -24)" d="M 6 8 L 42 8 L 42 12 L 6 12 z M 6 36 L 16 36 L 16 40 L 6 40 z M 33 40 L 26 40 L 26 36 L 33 36 C 35.8 36 38 33.8 38 31 C 38 28.200000000000003 35.8 26 33 26 L 6 26 L 6 22 L 33 22 C 38 22 42 26 42 31 C 42 36 38 40 33 40 z" stroke-linecap="round"></path></g><g transform="matrix(1 0 0 1 -1 14)"><path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: inherit; fill-rule: nonzero; opacity: 1;" transform=" translate(-23, -38)" d="M 26 44 L 20 38 L 26 32 z" stroke-linecap="round"></path></g></g></g>
                                </svg>
                            </span>
                            <span class="data-reset-height cursor-pointer" title="{{ __('admin/adm-tool-datas.data-reset-height') }}">
                                <svg class="w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300" viewBox="0 0 20 24" clip-rule="evenodd" fill-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2" xmlns="http://www.w3.org/2000/svg">
                                    <path d="m3.508 6.726c1.765-2.836 4.911-4.726 8.495-4.726 5.518 0 9.997 4.48 9.997 9.997 0 5.519-4.479 9.999-9.997 9.999-5.245 0-9.553-4.048-9.966-9.188-.024-.302.189-.811.749-.811.391 0 .715.3.747.69.351 4.369 4.012 7.809 8.47 7.809 4.69 0 8.497-3.808 8.497-8.499 0-4.689-3.807-8.497-8.497-8.497-3.037 0-5.704 1.597-7.206 3.995l1.991.005c.414 0 .75.336.75.75s-.336.75-.75.75h-4.033c-.414 0-.75-.336-.75-.75v-4.049c0-.414.336-.75.75-.75s.75.335.75.75zm8.492 2.272c1.656 0 3 1.344 3 3s-1.344 3-3 3-3-1.344-3-3 1.344-3 3-3z" fill-rule="nonzero"></path>
                                </svg>
                            </span>
                        </div>
                        <div class="relative bg-white pt-2 mt-4" data-te-input-wrapper-init="">
                            <x-admin.admin-textarea id="data-instructions-for-use" name="data-instructions-for-use"
                                      placeholder="{{ __('admin/adm-tool-datas.instructions-for-use') }}" style="overflow-wrap: normal"></x-admin.admin-textarea>
                            <x-admin.admin-textarea-label for="data-instructions-for-use">
                                {{ __('admin/adm-tool-datas.instructions-for-use') }}
                            </x-admin.admin-textarea-label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="data-blk mt-4">
                <h1 class="text-xl a4-text-shade-100 border-b-2">
                    <span class="data-expander flex items-center cursor-pointer" title="{{ __('globals.expand') }}" data-expander-name="advanced-techniques">
                        <span class="exp-arrow transition-transform duration-500 ease-in-out">
                            <svg class="h-5 w-5 stroke-neutral-800 hover:a4-stroke-shade-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path>
                            </svg>
                        </span>
                        <span class="pl-1">{{ __('admin/adm-tool-datas.techniques') }}</span>
                    </span>
                </h1>
                <div class="data-content delayed-hidden pl-6">
                    <div class="data-text-container grid grid-cols-[auto_1fr] gap-x-2">
                        <div class="pt-2 mt-4 flex flex-wrap gap-y-3 self-start w-5">
                            <span class="data-preview" title="{{ __('admin/adm-tool-datas.data-preview') }}">
                                <svg class="w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 1h17v2h-17v-2zm0 7h17v-2h-17v2zm0 5h17v-2h-17v2zm0 5h17v-2h-17v2zm0 5h17v-2h-17v2zm-5-22c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 9c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 9c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2z"></path>
                                </svg>
                            </span>
                            <span class="data-word-wrap cursor-pointer" title="{{ __('admin/adm-tool-datas.data-word-wrap') }}">
                                <svg class="w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <g transform="matrix(0.42 0 0 0.42 12 12)"><g><g transform="matrix(1 0 0 1 0 0)"><path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: inherit; fill-rule: nonzero; opacity: 1;" transform=" translate(-24, -24)" d="M 6 8 L 42 8 L 42 12 L 6 12 z M 6 36 L 16 36 L 16 40 L 6 40 z M 33 40 L 26 40 L 26 36 L 33 36 C 35.8 36 38 33.8 38 31 C 38 28.200000000000003 35.8 26 33 26 L 6 26 L 6 22 L 33 22 C 38 22 42 26 42 31 C 42 36 38 40 33 40 z" stroke-linecap="round"></path></g><g transform="matrix(1 0 0 1 -1 14)"><path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: inherit; fill-rule: nonzero; opacity: 1;" transform=" translate(-23, -38)" d="M 26 44 L 20 38 L 26 32 z" stroke-linecap="round"></path></g></g></g>
                                </svg>
                            </span>
                            <span class="data-reset-height cursor-pointer" title="{{ __('admin/adm-tool-datas.data-reset-height') }}">
                                <svg class="w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300" viewBox="0 0 20 24" clip-rule="evenodd" fill-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2" xmlns="http://www.w3.org/2000/svg">
                                    <path d="m3.508 6.726c1.765-2.836 4.911-4.726 8.495-4.726 5.518 0 9.997 4.48 9.997 9.997 0 5.519-4.479 9.999-9.997 9.999-5.245 0-9.553-4.048-9.966-9.188-.024-.302.189-.811.749-.811.391 0 .715.3.747.69.351 4.369 4.012 7.809 8.47 7.809 4.69 0 8.497-3.808 8.497-8.499 0-4.689-3.807-8.497-8.497-8.497-3.037 0-5.704 1.597-7.206 3.995l1.991.005c.414 0 .75.336.75.75s-.336.75-.75.75h-4.033c-.414 0-.75-.336-.75-.75v-4.049c0-.414.336-.75.75-.75s.75.335.75.75zm8.492 2.272c1.656 0 3 1.344 3 3s-1.344 3-3 3-3-1.344-3-3 1.344-3 3-3z" fill-rule="nonzero"></path>
                                </svg>
                            </span>
                        </div>
                        <div class="relative bg-white pt-2 mt-4" data-te-input-wrapper-init="">
                            <x-admin.admin-textarea id="data-advanced-techniques" name="data-advanced-techniques"
                                      placeholder="{{ __('admin/adm-tool-datas.techniques-advanced') }}" style="overflow-wrap: normal"></x-admin.admin-textarea>
                            <x-admin.admin-textarea-label for="data-advanced-techniques">
                                {{ __('admin/adm-tool-datas.techniques-advanced') }}
                            </x-admin.admin-textarea-label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="data-blk mt-4">
                <h1 class="text-xl a4-text-shade-100 border-b-2">
                    <span class="data-expander flex items-center cursor-pointer" title="{{ __('globals.expand') }}" data-expander-name="risks">
                        <span class="exp-arrow transition-transform duration-500 ease-in-out">
                            <svg class="h-5 w-5 stroke-neutral-800 hover:a4-stroke-shade-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path>
                            </svg>
                        </span>
                        <span class="pl-1">{{ __('admin/adm-tool-datas.risks') }}</span>
                    </span>
                </h1>
                <div class="data-content delayed-hidden pl-6">
                    <div class="data-text-container grid grid-cols-[auto_1fr] gap-x-2">
                        <div class="pt-2 mt-4 flex flex-wrap gap-y-3 self-start w-5">
                            <span class="data-preview" title="{{ __('admin/adm-tool-datas.data-preview') }}">
                                <svg class="w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 1h17v2h-17v-2zm0 7h17v-2h-17v2zm0 5h17v-2h-17v2zm0 5h17v-2h-17v2zm0 5h17v-2h-17v2zm-5-22c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 9c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 9c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2z"></path>
                                </svg>
                            </span>
                            <span class="data-word-wrap cursor-pointer" title="{{ __('admin/adm-tool-datas.data-word-wrap') }}">
                                <svg class="w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <g transform="matrix(0.42 0 0 0.42 12 12)"><g><g transform="matrix(1 0 0 1 0 0)"><path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: inherit; fill-rule: nonzero; opacity: 1;" transform=" translate(-24, -24)" d="M 6 8 L 42 8 L 42 12 L 6 12 z M 6 36 L 16 36 L 16 40 L 6 40 z M 33 40 L 26 40 L 26 36 L 33 36 C 35.8 36 38 33.8 38 31 C 38 28.200000000000003 35.8 26 33 26 L 6 26 L 6 22 L 33 22 C 38 22 42 26 42 31 C 42 36 38 40 33 40 z" stroke-linecap="round"></path></g><g transform="matrix(1 0 0 1 -1 14)"><path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: inherit; fill-rule: nonzero; opacity: 1;" transform=" translate(-23, -38)" d="M 26 44 L 20 38 L 26 32 z" stroke-linecap="round"></path></g></g></g>
                                </svg>
                            </span>
                            <span class="data-reset-height cursor-pointer" title="{{ __('admin/adm-tool-datas.data-reset-height') }}">
                                <svg class="w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300" viewBox="0 0 20 24" clip-rule="evenodd" fill-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2" xmlns="http://www.w3.org/2000/svg">
                                    <path d="m3.508 6.726c1.765-2.836 4.911-4.726 8.495-4.726 5.518 0 9.997 4.48 9.997 9.997 0 5.519-4.479 9.999-9.997 9.999-5.245 0-9.553-4.048-9.966-9.188-.024-.302.189-.811.749-.811.391 0 .715.3.747.69.351 4.369 4.012 7.809 8.47 7.809 4.69 0 8.497-3.808 8.497-8.499 0-4.689-3.807-8.497-8.497-8.497-3.037 0-5.704 1.597-7.206 3.995l1.991.005c.414 0 .75.336.75.75s-.336.75-.75.75h-4.033c-.414 0-.75-.336-.75-.75v-4.049c0-.414.336-.75.75-.75s.75.335.75.75zm8.492 2.272c1.656 0 3 1.344 3 3s-1.344 3-3 3-3-1.344-3-3 1.344-3 3-3z" fill-rule="nonzero"></path>
                                </svg>
                            </span>
                        </div>
                        <div class="relative bg-white pt-2 mt-4" data-te-input-wrapper-init="">
                            <x-admin.admin-textarea id="data-risks-and-remedies" name="data-risks-and-remedies"
                                      placeholder="{{ __('admin/adm-tool-datas.risks-and-remedies') }}" style="overflow-wrap: normal"></x-admin.admin-textarea>
                            <x-admin.admin-textarea-label for="data-risks-and-remedies">
                                {{ __('admin/adm-tool-datas.risks-and-remedies') }}
                            </x-admin.admin-textarea-label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="data-blk mt-4">
                <h1 class="text-xl a4-text-shade-100 border-b-2">
                    <span class="data-expander flex items-center cursor-pointer" title="{{ __('globals.expand') }}" data-expander-name="mistakes">
                        <span class="exp-arrow transition-transform duration-500 ease-in-out">
                            <svg class="h-5 w-5 stroke-neutral-800 hover:a4-stroke-shade-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path>
                            </svg>
                        </span>
                        <span class="pl-1">{{ __('admin/adm-tool-datas.mistakes') }}</span>
                    </span>
                </h1>
                <div class="data-content delayed-hidden pl-6">
                    <div class="data-text-container grid grid-cols-[auto_1fr] gap-x-2">
                        <div class="pt-2 mt-4 flex flex-wrap gap-y-3 self-start w-5">
                            <span class="data-preview" title="{{ __('admin/adm-tool-datas.data-preview') }}">
                                <svg class="w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 1h17v2h-17v-2zm0 7h17v-2h-17v2zm0 5h17v-2h-17v2zm0 5h17v-2h-17v2zm0 5h17v-2h-17v2zm-5-22c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 9c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 9c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2z"></path>
                                </svg>
                            </span>
                            <span class="data-word-wrap cursor-pointer" title="{{ __('admin/adm-tool-datas.data-word-wrap') }}">
                                <svg class="w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <g transform="matrix(0.42 0 0 0.42 12 12)"><g><g transform="matrix(1 0 0 1 0 0)"><path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: inherit; fill-rule: nonzero; opacity: 1;" transform=" translate(-24, -24)" d="M 6 8 L 42 8 L 42 12 L 6 12 z M 6 36 L 16 36 L 16 40 L 6 40 z M 33 40 L 26 40 L 26 36 L 33 36 C 35.8 36 38 33.8 38 31 C 38 28.200000000000003 35.8 26 33 26 L 6 26 L 6 22 L 33 22 C 38 22 42 26 42 31 C 42 36 38 40 33 40 z" stroke-linecap="round"></path></g><g transform="matrix(1 0 0 1 -1 14)"><path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: inherit; fill-rule: nonzero; opacity: 1;" transform=" translate(-23, -38)" d="M 26 44 L 20 38 L 26 32 z" stroke-linecap="round"></path></g></g></g>
                                </svg>
                            </span>
                            <span class="data-reset-height cursor-pointer" title="{{ __('admin/adm-tool-datas.data-reset-height') }}">
                                <svg class="w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300" viewBox="0 0 20 24" clip-rule="evenodd" fill-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2" xmlns="http://www.w3.org/2000/svg">
                                    <path d="m3.508 6.726c1.765-2.836 4.911-4.726 8.495-4.726 5.518 0 9.997 4.48 9.997 9.997 0 5.519-4.479 9.999-9.997 9.999-5.245 0-9.553-4.048-9.966-9.188-.024-.302.189-.811.749-.811.391 0 .715.3.747.69.351 4.369 4.012 7.809 8.47 7.809 4.69 0 8.497-3.808 8.497-8.499 0-4.689-3.807-8.497-8.497-8.497-3.037 0-5.704 1.597-7.206 3.995l1.991.005c.414 0 .75.336.75.75s-.336.75-.75.75h-4.033c-.414 0-.75-.336-.75-.75v-4.049c0-.414.336-.75.75-.75s.75.335.75.75zm8.492 2.272c1.656 0 3 1.344 3 3s-1.344 3-3 3-3-1.344-3-3 1.344-3 3-3z" fill-rule="nonzero"></path>
                                </svg>
                            </span>
                        </div>
                        <div class="relative bg-white pt-2 mt-4" data-te-input-wrapper-init="">
                            <x-admin.admin-textarea id="data-mistakes" name="data-mistakes"
                                      placeholder="{{ __('admin/adm-tool-datas.mistakes-to-avoid') }}" style="overflow-wrap: normal"></x-admin.admin-textarea>
                            <x-admin.admin-textarea-label for="data-mistakes">
                                {{ __('admin/adm-tool-datas.mistakes-to-avoid') }}
                            </x-admin.admin-textarea-label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="data-blk mt-4">
                <h1 class="text-xl a4-text-shade-100 border-b-2">
                    <span class="data-expander flex items-center cursor-pointer" title="{{ __('globals.expand') }}" data-expander-name="insights">
                        <span class="exp-arrow transition-transform duration-500 ease-in-out">
                            <svg class="h-5 w-5 stroke-neutral-800 hover:a4-stroke-shade-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path>
                            </svg>
                        </span>
                        <span class="pl-1">{{ __('admin/adm-tool-datas.insights') }}</span>
                    </span>
                </h1>
                <div class="data-content delayed-hidden pl-6">
                    <div class="data-text-container grid grid-cols-[auto_1fr] gap-x-2">
                        <div class="pt-2 mt-4 flex flex-wrap gap-y-3 self-start w-5">
                            <span class="data-preview" title="{{ __('admin/adm-tool-datas.data-preview') }}">
                                <svg class="w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 1h17v2h-17v-2zm0 7h17v-2h-17v2zm0 5h17v-2h-17v2zm0 5h17v-2h-17v2zm0 5h17v-2h-17v2zm-5-22c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 9c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 9c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2z"></path>
                                </svg>
                            </span>
                            <span class="data-word-wrap cursor-pointer" title="{{ __('admin/adm-tool-datas.data-word-wrap') }}">
                                <svg class="w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <g transform="matrix(0.42 0 0 0.42 12 12)"><g><g transform="matrix(1 0 0 1 0 0)"><path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: inherit; fill-rule: nonzero; opacity: 1;" transform=" translate(-24, -24)" d="M 6 8 L 42 8 L 42 12 L 6 12 z M 6 36 L 16 36 L 16 40 L 6 40 z M 33 40 L 26 40 L 26 36 L 33 36 C 35.8 36 38 33.8 38 31 C 38 28.200000000000003 35.8 26 33 26 L 6 26 L 6 22 L 33 22 C 38 22 42 26 42 31 C 42 36 38 40 33 40 z" stroke-linecap="round"></path></g><g transform="matrix(1 0 0 1 -1 14)"><path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: inherit; fill-rule: nonzero; opacity: 1;" transform=" translate(-23, -38)" d="M 26 44 L 20 38 L 26 32 z" stroke-linecap="round"></path></g></g></g>
                                </svg>
                            </span>
                            <span class="data-reset-height cursor-pointer" title="{{ __('admin/adm-tool-datas.data-reset-height') }}">
                                <svg class="w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300" viewBox="0 0 20 24" clip-rule="evenodd" fill-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2" xmlns="http://www.w3.org/2000/svg">
                                    <path d="m3.508 6.726c1.765-2.836 4.911-4.726 8.495-4.726 5.518 0 9.997 4.48 9.997 9.997 0 5.519-4.479 9.999-9.997 9.999-5.245 0-9.553-4.048-9.966-9.188-.024-.302.189-.811.749-.811.391 0 .715.3.747.69.351 4.369 4.012 7.809 8.47 7.809 4.69 0 8.497-3.808 8.497-8.499 0-4.689-3.807-8.497-8.497-8.497-3.037 0-5.704 1.597-7.206 3.995l1.991.005c.414 0 .75.336.75.75s-.336.75-.75.75h-4.033c-.414 0-.75-.336-.75-.75v-4.049c0-.414.336-.75.75-.75s.75.335.75.75zm8.492 2.272c1.656 0 3 1.344 3 3s-1.344 3-3 3-3-1.344-3-3 1.344-3 3-3z" fill-rule="nonzero"></path>
                                </svg>
                            </span>
                        </div>
                        <div class="relative bg-white pt-2 mt-4" data-te-input-wrapper-init="">
                            <x-admin.admin-textarea id="data-insight-1" name="data-insight-1"
                                      placeholder="{{ __('admin/adm-tool-datas.insights-1') }}" style="overflow-wrap: normal"></x-admin.admin-textarea>
                            <x-admin.admin-textarea-label for="data-insight-1">
                                {{ __('admin/adm-tool-datas.insights-1') }}
                            </x-admin.admin-textarea-label>
                        </div>
                    </div>

                    <div class="data-text-container grid grid-cols-[auto_1fr] gap-x-2">
                        <div class="pt-2 mt-4 flex flex-wrap gap-y-3 self-start w-5">
                            <span class="data-preview" title="{{ __('admin/adm-tool-datas.data-preview') }}">
                                <svg class="w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 1h17v2h-17v-2zm0 7h17v-2h-17v2zm0 5h17v-2h-17v2zm0 5h17v-2h-17v2zm0 5h17v-2h-17v2zm-5-22c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 9c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 9c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2z"></path>
                                </svg>
                            </span>
                            <span class="data-word-wrap cursor-pointer" title="{{ __('admin/adm-tool-datas.data-word-wrap') }}">
                                <svg class="w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <g transform="matrix(0.42 0 0 0.42 12 12)"><g><g transform="matrix(1 0 0 1 0 0)"><path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: inherit; fill-rule: nonzero; opacity: 1;" transform=" translate(-24, -24)" d="M 6 8 L 42 8 L 42 12 L 6 12 z M 6 36 L 16 36 L 16 40 L 6 40 z M 33 40 L 26 40 L 26 36 L 33 36 C 35.8 36 38 33.8 38 31 C 38 28.200000000000003 35.8 26 33 26 L 6 26 L 6 22 L 33 22 C 38 22 42 26 42 31 C 42 36 38 40 33 40 z" stroke-linecap="round"></path></g><g transform="matrix(1 0 0 1 -1 14)"><path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: inherit; fill-rule: nonzero; opacity: 1;" transform=" translate(-23, -38)" d="M 26 44 L 20 38 L 26 32 z" stroke-linecap="round"></path></g></g></g>
                                </svg>
                            </span>
                            <span class="data-reset-height cursor-pointer" title="{{ __('admin/adm-tool-datas.data-reset-height') }}">
                                <svg class="w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300" viewBox="0 0 20 24" clip-rule="evenodd" fill-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2" xmlns="http://www.w3.org/2000/svg">
                                    <path d="m3.508 6.726c1.765-2.836 4.911-4.726 8.495-4.726 5.518 0 9.997 4.48 9.997 9.997 0 5.519-4.479 9.999-9.997 9.999-5.245 0-9.553-4.048-9.966-9.188-.024-.302.189-.811.749-.811.391 0 .715.3.747.69.351 4.369 4.012 7.809 8.47 7.809 4.69 0 8.497-3.808 8.497-8.499 0-4.689-3.807-8.497-8.497-8.497-3.037 0-5.704 1.597-7.206 3.995l1.991.005c.414 0 .75.336.75.75s-.336.75-.75.75h-4.033c-.414 0-.75-.336-.75-.75v-4.049c0-.414.336-.75.75-.75s.75.335.75.75zm8.492 2.272c1.656 0 3 1.344 3 3s-1.344 3-3 3-3-1.344-3-3 1.344-3 3-3z" fill-rule="nonzero"></path>
                                </svg>
                            </span>
                        </div>
                        <div class="relative bg-white pt-2 mt-4" data-te-input-wrapper-init="">
                            <x-admin.admin-textarea id="data-insight-2" name="data-insight-2"
                                      placeholder="{{ __('admin/adm-tool-datas.insights-2') }}" style="overflow-wrap: normal"></x-admin.admin-textarea>
                            <x-admin.admin-textarea-label for="data-insight-2">
                                {{ __('admin/adm-tool-datas.insights-2') }}
                            </x-admin.admin-textarea-label>
                        </div>
                    </div>

                    <div class="data-text-container grid grid-cols-[auto_1fr] gap-x-2">
                        <div class="pt-2 mt-4 flex flex-wrap gap-y-3 self-start w-5">
                            <span class="data-preview" title="{{ __('admin/adm-tool-datas.data-preview') }}">
                                <svg class="w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 1h17v2h-17v-2zm0 7h17v-2h-17v2zm0 5h17v-2h-17v2zm0 5h17v-2h-17v2zm0 5h17v-2h-17v2zm-5-22c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 9c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 9c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2z"></path>
                                </svg>
                            </span>
                            <span class="data-word-wrap cursor-pointer" title="{{ __('admin/adm-tool-datas.data-word-wrap') }}">
                                <svg class="w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <g transform="matrix(0.42 0 0 0.42 12 12)"><g><g transform="matrix(1 0 0 1 0 0)"><path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: inherit; fill-rule: nonzero; opacity: 1;" transform=" translate(-24, -24)" d="M 6 8 L 42 8 L 42 12 L 6 12 z M 6 36 L 16 36 L 16 40 L 6 40 z M 33 40 L 26 40 L 26 36 L 33 36 C 35.8 36 38 33.8 38 31 C 38 28.200000000000003 35.8 26 33 26 L 6 26 L 6 22 L 33 22 C 38 22 42 26 42 31 C 42 36 38 40 33 40 z" stroke-linecap="round"></path></g><g transform="matrix(1 0 0 1 -1 14)"><path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: inherit; fill-rule: nonzero; opacity: 1;" transform=" translate(-23, -38)" d="M 26 44 L 20 38 L 26 32 z" stroke-linecap="round"></path></g></g></g>
                                </svg>
                            </span>
                            <span class="data-reset-height cursor-pointer" title="{{ __('admin/adm-tool-datas.data-reset-height') }}">
                                <svg class="w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300" viewBox="0 0 20 24" clip-rule="evenodd" fill-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2" xmlns="http://www.w3.org/2000/svg">
                                    <path d="m3.508 6.726c1.765-2.836 4.911-4.726 8.495-4.726 5.518 0 9.997 4.48 9.997 9.997 0 5.519-4.479 9.999-9.997 9.999-5.245 0-9.553-4.048-9.966-9.188-.024-.302.189-.811.749-.811.391 0 .715.3.747.69.351 4.369 4.012 7.809 8.47 7.809 4.69 0 8.497-3.808 8.497-8.499 0-4.689-3.807-8.497-8.497-8.497-3.037 0-5.704 1.597-7.206 3.995l1.991.005c.414 0 .75.336.75.75s-.336.75-.75.75h-4.033c-.414 0-.75-.336-.75-.75v-4.049c0-.414.336-.75.75-.75s.75.335.75.75zm8.492 2.272c1.656 0 3 1.344 3 3s-1.344 3-3 3-3-1.344-3-3 1.344-3 3-3z" fill-rule="nonzero"></path>
                                </svg>
                            </span>
                        </div>
                        <div class="relative bg-white pt-2 mt-4" data-te-input-wrapper-init="">
                            <x-admin.admin-textarea id="data-insight-3" name="data-insight-3"
                                      placeholder="{{ __('admin/adm-tool-datas.insights-3') }}" style="overflow-wrap: normal"></x-admin.admin-textarea>
                            <x-admin.admin-textarea-label for="data-insight-3">
                                {{ __('admin/adm-tool-datas.insights-3') }}
                            </x-admin.admin-textarea-label>
                        </div>
                    </div>

                    <div class="data-text-container grid grid-cols-[auto_1fr] gap-x-2">
                        <div class="pt-2 mt-4 flex flex-wrap gap-y-3 self-start w-5">
                            <span class="data-preview" title="{{ __('admin/adm-tool-datas.data-preview') }}">
                                <svg class="w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 1h17v2h-17v-2zm0 7h17v-2h-17v2zm0 5h17v-2h-17v2zm0 5h17v-2h-17v2zm0 5h17v-2h-17v2zm-5-22c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 9c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 9c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2z"></path>
                                </svg>
                            </span>
                            <span class="data-word-wrap cursor-pointer" title="{{ __('admin/adm-tool-datas.data-word-wrap') }}">
                                <svg class="w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <g transform="matrix(0.42 0 0 0.42 12 12)"><g><g transform="matrix(1 0 0 1 0 0)"><path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: inherit; fill-rule: nonzero; opacity: 1;" transform=" translate(-24, -24)" d="M 6 8 L 42 8 L 42 12 L 6 12 z M 6 36 L 16 36 L 16 40 L 6 40 z M 33 40 L 26 40 L 26 36 L 33 36 C 35.8 36 38 33.8 38 31 C 38 28.200000000000003 35.8 26 33 26 L 6 26 L 6 22 L 33 22 C 38 22 42 26 42 31 C 42 36 38 40 33 40 z" stroke-linecap="round"></path></g><g transform="matrix(1 0 0 1 -1 14)"><path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: inherit; fill-rule: nonzero; opacity: 1;" transform=" translate(-23, -38)" d="M 26 44 L 20 38 L 26 32 z" stroke-linecap="round"></path></g></g></g>
                                </svg>
                            </span>
                            <span class="data-reset-height cursor-pointer" title="{{ __('admin/adm-tool-datas.data-reset-height') }}">
                                <svg class="w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300" viewBox="0 0 20 24" clip-rule="evenodd" fill-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2" xmlns="http://www.w3.org/2000/svg">
                                    <path d="m3.508 6.726c1.765-2.836 4.911-4.726 8.495-4.726 5.518 0 9.997 4.48 9.997 9.997 0 5.519-4.479 9.999-9.997 9.999-5.245 0-9.553-4.048-9.966-9.188-.024-.302.189-.811.749-.811.391 0 .715.3.747.69.351 4.369 4.012 7.809 8.47 7.809 4.69 0 8.497-3.808 8.497-8.499 0-4.689-3.807-8.497-8.497-8.497-3.037 0-5.704 1.597-7.206 3.995l1.991.005c.414 0 .75.336.75.75s-.336.75-.75.75h-4.033c-.414 0-.75-.336-.75-.75v-4.049c0-.414.336-.75.75-.75s.75.335.75.75zm8.492 2.272c1.656 0 3 1.344 3 3s-1.344 3-3 3-3-1.344-3-3 1.344-3 3-3z" fill-rule="nonzero"></path>
                                </svg>
                            </span>
                        </div>
                        <div class="relative bg-white pt-2 mt-4" data-te-input-wrapper-init="">
                            <x-admin.admin-textarea id="data-insight-4" name="data-insight-4"
                                      placeholder="{{ __('admin/adm-tool-datas.insights-4') }}" style="overflow-wrap: normal"></x-admin.admin-textarea>
                            <x-admin.admin-textarea-label for="data-insight-4">
                                {{ __('admin/adm-tool-datas.insights-4') }}
                            </x-admin.admin-textarea-label>
                        </div>
                    </div>

                    <div class="data-text-container grid grid-cols-[auto_1fr] gap-x-2">
                        <div class="pt-2 mt-4 flex flex-wrap gap-y-3 self-start w-5">
                            <span class="data-preview" title="{{ __('admin/adm-tool-datas.data-preview') }}">
                                <svg class="w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 1h17v2h-17v-2zm0 7h17v-2h-17v2zm0 5h17v-2h-17v2zm0 5h17v-2h-17v2zm0 5h17v-2h-17v2zm-5-22c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 9c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 9c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2z"></path>
                                </svg>
                            </span>
                            <span class="data-word-wrap cursor-pointer" title="{{ __('admin/adm-tool-datas.data-word-wrap') }}">
                                <svg class="w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <g transform="matrix(0.42 0 0 0.42 12 12)"><g><g transform="matrix(1 0 0 1 0 0)"><path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: inherit; fill-rule: nonzero; opacity: 1;" transform=" translate(-24, -24)" d="M 6 8 L 42 8 L 42 12 L 6 12 z M 6 36 L 16 36 L 16 40 L 6 40 z M 33 40 L 26 40 L 26 36 L 33 36 C 35.8 36 38 33.8 38 31 C 38 28.200000000000003 35.8 26 33 26 L 6 26 L 6 22 L 33 22 C 38 22 42 26 42 31 C 42 36 38 40 33 40 z" stroke-linecap="round"></path></g><g transform="matrix(1 0 0 1 -1 14)"><path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: inherit; fill-rule: nonzero; opacity: 1;" transform=" translate(-23, -38)" d="M 26 44 L 20 38 L 26 32 z" stroke-linecap="round"></path></g></g></g>
                                </svg>
                            </span>
                            <span class="data-reset-height cursor-pointer" title="{{ __('admin/adm-tool-datas.data-reset-height') }}">
                                <svg class="w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300" viewBox="0 0 20 24" clip-rule="evenodd" fill-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2" xmlns="http://www.w3.org/2000/svg">
                                    <path d="m3.508 6.726c1.765-2.836 4.911-4.726 8.495-4.726 5.518 0 9.997 4.48 9.997 9.997 0 5.519-4.479 9.999-9.997 9.999-5.245 0-9.553-4.048-9.966-9.188-.024-.302.189-.811.749-.811.391 0 .715.3.747.69.351 4.369 4.012 7.809 8.47 7.809 4.69 0 8.497-3.808 8.497-8.499 0-4.689-3.807-8.497-8.497-8.497-3.037 0-5.704 1.597-7.206 3.995l1.991.005c.414 0 .75.336.75.75s-.336.75-.75.75h-4.033c-.414 0-.75-.336-.75-.75v-4.049c0-.414.336-.75.75-.75s.75.335.75.75zm8.492 2.272c1.656 0 3 1.344 3 3s-1.344 3-3 3-3-1.344-3-3 1.344-3 3-3z" fill-rule="nonzero"></path>
                                </svg>
                            </span>
                        </div>
                        <div class="relative bg-white pt-2 mt-4" data-te-input-wrapper-init="">
                            <x-admin.admin-textarea id="data-insight-5" name="data-insight-5"
                                      placeholder="{{ __('admin/adm-tool-datas.insights-5') }}" style="overflow-wrap: normal"></x-admin.admin-textarea>
                            <x-admin.admin-textarea-label for="data-insight-5">
                                {{ __('admin/adm-tool-datas.insights-5') }}
                            </x-admin.admin-textarea-label>
                        </div>
                    </div>

                    <div class="data-text-container grid grid-cols-[auto_1fr] gap-x-2">
                        <div class="pt-2 mt-4 flex flex-wrap gap-y-3 self-start w-5">
                            <span class="data-preview" title="{{ __('admin/adm-tool-datas.data-preview') }}">
                                <svg class="w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 1h17v2h-17v-2zm0 7h17v-2h-17v2zm0 5h17v-2h-17v2zm0 5h17v-2h-17v2zm0 5h17v-2h-17v2zm-5-22c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 9c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 9c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2z"></path>
                                </svg>
                            </span>
                            <span class="data-word-wrap cursor-pointer" title="{{ __('admin/adm-tool-datas.data-word-wrap') }}">
                                <svg class="w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <g transform="matrix(0.42 0 0 0.42 12 12)"><g><g transform="matrix(1 0 0 1 0 0)"><path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: inherit; fill-rule: nonzero; opacity: 1;" transform=" translate(-24, -24)" d="M 6 8 L 42 8 L 42 12 L 6 12 z M 6 36 L 16 36 L 16 40 L 6 40 z M 33 40 L 26 40 L 26 36 L 33 36 C 35.8 36 38 33.8 38 31 C 38 28.200000000000003 35.8 26 33 26 L 6 26 L 6 22 L 33 22 C 38 22 42 26 42 31 C 42 36 38 40 33 40 z" stroke-linecap="round"></path></g><g transform="matrix(1 0 0 1 -1 14)"><path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: inherit; fill-rule: nonzero; opacity: 1;" transform=" translate(-23, -38)" d="M 26 44 L 20 38 L 26 32 z" stroke-linecap="round"></path></g></g></g>
                                </svg>
                            </span>
                            <span class="data-reset-height cursor-pointer" title="{{ __('admin/adm-tool-datas.data-reset-height') }}">
                                <svg class="w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300" viewBox="0 0 20 24" clip-rule="evenodd" fill-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2" xmlns="http://www.w3.org/2000/svg">
                                    <path d="m3.508 6.726c1.765-2.836 4.911-4.726 8.495-4.726 5.518 0 9.997 4.48 9.997 9.997 0 5.519-4.479 9.999-9.997 9.999-5.245 0-9.553-4.048-9.966-9.188-.024-.302.189-.811.749-.811.391 0 .715.3.747.69.351 4.369 4.012 7.809 8.47 7.809 4.69 0 8.497-3.808 8.497-8.499 0-4.689-3.807-8.497-8.497-8.497-3.037 0-5.704 1.597-7.206 3.995l1.991.005c.414 0 .75.336.75.75s-.336.75-.75.75h-4.033c-.414 0-.75-.336-.75-.75v-4.049c0-.414.336-.75.75-.75s.75.335.75.75zm8.492 2.272c1.656 0 3 1.344 3 3s-1.344 3-3 3-3-1.344-3-3 1.344-3 3-3z" fill-rule="nonzero"></path>
                                </svg>
                            </span>
                        </div>
                        <div class="relative bg-white pt-2 mt-4" data-te-input-wrapper-init="">
                            <x-admin.admin-textarea id="data-provocation-1" name="data-provocation-1"
                                      placeholder="{{ __('admin/adm-tool-datas.insights-provocation-1') }}" style="overflow-wrap: normal"></x-admin.admin-textarea>
                            <x-admin.admin-textarea-label for="data-provocation-1">
                                {{ __('admin/adm-tool-datas.insights-provocation-1') }}
                            </x-admin.admin-textarea-label>
                        </div>
                    </div>

                    <div class="data-text-container grid grid-cols-[auto_1fr] gap-x-2">
                        <div class="pt-2 mt-4 flex flex-wrap gap-y-3 self-start w-5">
                            <span class="data-preview" title="{{ __('admin/adm-tool-datas.data-preview') }}">
                                <svg class="w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 1h17v2h-17v-2zm0 7h17v-2h-17v2zm0 5h17v-2h-17v2zm0 5h17v-2h-17v2zm0 5h17v-2h-17v2zm-5-22c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 9c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 9c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2z"></path>
                                </svg>
                            </span>
                            <span class="data-word-wrap cursor-pointer" title="{{ __('admin/adm-tool-datas.data-word-wrap') }}">
                                <svg class="w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <g transform="matrix(0.42 0 0 0.42 12 12)"><g><g transform="matrix(1 0 0 1 0 0)"><path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: inherit; fill-rule: nonzero; opacity: 1;" transform=" translate(-24, -24)" d="M 6 8 L 42 8 L 42 12 L 6 12 z M 6 36 L 16 36 L 16 40 L 6 40 z M 33 40 L 26 40 L 26 36 L 33 36 C 35.8 36 38 33.8 38 31 C 38 28.200000000000003 35.8 26 33 26 L 6 26 L 6 22 L 33 22 C 38 22 42 26 42 31 C 42 36 38 40 33 40 z" stroke-linecap="round"></path></g><g transform="matrix(1 0 0 1 -1 14)"><path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: inherit; fill-rule: nonzero; opacity: 1;" transform=" translate(-23, -38)" d="M 26 44 L 20 38 L 26 32 z" stroke-linecap="round"></path></g></g></g>
                                </svg>
                            </span>
                            <span class="data-reset-height cursor-pointer" title="{{ __('admin/adm-tool-datas.data-reset-height') }}">
                                <svg class="w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300" viewBox="0 0 20 24" clip-rule="evenodd" fill-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2" xmlns="http://www.w3.org/2000/svg">
                                    <path d="m3.508 6.726c1.765-2.836 4.911-4.726 8.495-4.726 5.518 0 9.997 4.48 9.997 9.997 0 5.519-4.479 9.999-9.997 9.999-5.245 0-9.553-4.048-9.966-9.188-.024-.302.189-.811.749-.811.391 0 .715.3.747.69.351 4.369 4.012 7.809 8.47 7.809 4.69 0 8.497-3.808 8.497-8.499 0-4.689-3.807-8.497-8.497-8.497-3.037 0-5.704 1.597-7.206 3.995l1.991.005c.414 0 .75.336.75.75s-.336.75-.75.75h-4.033c-.414 0-.75-.336-.75-.75v-4.049c0-.414.336-.75.75-.75s.75.335.75.75zm8.492 2.272c1.656 0 3 1.344 3 3s-1.344 3-3 3-3-1.344-3-3 1.344-3 3-3z" fill-rule="nonzero"></path>
                                </svg>
                            </span>
                        </div>
                        <div class="relative bg-white pt-2 mt-4" data-te-input-wrapper-init="">
                            <x-admin.admin-textarea id="data-provocation-2" name="data-provocation-2"
                                      placeholder="{{ __('admin/adm-tool-datas.insights-provocation-2') }}" style="overflow-wrap: normal"></x-admin.admin-textarea>
                            <x-admin.admin-textarea-label for="data-provocation-2">
                                {{ __('admin/adm-tool-datas.insights-provocation-2') }}
                            </x-admin.admin-textarea-label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="data-blk mt-4">
                <h1 class="text-xl a4-text-shade-100 border-b-2">
                    <span class="data-expander flex items-center cursor-pointer" title="{{ __('globals.expand') }}" data-expander-name="opportunities">
                        <span class="exp-arrow transition-transform duration-500 ease-in-out">
                            <svg class="h-5 w-5 stroke-neutral-800 hover:a4-stroke-shade-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path>
                            </svg>
                        </span>
                        <span class="pl-1">{{ __('admin/adm-tool-datas.opportunities') }}</span>
                    </span>
                </h1>
                <div class="data-content delayed-hidden pl-6">
                    <div class="data-text-container grid grid-cols-[auto_1fr] gap-x-2">
                        <div class="pt-2 mt-4 flex flex-wrap gap-y-3 self-start w-5">
                            <span class="data-preview" title="{{ __('admin/adm-tool-datas.data-preview') }}">
                                <svg class="w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 1h17v2h-17v-2zm0 7h17v-2h-17v2zm0 5h17v-2h-17v2zm0 5h17v-2h-17v2zm0 5h17v-2h-17v2zm-5-22c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 9c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 9c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2z"></path>
                                </svg>
                            </span>
                            <span class="data-word-wrap cursor-pointer" title="{{ __('admin/adm-tool-datas.data-word-wrap') }}">
                                <svg class="w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <g transform="matrix(0.42 0 0 0.42 12 12)"><g><g transform="matrix(1 0 0 1 0 0)"><path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: inherit; fill-rule: nonzero; opacity: 1;" transform=" translate(-24, -24)" d="M 6 8 L 42 8 L 42 12 L 6 12 z M 6 36 L 16 36 L 16 40 L 6 40 z M 33 40 L 26 40 L 26 36 L 33 36 C 35.8 36 38 33.8 38 31 C 38 28.200000000000003 35.8 26 33 26 L 6 26 L 6 22 L 33 22 C 38 22 42 26 42 31 C 42 36 38 40 33 40 z" stroke-linecap="round"></path></g><g transform="matrix(1 0 0 1 -1 14)"><path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: inherit; fill-rule: nonzero; opacity: 1;" transform=" translate(-23, -38)" d="M 26 44 L 20 38 L 26 32 z" stroke-linecap="round"></path></g></g></g>
                                </svg>
                            </span>
                            <span class="data-reset-height cursor-pointer" title="{{ __('admin/adm-tool-datas.data-reset-height') }}">
                                <svg class="w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300" viewBox="0 0 20 24" clip-rule="evenodd" fill-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2" xmlns="http://www.w3.org/2000/svg">
                                    <path d="m3.508 6.726c1.765-2.836 4.911-4.726 8.495-4.726 5.518 0 9.997 4.48 9.997 9.997 0 5.519-4.479 9.999-9.997 9.999-5.245 0-9.553-4.048-9.966-9.188-.024-.302.189-.811.749-.811.391 0 .715.3.747.69.351 4.369 4.012 7.809 8.47 7.809 4.69 0 8.497-3.808 8.497-8.499 0-4.689-3.807-8.497-8.497-8.497-3.037 0-5.704 1.597-7.206 3.995l1.991.005c.414 0 .75.336.75.75s-.336.75-.75.75h-4.033c-.414 0-.75-.336-.75-.75v-4.049c0-.414.336-.75.75-.75s.75.335.75.75zm8.492 2.272c1.656 0 3 1.344 3 3s-1.344 3-3 3-3-1.344-3-3 1.344-3 3-3z" fill-rule="nonzero"></path>
                                </svg>
                            </span>
                        </div>
                        <div class="relative bg-white pt-2 mt-4" data-te-input-wrapper-init="">
                            <x-admin.admin-textarea id="data-opportunities" name="data-opportunities"
                                      placeholder="{{ __('admin/adm-tool-datas.opportunities-opportunity') }}" style="overflow-wrap: normal"></x-admin.admin-textarea>
                            <x-admin.admin-textarea-label for="data-opportunities">
                                {{ __('admin/adm-tool-datas.opportunities-opportunity') }}
                            </x-admin.admin-textarea-label>
                        </div>
                    </div>
                </div>
            </div>

            <div class="data-blk mt-4">
                <h1 class="text-xl a4-text-shade-100 border-b-2">
                    <span class="data-expander flex items-center cursor-pointer" title="{{ __('globals.expand') }}" data-expander-name="key-results">
                        <span class="exp-arrow transition-transform duration-500 ease-in-out">
                            <svg class="h-5 w-5 stroke-neutral-800 hover:a4-stroke-shade-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path>
                            </svg>
                        </span>
                        <span class="pl-1">{{ __('admin/adm-tool-datas.key-results') }}</span>
                    </span>
                </h1>
                <div class="data-content delayed-hidden pl-6">
                    <div class="data-text-container grid grid-cols-[auto_1fr] gap-x-2">
                        <div class="pt-2 mt-4 flex flex-wrap gap-y-3 self-start w-5">
                            <span class="data-preview" title="{{ __('admin/adm-tool-datas.data-preview') }}">
                                <svg class="w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 1h17v2h-17v-2zm0 7h17v-2h-17v2zm0 5h17v-2h-17v2zm0 5h17v-2h-17v2zm0 5h17v-2h-17v2zm-5-22c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 9c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2zm0 9c-1.104 0-2 .896-2 2s.896 2 2 2 2-.896 2-2-.896-2-2-2z"></path>
                                </svg>
                            </span>
                            <span class="data-word-wrap cursor-pointer" title="{{ __('admin/adm-tool-datas.data-word-wrap') }}">
                                <svg class="w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                    <g transform="matrix(0.42 0 0 0.42 12 12)"><g><g transform="matrix(1 0 0 1 0 0)"><path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: inherit; fill-rule: nonzero; opacity: 1;" transform=" translate(-24, -24)" d="M 6 8 L 42 8 L 42 12 L 6 12 z M 6 36 L 16 36 L 16 40 L 6 40 z M 33 40 L 26 40 L 26 36 L 33 36 C 35.8 36 38 33.8 38 31 C 38 28.200000000000003 35.8 26 33 26 L 6 26 L 6 22 L 33 22 C 38 22 42 26 42 31 C 42 36 38 40 33 40 z" stroke-linecap="round"></path></g><g transform="matrix(1 0 0 1 -1 14)"><path style="stroke: none; stroke-width: 1; stroke-dasharray: none; stroke-linecap: butt; stroke-dashoffset: 0; stroke-linejoin: miter; stroke-miterlimit: 4; fill: inherit; fill-rule: nonzero; opacity: 1;" transform=" translate(-23, -38)" d="M 26 44 L 20 38 L 26 32 z" stroke-linecap="round"></path></g></g></g>
                                </svg>
                            </span>
                            <span class="data-reset-height cursor-pointer" title="{{ __('admin/adm-tool-datas.data-reset-height') }}">
                                <svg class="w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300" viewBox="0 0 20 24" clip-rule="evenodd" fill-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2" xmlns="http://www.w3.org/2000/svg">
                                    <path d="m3.508 6.726c1.765-2.836 4.911-4.726 8.495-4.726 5.518 0 9.997 4.48 9.997 9.997 0 5.519-4.479 9.999-9.997 9.999-5.245 0-9.553-4.048-9.966-9.188-.024-.302.189-.811.749-.811.391 0 .715.3.747.69.351 4.369 4.012 7.809 8.47 7.809 4.69 0 8.497-3.808 8.497-8.499 0-4.689-3.807-8.497-8.497-8.497-3.037 0-5.704 1.597-7.206 3.995l1.991.005c.414 0 .75.336.75.75s-.336.75-.75.75h-4.033c-.414 0-.75-.336-.75-.75v-4.049c0-.414.336-.75.75-.75s.75.335.75.75zm8.492 2.272c1.656 0 3 1.344 3 3s-1.344 3-3 3-3-1.344-3-3 1.344-3 3-3z" fill-rule="nonzero"></path>
                                </svg>
                            </span>
                        </div>
                        <div class="relative bg-white pt-2 mt-4" data-te-input-wrapper-init="">
                            <x-admin.admin-textarea id="data-key-results" name="data-key-results"
                                      placeholder="{{ __('admin/adm-tool-datas.key-results-key') }}" style="overflow-wrap: normal"></x-admin.admin-textarea>
                            <x-admin.admin-textarea-label for="data-key-results">
                                {{ __('admin/adm-tool-datas.key-results-key') }}
                            </x-admin.admin-textarea-label>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Languages block. --}}
<div id="languages-block" class="collapse h-0 page-block max-w-4xl mx-auto my-0 px-6">
    <div class="border-0">
        <h1 class="text-3xl px-4 py-3 border-b-2 a4-bord-shade-100">{{ __('admin/adm-languages.title') }}</h1>
        <form id="languages-form" name="languages-form" class="p-4">
            @csrf
            <p class="text-sm mb-4">{{ __('admin/adm-languages.description') }}</p>

            <x-error-message id="languages-errors" class="hidden" data-sql-error="{{ __('admin/adm-languages.sql-error') }}"></x-error-message>

            <div class="grid grid-cols-1 gap-y-2">
                <div class="mb-2">
                    <x-admin.admin-select id="language-names" name="language-names"
                            data-te-select-visible-options="10">
                      @foreach ($languages as $language)
                        <option value="{{ $language->code }}" @selected($language->code == $currentLanguage)>{{ $language->name }}</option>
                      @endforeach
                    </x-admin.admin-select>
                    <label data-te-select-label-ref="">{{ __('admin/adm-languages.language') }}</label>
                </div>

                <div class="mb-3 flex flex-row gap-x-3 justify-end">
                    <x-admin.admin-button id="edit-language" class="w-32"
                            title="{{ __('admin/adm-languages.update-button-tooltip', ['language' => __('admin/adm-languages.language')]) }}">
                        {{ __('globals.update-button') }}
                    </x-admin.admin-button>
                    <x-admin.admin-button id="add-language" class="w-32"
                            title="{{ __('admin/adm-languages.add-button-tooltip', ['language' => __('admin/adm-languages.language')]) }}">
                        {{ __('globals.add-button') }}
                    </x-admin.admin-button>
                    <x-admin.admin-button id="delete-language" class="w-32"
                            title="{{ __('admin/adm-languages.delete-button-tooltip', ['language' => __('admin/adm-languages.language')]) }}"
                            data-delete-title="{{ __('admin/adm-languages.delete-title') }}"
                            data-delete-body="{{ __('admin/adm-languages.delete-body') }}">
                        {{ __('globals.delete-button') }}
                    </x-admin.admin-button>
                </div>

                <div id="language-data" class="grid grid-cols-3 gap-x-4 px-4 pt-3 pb-4 border border-neutral-400 rounded transition-colors duration-500" title="{{ __('admin/adm-languages.language-data') }}">
                    <div class="relative mt-1" data-te-input-wrapper-init="">
                        <x-admin.admin-text-input type="text" id="language-name" name="language-name" placeholder="{{ __('admin/adm-languages.language-name') }}"
                               aria-required="true" class="invalid:a4-text-dark-red"
                               title="" data-title="{{ __('admin/adm-languages.language-name-tooltip') }}"
                               maxlength="32" pattern="^\s*[a-zA-Z].*$" required="required" />
                        <x-admin.admin-input-label for="language-name">
                            {{ __('admin/adm-languages.language-name') }}
                        </x-admin.admin-input-label>
                    </div>
                    <div class="relative mt-1" data-te-input-wrapper-init="">
                        <x-admin.admin-text-input type="text" id="language-code" name="language-code" placeholder="{{ __('admin/adm-languages.language-code') }}"
                               aria-required="true" class="invalid:a4-text-dark-red"
                               title="{{ __('admin/adm-languages.language-code-tooltip') }}"
                               pattern="^[a-z]{2}$" required="required" />
                        <x-admin.admin-input-label for="language-code">
                            {{ __('admin/adm-languages.language-code') }}
                        </x-admin.admin-input-label>
                    </div>
                    <div class="relative mt-1" data-te-input-wrapper-init="">
                        <x-admin.admin-text-input type="number" id="language-order" name="language-order"
                               aria-required="true" class="invalid:a4-text-dark-red"
                               title="{{ __('admin/adm-languages.language-order-tooltip') }}"
                               min="1" required="required" />
                        <x-admin.admin-input-label for="language-order">
                            {{ __('admin/adm-languages.language-order') }}
                        </x-admin.admin-input-label>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

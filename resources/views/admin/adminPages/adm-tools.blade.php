{{-- Tools block. --}}
<div id="tools-block" class="collapse h-0 page-block max-w-4xl mx-auto my-0 px-6">
    <div class="border-0">
        <h1 class="text-3xl px-4 py-3 border-b-2 a4-bord-shade-100">{{ __('admin/adm-tools.title') }}</h1>
        <form id="tools-form" name="tools-form" class="p-4">
            @csrf
            <p class="text-sm mb-4">{!! __('admin/adm-tools.description') !!}</p>

            <x-error-message id="tools-errors" class="hidden" data-sql-error="{{ __('admin/adm-tools.sql-error') }}"></x-error-message>

            <div class="grid grid-cols-[1fr_1fr_auto] gap-x-4">
                <div class="mb-2 col-span-3">
                    <x-admin.admin-select id="tools-tool-list" name="tools-tool-list"
                            data-te-select-visible-options="10">
                    </x-admin.admin-select>
                    <label data-te-select-label-ref="">{{ __('admin/adm-tools.tool') }}</label>
                </div>

                <div class="mb-6 col-span-3 flex flex-row gap-x-3 justify-end">
                    <x-admin.admin-button id="edit-tool" class="w-32"
                            title="{{ __('admin/adm-tools.update-button-tooltip', ['tool' => __('admin/adm-tools.tool')]) }}">
                        {{ __('globals.update-button') }}
                    </x-admin.admin-button>
                    <x-admin.admin-button id="add-tool" class="w-32"
                            title="{{ __('admin/adm-tools.add-button-tooltip') }}">
                        {{ __('globals.add-button') }}
                    </x-admin.admin-button>
                    <x-admin.admin-button id="delete-tool" class="w-32"
                            title="{{ __('admin/adm-tools.delete-button-tooltip', ['tool' => __('admin/adm-tools.tool')]) }}"
                            data-delete-title="{{ __('admin/adm-tools.delete-title') }}"
                            data-delete-body="{{ __('admin/adm-tools.delete-body') }}">
                        {{ __('globals.delete-button') }}
                    </x-admin.admin-button>
                </div>

                <div class="relative" data-te-input-wrapper-init="">
                    <x-admin.admin-text-input type="text" id="tools-name-id" name="tools-name-id"
                           class="invalid:a4-text-dark-red" placeholder="{{ __('admin/adm-tools.tool-id') }}" aria-required="true"
                           title="{{ __('admin/adm-tools.tool-id-tooltip') }}" maxlength="8" pattern="^A4(?!000$|0000)\d{3,4}$" required="required" />
                    <x-admin.admin-input-label for="tools-name-id">
                        {{ __('admin/adm-tools.tool-id') }}
                    </x-admin.admin-input-label>
                </div>
                <div class="relative" data-te-input-wrapper-init="">
                    <x-admin.admin-text-input type="text" id="tools-title-id" name="tools-title-id"
                           class="invalid:a4-text-dark-red" placeholder="{{ __('admin/adm-tools.tool-title') }}" aria-required="true"
                           title="{{ __('admin/adm-tools.tool-title-tooltip') }}" maxlength="64" pattern="^[A-Za-z]+$" required="required" />
                    <x-admin.admin-input-label for="tools-title-id">
                        {{ __('admin/adm-tools.tool-title') }}
                    </x-admin.admin-input-label>
                </div>
                <div class="relative pl-[1.5rem] self-center">
                    <x-admin.admin-checkbox-input id="tools-active" name="tools-active" />
                    <label for="tools-active" class="inline-block pl-[0.15rem] peer-enabled:hover:cursor-pointer peer-disabled:opacity-40">
                        {{ __('admin/adm-tools.tool-active') }}
                    </label>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-y-4 mt-4">
                <div>
                    <x-admin.admin-select id="tools-related-tools" name="tools-related-tools[]" aria-multiselectable="true"
                            data-te-select-visible-options="9" data-te-select-multiple="true"
                            data-te-select-options-selected-label="{{ __('admin/adm-tools.related-tools-selected') }}"
                            data-te-select-displayed-labels="3" multiple>
                    </x-admin.admin-select>
                    <label data-te-select-label-ref="">{{ __('admin/adm-tools.related-tools') }}</label>
                </div>

                <div>
                    <x-admin.admin-select id="tools-category-level" name="tools-category-level[]" aria-required="true"
                            aria-multiselectable="true" data-te-select-multiple="true"
                            data-te-select-visible-options="4"
                            multiple>
                        <option value="executive">{{ __('admin/adm-tools.tool-level-executive') }}</option>
                        <option value="advanced">{{ __('admin/adm-tools.tool-level-advanced') }}</option>
                        <option value="intermediate">{{ __('admin/adm-tools.tool-level-intermediate') }}</option>
                    </x-admin.admin-select>
                    <label data-te-select-label-ref="">{{ __('admin/adm-tools.tool-level') }}</label>
                </div>

                <div>
                    <x-admin.admin-select id="tools-category-recipient" name="tools-category-recipient[]" aria-required="true"
                            aria-multiselectable="true" data-te-select-multiple="true"
                            data-te-select-visible-options="5"
                            multiple>
                        <option value="management">{{ __('admin/adm-tools.tool-recipient-management') }}</option>
                        <option value="marketing">{{ __('admin/adm-tools.tool-recipient-marketing') }}</option>
                        <option value="operations">{{ __('admin/adm-tools.tool-recipient-operations') }}</option>
                        <option value="r-d">{{ __('admin/adm-tools.tool-recipient-rd') }}</option>
                    </x-admin.admin-select>
                    <label data-te-select-label-ref="">{{ __('admin/adm-tools.tool-recipient') }}</label>
                </div>

                <div>
                    <x-admin.admin-select id="tools-category-usage" name="tools-category-usage[]" aria-required="true"
                            aria-multiselectable="true" data-te-select-multiple="true"
                            data-te-select-visible-options="7" data-te-select-displayed-labels="6"
                            multiple>
                        <option value="strategy">{{ __('admin/adm-tools.tool-usage-strategy') }}</option>
                        <option value="assessment">{{ __('admin/adm-tools.tool-usage-assessment') }}</option>
                        <option value="correctives">{{ __('admin/adm-tools.tool-usage-correctives') }}</option>
                        <option value="simplification">{{ __('admin/adm-tools.tool-usage-simplification') }}</option>
                        <option value="delegation">{{ __('admin/adm-tools.tool-usage-delegation') }}</option>
                        <option value="motivation">{{ __('admin/adm-tools.tool-usage-motivation') }}</option>
                    </x-admin.admin-select>
                    <label data-te-select-label-ref="">{{ __('admin/adm-tools.tool-usage') }}</label>
                </div>

                <div>
                    <x-admin.admin-select id="tools-category-selection" name="tools-category-selection[]"
                            aria-multiselectable="true" data-te-select-multiple="true"
                            data-te-select-visible-options="5" multiple>
                        <option value="a-plus">{{ __('admin/adm-tools.tool-selection-a-plus') }}</option>
                        <option value="eco">{{ __('admin/adm-tools.tool-selection-eco') }}</option>
                        <option value="quick">{{ __('admin/adm-tools.tool-selection-quick') }}</option>
                        <option value="top">{{ __('admin/adm-tools.tool-selection-top') }}</option>
                    </x-admin.admin-select>
                    <label data-te-select-label-ref="">{{ __('admin/adm-tools.tool-selection') }}</label>
                </div>

                <div>
                    <x-admin.admin-select id="tools-category-scope" name="tools-category-scope">
                        <option value="company-management">{{ __('admin/adm-tools.tool-scope-company-management') }}</option>
                        <option value="management">{{ __('admin/adm-tools.tool-scope-management') }}</option>
                        <option value="team-management">{{ __('admin/adm-tools.tool-scope-team-management') }}</option>
                        <option value="professional-development">{{ __('admin/adm-tools.tool-scope-professional-development') }}</option>
                        <option value="individual-development">{{ __('admin/adm-tools.tool-scope-individual-development') }}</option>
                    </x-admin.admin-select>
                    <label data-te-select-label-ref="">{{ __('admin/adm-tools.tool-scope') }}</label>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Employees sections block. --}}
<div id="employees-sections-block" class="collapse h-0 page-block max-w-4xl mx-auto my-0 px-6">
    <div class="border-0">
        <h1 class="text-3xl px-4 py-3 border-b-2 a4-bord-shade-100">{!! __('admin/adm-employees-sections.title') . (($user->role == 'siteAdmin') ? ' &nbsp;<span class="a4-text-shade-300 text-[60%]">«<span id="empsections-customer-name" title="' . __('admin/adm-employees-sections.title-tooltip') . '"></span>»</span>' : '') !!}</h1>
        <form id="employees-sections-form" name="employees-sections-form" class="p-4">
            @csrf
            <p class="text-sm mb-4">{!! __('admin/adm-employees-sections.description-employees') !!}</p>

            <x-error-message id="employees-sections-errors" class="hidden"></x-error-message>

            <div class="grid grid-cols-1 gap-y-2">
                <div class="mb-1">
                    {{-- data-te-select-option-height="52" --}}
                    <x-admin.admin-select id="employee-section-names" name="employee-section-names" data-te-select-option-height="52"
                            data-te-select-visible-options="10" title="{{ __('admin/adm-employees-sections.employee-tooltip') }}">
                    </x-admin.admin-select>
                    <label data-te-select-label-ref="">{{ __('admin/adm-employees-sections.employee-label') }}</label>
                </div>

                <div class="w-8 h-8 justify-self-center">
                    <svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="currentColor"><path fill-rule="evenodd" d="M1.646 6.646a.5.5 0 0 1 .708 0L8 12.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"></path><path fill-rule="evenodd" d="M1.646 2.646a.5.5 0 0 1 .708 0L8 8.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"></path></svg>
                </div>

                <div class="mb-1">
                    <x-admin.admin-select id="section-all-names" name="section-all-names[]"
                            data-te-select-visible-options="10" data-te-select-multiple="true"
                            data-te-select-options-selected-label="{{ __('admin/adm-employees-sections.employee-unit-selected') }}"
                            aria-multiselectable="true"
                            title="{{ __('admin/adm-employees-sections.employee-unit-tooltip') }}" multiple>
                    </x-admin.admin-select>
                    <label data-te-select-label-ref="">{{ __('admin/adm-employees-sections.employee-unit-label') }}</label>
                </div>

                <div class="pb-6 border-b-2 a4-bord-shade-100">
                    <div class="grid justify-items-end">
                        <x-admin.admin-button id="save-employee-sections" class="self-end">
                            {{ __('globals.save-button') }}
                        </x-admin.admin-button>
                    </div>
                </div>
            </div>


            <p class="text-sm my-4">{{ __('admin/adm-employees-sections.description-units') }}</p>

            <div class="grid grid-cols-1 gap-y-2">
                <div class="mb-1">
                    <x-admin.admin-select id="section-employee-names" name="section-employee-names"
                            data-te-select-visible-options="10"
                            title="{{ __('admin/adm-employees-sections.unit-tooltip') }}">
                    </x-admin.admin-select>
                    <label data-te-select-label-ref="">{{ __('admin/adm-employees-sections.unit-label') }}</label>
                </div>

                <div class="w-8 h-8 justify-self-center">
                    <svg viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg" fill="currentColor"><path fill-rule="evenodd" d="M1.646 6.646a.5.5 0 0 1 .708 0L8 12.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"></path><path fill-rule="evenodd" d="M1.646 2.646a.5.5 0 0 1 .708 0L8 8.293l5.646-5.647a.5.5 0 0 1 .708.708l-6 6a.5.5 0 0 1-.708 0l-6-6a.5.5 0 0 1 0-.708z"></path></svg>
                </div>

                <div class="mb-1">
                    {{-- Le classi di default dell'attributo "data-te-class-select-option-secondary-text" sono:
                           block text-[0.8rem] text-gray-500 dark:text-gray-300
                         La classe "pl-7" è stata aggiunta per indentare il testo secondario e allinearlo al
                         testo principale (a destra del checkBox).
                         La classe "pl-7" può essere aggiunta (concatenata) anche tramite JavaScript così:
                           te.Select.getInstance($("#employee-all-names").get(0))
                                    ._classes.selectOptionSecondaryText += " pl-7";

                         L'attributo "data-te-class-select-option-secondary-text" corrisponde alla property
                                                    \      \      \         |
                                                     \      |     |         |
                                                      \     \     \         |
                                              _classes.selectOptionSecondaryText

                         Nota: gli attributi data-te-class-* non permettono la concatenazione, l'approccio
                               tramite JavaScript (concatenazione) sarebbe da preferire in caso le classi
                               di default cambino con gli aggiornamenti d TWE.

                         Vedi properties nel file "Laravel\TailWind CSS\Documentation\selects - te.Select.txt".
                    --}}
                    <x-admin.admin-select id="employee-all-names" name="employee-all-names[]"
                            data-te-select-visible-options="10" data-te-select-multiple="true"
                            data-te-select-options-selected-label="{{ __('admin/adm-employees-sections.unit-employees-selected') }}"
                            aria-multiselectable="true" data-te-select-option-height="52" data-te-select-displayed-labels="2"
                            data-te-class-select-option-secondary-text="block text-[0.8rem] text-gray-500 dark:text-gray-300 pl-7"
                            title="{{ __('admin/adm-employees-sections.unit-employees-tooltip') }}" multiple>
                    </x-admin.admin-select>
                    <label data-te-select-label-ref="">{{ __('admin/adm-employees-sections.unit-employees-label') }}</label>
                </div>

                <div>
                    <div class="grid justify-items-end">
                        <x-admin.admin-button id="save-section-employees" class="self-end">
                            {{ __('globals.save-button') }}
                        </x-admin.admin-button>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

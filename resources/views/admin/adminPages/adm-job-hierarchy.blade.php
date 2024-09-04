{{-- Job hierarchy block. --}}
<div id="job-hierarchy-block" class="collapse h-0 page-block max-w-4xl mx-auto my-0 px-6">
    <div class="border-0">
        <h1 class="text-3xl px-4 py-3 border-b-2 a4-bord-shade-100">{!! __('admin/adm-job-hierarchy.title') . (($user->role == 'siteAdmin') ? ' &nbsp;<span class="a4-text-shade-300 text-[60%]">«<span id="job-hierarchy-customer-name" title="' . __('admin/adm-job-hierarchy.title-tooltip') . '"></span>»</span>' : '') !!}</h1>
        <form id="job-hierarchy-form" name="job-hierarchy-form" class="p-4">
            @csrf
            <p class="text-sm mb-4">{!! __('admin/adm-job-hierarchy.description') !!}</p>

            <x-error-message id="job-hierarchy-errors" class="hidden" data-sql-error="{{ __('admin/adm-job-hierarchy.sql-error') }}"></x-error-message>

            <div class="grid grid-cols-2 gap-x-4 gap-y-2">
                <div class="mb-3">
                    <x-admin.admin-select id="job-hierarchy-names" name="job-hierarchy-names"
                            data-te-select-visible-options="10"
                            title="{{ __('admin/adm-job-hierarchy.hierarchy-names-tooltip') }}">
                    </x-admin.admin-select>
                    <label data-te-select-label-ref="">{{ __('admin/adm-job-hierarchy.hierarchy-names-label') }}</label>
                </div>
                <div class="mb-3">
                    <x-admin.admin-button id="edit-job-hierarchy" class="self-end w-32"
                            title="{!! __('admin/adm-job-hierarchy.update-button-tooltip', ['name' => __('admin/adm-job-hierarchy.hierarchy-names-label')]) !!}">
                        {{ __('globals.update-button') }}
                    </x-admin.admin-button>
                    <x-admin.admin-button id="delete-job-hierarchy" class="self-end w-32 ml-2"
                            title="{!! __('admin/adm-job-hierarchy.delete-button-tooltip', ['name' => __('admin/adm-job-hierarchy.hierarchy-names-label')]) !!}"
                            data-delete-title="{{ __('admin/adm-job-hierarchy.delete-title') }}"
                            data-delete-body="{{ __('admin/adm-job-hierarchy.delete-body') }}">
                        {{ __('globals.delete-button') }}
                    </x-admin.admin-button>
                </div>

                <div class="relative" data-te-input-wrapper-init="">
                    <x-admin.admin-text-input type="text" id="new-job-hierarchy-name" name="new-job-hierarchy-name"
                           placeholder="{{ __('admin/adm-job-hierarchy.new-hierarchy-name') }}" class="invalid:a4-text-dark-red"
                           data-title="{!! __('admin/adm-job-hierarchy.new-hierarchy-name-tooltip', ['update' => __('globals.update-button')]) !!}"
                           data-title-error="{{ __('admin/adm-job-hierarchy.new-hierarchy-name-error') }}" maxlength="64" />
                    <x-admin.admin-input-label for="new-job-hierarchy-name">
                        {{ __('admin/adm-job-hierarchy.new-hierarchy-name') }}
                    </x-admin.admin-input-label>
                </div>
                <div>
                    <x-admin.admin-button id="add-job-hierarchy" class="self-end w-32"
                            title="{!! __('admin/adm-job-hierarchy.add-button-tooltip', ['newname' => __('admin/adm-job-hierarchy.new-hierarchy-name')]) !!}">
                        {{ __('globals.add-button') }}
                    </x-admin.admin-button>
                </div>
            </div>

            <div class="mt-4"><span id="hier-level-add" class="cursor-pointer inline-block" title="{{ __('admin/adm-job-hierarchy.add-level-button-tooltip') }}"><svg class="w-6 h-6 fill-neutral-800 hover:a4-fill-shade-300 transition-all duration-300 ease-linear" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg"><path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z"></path><path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"></path></svg></span></div>

            <p class="text-sm mt-3 mb-2">{{ __('admin/adm-job-hierarchy.preview-label') }}:</p>
            <div id="hier-sample" class="flex w-full items-stretch">
              @for ($n = 1; $n <= 4; $n++)
                <div class="hier-l relative flex w-full items-stretch ml-[1px]" data-te-input-wrapper-init="" data-te-input-group-ref="">
                    <span id="sl{{ $n }}" class="flex items-center whitespace-nowrap rounded-l border border-solid border-neutral-300 px-3 py-[0.25rem] text-center text-base font-normal leading-[1.6] text-neutral-500 dark:border-neutral-600 dark:text-neutral-200 dark:placeholder:text-neutral-200" title="{{ __('admin/adm-job-hierarchy.level-number-tooltip', ['level' => $n]) }}" data-te-input-group-text-ref="">{{ __('admin/adm-job-hierarchy.level-short') . $n }}</span>
                    <x-admin.admin-text-input type="text" id="hier-sample-l{{ $n }}" placeholder="" aria-label="" aria-describedby="sl{{ $n }}" aria-required="true" class="invalid:a4-text-dark-red" title="{!! __('admin/adm-job-hierarchy.level-info-tooltip') !!}" maxlength="64" required="required" />
                    <x-admin.admin-input-label for="hier-sample-l{{ $n }}"></x-admin.admin-input-label>
                </div>
              @endfor
            </div>

            <div class="job-hier-container">
                <input type="hidden" id="hier-level-count" name="hier-level-count" value="" />
              @for ($n = 1; $n <= 4; $n++)
                <div class="hier-blk border border-neutral-400 rounded transition-colors duration-500 {{ ($n > 1) ? 'collapse h-0' : 'mt-4 px-4 pt-3 pb-4' }}"
                     data-title="{{ __('admin/adm-job-hierarchy.level-min-languages-tooltip') }}">
                    <div class="hier-level flex items-center text-lg a4-text-shade-100">
                        <span class="transition-colors duration-500">{{ __('admin/adm-job-hierarchy.level-number-tooltip', ['level' => $n]) }}</span>
                        <span class="hier-trash ml-6 cursor-pointer" title="{{ __('admin/adm-job-hierarchy.delete-level-tooltip') }}"><svg class="w-5 h-5 fill-neutral-800 hover:a4-fill-shade-300" viewBox="0 0 16 16" xmlns="http://www.w3.org/2000/svg"><path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"></path><path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"></path></svg></span>
                    </div>
                    <div class="hier-langs grid grid-cols-2 gap-x-4 gap-y-2">
                      @foreach ($languages as $language)
                        <div class="relative mt-1" data-te-input-wrapper-init="">
                            <x-admin.admin-text-input type="text" id="hier-{{ $n }}-{{ $language->code }}" name="hier-{{ $n }}-{{ $language->code }}" placeholder="{{ $language->name }}" maxlength="64" />
                            <x-admin.admin-input-label for="hier-{{ $n }}-{{ $language->code }}">
                                {{ $language->name }}
                            </x-admin.admin-input-label>
                        </div>
                       @endforeach
                    </div>
                </div>
              @endfor
            </div>
        </form>
    </div>
</div>

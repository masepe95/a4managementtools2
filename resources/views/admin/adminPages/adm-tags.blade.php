{{-- Tags tools block. --}}
<div id="tags-block" class="collapse h-0 page-block max-w-4xl mx-auto my-0 px-6">
    <div class="border-0">
        <h1 class="text-3xl px-4 py-3 border-b-2 a4-bord-shade-100">{{ __('admin/adm-tags.title') }}</h1>
        <form id="tags-form" name="tags-form" class="p-4">
            @csrf
            <p class="text-sm mb-4">{!! __('admin/adm-tags.description') !!}</p>

            <x-error-message id="tags-errors" class="hidden" data-sql-error="{{ __('admin/adm-tags.sql-error') }}"></x-error-message>

            <div class="grid grid-cols-1 gap-y-2">
                <div class="mb-2">
                    <x-admin.admin-select id="tag-tool-names" name="tag-tool-names"
                            data-te-select-visible-options="10" title="{{ __('admin/adm-tags.tag-tooltip') }}">
                    </x-admin.admin-select>
                    <label data-te-select-label-ref="">{{ __('admin/adm-tags.tag') }}</label>
                </div>

                <div class="mb-3 flex flex-row gap-x-3 justify-end">
                    <x-admin.admin-button id="edit-tag" class="w-32"
                            title="{{ __('admin/adm-tags.update-button-tooltip', ['tag' => __('admin/adm-tags.tag')]) }}">
                        {{ __('globals.update-button') }}
                    </x-admin.admin-button>
                    <x-admin.admin-button id="add-tag" class="w-32"
                            title="{{ __('admin/adm-tags.add-button-tooltip') }}">
                        {{ __('globals.add-button') }}
                    </x-admin.admin-button>
                    <x-admin.admin-button id="delete-tag" class="w-32"
                            title="{{ __('admin/adm-tags.delete-button-tooltip', ['tag' => __('admin/adm-tags.tag')]) }}"
                            data-delete-title="{{ __('admin/adm-tags.delete-title') }}"
                            data-delete-body="{{ __('admin/adm-tags.delete-body') }}">
                        {{ __('globals.delete-button') }}
                    </x-admin.admin-button>
                </div>

                <div id="tag-langs" class="grid grid-cols-2 gap-x-4 gap-y-2 px-4 pt-3 pb-4 border border-neutral-400 rounded transition-colors duration-500" title="{{ __('admin/adm-tags.tag-minimum-language') }}">
                  @foreach ($languages as $language)
                    <div class="relative mt-1" data-te-input-wrapper-init="">
                        <x-admin.admin-text-input type="text" id="tag-name-{{ $language->code }}" name="tag-name-{{ $language->code }}" placeholder="{{ $language->name }}" maxlength="255" />
                        <x-admin.admin-input-label for="tag-name-{{ $language->code }}">
                            {{ $language->name }}
                        </x-admin.admin-input-label>
                    </div>
                  @endforeach
                </div>
            </div>
        </form>
    </div>
</div>

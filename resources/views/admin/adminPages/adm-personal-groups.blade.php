{{-- Personal groups block. --}}
<div id="personal-groups-block" class="collapse h-0 page-block max-w-4xl mx-auto my-0 px-6">
    <div class="border-0">
        <h1 class="text-3xl px-4 py-3 border-b-2 a4-bord-shade-100">{{ __('admin/adm-personal-groups.title') }}</h1>
        <form id="personal-groups-form" name="personal-groups-form" class="p-4">
            @csrf
            <p class="text-sm mb-4">{!! __('admin/adm-personal-groups.description') !!}</p>

            <x-error-message id="personal-groups-errors" class="hidden" data-sql-error="{{ __('admin/adm-personal-groups.sql-error') }}"></x-error-message>

            <div class="grid grid-cols-2 gap-x-4 gap-y-2">
                <div class="mb-3">
                    <x-admin.admin-select id="user-group-names" name="user-group-names"
                            data-te-select-visible-options="10" data-search-threshold="5"
                            title="{{ __('admin/adm-personal-groups.group-names-tooltip') }}">
                    </x-admin.admin-select>
                    <label data-te-select-label-ref="">{{ __('admin/adm-personal-groups.group-names-label') }}</label>
                </div>
                <div class="mb-3">
                    <x-admin.admin-button id="edit-personal-group" class="self-end w-32"
                            title="{!! __('admin/adm-personal-groups.update-button-tooltip', ['name' => __('admin/adm-personal-groups.group-names-label')]) !!}">
                        {{ __('globals.update-button') }}
                    </x-admin.admin-button>
                    <x-admin.admin-button id="delete-personal-group" class="self-end w-32 ml-2"
                            title="{!! __('admin/adm-personal-groups.delete-button-tooltip', ['name' => __('admin/adm-personal-groups.group-names-label')]) !!}"
                            data-delete-title="{{ __('admin/adm-personal-groups.delete-title') }}"
                            data-delete-body="{{ __('admin/adm-personal-groups.delete-body') }}">
                        {{ __('globals.delete-button') }}
                    </x-admin.admin-button>
                </div>

                <div class="relative mb-3" data-te-input-wrapper-init="">
                    <x-admin.admin-text-input type="text" id="user-new-grp-name" name="user-new-grp-name"
                           placeholder="{{ __('admin/adm-personal-groups.new-group-name') }}" class="invalid:a4-text-dark-red"
                           data-title="{!! __('admin/adm-personal-groups.new-group-name-tooltip', ['update' => __('globals.update-button')]) !!}"
                           data-title-error="{{ __('admin/adm-personal-groups.new-group-name-error') }}" maxlength="255" />
                    <x-admin.admin-input-label for="user-new-grp-name">
                        {{ __('admin/adm-personal-groups.new-group-name') }}
                    </x-admin.admin-input-label>
                </div>
                <div class="mb-3">
                    <x-admin.admin-button id="add-personal-group" class="self-end w-32"
                            title="{!! __('admin/adm-personal-groups.add-button-tooltip', ['newname' => __('admin/adm-personal-groups.new-group-name')]) !!}">
                        {{ __('globals.add-button') }}
                    </x-admin.admin-button>
                </div>

                <div class="col-span-2">
                    <x-admin.admin-select id="users-group-list" name="users-group-list[]" aria-required="true" aria-multiselectable="true"
                            data-te-select-visible-options="10" data-te-select-multiple="true"
                            data-te-select-options-selected-label="{{ __('admin/adm-personal-groups.group-list-selected') }}"
                            title="{{ __('admin/adm-personal-groups.group-list-tooltip') }}" multiple>
                    </x-admin.admin-select>
                    <label data-te-select-label-ref="">{{ __('admin/adm-personal-groups.group-list') }}</label>
                </div>
            </div>
        </form>
    </div>
</div>

{{-- Inspire me block. --}}
<div id="inspire-me-block" class="collapse h-0 page-block max-w-4xl mx-auto my-0 px-6">
    <div class="border-0">
        <h1 class="text-3xl px-4 py-3 border-b-2 a4-bord-shade-100">{{ __('admin/adm-inspire-me.title') }}</h1>
        <form id="inspire-me-form" name="inspire-me-form" class="p-4">
            @csrf
            <p class="text-sm mb-4">{!! __('admin/adm-inspire-me.description') !!}</p>

            <x-error-message id="inspire-me-errors" class="hidden"></x-error-message>

            <div id="inspire-langs" class="grid grid-cols-1 gap-y-4 p-4 border border-neutral-400 rounded transition-colors duration-500" title="{{ __('admin/adm-inspire-me.languages') }}">
              @foreach ($languages as $language)
                <div class="relative bg-white pt-2" data-te-input-wrapper-init="">
                    <x-admin.admin-textarea id="inspire-me-{{ $language->code }}" name="inspire-me-{{ $language->code }}"
                              placeholder="{{ $language->name }}" style="overflow-wrap: normal" data-resize="none"></x-admin.admin-textarea>
                    <x-admin.admin-textarea-label for="inspire-me-{{ $language->code }}">
                        {{ $language->name }}
                    </x-admin.admin-textarea-label>
                </div>
              @endforeach
            </div>

            <div class="grid justify-items-end mt-4">
                <x-admin.admin-button type="button" id="save-inspire-me" class="self-end">
                    {{ __('globals.save-button') }}
                </x-admin.admin-button>
            </div>
        </form>
    </div>
</div>

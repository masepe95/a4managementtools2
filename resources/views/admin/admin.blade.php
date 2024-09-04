<!doctype html>
{{-- Copyright Marco Cerulli Consulting © --}}
{{-- Written by Neil Otupacca. --}}
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
<meta charset="utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
<title>{{ __('admin-aside.page-title') }}</title>
<link rel="shortcut icon" type="image/svg+xml" href="images/a4-favicon.svg" />
@vite('resources/css/styles.css')
<link rel="stylesheet" href="build/css/jquery.datetimepicker.min.css" type="text/css" />
<script type="text/javascript" src="build/js/jquery-3.7.0.min.js"></script>
<script type="text/javascript" src="build/js/jquery.datetimepicker.full.js"></script>
@vite(['resources/js/admin.js', 'resources/js/inputs.js', 'resources/js/storage.js'])
<script type="text/javascript" src="build/js/showdown.js"></script>  {{-- Markdown to HTML bidirectional converter. --}}
</head>

<body class="a4-fontFamily bg-neutral-50 text-base" data-input-classes="peer block min-h-[auto] w-full rounded border-0 disabled:bg-neutral-100 disabled:text-neutral-400 enabled:bg-white py-[0.32rem] px-3 leading-[1.6] outline-none transition-all duration-300 ease-linear focus:placeholder:opacity-100 data-[te-input-state-active]:placeholder:opacity-100 motion-reduce:transition-none dark:text-neutral-200 dark:placeholder:text-neutral-200 [&:not([data-te-input-placeholder-active])]:placeholder:opacity-0" data-label-classes="pointer-events-none absolute top-0 left-3 mb-0 max-w-[90%] origin-[0_0] truncate pt-[0.37rem] leading-[1.6] text-neutral-500 transition-all duration-300 ease-out peer-focus:-translate-y-[0.9rem] peer-focus:scale-[0.8] peer-focus:text-primary peer-data-[te-input-state-active]:-translate-y-[0.9rem] peer-data-[te-input-state-active]:scale-[0.8] motion-reduce:transition-none dark:disabled:bg-neutral-700 dark:text-neutral-200 dark:peer-focus:text-neutral-200">

{{-- Delete's modal warning. --}}
<div id="confirm-modal-dialogbox" data-te-modal-init="" data-te-backdrop="static" data-te-keyboard="true"
     class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
     tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div data-te-modal-dialog-ref=""
         class="pointer-events-none relative w-auto translate-y-[-50px] opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-12 min-[576px]:max-w-[520px]">
        <div class="min-[576px]:shadow-[0_0.5rem_1rem_rgba(#000, 0.15)] pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-lg outline-none dark:bg-neutral-600">
            <div class="flex flex-shrink-0 items-center justify-between rounded-t-md bg-[#ffd630] border-b border-neutral-300 border-opacity-100 p-4 dark:border-opacity-50">
                <!--Modal title-->
                <h5 id="confirm-modal-title" class="text-xl font-medium leading-normal text-black dark:text-neutral-200"></h5>
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
                <div class="flex items-center"><p id="confirm-modal-body"></p></div>
            </div>
            <!--Modal footer-->
            <div class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md border-t border-neutral-300 border-opacity-100 px-5 py-4 dark:border-opacity-50">
                <button type="button" id="confirm-modal-yes-button" data-te-modal-dismiss="" data-te-ripple-init="" data-te-ripple-color="light"
                        class="disabled:pointer-events-none disabled:opacity-60 relative inline-block rounded a4-bg-shade-100 px-6 pb-2 pt-2.5 text-xs font-medium tracking-widest uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-500 ease-in-out hover:bg-primary-800 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-800 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-900 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)]">
                    {{ __('globals.yes-button') }}
                </button>
                <button type="button" data-te-modal-dismiss="" data-te-ripple-init="" data-te-ripple-color="light"
                        class="disabled:pointer-events-none disabled:opacity-60 relative ml-3 inline-block rounded bg-primary-100 px-6 pb-2 pt-2.5 text-xs font-medium tracking-widest uppercase leading-normal text-primary-700 transition duration-500 ease-in-out hover:bg-primary-accent-100 focus:bg-primary-accent-100 focus:outline-none focus:ring-0 active:bg-primary-accent-200">
                    {{ __('globals.no-button') }}
                </button>
            </div>
        </div>
    </div>
</div>

<div id="admin-aside" class="fixed hidden md:block w-[20rem] inset-y-0 p-2 border-solid border-info-600 border-r-2 overflow-y-hidden"
     data-te-perfect-scrollbar-init=""  data-te-wheel-propagation="false">
    <div class="flex"><span id="home-page" class="ml-2 cursor-pointer" title="{{ __('admin-aside.return') }}"><svg class="fill-neutral-800 hover:a4-fill-shade-300" width="24" height="24" viewBox="0 0 24 24" clip-rule="evenodd" fill-rule="evenodd" stroke-linejoin="round" stroke-miterlimit="2" xmlns="http://www.w3.org/2000/svg"><path d="m9.474 5.209s-4.501 4.505-6.254 6.259c-.147.146-.22.338-.22.53s.073.384.22.53c1.752 1.754 6.252 6.257 6.252 6.257.145.145.336.217.527.217.191-.001.383-.074.53-.221.293-.293.294-.766.004-1.057l-4.976-4.976h14.692c.414 0 .75-.336.75-.75s-.336-.75-.75-.75h-14.692l4.978-4.979c.289-.289.287-.761-.006-1.054-.147-.147-.339-.221-.53-.221-.191-.001-.38.071-.525.215z" fill-rule="nonzero"></path></svg></span></div>
    @canany(['adm-profile', 'adm-personal-groups', 'adm-personal-job-hierarchy'])
    {{-- Profile. --}}
    <div class="expander cursor-pointer relative flex w-[97%] items-center px-2 pt-3" data-expander-name="profile">
        <span class="mr-2">
            <svg class="h-3 w-3 a4-fill-shade-100" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M19 7.001c0 3.865-3.134 7-7 7s-7-3.135-7-7c0-3.867 3.134-7.001 7-7.001s7 3.134 7 7.001zm-1.598 7.18c-1.506 1.137-3.374 1.82-5.402 1.82-2.03 0-3.899-.685-5.407-1.822-4.072 1.793-6.593 7.376-6.593 9.821h24c0-2.423-2.6-8.006-6.598-9.819z"></path>
            </svg>
        </span>
        <span class="text-lg a4-text-shade-100">{{ __('admin-aside.menu-profile') }}</span>
        <span class="exp-arrow ml-auto -mr-1 w-4 h-4 shrink-0 transition-transform duration-500 ease-in-out">
            <svg class="h-4 w-4 stroke-neutral-800 hover:a4-stroke-shade-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path>
            </svg>
        </span>
    </div>
    <div class="exp-block pl-6 pr-2 hidden">
        @can('adm-profile')
        <div id="adm-profile" class="admin-selector" data-can-view="{{ array_key_exists('adm-profile', $pageAccesses) ? $pageAccesses['adm-profile'] : 'no' }}">{{ __('admin-aside.menu-profile-profile') }}</div>
        @endcan
        @can('adm-personal-groups')
        <div id="adm-personal-groups" class="admin-selector" data-can-view="{{ array_key_exists('adm-personal-groups', $pageAccesses) ? $pageAccesses['adm-personal-groups'] : 'no' }}">{{ __('admin-aside.menu-profile-personal-groups') }}</div>
        @endcan
        @can('adm-personal-job-hierarchy')
        <div id="adm-personal-job-hierarchy" class="admin-selector" data-can-view="{{ array_key_exists('adm-personal-job-hierarchy', $pageAccesses) ? $pageAccesses['adm-personal-job-hierarchy'] : 'no' }}">{{ __('admin-aside.menu-profile-personal-job-hierarchy') }}</div>
        @endcan
    </div>
    @endcanany

@if ($user->role == 'customerAdmin' || $user->role == 'siteAdmin')
    @canany(['adm-customer', 'adm-customer-contacts', 'adm-job-hierarchy',
             'adm-employees', 'adm-sections', 'adm-employees-sections'])
    {{-- Admin. --}}
    <div class="expander cursor-pointer relative flex w-[97%] items-center px-2 pt-3" data-expander-name="admin">
        <span class="mr-2">
            <svg class="h-3 w-3 a4-fill-shade-100" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path d="M24 13.616v-3.232l-2.869-1.02c-.198-.687-.472-1.342-.811-1.955l1.308-2.751-2.285-2.285-2.751 1.307c-.613-.339-1.269-.613-1.955-.811l-1.021-2.869h-3.232l-1.021 2.869c-.686.198-1.342.471-1.955.811l-2.751-1.308-2.285 2.285 1.308 2.752c-.339.613-.614 1.268-.811 1.955l-2.869 1.02v3.232l2.869 1.02c.197.687.472 1.342.811 1.955l-1.308 2.751 2.285 2.286 2.751-1.308c.613.339 1.269.613 1.955.811l1.021 2.869h3.232l1.021-2.869c.687-.198 1.342-.472 1.955-.811l2.751 1.308 2.285-2.286-1.308-2.751c.339-.613.613-1.268.811-1.955l2.869-1.02zm-12 2.384c-2.209 0-4-1.791-4-4s1.791-4 4-4 4 1.791 4 4-1.791 4-4 4z"></path>
            </svg>
        </span>
        <span class="text-lg a4-text-shade-100">{{ __('admin-aside.menu-admin') }}</span>
        <span class="exp-arrow ml-auto -mr-1 w-4 h-4 shrink-0 transition-transform duration-500 ease-in-out">
            <svg class="h-4 w-4 stroke-neutral-800 hover:a4-stroke-shade-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path>
            </svg>
        </span>
    </div>
    <div class="exp-block pl-6 pr-2 hidden">
        @can('adm-customer')
        <div id="adm-customer" class="admin-selector" data-can-view="{{ array_key_exists('adm-customer', $pageAccesses) ? $pageAccesses['adm-customer'] : 'no' }}">{{ __('admin-aside.menu-admin-customer') }}</div>
        @endcan
        @can('adm-customer-contacts')
        <div id="adm-customer-contacts" class="admin-selector" data-can-view="{{ array_key_exists('adm-customer-contacts', $pageAccesses) ? $pageAccesses['adm-customer-contacts'] : 'no' }}">{{ __('admin-aside.menu-admin-customer-contacts') }}</div>
        @endcan
        @can('adm-job-hierarchy')
        <div id="adm-job-hierarchy" class="admin-selector" data-can-view="{{ array_key_exists('adm-job-hierarchy', $pageAccesses) ? $pageAccesses['adm-job-hierarchy'] : 'no' }}">{{ __('admin-aside.menu-admin-job-hierarchy') }}</div>
        @endcan
        @can('adm-employees')
        <div id="adm-employees" class="admin-selector" data-can-view="{{ array_key_exists('adm-employees', $pageAccesses) ? $pageAccesses['adm-employees'] : 'no' }}">{{ __('admin-aside.menu-admin-employees') }}</div>
        @endcan
        @can('adm-sections')
        <div id="adm-sections" class="admin-selector" data-can-view="{{ array_key_exists('adm-sections', $pageAccesses) ? $pageAccesses['adm-sections'] : 'no' }}">{{ __('admin-aside.menu-admin-sections') }}</div>
        @endcan
        @can('adm-employees-sections')
        <div id="adm-employees-sections" class="admin-selector" data-can-view="{{ array_key_exists('adm-employees-sections', $pageAccesses) ? $pageAccesses['adm-employees-sections'] : 'no' }}">{{ __('admin-aside.menu-admin-employees-sections') }}</div>
        @endcan
    </div>
    @endcanany
@endif

@if ($user->role == 'siteAdmin')
    {{-- Super Admin. --}}
    <div class="expander cursor-pointer relative flex w-[97%] items-center px-2 pt-3" data-expander-name="super-admin">
        <span class="mr-2">
            <svg  class="h-3 w-3 a4-fill-shade-100" viewBox="0 1 15 15" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M10.0248,9.97521 L5.83008,14.1699 C4.72551,15.2745 2.93464,15.2745 1.83008,14.1699 C0.725505,13.0654 0.725506,11.2745 1.83008,10.1699 L6.02479,5.97521 C6.0084,5.81904 6,5.6605 6,5.5 C6,3.18096 7.7542,1.27164 10.008,1.02658 C10.1696,1.00901 10.3338,1 10.5,1 C11.1906,1 11.8448,1.15555 12.4295,1.43351 L10.2851,3.57797 C9.6993,4.16376 9.6993,5.11351 10.2851,5.69929 C10.8709,6.28508 11.8206,6.28508 12.4064,5.69929 L14.5564,3.54932 C14.8407,4.13945 15,4.80112 15,5.5 C15,5.65429 14.9922,5.80676 14.9771,5.95705 C14.748,8.22767 12.831,10 10.5,10 C10.3395,10 10.181,9.9916 10.0248,9.97521 Z M9.28499,7.88658 L4.41586,12.7557 C4.09234,13.0792 3.56781,13.0792 3.24429,12.7557 C2.92077,12.4322 2.92077,11.9077 3.24429,11.5841 L8.11342,6.715 L9.28499,7.88658 Z"></path>
            </svg>
        </span>
        <span class="text-lg a4-text-shade-100">{{ __('admin-aside.menu-site') }}</span>
        <span class="exp-arrow ml-auto -mr-1 w-4 h-4 shrink-0 transition-transform duration-500 ease-in-out">
            <svg class="h-4 w-4 stroke-neutral-800 hover:a4-stroke-shade-300" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"></path>
            </svg>
        </span>
    </div>
    <div class="exp-block pl-6 pr-2 hidden">
        <div id="adm-tools" class="admin-selector" data-can-view="{{ array_key_exists('adm-tools', $pageAccesses) ? $pageAccesses['adm-tools'] : 'no' }}">{{ __('admin-aside.menu-site-tools') }}</div>
        <div id="adm-tool-datas" class="admin-selector" data-can-view="{{ array_key_exists('adm-tool-datas', $pageAccesses) ? $pageAccesses['adm-tool-datas'] : 'no' }}">{{ __('admin-aside.menu-site-tool-datas') }}</div>
        <div id="adm-personal-tools" class="admin-selector" data-can-view="{{ array_key_exists('adm-personal-tools', $pageAccesses) ? $pageAccesses['adm-personal-tools'] : 'no' }}">{{ __('admin-aside.menu-site-personal-tools') }}</div>
        <div id="adm-tags" class="admin-selector" data-can-view="{{ array_key_exists('adm-tags', $pageAccesses) ? $pageAccesses['adm-tags'] : 'no' }}">{{ __('admin-aside.menu-site-tags') }}</div>
        <div id="adm-tools-tags" class="admin-selector" data-can-view="{{ array_key_exists('adm-tools-tags', $pageAccesses) ? $pageAccesses['adm-tools-tags'] : 'no' }}">{{ __('admin-aside.menu-site-tools-tags') }}</div>
        <div id="adm-languages" class="admin-selector" data-can-view="{{ array_key_exists('adm-languages', $pageAccesses) ? $pageAccesses['adm-languages'] : 'no' }}">{{ __('admin-aside.menu-site-languages') }}</div>
        <div id="adm-inspire-me" class="admin-selector" data-can-view="{{ array_key_exists('adm-inspire-me', $pageAccesses) ? $pageAccesses['adm-inspire-me'] : 'no' }}">{{ __('admin-aside.menu-site-inspire-me') }}</div>
        <div id="adm-global-options" class="admin-selector" data-can-view="{{ array_key_exists('adm-global-options', $pageAccesses) ? $pageAccesses['adm-global-options'] : 'no' }}">{{ __('admin-aside.menu-site-global-options') }}</div>
        <div id="adm-logs" class="admin-selector" data-can-view="{{ array_key_exists('adm-logs', $pageAccesses) ? $pageAccesses['adm-logs'] : 'no' }}">{{ __('admin-aside.menu-site-logs') }}</div>
    </div>
@endif

    <div class="grid grid-cols-1 gap-y-4 justify-items-center border-neutral-300 border-t mt-4">
@if ($user->role == 'siteAdmin')
        <div class="w-full mt-4">
            <x-admin.admin-select id="impersonated-employee" name="impersonated-employee"
                    data-te-select-visible-options="6" data-te-select-option-height="52"
                    data-option-count="{{ count($allUsers) }}"
                    data-curr-id="{{ $user->id }}" data-impersonated-marker="bg-amber-200"
                    data-csrf-token="{{ csrf_token() }}">
            @php($currCustomer = -1)
            @foreach ($allUsers as $usr)
              @if ($usr->customer_id != $currCustomer)
                @if (!$loop->first) </optgroup> @endif
                <optgroup id="{{ $usr->customer_id }}" label="{{ $usr->customer_name }}">
                @php($currCustomer = $usr->customer_id)
              @endif
                <option value="{{ $usr->employee_id }}" data-te-select-secondary-text="{{ __('globals.employee-role')[$usr->employee_role] }}" @selected($usr->employee_id == $currentImpersonated)>{{ $usr->employee_name }}</option>
            @endforeach
            @if ($currCustomer >= 0) </optgroup> @endif
            </x-admin.admin-select>
            <label data-te-select-label-ref="">{{ __('admin-aside.sel-impersonated-employee') }}</label>
        </div>
@endif

        <div class="w-full{{ ($user->role != 'siteAdmin') ? ' mt-4' : '' }}">
            <x-admin.admin-select id="language" name="language" data-route-change-lang="{{ route('changeLanguage') }}">
              @foreach ($languages as $language)
                <option value="{{ $language->code }}" @selected($language->code == $currentLanguage)>{{ $language->name }}</option>
              @endforeach
            </x-admin.admin-select>
            <label data-te-select-label-ref="">{{ __('admin-aside.sel-language') }}</label>
        </div>
        <div class="text-center">
            <img id="user-photo" src="{{ $userPhoto }}" class="mx-auto w-[160px] border-2 rounded-lg"
                 data-csrf-token="{{ csrf_token() }}" />
            <h5 class="text-xl font-medium leading-tight mt-1">{{ $user->firstname }} {{ $user->lastname }}</h5>
            <p class="text-neutral-500 dark:text-neutral-400">
                {{ __('globals.employee-role')[$user->role] }}
                @if(!is_null($user->job_title)) <br /> {{ $user->job_title }} @endif</p>
        </div>
    </div>
</div>

<div class="md:ml-[20rem]">
    <div class="min-w-[40rem] pt-8 pb-4">
        {{-- Profile. --}}
        @includeWhen($user->can('adm-profile'), 'admin/adminPages/adm-profile')
        @includeWhen($user->can('adm-personal-groups'), 'admin/adminPages/adm-personal-groups')
        @includeWhen($user->can('adm-personal-job-hierarchy'), 'admin/adminPages/adm-personal-job-hierarchy')

        {{-- Admin. --}}
        @includeWhen($user->can('adm-customer'), 'admin/adminPages/adm-customer')
        @includeWhen($user->can('adm-customer-contacts'), 'admin/adminPages/adm-customer-contacts')
        @includeWhen($user->can('adm-job-hierarchy'), 'admin/adminPages/adm-job-hierarchy')
        @includeWhen($user->can('adm-employees'), 'admin/adminPages/adm-employees')
        @includeWhen($user->can('adm-sections'), 'admin/adminPages/adm-sections')
        @includeWhen($user->can('adm-employees-sections'), 'admin/adminPages/adm-employees-sections')

    @if ($user->role == 'siteAdmin')
        {{-- Super Admin. --}}
        @include('admin/adminPages/adm-tools')
        @include('admin/adminPages/adm-tool-datas')
        @include('admin/adminPages/adm-personal-tools')
        @include('admin/adminPages/adm-tags')
        @include('admin/adminPages/adm-tools-tags')
        @include('admin/adminPages/adm-languages')
        @include('admin/adminPages/adm-inspire-me')
        @include('admin/adminPages/adm-global-options')
        @include('admin/adminPages/adm-logs')
    @endif
    </div>
</div>

<script type="text/javascript" src="build/js/tw-elements.js"></script>
</body>
</html>

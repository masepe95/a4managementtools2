{{-- Logs block. --}}
<div id="logs-block" class="collapse h-0 page-block max-w-4xl mx-auto my-0 px-6">
    <div class="border-0">
        <h1 class="text-3xl px-4 py-3 border-b-2 a4-bord-shade-100">{{ __('admin/adm-logs.title') }}</h1>
        <form id="logs-form" name="logs-form" class="p-4">
            @csrf
            <p class="text-sm mb-4">{{ __('admin/adm-logs.description') }}</p>

            <x-error-message id="logs-errors" class="hidden"></x-error-message>

            <div class="grid grid-cols-2 gap-x-4 gap-y-2">
                <div class="mb-3">
                    <x-admin.admin-select id="log-customers" name="log-customers[]" aria-multiselectable="true"
                            data-te-select-visible-options="10" data-te-select-displayed-labels="3"
                            data-te-select-multiple="true" data-option-count="{{ count($allCustomers) }}"
                            data-te-select-options-selected-label="{{ __('admin/adm-logs.customers-selected') }}"
                            multiple>
                      @foreach ($allCustomers as $cust)
                        <option value="{{ $cust->id }}">{{ $cust->name }}</option>
                      @endforeach
                    </x-admin.admin-select>
                    <label data-te-select-label-ref="">{{ __('admin/adm-logs.customers') }}</label>
                </div>
                <div class="mb-3">
                    <x-admin.admin-select id="log-employees" name="log-employees[]" aria-multiselectable="true"
                            data-te-select-visible-options="10" data-te-select-displayed-labels="3"
                            data-te-select-option-height="52" data-option-count="{{ count($allUsers) }}"
                            data-te-select-multiple="true"
                            data-te-select-options-selected-label="{{ __('admin/adm-logs.employees-selected') }}"
                            multiple>
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
                    <label data-te-select-label-ref="">{{ __('admin/adm-logs.employees') }}</label>
                </div>

                <div class="mb-3">
                    <x-admin.admin-select id="log-actions" name="log-actions[]" aria-multiselectable="true"
                            data-te-select-visible-options="10" data-te-select-displayed-labels="3"
                            data-te-select-multiple="true"
                            data-te-select-options-selected-label="{{ __('admin/adm-logs.actions-selected') }}"
                            multiple>
                        <option value="login">{{ __('admin/adm-logs.actions-logins') }}</option>
                        <option value="toolOpen">{{ __('admin/adm-logs.actions-tool-open') }}</option>
                        <option value="toolCreate">{{ __('admin/adm-logs.actions-tool-create') }}</option>
                        <option value="toolSearch">{{ __('admin/adm-logs.actions-tool-search') }}</option>
                        <option value="fail">{{ __('admin/adm-logs.actions-fail') }}</option>
                        <option value="failUnknown">{{ __('admin/adm-logs.actions-fail-unknown') }}</option>
                    </x-admin.admin-select>
                    <label data-te-select-label-ref="">{{ __('admin/adm-logs.actions') }}</label>
                </div>
                <div class="mb-3">
                    <x-admin.admin-select id="log-sorting" name="log-sorting" data-te-select-visible-options="10">
                        <option value="datetime">{{ __('admin/adm-logs.sorting-date') }} {{ __('admin/adm-logs.sorting-date-asc') }}</option>
                        <option value="datetime_desc" selected="">{{ __('admin/adm-logs.sorting-date') }} {{ __('admin/adm-logs.sorting-date-desc') }}</option>
                        <option value="action">{{ __('admin/adm-logs.sorting-action') }} A-Z</option>
                        <option value="action_desc">{{ __('admin/adm-logs.sorting-action') }} Z-A</option>
                        <option value="employee">{{ __('admin/adm-logs.sorting-employee') }} A-Z</option>
                        <option value="employee_desc">{{ __('admin/adm-logs.sorting-employee') }} Z-A</option>
                        <option value="customer">{{ __('admin/adm-logs.sorting-customer') }} A-Z</option>
                        <option value="customer_desc">{{ __('admin/adm-logs.sorting-customer') }} Z-A</option>
                    </x-admin.admin-select>
                    <label data-te-select-label-ref="">{{ __('admin/adm-logs.sorting') }}</label>
                </div>
            </div>

            <div class="grid grid-cols-[20%_10%_30%_40%] text-white a4-bg-shade-100 mt-4 p-2 min-w-full text-left text-sm font-semibold border a4-bord-shade-100 rounded-t-md">
                <div>{{ __('admin/adm-logs.header-date') }}</div>
                <div>{{ __('admin/adm-logs.header-actions') }}</div>
                <div>{{ __('admin/adm-logs.header-employees-customers') }}</div>
                <div>{{ __('admin/adm-logs.header-customers') }}</div>
            </div>

            <div class="relative border-x border-b rounded-b a4-bord-shade-100 max-h-96 overflow-auto">
                <table id="log-table" class="p-2 min-w-full text-left text-sm font-light">
                    <colgroup>
                        <col class="w-1/5" />
                        <col class="w-[10%]" />
                        <col class="w-[30%]" />
                        <col class="w-2/5" />
                    </colgroup>

                    <tbody>
                        <tr>
                            <td>12-05-2023 15:30</td>
                            <td>Login</td>
                            <td>Marco Cerulli<br /><span>Marco Cerulli Consulting</span></td>
                            <td>Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/112.0 (IP: 85.6.218.106)</td>
                        </tr>
                        <tr>
                            <td>12-05-2023 15:40</td>
                            <td>Apertura tool</td>
                            <td>Neil Otupacca<br /><span>Marco Cerulli Consulting</span></td>
                            <td>Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/112.0 (IP: 85.6.218.106)</td>
                        </tr>
                        <tr>
                            <td>12-05-2023 15:40</td>
                            <td>Apertura tool</td>
                            <td>Neil Otupacca<br /><span>Marco Cerulli Consulting</span></td>
                            <td>Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/112.0 (IP: 85.6.218.106)</td>
                        </tr>
                        <tr>
                            <td>12-05-2023 15:40</td>
                            <td>Apertura tool</td>
                            <td>Neil Otupacca<br /><span>Marco Cerulli Consulting</span></td>
                            <td>Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/112.0 (IP: 85.6.218.106)</td>
                        </tr>
                        <tr>
                            <td>12-05-2023 15:30</td>
                            <td>Login</td>
                            <td>Marco Cerulli<br /><span>Marco Cerulli Consulting</span></td>
                            <td>Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/112.0 (IP: 85.6.218.106)</td>
                        </tr>
                        <tr>
                            <td>12-05-2023 15:40</td>
                            <td>Apertura tool</td>
                            <td>Neil Otupacca<br /><span>Marco Cerulli Consulting</span></td>
                            <td>Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/112.0 (IP: 85.6.218.106)</td>
                        </tr>
                        <tr>
                            <td>12-05-2023 15:40</td>
                            <td>Apertura tool</td>
                            <td>Neil Otupacca<br /><span>Marco Cerulli Consulting</span></td>
                            <td>Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/112.0 (IP: 85.6.218.106)</td>
                        </tr>
                        <tr>
                            <td>12-05-2023 15:40</td>
                            <td>Apertura tool</td>
                            <td>Neil Otupacca<br /><span>Marco Cerulli Consulting</span></td>
                            <td>Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:109.0) Gecko/20100101 Firefox/112.0 (IP: 85.6.218.106)</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </form>
    </div>
</div>

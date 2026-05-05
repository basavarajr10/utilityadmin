@extends('layouts.admin')

@section('styles')
<style>
    /* DataTable toolbar buttons */
    .dataTables_wrapper .btn {
        font-family: 'Inter', sans-serif !important;
        font-size: 0.75rem !important;
        font-weight: 600 !important;
        padding: 6px 12px !important;
        border-radius: 8px !important;
        border: none !important;
        cursor: pointer !important;
        line-height: 1.4 !important;
    }

    .dataTables_wrapper .btn-primary   { background: #002970 !important; color: #fff !important; }
    .dataTables_wrapper .btn-primary:hover { background: #001a4d !important; }

    .dataTables_wrapper .btn-default   { background: #f1f5f9 !important; color: #1e293b !important; border: 1px solid #e2e8f0 !important; }
    .dataTables_wrapper .btn-default:hover { background: #e2e8f0 !important; }

    .dataTables_wrapper .btn-danger    { background: #ef4444 !important; color: #fff !important; }
    .dataTables_wrapper .btn-danger:hover { background: #dc2626 !important; }

    /* Show entries + search */
    .dataTables_wrapper .dataTables_length select,
    .dataTables_wrapper .dataTables_filter input {
        font-family: 'Inter', sans-serif !important;
        font-size: 0.8rem !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 8px !important;
        padding: 5px 10px !important;
        outline: none !important;
        color: #1e293b !important;
    }

    .dataTables_wrapper .dataTables_filter input:focus {
        border-color: #00baf2 !important;
        box-shadow: 0 0 0 3px rgba(0,186,242,0.1) !important;
    }

    .dataTables_wrapper .dataTables_length,
    .dataTables_wrapper .dataTables_filter,
    .dataTables_wrapper .dataTables_info,
    .dataTables_wrapper .dataTables_paginate {
        font-family: 'Inter', sans-serif !important;
        font-size: 0.8rem !important;
        color: #64748b !important;
    }

    .dataTables_wrapper .paginate_button {
        border-radius: 6px !important;
        font-size: 0.78rem !important;
        font-family: 'Inter', sans-serif !important;
    }

    .dataTables_wrapper .paginate_button.current,
    .dataTables_wrapper .paginate_button.current:hover {
        background: #002970 !important;
        border-color: #002970 !important;
        color: #fff !important;
    }

    /* Buttons row spacing */
    .dt-buttons { display: flex; flex-wrap: wrap; gap: 6px; }
</style>
@endsection

@section('content')
<div class="card">
    <div class="card-header" style="display:flex;justify-content:space-between;align-items:center;">
        <span>{{ trans('cruds.customer.title_singular') }} {{ trans('global.list') }}</span>
        @can('customer_create')
            <a href="{{ route('admin.customers.create') }}"
               style="background:linear-gradient(135deg,#002970,#0057b8);color:#fff;padding:8px 18px;border-radius:8px;font-size:0.82rem;font-weight:700;text-decoration:none;display:inline-flex;align-items:center;gap:8px;font-family:'Inter',sans-serif;">
                <i class="fas fa-plus"></i> {{ trans('global.add') }} {{ trans('cruds.customer.title_singular') }}
            </a>
        @endcan
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped table-hover ajaxTable datatable datatable-Customer">
            <thead>
                <tr>
                    <th width="10"></th>
                    <th>{{ trans('cruds.customer.fields.id') }}</th>
                    <th>{{ trans('cruds.customer.fields.profile_photo') }}</th>
                    <th>{{ trans('cruds.customer.fields.first_name') }}</th>
                    <th>{{ trans('cruds.customer.fields.last_name') }}</th>
                    <th>{{ trans('cruds.customer.fields.mobile_number') }}</th>
                    <th>{{ trans('cruds.customer.fields.email') }}</th>
                    <th>{{ trans('cruds.customer.fields.wallet_balance') }}</th>
                    <th>{{ trans('cruds.customer.fields.kyc_status') }}</th>
                    <th>{{ trans('cruds.customer.fields.is_active') }}</th>
                    <th>{{ trans('cruds.customer.fields.referral_code') }}</th>
                    <th>&nbsp;</th>
                </tr>
                <tr>
                    <td></td>
                    <td><input class="search" type="text" placeholder="{{ trans('global.search') }}"></td>
                    <td></td>
                    <td><input class="search" type="text" placeholder="{{ trans('global.search') }}"></td>
                    <td><input class="search" type="text" placeholder="{{ trans('global.search') }}"></td>
                    <td><input class="search" type="text" placeholder="{{ trans('global.search') }}"></td>
                    <td><input class="search" type="text" placeholder="{{ trans('global.search') }}"></td>
                    <td><input class="search" type="text" placeholder="{{ trans('global.search') }}"></td>
                    <td>
                        <select class="search" strict="true">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach(App\Models\Customer::KYC_STATUS_SELECT as $key => $item)
                                <option value="{{ $key }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td></td>
                    <td><input class="search" type="text" placeholder="{{ trans('global.search') }}"></td>
                    <td></td>
                </tr>
            </thead>
        </table>
    </div>
</div>
@endsection

@section('scripts')
@parent
<script>
$(function () {
    let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)

    @can('customer_delete')
    let deleteButton = {
        text: '{{ trans('global.datatables.delete') }}',
        url: "{{ route('admin.customers.massDestroy') }}",
        className: 'btn-danger',
        action: function (e, dt, node, config) {
            var ids = $.map(dt.rows({ selected: true }).data(), function (entry) { return entry.id });
            if (ids.length === 0) { alert('{{ trans('global.datatables.zero_selected') }}'); return; }
            if (confirm('{{ trans('global.areYouSure') }}')) {
                $.ajax({ headers: {'x-csrf-token': _token}, method: 'POST', url: config.url, data: { ids: ids, _method: 'DELETE' }})
                    .done(function () { location.reload() });
            }
        }
    }
    dtButtons.push(deleteButton)
    @endcan

    let dtOverrideGlobals = {
        buttons: dtButtons,
        processing: true,
        serverSide: true,
        retrieve: true,
        aaSorting: [],
        ajax: "{{ route('admin.customers.index') }}",
        columns: [
            { data: 'placeholder', name: 'placeholder' },
            { data: 'id', name: 'id' },
            { data: 'profile_photo', name: 'profile_photo', sortable: false, searchable: false },
            { data: 'first_name', name: 'first_name' },
            { data: 'last_name', name: 'last_name' },
            { data: 'mobile_number', name: 'mobile_number' },
            { data: 'email', name: 'email' },
            { data: 'wallet_balance', name: 'wallet_balance' },
            { data: 'kyc_status', name: 'kyc_status' },
            { data: 'is_active', name: 'is_active' },
            { data: 'referral_code', name: 'referral_code' },
            { data: 'actions', name: '{{ trans('global.actions') }}' }
        ],
        orderCellsTop: true,
        order: [[ 1, 'desc' ]],
        pageLength: 100,
    };

    let table = $('.datatable-Customer').DataTable(dtOverrideGlobals);

    $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
        $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
    });

    let visibleColumnsIndexes = null;
    $('.datatable thead').on('input', '.search', function () {
        let strict = $(this).attr('strict') || false
        let value = strict && this.value ? "^" + this.value + "$" : this.value
        let index = $(this).parent().index()
        if (visibleColumnsIndexes !== null) index = visibleColumnsIndexes[index]
        table.column(index).search(value, strict).draw()
    });

    table.on('column-visibility.dt', function(e, settings, column, state) {
        visibleColumnsIndexes = []
        table.columns(":visible").every(function(colIdx) { visibleColumnsIndexes.push(colIdx); });
    });
});
</script>
@endsection

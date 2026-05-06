@extends('layouts.admin')

@section('styles')
<style>
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
    .dataTables_wrapper .paginate_button { border-radius: 6px !important; font-size: 0.78rem !important; font-family: 'Inter', sans-serif !important; }
    .dataTables_wrapper .paginate_button.current,
    .dataTables_wrapper .paginate_button.current:hover { background: #002970 !important; border-color: #002970 !important; color: #fff !important; }
    .dt-buttons { display: flex; flex-wrap: wrap; gap: 6px; }
</style>
@endsection

@section('content')
<div class="card">
    <div class="card-header" style="display:flex;justify-content:space-between;align-items:center;">
        <span>{{ trans('cruds.userAlert.title_singular') }} {{ trans('global.list') }}</span>
        @can('user_alert_create')
        <a href="{{ route('admin.user-alerts.create') }}"
           style="background:linear-gradient(135deg,#002970,#0057b8);color:#fff;padding:8px 18px;border-radius:8px;font-size:0.82rem;font-weight:700;text-decoration:none;display:inline-flex;align-items:center;gap:8px;font-family:'Inter',sans-serif;">
            <i class="fas fa-plus"></i> {{ trans('global.add') }} {{ trans('cruds.userAlert.title_singular') }}
        </a>
        @endcan
    </div>

    <div class="card-body">
        <table class="table table-bordered table-striped table-hover ajaxTable datatable datatable-UserAlert" style="width:100%">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.userAlert.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.userAlert.fields.alert_text') }}
                    </th>
                    <th>
                        {{ trans('cruds.userAlert.fields.alert_link') }}
                    </th>
                    <th>
                        {{ trans('cruds.userAlert.fields.user') }}
                    </th>
                    <th>
                        {{ trans('cruds.userAlert.fields.created_at') }}
                    </th>
                    <th>{{ trans('global.actions') }}</th>
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
@can('user_alert_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.user-alerts.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).data(), function (entry) {
          return entry.id
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
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
    autoWidth: false,
    aaSorting: [],
    ajax: "{{ route('admin.user-alerts.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'alert_text', name: 'alert_text' },
{ data: 'alert_link', name: 'alert_link' },
{ data: 'user', name: 'users.name' },
{ data: 'created_at', name: 'created_at' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-UserAlert').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
});

</script>
@endsection
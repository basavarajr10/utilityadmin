@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
<span>{{ trans('cruds.dthRecharge.title_singular') }} {{ trans('global.list') }}</span>
@can('dth_recharge_create')
<a href="{{ route('admin.dth-recharges.create') }}" class="btn-add-record"><i class="fas fa-plus"></i> {{ trans('global.add') }} {{ trans('cruds.dthRecharge.title_singular') }}</a>
@endcan
</div>

    <div class="card-body">
        <table class=" table table-bordered table-striped table-hover ajaxTable datatable datatable-DthRecharge">
            <thead>
                <tr>
                    <th width="10">

                    </th>
                    <th>
                        {{ trans('cruds.dthRecharge.fields.id') }}
                    </th>
                    <th>
                        {{ trans('cruds.dthRecharge.fields.customer') }}
                    </th>
                    <th>
                        {{ trans('cruds.dthRecharge.fields.txn') }}
                    </th>
                    <th>
                        {{ trans('cruds.dthRecharge.fields.subscriber') }}
                    </th>
                    <th>
                        {{ trans('cruds.dthRecharge.fields.provider') }}
                    </th>
                    <th>
                        {{ trans('cruds.dthRecharge.fields.pack_name') }}
                    </th>
                    <th>
                        {{ trans('cruds.dthRecharge.fields.amount') }}
                    </th>
                    <th>
                        {{ trans('cruds.dthRecharge.fields.status') }}
                    </th>
                    <th>
                        {{ trans('cruds.dthRecharge.fields.api_ref') }}
                    </th>
                    <th>
                        &nbsp;
                    </th>
                </tr>
                <tr>
                    <td>
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <select class="search">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach($customers as $key => $item)
                                <option value="{{ $item->first_name }}">{{ $item->first_name }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                        <select class="search" strict="true">
                            <option value>{{ trans('global.all') }}</option>
                            @foreach(App\Models\DthRecharge::STATUS_SELECT as $key => $item)
                                <option value="{{ $key }}">{{ $item }}</option>
                            @endforeach
                        </select>
                    </td>
                    <td>
                        <input class="search" type="text" placeholder="{{ trans('global.search') }}">
                    </td>
                    <td>
                    </td>
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
@can('dth_recharge_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}';
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.dth-recharges.massDestroy') }}",
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
    aaSorting: [],
    ajax: "{{ route('admin.dth-recharges.index') }}",
    columns: [
      { data: 'placeholder', name: 'placeholder' },
{ data: 'id', name: 'id' },
{ data: 'customer_first_name', name: 'customer.first_name' },
{ data: 'txn', name: 'txn' },
{ data: 'subscriber', name: 'subscriber' },
{ data: 'provider', name: 'provider' },
{ data: 'pack_name', name: 'pack_name' },
{ data: 'amount', name: 'amount' },
{ data: 'status', name: 'status' },
{ data: 'api_ref', name: 'api_ref' },
{ data: 'actions', name: '{{ trans('global.actions') }}' }
    ],
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  };
  let table = $('.datatable-DthRecharge').DataTable(dtOverrideGlobals);
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
let visibleColumnsIndexes = null;
$('.datatable thead').on('input', '.search', function () {
      let strict = $(this).attr('strict') || false
      let value = strict && this.value ? "^" + this.value + "$" : this.value

      let index = $(this).parent().index()
      if (visibleColumnsIndexes !== null) {
        index = visibleColumnsIndexes[index]
      }

      table
        .column(index)
        .search(value, strict)
        .draw()
  });
table.on('column-visibility.dt', function(e, settings, column, state) {
      visibleColumnsIndexes = []
      table.columns(":visible").every(function(colIdx) {
          visibleColumnsIndexes.push(colIdx);
      });
  })
});

</script>
@endsection
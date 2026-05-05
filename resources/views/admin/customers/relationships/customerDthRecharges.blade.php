<div class="m-3">
    @can('dth_recharge_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.dth-recharges.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.dthRecharge.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.dthRecharge.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-customerDthRecharges">
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
                    </thead>
                    <tbody>
                        @foreach($dthRecharges as $key => $dthRecharge)
                            <tr data-entry-id="{{ $dthRecharge->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $dthRecharge->id ?? '' }}
                                </td>
                                <td>
                                    {{ $dthRecharge->customer->first_name ?? '' }}
                                </td>
                                <td>
                                    {{ $dthRecharge->txn ?? '' }}
                                </td>
                                <td>
                                    {{ $dthRecharge->subscriber ?? '' }}
                                </td>
                                <td>
                                    {{ $dthRecharge->provider ?? '' }}
                                </td>
                                <td>
                                    {{ $dthRecharge->pack_name ?? '' }}
                                </td>
                                <td>
                                    {{ $dthRecharge->amount ?? '' }}
                                </td>
                                <td>
                                    {{ App\Models\DthRecharge::STATUS_SELECT[$dthRecharge->status] ?? '' }}
                                </td>
                                <td>
                                    {{ $dthRecharge->api_ref ?? '' }}
                                </td>
                                <td>
                                    @can('dth_recharge_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.dth-recharges.show', $dthRecharge->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan

                                    @can('dth_recharge_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.dth-recharges.edit', $dthRecharge->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    @can('dth_recharge_delete')
                                        <form action="{{ route('admin.dth-recharges.destroy', $dthRecharge->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                            <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                        </form>
                                    @endcan

                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('dth_recharge_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.dth-recharges.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
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

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-customerDthRecharges:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection
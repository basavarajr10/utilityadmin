<div class="m-3">
    @can('mobile_recharge_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.mobile-recharges.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.mobileRecharge.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.mobileRecharge.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-customerMobileRecharges">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                {{ trans('cruds.mobileRecharge.fields.id') }}
                            </th>
                            <th>
                                {{ trans('cruds.mobileRecharge.fields.customer') }}
                            </th>
                            <th>
                                {{ trans('cruds.mobileRecharge.fields.txn') }}
                            </th>
                            <th>
                                {{ trans('cruds.mobileRecharge.fields.mobile_number') }}
                            </th>
                            <th>
                                {{ trans('cruds.mobileRecharge.fields.operator') }}
                            </th>
                            <th>
                                {{ trans('cruds.mobileRecharge.fields.circle') }}
                            </th>
                            <th>
                                {{ trans('cruds.mobileRecharge.fields.plan_name') }}
                            </th>
                            <th>
                                {{ trans('cruds.mobileRecharge.fields.amount') }}
                            </th>
                            <th>
                                {{ trans('cruds.mobileRecharge.fields.status') }}
                            </th>
                            <th>
                                {{ trans('cruds.mobileRecharge.fields.api_ref') }}
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($mobileRecharges as $key => $mobileRecharge)
                            <tr data-entry-id="{{ $mobileRecharge->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $mobileRecharge->id ?? '' }}
                                </td>
                                <td>
                                    {{ $mobileRecharge->customer->first_name ?? '' }}
                                </td>
                                <td>
                                    {{ $mobileRecharge->txn ?? '' }}
                                </td>
                                <td>
                                    {{ $mobileRecharge->mobile_number ?? '' }}
                                </td>
                                <td>
                                    {{ $mobileRecharge->operator ?? '' }}
                                </td>
                                <td>
                                    {{ $mobileRecharge->circle ?? '' }}
                                </td>
                                <td>
                                    {{ $mobileRecharge->plan_name ?? '' }}
                                </td>
                                <td>
                                    {{ $mobileRecharge->amount ?? '' }}
                                </td>
                                <td>
                                    {{ App\Models\MobileRecharge::STATUS_SELECT[$mobileRecharge->status] ?? '' }}
                                </td>
                                <td>
                                    {{ $mobileRecharge->api_ref ?? '' }}
                                </td>
                                <td>
                                    @can('mobile_recharge_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.mobile-recharges.show', $mobileRecharge->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan

                                    @can('mobile_recharge_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.mobile-recharges.edit', $mobileRecharge->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    @can('mobile_recharge_delete')
                                        <form action="{{ route('admin.mobile-recharges.destroy', $mobileRecharge->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('mobile_recharge_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.mobile-recharges.massDestroy') }}",
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
  let table = $('.datatable-customerMobileRecharges:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection
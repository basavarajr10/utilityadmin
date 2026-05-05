<div class="m-3">
    @can('wallet_topup_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.wallet-topups.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.walletTopup.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.walletTopup.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-customerWalletTopups">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                {{ trans('cruds.walletTopup.fields.id') }}
                            </th>
                            <th>
                                {{ trans('cruds.walletTopup.fields.customer') }}
                            </th>
                            <th>
                                {{ trans('cruds.walletTopup.fields.txn') }}
                            </th>
                            <th>
                                {{ trans('cruds.walletTopup.fields.amount') }}
                            </th>
                            <th>
                                {{ trans('cruds.walletTopup.fields.method') }}
                            </th>
                            <th>
                                {{ trans('cruds.walletTopup.fields.gateway_ref') }}
                            </th>
                            <th>
                                {{ trans('cruds.walletTopup.fields.status') }}
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($walletTopups as $key => $walletTopup)
                            <tr data-entry-id="{{ $walletTopup->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $walletTopup->id ?? '' }}
                                </td>
                                <td>
                                    {{ $walletTopup->customer->first_name ?? '' }}
                                </td>
                                <td>
                                    {{ $walletTopup->txn ?? '' }}
                                </td>
                                <td>
                                    {{ $walletTopup->amount ?? '' }}
                                </td>
                                <td>
                                    {{ App\Models\WalletTopup::METHOD_SELECT[$walletTopup->method] ?? '' }}
                                </td>
                                <td>
                                    {{ $walletTopup->gateway_ref ?? '' }}
                                </td>
                                <td>
                                    {{ App\Models\WalletTopup::STATUS_SELECT[$walletTopup->status] ?? '' }}
                                </td>
                                <td>
                                    @can('wallet_topup_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.wallet-topups.show', $walletTopup->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan

                                    @can('wallet_topup_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.wallet-topups.edit', $walletTopup->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    @can('wallet_topup_delete')
                                        <form action="{{ route('admin.wallet-topups.destroy', $walletTopup->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('wallet_topup_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.wallet-topups.massDestroy') }}",
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
  let table = $('.datatable-customerWalletTopups:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection
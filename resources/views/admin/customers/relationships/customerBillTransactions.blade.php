<div class="m-3">
    @can('bill_transaction_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.bill-transactions.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.billTransaction.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.billTransaction.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-customerBillTransactions">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                {{ trans('cruds.billTransaction.fields.id') }}
                            </th>
                            <th>
                                {{ trans('cruds.billTransaction.fields.customer') }}
                            </th>
                            <th>
                                {{ trans('cruds.billTransaction.fields.txn') }}
                            </th>
                            <th>
                                {{ trans('cruds.billTransaction.fields.category') }}
                            </th>
                            <th>
                                {{ trans('cruds.billTransaction.fields.biller_name') }}
                            </th>
                            <th>
                                {{ trans('cruds.billTransaction.fields.consumer_number') }}
                            </th>
                            <th>
                                {{ trans('cruds.billTransaction.fields.amount') }}
                            </th>
                            <th>
                                {{ trans('cruds.billTransaction.fields.status') }}
                            </th>
                            <th>
                                {{ trans('cruds.billTransaction.fields.bbps_ref') }}
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($billTransactions as $key => $billTransaction)
                            <tr data-entry-id="{{ $billTransaction->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $billTransaction->id ?? '' }}
                                </td>
                                <td>
                                    {{ $billTransaction->customer->first_name ?? '' }}
                                </td>
                                <td>
                                    {{ $billTransaction->txn ?? '' }}
                                </td>
                                <td>
                                    {{ App\Models\BillTransaction::CATEGORY_SELECT[$billTransaction->category] ?? '' }}
                                </td>
                                <td>
                                    {{ $billTransaction->biller_name ?? '' }}
                                </td>
                                <td>
                                    {{ $billTransaction->consumer_number ?? '' }}
                                </td>
                                <td>
                                    {{ $billTransaction->amount ?? '' }}
                                </td>
                                <td>
                                    {{ App\Models\BillTransaction::STATUS_SELECT[$billTransaction->status] ?? '' }}
                                </td>
                                <td>
                                    {{ $billTransaction->bbps_ref ?? '' }}
                                </td>
                                <td>
                                    @can('bill_transaction_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.bill-transactions.show', $billTransaction->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan

                                    @can('bill_transaction_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.bill-transactions.edit', $billTransaction->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    @can('bill_transaction_delete')
                                        <form action="{{ route('admin.bill-transactions.destroy', $billTransaction->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('bill_transaction_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.bill-transactions.massDestroy') }}",
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
  let table = $('.datatable-customerBillTransactions:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection
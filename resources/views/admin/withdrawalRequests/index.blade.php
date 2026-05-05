@extends('layouts.admin')
@section('content')
<div class="card">
    <div class="card-header">
<span>{{ trans('cruds.withdrawalRequest.title_singular') }} {{ trans('global.list') }}</span>
@can('withdrawal_request_create')
<a href="{{ route('admin.withdrawal-requests.create') }}" class="btn-add-record"><i class="fas fa-plus"></i> {{ trans('global.add') }} {{ trans('cruds.withdrawalRequest.title_singular') }}</a>
@endcan
</div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-WithdrawalRequest">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.withdrawalRequest.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.withdrawalRequest.fields.customer') }}
                        </th>
                        <th>
                            {{ trans('cruds.withdrawalRequest.fields.amount') }}
                        </th>
                        <th>
                            {{ trans('cruds.withdrawalRequest.fields.bank_name') }}
                        </th>
                        <th>
                            {{ trans('cruds.withdrawalRequest.fields.account_number') }}
                        </th>
                        <th>
                            {{ trans('cruds.withdrawalRequest.fields.ifsc_code') }}
                        </th>
                        <th>
                            {{ trans('cruds.withdrawalRequest.fields.upi') }}
                        </th>
                        <th>
                            {{ trans('cruds.withdrawalRequest.fields.status') }}
                        </th>
                        <th>
                            {{ trans('cruds.withdrawalRequest.fields.processed_at') }}
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
                                @foreach(App\Models\WithdrawalRequest::STATUS_SELECT as $key => $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
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
                <tbody>
                    @foreach($withdrawalRequests as $key => $withdrawalRequest)
                        <tr data-entry-id="{{ $withdrawalRequest->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $withdrawalRequest->id ?? '' }}
                            </td>
                            <td>
                                {{ $withdrawalRequest->customer->first_name ?? '' }}
                            </td>
                            <td>
                                {{ $withdrawalRequest->amount ?? '' }}
                            </td>
                            <td>
                                {{ $withdrawalRequest->bank_name ?? '' }}
                            </td>
                            <td>
                                {{ $withdrawalRequest->account_number ?? '' }}
                            </td>
                            <td>
                                {{ $withdrawalRequest->ifsc_code ?? '' }}
                            </td>
                            <td>
                                {{ $withdrawalRequest->upi ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\WithdrawalRequest::STATUS_SELECT[$withdrawalRequest->status] ?? '' }}
                            </td>
                            <td>
                                {{ $withdrawalRequest->processed_at ?? '' }}
                            </td>
                            <td>
                                @can('withdrawal_request_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.withdrawal-requests.show', $withdrawalRequest->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('withdrawal_request_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.withdrawal-requests.edit', $withdrawalRequest->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('withdrawal_request_delete')
                                    <form action="{{ route('admin.withdrawal-requests.destroy', $withdrawalRequest->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('withdrawal_request_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.withdrawal-requests.massDestroy') }}",
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
  let table = $('.datatable-WithdrawalRequest:not(.ajaxTable)').DataTable({ buttons: dtButtons })
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
})

</script>
@endsection
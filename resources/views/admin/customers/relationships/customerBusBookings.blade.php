<div class="m-3">
    @can('bus_booking_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.bus-bookings.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.busBooking.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.busBooking.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-customerBusBookings">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                {{ trans('cruds.busBooking.fields.id') }}
                            </th>
                            <th>
                                {{ trans('cruds.busBooking.fields.customer') }}
                            </th>
                            <th>
                                {{ trans('cruds.busBooking.fields.booking') }}
                            </th>
                            <th>
                                {{ trans('cruds.busBooking.fields.source') }}
                            </th>
                            <th>
                                {{ trans('cruds.busBooking.fields.destination') }}
                            </th>
                            <th>
                                {{ trans('cruds.busBooking.fields.travel_date') }}
                            </th>
                            <th>
                                {{ trans('cruds.busBooking.fields.seats') }}
                            </th>
                            <th>
                                {{ trans('cruds.busBooking.fields.passenger_details') }}
                            </th>
                            <th>
                                {{ trans('cruds.busBooking.fields.amount') }}
                            </th>
                            <th>
                                {{ trans('cruds.busBooking.fields.status') }}
                            </th>
                            <th>
                                {{ trans('cruds.busBooking.fields.api_ref') }}
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($busBookings as $key => $busBooking)
                            <tr data-entry-id="{{ $busBooking->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $busBooking->id ?? '' }}
                                </td>
                                <td>
                                    {{ $busBooking->customer->first_name ?? '' }}
                                </td>
                                <td>
                                    {{ $busBooking->booking ?? '' }}
                                </td>
                                <td>
                                    {{ $busBooking->source ?? '' }}
                                </td>
                                <td>
                                    {{ $busBooking->destination ?? '' }}
                                </td>
                                <td>
                                    {{ $busBooking->travel_date ?? '' }}
                                </td>
                                <td>
                                    {{ $busBooking->seats ?? '' }}
                                </td>
                                <td>
                                    {{ $busBooking->passenger_details ?? '' }}
                                </td>
                                <td>
                                    {{ $busBooking->amount ?? '' }}
                                </td>
                                <td>
                                    {{ App\Models\BusBooking::STATUS_SELECT[$busBooking->status] ?? '' }}
                                </td>
                                <td>
                                    {{ $busBooking->api_ref ?? '' }}
                                </td>
                                <td>
                                    @can('bus_booking_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.bus-bookings.show', $busBooking->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan

                                    @can('bus_booking_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.bus-bookings.edit', $busBooking->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    @can('bus_booking_delete')
                                        <form action="{{ route('admin.bus-bookings.destroy', $busBooking->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('bus_booking_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.bus-bookings.massDestroy') }}",
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
  let table = $('.datatable-customerBusBookings:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection
<div class="m-3">
    @can('kyc_request_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.kyc-requests.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.kycRequest.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card">
        <div class="card-header">
            {{ trans('cruds.kycRequest.title_singular') }} {{ trans('global.list') }}
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-customerKycRequests">
                    <thead>
                        <tr>
                            <th width="10">

                            </th>
                            <th>
                                {{ trans('cruds.kycRequest.fields.id') }}
                            </th>
                            <th>
                                {{ trans('cruds.kycRequest.fields.customer') }}
                            </th>
                            <th>
                                {{ trans('cruds.kycRequest.fields.aadhaar_number') }}
                            </th>
                            <th>
                                {{ trans('cruds.kycRequest.fields.pan_number') }}
                            </th>
                            <th>
                                {{ trans('cruds.kycRequest.fields.selfie') }}
                            </th>
                            <th>
                                {{ trans('cruds.kycRequest.fields.aadhaar_doc') }}
                            </th>
                            <th>
                                {{ trans('cruds.kycRequest.fields.pan_doc') }}
                            </th>
                            <th>
                                {{ trans('cruds.kycRequest.fields.status') }}
                            </th>
                            <th>
                                {{ trans('cruds.kycRequest.fields.reviewed_at') }}
                            </th>
                            <th>
                                &nbsp;
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kycRequests as $key => $kycRequest)
                            <tr data-entry-id="{{ $kycRequest->id }}">
                                <td>

                                </td>
                                <td>
                                    {{ $kycRequest->id ?? '' }}
                                </td>
                                <td>
                                    {{ $kycRequest->customer->first_name ?? '' }}
                                </td>
                                <td>
                                    {{ $kycRequest->aadhaar_number ?? '' }}
                                </td>
                                <td>
                                    {{ $kycRequest->pan_number ?? '' }}
                                </td>
                                <td>
                                    @if($kycRequest->selfie)
                                        <a href="{{ $kycRequest->selfie->getUrl() }}" target="_blank" style="display: inline-block">
                                            <img src="{{ $kycRequest->selfie->getUrl('thumb') }}">
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    @foreach($kycRequest->aadhaar_doc as $key => $media)
                                        <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                            <img src="{{ $media->getUrl('thumb') }}">
                                        </a>
                                    @endforeach
                                </td>
                                <td>
                                    @foreach($kycRequest->pan_doc as $key => $media)
                                        <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                            <img src="{{ $media->getUrl('thumb') }}">
                                        </a>
                                    @endforeach
                                </td>
                                <td>
                                    {{ App\Models\KycRequest::STATUS_SELECT[$kycRequest->status] ?? '' }}
                                </td>
                                <td>
                                    {{ $kycRequest->reviewed_at ?? '' }}
                                </td>
                                <td>
                                    @can('kyc_request_show')
                                        <a class="btn btn-xs btn-primary" href="{{ route('admin.kyc-requests.show', $kycRequest->id) }}">
                                            {{ trans('global.view') }}
                                        </a>
                                    @endcan

                                    @can('kyc_request_edit')
                                        <a class="btn btn-xs btn-info" href="{{ route('admin.kyc-requests.edit', $kycRequest->id) }}">
                                            {{ trans('global.edit') }}
                                        </a>
                                    @endcan

                                    @can('kyc_request_delete')
                                        <form action="{{ route('admin.kyc-requests.destroy', $kycRequest->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('kyc_request_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.kyc-requests.massDestroy') }}",
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
  let table = $('.datatable-customerKycRequests:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection
@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.kycRequest.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.kyc-requests.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.kycRequest.fields.id') }}
                        </th>
                        <td>
                            {{ $kycRequest->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.kycRequest.fields.customer') }}
                        </th>
                        <td>
                            {{ $kycRequest->customer->first_name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.kycRequest.fields.aadhaar_number') }}
                        </th>
                        <td>
                            {{ $kycRequest->aadhaar_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.kycRequest.fields.pan_number') }}
                        </th>
                        <td>
                            {{ $kycRequest->pan_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.kycRequest.fields.selfie') }}
                        </th>
                        <td>
                            @if($kycRequest->selfie)
                                <a href="{{ $kycRequest->selfie->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $kycRequest->selfie->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.kycRequest.fields.aadhaar_doc') }}
                        </th>
                        <td>
                            @foreach($kycRequest->aadhaar_doc as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.kycRequest.fields.pan_doc') }}
                        </th>
                        <td>
                            @foreach($kycRequest->pan_doc as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.kycRequest.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\KycRequest::STATUS_SELECT[$kycRequest->status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.kycRequest.fields.reviewer_note') }}
                        </th>
                        <td>
                            {!! $kycRequest->reviewer_note !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.kycRequest.fields.reviewed_at') }}
                        </th>
                        <td>
                            {{ $kycRequest->reviewed_at }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.kyc-requests.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
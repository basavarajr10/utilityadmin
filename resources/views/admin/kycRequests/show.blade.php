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
                        <th>Overall Status</th>
                        <td>
                            @php $s = $kycRequest->status; @endphp
                            <span class="badge badge-{{ $s === 'approved' ? 'success' : ($s === 'rejected' ? 'danger' : 'warning') }}">
                                {{ App\Models\KycRequest::STATUS_SELECT[$s] ?? $s }}
                            </span>
                        </td>
                    </tr>
                    <tr>
                        <th>Reviewed At</th>
                        <td>{{ $kycRequest->reviewed_at }}</td>
                    </tr>
                    <tr>
                        <th>Reviewer Note</th>
                        <td>{{ strip_tags($kycRequest->reviewer_note ?? '') }}</td>
                    </tr>
                </tbody>
            </table>

            {{-- Per-document status table --}}
            <h5 class="mt-4">Document Review</h5>
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Document</th>
                        <th>Image</th>
                        <th>Status</th>
                        <th>Note</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                    $docs = [
                        ['label' => 'Selfie',        'img' => $kycRequest->selfie,        'status' => $kycRequest->selfie_status,        'note' => $kycRequest->selfie_note],
                        ['label' => 'Aadhaar Front', 'img' => null,                        'status' => $kycRequest->aadhaar_front_status, 'note' => $kycRequest->aadhaar_front_note],
                        ['label' => 'Aadhaar Back',  'img' => null,                        'status' => $kycRequest->aadhaar_back_status,  'note' => $kycRequest->aadhaar_back_note],
                        ['label' => 'PAN Image',     'img' => null,                        'status' => $kycRequest->pan_image_status,     'note' => $kycRequest->pan_image_note],
                    ];
                    $aadhaarImgs = $kycRequest->aadhaar_doc;
                    $panImgs     = $kycRequest->pan_doc;
                    $docs[1]['img'] = $aadhaarImgs[0] ?? null;
                    $docs[2]['img'] = $aadhaarImgs[1] ?? null;
                    $docs[3]['img'] = $panImgs[0] ?? null;
                    @endphp
                    @foreach($docs as $doc)
                    <tr>
                        <td>{{ $doc['label'] }}</td>
                        <td>
                            @if($doc['img'])
                                <a href="{{ $doc['img']->url }}" target="_blank">
                                    <img src="{{ $doc['img']->thumbnail ?? $doc['img']->url }}" style="max-width:60px;">
                                </a>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            @php $ds = $doc['status'] ?? 'pending'; @endphp
                            <span class="badge badge-{{ $ds === 'approved' ? 'success' : ($ds === 'rejected' ? 'danger' : 'warning') }}">
                                {{ ucfirst($ds) }}
                            </span>
                        </td>
                        <td>{{ $doc['note'] ?? '—' }}</td>
                    </tr>
                    @endforeach
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
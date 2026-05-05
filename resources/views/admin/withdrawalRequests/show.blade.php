@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.withdrawalRequest.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.withdrawal-requests.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.withdrawalRequest.fields.id') }}
                        </th>
                        <td>
                            {{ $withdrawalRequest->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.withdrawalRequest.fields.customer') }}
                        </th>
                        <td>
                            {{ $withdrawalRequest->customer->first_name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.withdrawalRequest.fields.amount') }}
                        </th>
                        <td>
                            {{ $withdrawalRequest->amount }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.withdrawalRequest.fields.bank_name') }}
                        </th>
                        <td>
                            {{ $withdrawalRequest->bank_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.withdrawalRequest.fields.account_number') }}
                        </th>
                        <td>
                            {{ $withdrawalRequest->account_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.withdrawalRequest.fields.ifsc_code') }}
                        </th>
                        <td>
                            {{ $withdrawalRequest->ifsc_code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.withdrawalRequest.fields.upi') }}
                        </th>
                        <td>
                            {{ $withdrawalRequest->upi }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.withdrawalRequest.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\WithdrawalRequest::STATUS_SELECT[$withdrawalRequest->status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.withdrawalRequest.fields.admin_note') }}
                        </th>
                        <td>
                            {!! $withdrawalRequest->admin_note !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.withdrawalRequest.fields.processed_at') }}
                        </th>
                        <td>
                            {{ $withdrawalRequest->processed_at }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.withdrawal-requests.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
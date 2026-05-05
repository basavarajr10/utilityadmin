@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.mobileRecharge.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.mobile-recharges.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.mobileRecharge.fields.id') }}
                        </th>
                        <td>
                            {{ $mobileRecharge->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.mobileRecharge.fields.customer') }}
                        </th>
                        <td>
                            {{ $mobileRecharge->customer->first_name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.mobileRecharge.fields.txn') }}
                        </th>
                        <td>
                            {{ $mobileRecharge->txn }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.mobileRecharge.fields.mobile_number') }}
                        </th>
                        <td>
                            {{ $mobileRecharge->mobile_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.mobileRecharge.fields.operator') }}
                        </th>
                        <td>
                            {{ $mobileRecharge->operator }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.mobileRecharge.fields.circle') }}
                        </th>
                        <td>
                            {{ $mobileRecharge->circle }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.mobileRecharge.fields.plan_name') }}
                        </th>
                        <td>
                            {{ $mobileRecharge->plan_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.mobileRecharge.fields.amount') }}
                        </th>
                        <td>
                            {{ $mobileRecharge->amount }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.mobileRecharge.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\MobileRecharge::STATUS_SELECT[$mobileRecharge->status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.mobileRecharge.fields.api_ref') }}
                        </th>
                        <td>
                            {{ $mobileRecharge->api_ref }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.mobile-recharges.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
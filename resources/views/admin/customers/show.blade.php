@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.customer.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.customers.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.customer.fields.id') }}
                        </th>
                        <td>
                            {{ $customer->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.customer.fields.profile_photo') }}
                        </th>
                        <td>
                            @if($customer->profile_photo)
                                <a href="{{ $customer->profile_photo->url }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $customer->profile_photo->thumbnail ?? $customer->profile_photo->url }}" style="max-width:80px;">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.customer.fields.first_name') }}
                        </th>
                        <td>
                            {{ $customer->first_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.customer.fields.last_name') }}
                        </th>
                        <td>
                            {{ $customer->last_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.customer.fields.mobile_number') }}
                        </th>
                        <td>
                            {{ $customer->mobile_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.customer.fields.email') }}
                        </th>
                        <td>
                            {{ $customer->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.customer.fields.wallet_balance') }}
                        </th>
                        <td>
                            {{ $customer->wallet_balance }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.customer.fields.kyc_status') }}
                        </th>
                        <td>
                            {{ App\Models\Customer::KYC_STATUS_SELECT[$customer->kyc_status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.customer.fields.is_active') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $customer->is_active ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.customer.fields.device_token') }}
                        </th>
                        <td>
                            {{ $customer->device_token }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.customer.fields.referral_code') }}
                        </th>
                        <td>
                            {{ $customer->referral_code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.customer.fields.last_login') }}
                        </th>
                        <td>
                            {{ $customer->last_login }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.customers.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        <li class="nav-item">
            <a class="nav-link" href="#customer_kyc_requests" role="tab" data-toggle="tab">
                {{ trans('cruds.kycRequest.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#customer_mobile_recharges" role="tab" data-toggle="tab">
                {{ trans('cruds.mobileRecharge.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#customer_dth_recharges" role="tab" data-toggle="tab">
                {{ trans('cruds.dthRecharge.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#customer_bill_transactions" role="tab" data-toggle="tab">
                {{ trans('cruds.billTransaction.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#customer_bus_bookings" role="tab" data-toggle="tab">
                {{ trans('cruds.busBooking.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#customer_wallet_topups" role="tab" data-toggle="tab">
                {{ trans('cruds.walletTopup.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#customer_withdrawal_requests" role="tab" data-toggle="tab">
                {{ trans('cruds.withdrawalRequest.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#customer_transactions" role="tab" data-toggle="tab">
                {{ trans('cruds.transaction.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="customer_kyc_requests">
            @includeIf('admin.customers.relationships.customerKycRequests', ['kycRequests' => $customer->customerKycRequests])
        </div>
        <div class="tab-pane" role="tabpanel" id="customer_mobile_recharges">
            @includeIf('admin.customers.relationships.customerMobileRecharges', ['mobileRecharges' => $customer->customerMobileRecharges])
        </div>
        <div class="tab-pane" role="tabpanel" id="customer_dth_recharges">
            @includeIf('admin.customers.relationships.customerDthRecharges', ['dthRecharges' => $customer->customerDthRecharges])
        </div>
        <div class="tab-pane" role="tabpanel" id="customer_bill_transactions">
            @includeIf('admin.customers.relationships.customerBillTransactions', ['billTransactions' => $customer->customerBillTransactions])
        </div>
        <div class="tab-pane" role="tabpanel" id="customer_bus_bookings">
            @includeIf('admin.customers.relationships.customerBusBookings', ['busBookings' => $customer->customerBusBookings])
        </div>
        <div class="tab-pane" role="tabpanel" id="customer_wallet_topups">
            @includeIf('admin.customers.relationships.customerWalletTopups', ['walletTopups' => $customer->customerWalletTopups])
        </div>
        <div class="tab-pane" role="tabpanel" id="customer_withdrawal_requests">
            @includeIf('admin.customers.relationships.customerWithdrawalRequests', ['withdrawalRequests' => $customer->customerWithdrawalRequests])
        </div>
        <div class="tab-pane" role="tabpanel" id="customer_transactions">
            @includeIf('admin.customers.relationships.customerTransactions', ['transactions' => $customer->customerTransactions])
        </div>
    </div>
</div>

@endsection
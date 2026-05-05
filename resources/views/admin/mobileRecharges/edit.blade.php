@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.mobileRecharge.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.mobile-recharges.update", [$mobileRecharge->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="customer_id">{{ trans('cruds.mobileRecharge.fields.customer') }}</label>
                <select class="form-control select2 {{ $errors->has('customer') ? 'is-invalid' : '' }}" name="customer_id" id="customer_id" required>
                    @foreach($customers as $id => $entry)
                        <option value="{{ $id }}" {{ (old('customer_id') ? old('customer_id') : $mobileRecharge->customer->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('customer'))
                    <span class="text-danger">{{ $errors->first('customer') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.mobileRecharge.fields.customer_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="txn">{{ trans('cruds.mobileRecharge.fields.txn') }}</label>
                <input class="form-control {{ $errors->has('txn') ? 'is-invalid' : '' }}" type="text" name="txn" id="txn" value="{{ old('txn', $mobileRecharge->txn) }}" required>
                @if($errors->has('txn'))
                    <span class="text-danger">{{ $errors->first('txn') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.mobileRecharge.fields.txn_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="mobile_number">{{ trans('cruds.mobileRecharge.fields.mobile_number') }}</label>
                <input class="form-control {{ $errors->has('mobile_number') ? 'is-invalid' : '' }}" type="text" name="mobile_number" id="mobile_number" value="{{ old('mobile_number', $mobileRecharge->mobile_number) }}" required>
                @if($errors->has('mobile_number'))
                    <span class="text-danger">{{ $errors->first('mobile_number') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.mobileRecharge.fields.mobile_number_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="operator">{{ trans('cruds.mobileRecharge.fields.operator') }}</label>
                <input class="form-control {{ $errors->has('operator') ? 'is-invalid' : '' }}" type="text" name="operator" id="operator" value="{{ old('operator', $mobileRecharge->operator) }}" required>
                @if($errors->has('operator'))
                    <span class="text-danger">{{ $errors->first('operator') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.mobileRecharge.fields.operator_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="circle">{{ trans('cruds.mobileRecharge.fields.circle') }}</label>
                <input class="form-control {{ $errors->has('circle') ? 'is-invalid' : '' }}" type="text" name="circle" id="circle" value="{{ old('circle', $mobileRecharge->circle) }}">
                @if($errors->has('circle'))
                    <span class="text-danger">{{ $errors->first('circle') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.mobileRecharge.fields.circle_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="plan_name">{{ trans('cruds.mobileRecharge.fields.plan_name') }}</label>
                <input class="form-control {{ $errors->has('plan_name') ? 'is-invalid' : '' }}" type="text" name="plan_name" id="plan_name" value="{{ old('plan_name', $mobileRecharge->plan_name) }}">
                @if($errors->has('plan_name'))
                    <span class="text-danger">{{ $errors->first('plan_name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.mobileRecharge.fields.plan_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="amount">{{ trans('cruds.mobileRecharge.fields.amount') }}</label>
                <input class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" type="text" name="amount" id="amount" value="{{ old('amount', $mobileRecharge->amount) }}" required>
                @if($errors->has('amount'))
                    <span class="text-danger">{{ $errors->first('amount') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.mobileRecharge.fields.amount_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.mobileRecharge.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status">
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\MobileRecharge::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', $mobileRecharge->status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <span class="text-danger">{{ $errors->first('status') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.mobileRecharge.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="api_ref">{{ trans('cruds.mobileRecharge.fields.api_ref') }}</label>
                <input class="form-control {{ $errors->has('api_ref') ? 'is-invalid' : '' }}" type="text" name="api_ref" id="api_ref" value="{{ old('api_ref', $mobileRecharge->api_ref) }}">
                @if($errors->has('api_ref'))
                    <span class="text-danger">{{ $errors->first('api_ref') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.mobileRecharge.fields.api_ref_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection
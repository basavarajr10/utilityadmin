@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.dthRecharge.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.dth-recharges.update", [$dthRecharge->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="customer_id">{{ trans('cruds.dthRecharge.fields.customer') }}</label>
                <select class="form-control select2 {{ $errors->has('customer') ? 'is-invalid' : '' }}" name="customer_id" id="customer_id">
                    @foreach($customers as $id => $entry)
                        <option value="{{ $id }}" {{ (old('customer_id') ? old('customer_id') : $dthRecharge->customer->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('customer'))
                    <span class="text-danger">{{ $errors->first('customer') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.dthRecharge.fields.customer_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="txn">{{ trans('cruds.dthRecharge.fields.txn') }}</label>
                <input class="form-control {{ $errors->has('txn') ? 'is-invalid' : '' }}" type="text" name="txn" id="txn" value="{{ old('txn', $dthRecharge->txn) }}" required>
                @if($errors->has('txn'))
                    <span class="text-danger">{{ $errors->first('txn') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.dthRecharge.fields.txn_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="subscriber">{{ trans('cruds.dthRecharge.fields.subscriber') }}</label>
                <input class="form-control {{ $errors->has('subscriber') ? 'is-invalid' : '' }}" type="text" name="subscriber" id="subscriber" value="{{ old('subscriber', $dthRecharge->subscriber) }}" required>
                @if($errors->has('subscriber'))
                    <span class="text-danger">{{ $errors->first('subscriber') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.dthRecharge.fields.subscriber_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="provider">{{ trans('cruds.dthRecharge.fields.provider') }}</label>
                <input class="form-control {{ $errors->has('provider') ? 'is-invalid' : '' }}" type="text" name="provider" id="provider" value="{{ old('provider', $dthRecharge->provider) }}" required>
                @if($errors->has('provider'))
                    <span class="text-danger">{{ $errors->first('provider') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.dthRecharge.fields.provider_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="pack_name">{{ trans('cruds.dthRecharge.fields.pack_name') }}</label>
                <input class="form-control {{ $errors->has('pack_name') ? 'is-invalid' : '' }}" type="text" name="pack_name" id="pack_name" value="{{ old('pack_name', $dthRecharge->pack_name) }}">
                @if($errors->has('pack_name'))
                    <span class="text-danger">{{ $errors->first('pack_name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.dthRecharge.fields.pack_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="amount">{{ trans('cruds.dthRecharge.fields.amount') }}</label>
                <input class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" type="text" name="amount" id="amount" value="{{ old('amount', $dthRecharge->amount) }}" required>
                @if($errors->has('amount'))
                    <span class="text-danger">{{ $errors->first('amount') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.dthRecharge.fields.amount_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.dthRecharge.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status">
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\DthRecharge::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', $dthRecharge->status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <span class="text-danger">{{ $errors->first('status') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.dthRecharge.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="api_ref">{{ trans('cruds.dthRecharge.fields.api_ref') }}</label>
                <input class="form-control {{ $errors->has('api_ref') ? 'is-invalid' : '' }}" type="text" name="api_ref" id="api_ref" value="{{ old('api_ref', $dthRecharge->api_ref) }}">
                @if($errors->has('api_ref'))
                    <span class="text-danger">{{ $errors->first('api_ref') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.dthRecharge.fields.api_ref_helper') }}</span>
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
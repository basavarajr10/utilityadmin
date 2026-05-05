@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.walletTopup.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.wallet-topups.update", [$walletTopup->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="customer_id">{{ trans('cruds.walletTopup.fields.customer') }}</label>
                <select class="form-control select2 {{ $errors->has('customer') ? 'is-invalid' : '' }}" name="customer_id" id="customer_id" required>
                    @foreach($customers as $id => $entry)
                        <option value="{{ $id }}" {{ (old('customer_id') ? old('customer_id') : $walletTopup->customer->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('customer'))
                    <span class="text-danger">{{ $errors->first('customer') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.walletTopup.fields.customer_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="txn">{{ trans('cruds.walletTopup.fields.txn') }}</label>
                <input class="form-control {{ $errors->has('txn') ? 'is-invalid' : '' }}" type="text" name="txn" id="txn" value="{{ old('txn', $walletTopup->txn) }}" required>
                @if($errors->has('txn'))
                    <span class="text-danger">{{ $errors->first('txn') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.walletTopup.fields.txn_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="amount">{{ trans('cruds.walletTopup.fields.amount') }}</label>
                <input class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" type="text" name="amount" id="amount" value="{{ old('amount', $walletTopup->amount) }}" required>
                @if($errors->has('amount'))
                    <span class="text-danger">{{ $errors->first('amount') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.walletTopup.fields.amount_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.walletTopup.fields.method') }}</label>
                <select class="form-control {{ $errors->has('method') ? 'is-invalid' : '' }}" name="method" id="method">
                    <option value disabled {{ old('method', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\WalletTopup::METHOD_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('method', $walletTopup->method) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('method'))
                    <span class="text-danger">{{ $errors->first('method') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.walletTopup.fields.method_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="gateway_ref">{{ trans('cruds.walletTopup.fields.gateway_ref') }}</label>
                <input class="form-control {{ $errors->has('gateway_ref') ? 'is-invalid' : '' }}" type="text" name="gateway_ref" id="gateway_ref" value="{{ old('gateway_ref', $walletTopup->gateway_ref) }}">
                @if($errors->has('gateway_ref'))
                    <span class="text-danger">{{ $errors->first('gateway_ref') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.walletTopup.fields.gateway_ref_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.walletTopup.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status">
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\WalletTopup::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', $walletTopup->status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <span class="text-danger">{{ $errors->first('status') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.walletTopup.fields.status_helper') }}</span>
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
@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.billTransaction.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.bill-transactions.update", [$billTransaction->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="customer_id">{{ trans('cruds.billTransaction.fields.customer') }}</label>
                <select class="form-control select2 {{ $errors->has('customer') ? 'is-invalid' : '' }}" name="customer_id" id="customer_id" required>
                    @foreach($customers as $id => $entry)
                        <option value="{{ $id }}" {{ (old('customer_id') ? old('customer_id') : $billTransaction->customer->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('customer'))
                    <span class="text-danger">{{ $errors->first('customer') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.billTransaction.fields.customer_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="txn">{{ trans('cruds.billTransaction.fields.txn') }}</label>
                <input class="form-control {{ $errors->has('txn') ? 'is-invalid' : '' }}" type="text" name="txn" id="txn" value="{{ old('txn', $billTransaction->txn) }}" required>
                @if($errors->has('txn'))
                    <span class="text-danger">{{ $errors->first('txn') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.billTransaction.fields.txn_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.billTransaction.fields.category') }}</label>
                <select class="form-control {{ $errors->has('category') ? 'is-invalid' : '' }}" name="category" id="category">
                    <option value disabled {{ old('category', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\BillTransaction::CATEGORY_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('category', $billTransaction->category) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('category'))
                    <span class="text-danger">{{ $errors->first('category') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.billTransaction.fields.category_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="biller_name">{{ trans('cruds.billTransaction.fields.biller_name') }}</label>
                <input class="form-control {{ $errors->has('biller_name') ? 'is-invalid' : '' }}" type="text" name="biller_name" id="biller_name" value="{{ old('biller_name', $billTransaction->biller_name) }}" required>
                @if($errors->has('biller_name'))
                    <span class="text-danger">{{ $errors->first('biller_name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.billTransaction.fields.biller_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="consumer_number">{{ trans('cruds.billTransaction.fields.consumer_number') }}</label>
                <input class="form-control {{ $errors->has('consumer_number') ? 'is-invalid' : '' }}" type="text" name="consumer_number" id="consumer_number" value="{{ old('consumer_number', $billTransaction->consumer_number) }}" required>
                @if($errors->has('consumer_number'))
                    <span class="text-danger">{{ $errors->first('consumer_number') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.billTransaction.fields.consumer_number_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="amount">{{ trans('cruds.billTransaction.fields.amount') }}</label>
                <input class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" type="text" name="amount" id="amount" value="{{ old('amount', $billTransaction->amount) }}" required>
                @if($errors->has('amount'))
                    <span class="text-danger">{{ $errors->first('amount') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.billTransaction.fields.amount_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.billTransaction.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status">
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\BillTransaction::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', $billTransaction->status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <span class="text-danger">{{ $errors->first('status') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.billTransaction.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="bbps_ref">{{ trans('cruds.billTransaction.fields.bbps_ref') }}</label>
                <input class="form-control {{ $errors->has('bbps_ref') ? 'is-invalid' : '' }}" type="text" name="bbps_ref" id="bbps_ref" value="{{ old('bbps_ref', $billTransaction->bbps_ref) }}">
                @if($errors->has('bbps_ref'))
                    <span class="text-danger">{{ $errors->first('bbps_ref') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.billTransaction.fields.bbps_ref_helper') }}</span>
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
@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.busBooking.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.bus-bookings.update", [$busBooking->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="customer_id">{{ trans('cruds.busBooking.fields.customer') }}</label>
                <select class="form-control select2 {{ $errors->has('customer') ? 'is-invalid' : '' }}" name="customer_id" id="customer_id" required>
                    @foreach($customers as $id => $entry)
                        <option value="{{ $id }}" {{ (old('customer_id') ? old('customer_id') : $busBooking->customer->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('customer'))
                    <span class="text-danger">{{ $errors->first('customer') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.busBooking.fields.customer_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="booking">{{ trans('cruds.busBooking.fields.booking') }}</label>
                <input class="form-control {{ $errors->has('booking') ? 'is-invalid' : '' }}" type="text" name="booking" id="booking" value="{{ old('booking', $busBooking->booking) }}" required>
                @if($errors->has('booking'))
                    <span class="text-danger">{{ $errors->first('booking') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.busBooking.fields.booking_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="source">{{ trans('cruds.busBooking.fields.source') }}</label>
                <input class="form-control {{ $errors->has('source') ? 'is-invalid' : '' }}" type="text" name="source" id="source" value="{{ old('source', $busBooking->source) }}" required>
                @if($errors->has('source'))
                    <span class="text-danger">{{ $errors->first('source') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.busBooking.fields.source_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="destination">{{ trans('cruds.busBooking.fields.destination') }}</label>
                <input class="form-control {{ $errors->has('destination') ? 'is-invalid' : '' }}" type="text" name="destination" id="destination" value="{{ old('destination', $busBooking->destination) }}" required>
                @if($errors->has('destination'))
                    <span class="text-danger">{{ $errors->first('destination') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.busBooking.fields.destination_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="travel_date">{{ trans('cruds.busBooking.fields.travel_date') }}</label>
                <input class="form-control datetime {{ $errors->has('travel_date') ? 'is-invalid' : '' }}" type="text" name="travel_date" id="travel_date" value="{{ old('travel_date', $busBooking->travel_date) }}" required>
                @if($errors->has('travel_date'))
                    <span class="text-danger">{{ $errors->first('travel_date') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.busBooking.fields.travel_date_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="seats">{{ trans('cruds.busBooking.fields.seats') }}</label>
                <input class="form-control {{ $errors->has('seats') ? 'is-invalid' : '' }}" type="text" name="seats" id="seats" value="{{ old('seats', $busBooking->seats) }}" required>
                @if($errors->has('seats'))
                    <span class="text-danger">{{ $errors->first('seats') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.busBooking.fields.seats_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="passenger_details">{{ trans('cruds.busBooking.fields.passenger_details') }}</label>
                <input class="form-control {{ $errors->has('passenger_details') ? 'is-invalid' : '' }}" type="text" name="passenger_details" id="passenger_details" value="{{ old('passenger_details', $busBooking->passenger_details) }}">
                @if($errors->has('passenger_details'))
                    <span class="text-danger">{{ $errors->first('passenger_details') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.busBooking.fields.passenger_details_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="amount">{{ trans('cruds.busBooking.fields.amount') }}</label>
                <input class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" type="text" name="amount" id="amount" value="{{ old('amount', $busBooking->amount) }}" required>
                @if($errors->has('amount'))
                    <span class="text-danger">{{ $errors->first('amount') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.busBooking.fields.amount_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.busBooking.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status">
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\BusBooking::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', $busBooking->status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <span class="text-danger">{{ $errors->first('status') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.busBooking.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="api_ref">{{ trans('cruds.busBooking.fields.api_ref') }}</label>
                <input class="form-control {{ $errors->has('api_ref') ? 'is-invalid' : '' }}" type="text" name="api_ref" id="api_ref" value="{{ old('api_ref', $busBooking->api_ref) }}">
                @if($errors->has('api_ref'))
                    <span class="text-danger">{{ $errors->first('api_ref') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.busBooking.fields.api_ref_helper') }}</span>
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
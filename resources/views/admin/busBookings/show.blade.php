@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.busBooking.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.bus-bookings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.busBooking.fields.id') }}
                        </th>
                        <td>
                            {{ $busBooking->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.busBooking.fields.customer') }}
                        </th>
                        <td>
                            {{ $busBooking->customer->first_name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.busBooking.fields.booking') }}
                        </th>
                        <td>
                            {{ $busBooking->booking }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.busBooking.fields.source') }}
                        </th>
                        <td>
                            {{ $busBooking->source }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.busBooking.fields.destination') }}
                        </th>
                        <td>
                            {{ $busBooking->destination }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.busBooking.fields.travel_date') }}
                        </th>
                        <td>
                            {{ $busBooking->travel_date }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.busBooking.fields.seats') }}
                        </th>
                        <td>
                            {{ $busBooking->seats }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.busBooking.fields.passenger_details') }}
                        </th>
                        <td>
                            {{ $busBooking->passenger_details }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.busBooking.fields.amount') }}
                        </th>
                        <td>
                            {{ $busBooking->amount }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.busBooking.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\BusBooking::STATUS_SELECT[$busBooking->status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.busBooking.fields.api_ref') }}
                        </th>
                        <td>
                            {{ $busBooking->api_ref }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.bus-bookings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
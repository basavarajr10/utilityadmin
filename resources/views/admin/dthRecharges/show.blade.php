@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.dthRecharge.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.dth-recharges.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.dthRecharge.fields.id') }}
                        </th>
                        <td>
                            {{ $dthRecharge->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.dthRecharge.fields.customer') }}
                        </th>
                        <td>
                            {{ $dthRecharge->customer->first_name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.dthRecharge.fields.txn') }}
                        </th>
                        <td>
                            {{ $dthRecharge->txn }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.dthRecharge.fields.subscriber') }}
                        </th>
                        <td>
                            {{ $dthRecharge->subscriber }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.dthRecharge.fields.provider') }}
                        </th>
                        <td>
                            {{ $dthRecharge->provider }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.dthRecharge.fields.pack_name') }}
                        </th>
                        <td>
                            {{ $dthRecharge->pack_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.dthRecharge.fields.amount') }}
                        </th>
                        <td>
                            {{ $dthRecharge->amount }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.dthRecharge.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\DthRecharge::STATUS_SELECT[$dthRecharge->status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.dthRecharge.fields.api_ref') }}
                        </th>
                        <td>
                            {{ $dthRecharge->api_ref }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.dth-recharges.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
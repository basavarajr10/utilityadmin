@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.walletTopup.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.wallet-topups.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.walletTopup.fields.id') }}
                        </th>
                        <td>
                            {{ $walletTopup->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.walletTopup.fields.customer') }}
                        </th>
                        <td>
                            {{ $walletTopup->customer->first_name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.walletTopup.fields.txn') }}
                        </th>
                        <td>
                            {{ $walletTopup->txn }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.walletTopup.fields.amount') }}
                        </th>
                        <td>
                            {{ $walletTopup->amount }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.walletTopup.fields.method') }}
                        </th>
                        <td>
                            {{ App\Models\WalletTopup::METHOD_SELECT[$walletTopup->method] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.walletTopup.fields.gateway_ref') }}
                        </th>
                        <td>
                            {{ $walletTopup->gateway_ref }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.walletTopup.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\WalletTopup::STATUS_SELECT[$walletTopup->status] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.wallet-topups.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
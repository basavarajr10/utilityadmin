@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.billTransaction.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.bill-transactions.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.billTransaction.fields.id') }}
                        </th>
                        <td>
                            {{ $billTransaction->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.billTransaction.fields.customer') }}
                        </th>
                        <td>
                            {{ $billTransaction->customer->first_name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.billTransaction.fields.txn') }}
                        </th>
                        <td>
                            {{ $billTransaction->txn }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.billTransaction.fields.category') }}
                        </th>
                        <td>
                            {{ App\Models\BillTransaction::CATEGORY_SELECT[$billTransaction->category] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.billTransaction.fields.biller_name') }}
                        </th>
                        <td>
                            {{ $billTransaction->biller_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.billTransaction.fields.consumer_number') }}
                        </th>
                        <td>
                            {{ $billTransaction->consumer_number }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.billTransaction.fields.amount') }}
                        </th>
                        <td>
                            {{ $billTransaction->amount }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.billTransaction.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\BillTransaction::STATUS_SELECT[$billTransaction->status] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.billTransaction.fields.bbps_ref') }}
                        </th>
                        <td>
                            {{ $billTransaction->bbps_ref }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.bill-transactions.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
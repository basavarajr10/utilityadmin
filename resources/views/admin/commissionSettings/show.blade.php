@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.commissionSetting.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.commission-settings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.commissionSetting.fields.id') }}
                        </th>
                        <td>
                            {{ $commissionSetting->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.commissionSetting.fields.service_type') }}
                        </th>
                        <td>
                            {{ App\Models\CommissionSetting::SERVICE_TYPE_SELECT[$commissionSetting->service_type] ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.commissionSetting.fields.commission_pct') }}
                        </th>
                        <td>
                            {{ $commissionSetting->commission_pct }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.commissionSetting.fields.min_commission') }}
                        </th>
                        <td>
                            {{ $commissionSetting->min_commission }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.commissionSetting.fields.max_commission') }}
                        </th>
                        <td>
                            {{ $commissionSetting->max_commission }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.commissionSetting.fields.flat_charge') }}
                        </th>
                        <td>
                            {{ $commissionSetting->flat_charge }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.commissionSetting.fields.is_active') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $commissionSetting->is_active ? 'checked' : '' }}>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.commission-settings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
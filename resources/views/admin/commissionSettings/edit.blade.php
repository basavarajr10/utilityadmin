@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.commissionSetting.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.commission-settings.update", [$commissionSetting->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required">{{ trans('cruds.commissionSetting.fields.service_type') }}</label>
                <select class="form-control {{ $errors->has('service_type') ? 'is-invalid' : '' }}" name="service_type" id="service_type" required>
                    <option value disabled {{ old('service_type', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\CommissionSetting::SERVICE_TYPE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('service_type', $commissionSetting->service_type) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('service_type'))
                    <span class="text-danger">{{ $errors->first('service_type') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.commissionSetting.fields.service_type_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="commission_pct">{{ trans('cruds.commissionSetting.fields.commission_pct') }}</label>
                <input class="form-control {{ $errors->has('commission_pct') ? 'is-invalid' : '' }}" type="text" name="commission_pct" id="commission_pct" value="{{ old('commission_pct', $commissionSetting->commission_pct) }}" required>
                @if($errors->has('commission_pct'))
                    <span class="text-danger">{{ $errors->first('commission_pct') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.commissionSetting.fields.commission_pct_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="min_commission">{{ trans('cruds.commissionSetting.fields.min_commission') }}</label>
                <input class="form-control {{ $errors->has('min_commission') ? 'is-invalid' : '' }}" type="text" name="min_commission" id="min_commission" value="{{ old('min_commission', $commissionSetting->min_commission) }}" required>
                @if($errors->has('min_commission'))
                    <span class="text-danger">{{ $errors->first('min_commission') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.commissionSetting.fields.min_commission_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="max_commission">{{ trans('cruds.commissionSetting.fields.max_commission') }}</label>
                <input class="form-control {{ $errors->has('max_commission') ? 'is-invalid' : '' }}" type="text" name="max_commission" id="max_commission" value="{{ old('max_commission', $commissionSetting->max_commission) }}" required>
                @if($errors->has('max_commission'))
                    <span class="text-danger">{{ $errors->first('max_commission') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.commissionSetting.fields.max_commission_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="flat_charge">{{ trans('cruds.commissionSetting.fields.flat_charge') }}</label>
                <input class="form-control {{ $errors->has('flat_charge') ? 'is-invalid' : '' }}" type="text" name="flat_charge" id="flat_charge" value="{{ old('flat_charge', $commissionSetting->flat_charge) }}">
                @if($errors->has('flat_charge'))
                    <span class="text-danger">{{ $errors->first('flat_charge') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.commissionSetting.fields.flat_charge_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('is_active') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="is_active" value="0">
                    <input class="form-check-input" type="checkbox" name="is_active" id="is_active" value="1" {{ $commissionSetting->is_active || old('is_active', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_active">{{ trans('cruds.commissionSetting.fields.is_active') }}</label>
                </div>
                @if($errors->has('is_active'))
                    <span class="text-danger">{{ $errors->first('is_active') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.commissionSetting.fields.is_active_helper') }}</span>
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
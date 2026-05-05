@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.notification.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.notifications.update", [$notification->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="title">{{ trans('cruds.notification.fields.title') }}</label>
                <input class="form-control {{ $errors->has('title') ? 'is-invalid' : '' }}" type="text" name="title" id="title" value="{{ old('title', $notification->title) }}" required>
                @if($errors->has('title'))
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.notification.fields.title_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="message">{{ trans('cruds.notification.fields.message') }}</label>
                <input class="form-control {{ $errors->has('message') ? 'is-invalid' : '' }}" type="text" name="message" id="message" value="{{ old('message', $notification->message) }}" required>
                @if($errors->has('message'))
                    <span class="text-danger">{{ $errors->first('message') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.notification.fields.message_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required">{{ trans('cruds.notification.fields.channel') }}</label>
                <select class="form-control {{ $errors->has('channel') ? 'is-invalid' : '' }}" name="channel" id="channel" required>
                    <option value disabled {{ old('channel', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Notification::CHANNEL_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('channel', $notification->channel) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('channel'))
                    <span class="text-danger">{{ $errors->first('channel') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.notification.fields.channel_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.notification.fields.audience') }}</label>
                <select class="form-control {{ $errors->has('audience') ? 'is-invalid' : '' }}" name="audience" id="audience">
                    <option value disabled {{ old('audience', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Notification::AUDIENCE_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('audience', $notification->audience) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('audience'))
                    <span class="text-danger">{{ $errors->first('audience') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.notification.fields.audience_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="phone_number">{{ trans('cruds.notification.fields.phone_number') }}</label>
                <input class="form-control {{ $errors->has('phone_number') ? 'is-invalid' : '' }}" type="text" name="phone_number" id="phone_number" value="{{ old('phone_number', $notification->phone_number) }}">
                @if($errors->has('phone_number'))
                    <span class="text-danger">{{ $errors->first('phone_number') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.notification.fields.phone_number_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.notification.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status">
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\Notification::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', $notification->status) === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <span class="text-danger">{{ $errors->first('status') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.notification.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="sent_count">{{ trans('cruds.notification.fields.sent_count') }}</label>
                <input class="form-control {{ $errors->has('sent_count') ? 'is-invalid' : '' }}" type="text" name="sent_count" id="sent_count" value="{{ old('sent_count', $notification->sent_count) }}">
                @if($errors->has('sent_count'))
                    <span class="text-danger">{{ $errors->first('sent_count') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.notification.fields.sent_count_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="delivered_count">{{ trans('cruds.notification.fields.delivered_count') }}</label>
                <input class="form-control {{ $errors->has('delivered_count') ? 'is-invalid' : '' }}" type="text" name="delivered_count" id="delivered_count" value="{{ old('delivered_count', $notification->delivered_count) }}">
                @if($errors->has('delivered_count'))
                    <span class="text-danger">{{ $errors->first('delivered_count') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.notification.fields.delivered_count_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="sent_at">{{ trans('cruds.notification.fields.sent_at') }}</label>
                <input class="form-control datetime {{ $errors->has('sent_at') ? 'is-invalid' : '' }}" type="text" name="sent_at" id="sent_at" value="{{ old('sent_at', $notification->sent_at) }}">
                @if($errors->has('sent_at'))
                    <span class="text-danger">{{ $errors->first('sent_at') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.notification.fields.sent_at_helper') }}</span>
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
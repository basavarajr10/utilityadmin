@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.withdrawalRequest.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.withdrawal-requests.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="customer_id">{{ trans('cruds.withdrawalRequest.fields.customer') }}</label>
                <select class="form-control select2 {{ $errors->has('customer') ? 'is-invalid' : '' }}" name="customer_id" id="customer_id" required>
                    @foreach($customers as $id => $entry)
                        <option value="{{ $id }}" {{ old('customer_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('customer'))
                    <span class="text-danger">{{ $errors->first('customer') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.withdrawalRequest.fields.customer_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="amount">{{ trans('cruds.withdrawalRequest.fields.amount') }}</label>
                <input class="form-control {{ $errors->has('amount') ? 'is-invalid' : '' }}" type="text" name="amount" id="amount" value="{{ old('amount', '') }}" required>
                @if($errors->has('amount'))
                    <span class="text-danger">{{ $errors->first('amount') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.withdrawalRequest.fields.amount_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="bank_name">{{ trans('cruds.withdrawalRequest.fields.bank_name') }}</label>
                <input class="form-control {{ $errors->has('bank_name') ? 'is-invalid' : '' }}" type="text" name="bank_name" id="bank_name" value="{{ old('bank_name', '') }}">
                @if($errors->has('bank_name'))
                    <span class="text-danger">{{ $errors->first('bank_name') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.withdrawalRequest.fields.bank_name_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="account_number">{{ trans('cruds.withdrawalRequest.fields.account_number') }}</label>
                <input class="form-control {{ $errors->has('account_number') ? 'is-invalid' : '' }}" type="text" name="account_number" id="account_number" value="{{ old('account_number', '') }}">
                @if($errors->has('account_number'))
                    <span class="text-danger">{{ $errors->first('account_number') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.withdrawalRequest.fields.account_number_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="ifsc_code">{{ trans('cruds.withdrawalRequest.fields.ifsc_code') }}</label>
                <input class="form-control {{ $errors->has('ifsc_code') ? 'is-invalid' : '' }}" type="text" name="ifsc_code" id="ifsc_code" value="{{ old('ifsc_code', '') }}">
                @if($errors->has('ifsc_code'))
                    <span class="text-danger">{{ $errors->first('ifsc_code') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.withdrawalRequest.fields.ifsc_code_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="upi">{{ trans('cruds.withdrawalRequest.fields.upi') }}</label>
                <input class="form-control {{ $errors->has('upi') ? 'is-invalid' : '' }}" type="text" name="upi" id="upi" value="{{ old('upi', '') }}">
                @if($errors->has('upi'))
                    <span class="text-danger">{{ $errors->first('upi') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.withdrawalRequest.fields.upi_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.withdrawalRequest.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status">
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\WithdrawalRequest::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <span class="text-danger">{{ $errors->first('status') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.withdrawalRequest.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="admin_note">{{ trans('cruds.withdrawalRequest.fields.admin_note') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('admin_note') ? 'is-invalid' : '' }}" name="admin_note" id="admin_note">{!! old('admin_note') !!}</textarea>
                @if($errors->has('admin_note'))
                    <span class="text-danger">{{ $errors->first('admin_note') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.withdrawalRequest.fields.admin_note_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="processed_at">{{ trans('cruds.withdrawalRequest.fields.processed_at') }}</label>
                <input class="form-control datetime {{ $errors->has('processed_at') ? 'is-invalid' : '' }}" type="text" name="processed_at" id="processed_at" value="{{ old('processed_at') }}">
                @if($errors->has('processed_at'))
                    <span class="text-danger">{{ $errors->first('processed_at') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.withdrawalRequest.fields.processed_at_helper') }}</span>
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

@section('scripts')
<script>
    $(document).ready(function () {
  function SimpleUploadAdapter(editor) {
    editor.plugins.get('FileRepository').createUploadAdapter = function(loader) {
      return {
        upload: function() {
          return loader.file
            .then(function (file) {
              return new Promise(function(resolve, reject) {
                // Init request
                var xhr = new XMLHttpRequest();
                xhr.open('POST', '{{ route('admin.withdrawal-requests.storeCKEditorImages') }}', true);
                xhr.setRequestHeader('x-csrf-token', window._token);
                xhr.setRequestHeader('Accept', 'application/json');
                xhr.responseType = 'json';

                // Init listeners
                var genericErrorText = `Couldn't upload file: ${ file.name }.`;
                xhr.addEventListener('error', function() { reject(genericErrorText) });
                xhr.addEventListener('abort', function() { reject() });
                xhr.addEventListener('load', function() {
                  var response = xhr.response;

                  if (!response || xhr.status !== 201) {
                    return reject(response && response.message ? `${genericErrorText}\n${xhr.status} ${response.message}` : `${genericErrorText}\n ${xhr.status} ${xhr.statusText}`);
                  }

                  $('form').append('<input type="hidden" name="ck-media[]" value="' + response.id + '">');

                  resolve({ default: response.url });
                });

                if (xhr.upload) {
                  xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                      loader.uploadTotal = e.total;
                      loader.uploaded = e.loaded;
                    }
                  });
                }

                // Send request
                var data = new FormData();
                data.append('upload', file);
                data.append('crud_id', '{{ $withdrawalRequest->id ?? 0 }}');
                xhr.send(data);
              });
            })
        }
      };
    }
  }

  var allEditors = document.querySelectorAll('.ckeditor');
  for (var i = 0; i < allEditors.length; ++i) {
    ClassicEditor.create(
      allEditors[i], {
        extraPlugins: [SimpleUploadAdapter]
      }
    );
  }
});
</script>

@endsection
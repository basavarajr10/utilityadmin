@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.kycRequest.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.kyc-requests.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="customer_id">{{ trans('cruds.kycRequest.fields.customer') }}</label>
                <select class="form-control select2 {{ $errors->has('customer') ? 'is-invalid' : '' }}" name="customer_id" id="customer_id">
                    @foreach($customers as $id => $entry)
                        <option value="{{ $id }}" {{ old('customer_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('customer'))
                    <span class="text-danger">{{ $errors->first('customer') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.kycRequest.fields.customer_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="aadhaar_number">{{ trans('cruds.kycRequest.fields.aadhaar_number') }}</label>
                <input class="form-control {{ $errors->has('aadhaar_number') ? 'is-invalid' : '' }}" type="text" name="aadhaar_number" id="aadhaar_number" value="{{ old('aadhaar_number', '') }}">
                @if($errors->has('aadhaar_number'))
                    <span class="text-danger">{{ $errors->first('aadhaar_number') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.kycRequest.fields.aadhaar_number_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="pan_number">{{ trans('cruds.kycRequest.fields.pan_number') }}</label>
                <input class="form-control {{ $errors->has('pan_number') ? 'is-invalid' : '' }}" type="text" name="pan_number" id="pan_number" value="{{ old('pan_number', '') }}">
                @if($errors->has('pan_number'))
                    <span class="text-danger">{{ $errors->first('pan_number') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.kycRequest.fields.pan_number_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="selfie">{{ trans('cruds.kycRequest.fields.selfie') }}</label>
                <div class="needsclick dropzone {{ $errors->has('selfie') ? 'is-invalid' : '' }}" id="selfie-dropzone">
                </div>
                @if($errors->has('selfie'))
                    <span class="text-danger">{{ $errors->first('selfie') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.kycRequest.fields.selfie_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="aadhaar_doc">{{ trans('cruds.kycRequest.fields.aadhaar_doc') }}</label>
                <div class="needsclick dropzone {{ $errors->has('aadhaar_doc') ? 'is-invalid' : '' }}" id="aadhaar_doc-dropzone">
                </div>
                @if($errors->has('aadhaar_doc'))
                    <span class="text-danger">{{ $errors->first('aadhaar_doc') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.kycRequest.fields.aadhaar_doc_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="pan_doc">{{ trans('cruds.kycRequest.fields.pan_doc') }}</label>
                <div class="needsclick dropzone {{ $errors->has('pan_doc') ? 'is-invalid' : '' }}" id="pan_doc-dropzone">
                </div>
                @if($errors->has('pan_doc'))
                    <span class="text-danger">{{ $errors->first('pan_doc') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.kycRequest.fields.pan_doc_helper') }}</span>
            </div>
            <div class="form-group">
                <label>{{ trans('cruds.kycRequest.fields.status') }}</label>
                <select class="form-control {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status" id="status">
                    <option value disabled {{ old('status', null) === null ? 'selected' : '' }}>{{ trans('global.pleaseSelect') }}</option>
                    @foreach(App\Models\KycRequest::STATUS_SELECT as $key => $label)
                        <option value="{{ $key }}" {{ old('status', '') === (string) $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <span class="text-danger">{{ $errors->first('status') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.kycRequest.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="reviewer_note">{{ trans('cruds.kycRequest.fields.reviewer_note') }}</label>
                <textarea class="form-control ckeditor {{ $errors->has('reviewer_note') ? 'is-invalid' : '' }}" name="reviewer_note" id="reviewer_note">{!! old('reviewer_note') !!}</textarea>
                @if($errors->has('reviewer_note'))
                    <span class="text-danger">{{ $errors->first('reviewer_note') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.kycRequest.fields.reviewer_note_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="reviewed_at">{{ trans('cruds.kycRequest.fields.reviewed_at') }}</label>
                <input class="form-control datetime {{ $errors->has('reviewed_at') ? 'is-invalid' : '' }}" type="text" name="reviewed_at" id="reviewed_at" value="{{ old('reviewed_at') }}">
                @if($errors->has('reviewed_at'))
                    <span class="text-danger">{{ $errors->first('reviewed_at') }}</span>
                @endif
                <span class="help-block">{{ trans('cruds.kycRequest.fields.reviewed_at_helper') }}</span>
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
    Dropzone.options.selfieDropzone = {
    url: '{{ route('admin.kyc-requests.storeMedia') }}',
    maxFilesize: 10, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    maxFiles: 1,
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 10,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').find('input[name="selfie"]').remove()
      $('form').append('<input type="hidden" name="selfie" value="' + response.name + '">')
    },
    removedfile: function (file) {
      file.previewElement.remove()
      if (file.status !== 'error') {
        $('form').find('input[name="selfie"]').remove()
        this.options.maxFiles = this.options.maxFiles + 1
      }
    },
    init: function () {
@if(isset($kycRequest) && $kycRequest->selfie)
      var file = {!! json_encode($kycRequest->selfie) !!}
          this.options.addedfile.call(this, file)
      this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
      file.previewElement.classList.add('dz-complete')
      $('form').append('<input type="hidden" name="selfie" value="' + file.file_name + '">')
      this.options.maxFiles = this.options.maxFiles - 1
@endif
    },
    error: function (file, response) {
        if ($.type(response) === 'string') {
            var message = response //dropzone sends it's own error messages in string
        } else {
            var message = response.errors.file
        }
        file.previewElement.classList.add('dz-error')
        _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
        _results = []
        for (_i = 0, _len = _ref.length; _i < _len; _i++) {
            node = _ref[_i]
            _results.push(node.textContent = message)
        }

        return _results
    }
}

</script>
<script>
    var uploadedAadhaarDocMap = {}
Dropzone.options.aadhaarDocDropzone = {
    url: '{{ route('admin.kyc-requests.storeMedia') }}',
    maxFilesize: 10, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 10,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="aadhaar_doc[]" value="' + response.name + '">')
      uploadedAadhaarDocMap[file.name] = response.name
    },
    removedfile: function (file) {
      console.log(file)
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedAadhaarDocMap[file.name]
      }
      $('form').find('input[name="aadhaar_doc[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($kycRequest) && $kycRequest->aadhaar_doc)
      var files = {!! json_encode($kycRequest->aadhaar_doc) !!}
          for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
          file.previewElement.classList.add('dz-complete')
          $('form').append('<input type="hidden" name="aadhaar_doc[]" value="' + file.file_name + '">')
        }
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}

</script>
<script>
    var uploadedPanDocMap = {}
Dropzone.options.panDocDropzone = {
    url: '{{ route('admin.kyc-requests.storeMedia') }}',
    maxFilesize: 10, // MB
    acceptedFiles: '.jpeg,.jpg,.png,.gif',
    addRemoveLinks: true,
    headers: {
      'X-CSRF-TOKEN': "{{ csrf_token() }}"
    },
    params: {
      size: 10,
      width: 4096,
      height: 4096
    },
    success: function (file, response) {
      $('form').append('<input type="hidden" name="pan_doc[]" value="' + response.name + '">')
      uploadedPanDocMap[file.name] = response.name
    },
    removedfile: function (file) {
      console.log(file)
      file.previewElement.remove()
      var name = ''
      if (typeof file.file_name !== 'undefined') {
        name = file.file_name
      } else {
        name = uploadedPanDocMap[file.name]
      }
      $('form').find('input[name="pan_doc[]"][value="' + name + '"]').remove()
    },
    init: function () {
@if(isset($kycRequest) && $kycRequest->pan_doc)
      var files = {!! json_encode($kycRequest->pan_doc) !!}
          for (var i in files) {
          var file = files[i]
          this.options.addedfile.call(this, file)
          this.options.thumbnail.call(this, file, file.preview ?? file.preview_url)
          file.previewElement.classList.add('dz-complete')
          $('form').append('<input type="hidden" name="pan_doc[]" value="' + file.file_name + '">')
        }
@endif
    },
     error: function (file, response) {
         if ($.type(response) === 'string') {
             var message = response //dropzone sends it's own error messages in string
         } else {
             var message = response.errors.file
         }
         file.previewElement.classList.add('dz-error')
         _ref = file.previewElement.querySelectorAll('[data-dz-errormessage]')
         _results = []
         for (_i = 0, _len = _ref.length; _i < _len; _i++) {
             node = _ref[_i]
             _results.push(node.textContent = message)
         }

         return _results
     }
}

</script>
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
                xhr.open('POST', '{{ route('admin.kyc-requests.storeCKEditorImages') }}', true);
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
                data.append('crud_id', '{{ $kycRequest->id ?? 0 }}');
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
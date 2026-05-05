<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyKycRequestRequest;
use App\Http\Requests\StoreKycRequestRequest;
use App\Http\Requests\UpdateKycRequestRequest;
use App\Models\Customer;
use App\Models\KycRequest;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class KycRequestsController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('kyc_request_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = KycRequest::with(['customer'])->select(sprintf('%s.*', (new KycRequest)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'kyc_request_show';
                $editGate      = 'kyc_request_edit';
                $deleteGate    = 'kyc_request_delete';
                $crudRoutePart = 'kyc-requests';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->addColumn('customer_first_name', function ($row) {
                return $row->customer ? $row->customer->first_name : '';
            });

            $table->editColumn('aadhaar_number', function ($row) {
                return $row->aadhaar_number ? $row->aadhaar_number : '';
            });
            $table->editColumn('pan_number', function ($row) {
                return $row->pan_number ? $row->pan_number : '';
            });
            $table->editColumn('selfie', function ($row) {
                if ($photo = $row->selfie) {
                    return sprintf(
                        '<a href="%s" target="_blank"><img src="%s" width="50px" height="50px"></a>',
                        $photo->url,
                        $photo->thumbnail
                    );
                }

                return '';
            });
            $table->editColumn('aadhaar_doc', function ($row) {
                if (! $row->aadhaar_doc) {
                    return '';
                }
                $links = [];
                foreach ($row->aadhaar_doc as $media) {
                    $links[] = '<a href="' . $media->getUrl() . '" target="_blank"><img src="' . $media->getUrl('thumb') . '" width="50px" height="50px"></a>';
                }

                return implode(' ', $links);
            });
            $table->editColumn('pan_doc', function ($row) {
                if (! $row->pan_doc) {
                    return '';
                }
                $links = [];
                foreach ($row->pan_doc as $media) {
                    $links[] = '<a href="' . $media->getUrl() . '" target="_blank"><img src="' . $media->getUrl('thumb') . '" width="50px" height="50px"></a>';
                }

                return implode(' ', $links);
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? KycRequest::STATUS_SELECT[$row->status] : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'customer', 'selfie', 'aadhaar_doc', 'pan_doc']);

            return $table->make(true);
        }

        $customers = Customer::get();

        return view('admin.kycRequests.index', compact('customers'));
    }

    public function create()
    {
        abort_if(Gate::denies('kyc_request_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $customers = Customer::pluck('first_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.kycRequests.create', compact('customers'));
    }

    public function store(StoreKycRequestRequest $request)
    {
        $kycRequest = KycRequest::create($request->all());

        if ($request->input('selfie', false)) {
            $kycRequest->addMedia(storage_path('tmp/uploads/' . basename($request->input('selfie'))))->toMediaCollection('selfie');
        }

        foreach ($request->input('aadhaar_doc', []) as $file) {
            $kycRequest->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('aadhaar_doc');
        }

        foreach ($request->input('pan_doc', []) as $file) {
            $kycRequest->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('pan_doc');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $kycRequest->id]);
        }

        return redirect()->route('admin.kyc-requests.index');
    }

    public function edit(KycRequest $kycRequest)
    {
        abort_if(Gate::denies('kyc_request_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $customers = Customer::pluck('first_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $kycRequest->load('customer');

        return view('admin.kycRequests.edit', compact('customers', 'kycRequest'));
    }

    public function update(UpdateKycRequestRequest $request, KycRequest $kycRequest)
    {
        $kycRequest->update($request->all());

        if ($request->input('selfie', false)) {
            if (! $kycRequest->selfie || $request->input('selfie') !== $kycRequest->selfie->file_name) {
                if ($kycRequest->selfie) {
                    $kycRequest->selfie->delete();
                }
                $kycRequest->addMedia(storage_path('tmp/uploads/' . basename($request->input('selfie'))))->toMediaCollection('selfie');
            }
        } elseif ($kycRequest->selfie) {
            $kycRequest->selfie->delete();
        }

        if (count($kycRequest->aadhaar_doc) > 0) {
            foreach ($kycRequest->aadhaar_doc as $media) {
                if (! in_array($media->file_name, $request->input('aadhaar_doc', []))) {
                    $media->delete();
                }
            }
        }
        $media = $kycRequest->aadhaar_doc->pluck('file_name')->toArray();
        foreach ($request->input('aadhaar_doc', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $kycRequest->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('aadhaar_doc');
            }
        }

        if (count($kycRequest->pan_doc) > 0) {
            foreach ($kycRequest->pan_doc as $media) {
                if (! in_array($media->file_name, $request->input('pan_doc', []))) {
                    $media->delete();
                }
            }
        }
        $media = $kycRequest->pan_doc->pluck('file_name')->toArray();
        foreach ($request->input('pan_doc', []) as $file) {
            if (count($media) === 0 || ! in_array($file, $media)) {
                $kycRequest->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('pan_doc');
            }
        }

        return redirect()->route('admin.kyc-requests.index');
    }

    public function show(KycRequest $kycRequest)
    {
        abort_if(Gate::denies('kyc_request_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $kycRequest->load('customer');

        return view('admin.kycRequests.show', compact('kycRequest'));
    }

    public function destroy(KycRequest $kycRequest)
    {
        abort_if(Gate::denies('kyc_request_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $kycRequest->delete();

        return back();
    }

    public function massDestroy(MassDestroyKycRequestRequest $request)
    {
        $kycRequests = KycRequest::find(request('ids'));

        foreach ($kycRequests as $kycRequest) {
            $kycRequest->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('kyc_request_create') && Gate::denies('kyc_request_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new KycRequest();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}

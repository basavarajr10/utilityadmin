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
                if (! $row->aadhaar_doc || $row->aadhaar_doc->isEmpty()) {
                    return '';
                }
                $links = [];
                foreach ($row->aadhaar_doc as $media) {
                    $links[] = '<a href="' . $media->url . '" target="_blank"><img src="' . ($media->thumbnail ?? $media->url) . '" width="50px" height="50px"></a>';
                }

                return implode(' ', $links);
            });
            $table->editColumn('pan_doc', function ($row) {
                if (! $row->pan_doc || $row->pan_doc->isEmpty()) {
                    return '';
                }
                $links = [];
                foreach ($row->pan_doc as $media) {
                    $links[] = '<a href="' . $media->url . '" target="_blank"><img src="' . ($media->thumbnail ?? $media->url) . '" width="50px" height="50px"></a>';
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
            $media = $kycRequest->addMedia(storage_path('tmp/uploads/' . basename($request->input('selfie'))))->toMediaCollection('selfie');
            $kycRequest->updateQuietly(['selfie' => $media->file_name]);
        }

        $aadhaarFiles = $request->input('aadhaar_doc', []);
        foreach ($aadhaarFiles as $index => $file) {
            $media = $kycRequest->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('aadhaar_doc');
            $col = $index === 0 ? 'aadhaar_front' : 'aadhaar_back';
            $kycRequest->updateQuietly([$col => $media->file_name]);
        }

        $panFiles = $request->input('pan_doc', []);
        foreach ($panFiles as $file) {
            $media = $kycRequest->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('pan_doc');
            $kycRequest->updateQuietly(['pan_image' => $media->file_name]);
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

        // Auto-derive overall status from per-doc statuses
        $docStatuses = [
            $request->input('selfie_status', $kycRequest->selfie_status),
            $request->input('aadhaar_front_status', $kycRequest->aadhaar_front_status),
            $request->input('aadhaar_back_status', $kycRequest->aadhaar_back_status),
            $request->input('pan_image_status', $kycRequest->pan_image_status),
        ];
        if (in_array('rejected', $docStatuses)) {
            $derivedStatus = 'rejected';
        } elseif (count(array_filter($docStatuses, fn($s) => $s === 'approved')) === count($docStatuses)) {
            $derivedStatus = 'approved';
        } else {
            $derivedStatus = 'pending';
        }
        $kycRequest->updateQuietly([
            'status'      => $derivedStatus,
            'reviewed_at' => now()->format(config('panel.date_format') . ' ' . config('panel.time_format')),
        ]);

        if ($kycRequest->customer_id) {
            Customer::where('id', $kycRequest->customer_id)->update(['kyc_status' => $derivedStatus]);
        }

        $selfieMedia = $kycRequest->getMedia('selfie');
        if ($request->input('selfie', false)) {
            $currentFileName = $selfieMedia->last()?->file_name;
            if (! $currentFileName || $request->input('selfie') !== $currentFileName) {
                $tmpPath = storage_path('tmp/uploads/' . basename($request->input('selfie')));
                if (file_exists($tmpPath)) {
                    if ($selfieMedia->count()) {
                        $selfieMedia->last()->delete();
                    }
                    $media = $kycRequest->addMedia($tmpPath)->toMediaCollection('selfie');
                    $kycRequest->updateQuietly(['selfie' => $media->file_name]);
                }
            }
        } elseif ($selfieMedia->count()) {
            $selfieMedia->last()->delete();
            $kycRequest->updateQuietly(['selfie' => null]);
        }

        $existingAadhaar = $kycRequest->getMedia('aadhaar_doc');
        if ($existingAadhaar->count() > 0) {
            foreach ($existingAadhaar as $media) {
                if (! in_array($media->file_name, $request->input('aadhaar_doc', []))) {
                    $media->delete();
                }
            }
        }
        $existingAadhaarNames = $kycRequest->getMedia('aadhaar_doc')->pluck('file_name')->toArray();
        foreach ($request->input('aadhaar_doc', []) as $index => $file) {
            if (! in_array($file, $existingAadhaarNames)) {
                $tmpPath = storage_path('tmp/uploads/' . basename($file));
                if (file_exists($tmpPath)) {
                    $media = $kycRequest->addMedia($tmpPath)->toMediaCollection('aadhaar_doc');
                    $col = $index === 0 ? 'aadhaar_front' : 'aadhaar_back';
                    $kycRequest->updateQuietly([$col => $media->file_name]);
                }
            }
        }

        $existingPan = $kycRequest->getMedia('pan_doc');
        if ($existingPan->count() > 0) {
            foreach ($existingPan as $media) {
                if (! in_array($media->file_name, $request->input('pan_doc', []))) {
                    $media->delete();
                }
            }
        }
        $existingPanNames = $kycRequest->getMedia('pan_doc')->pluck('file_name')->toArray();
        foreach ($request->input('pan_doc', []) as $file) {
            if (! in_array($file, $existingPanNames)) {
                $tmpPath = storage_path('tmp/uploads/' . basename($file));
                if (file_exists($tmpPath)) {
                    $media = $kycRequest->addMedia($tmpPath)->toMediaCollection('pan_doc');
                    $kycRequest->updateQuietly(['pan_image' => $media->file_name]);
                }
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

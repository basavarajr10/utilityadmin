<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyCustomerRequest;
use App\Http\Requests\StoreCustomerRequest;
use App\Http\Requests\UpdateCustomerRequest;
use App\Models\Customer;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CustomersController extends Controller
{
    use MediaUploadingTrait;

    public function index(Request $request)
    {
        abort_if(Gate::denies('customer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = Customer::query()->select(sprintf('%s.*', (new Customer)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'customer_show';
                $editGate      = 'customer_edit';
                $deleteGate    = 'customer_delete';
                $crudRoutePart = 'customers';

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
            $table->editColumn('profile_photo', function ($row) {
                if ($photo = $row->profile_photo) {
                    return sprintf(
                        '<a href="%s" target="_blank"><img src="%s" width="50px" height="50px"></a>',
                        $photo->url,
                        $photo->thumbnail
                    );
                }

                return '';
            });
            $table->editColumn('first_name', function ($row) {
                return $row->first_name ? $row->first_name : '';
            });
            $table->editColumn('last_name', function ($row) {
                return $row->last_name ? $row->last_name : '';
            });
            $table->editColumn('mobile_number', function ($row) {
                return $row->mobile_number ? $row->mobile_number : '';
            });
            $table->editColumn('email', function ($row) {
                return $row->email ? $row->email : '';
            });
            $table->editColumn('wallet_balance', function ($row) {
                return $row->wallet_balance ? $row->wallet_balance : '';
            });
            $table->editColumn('kyc_status', function ($row) {
                return $row->kyc_status ? Customer::KYC_STATUS_SELECT[$row->kyc_status] : '';
            });
            $table->editColumn('is_active', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->is_active ? 'checked' : null) . '>';
            });
            $table->editColumn('referral_code', function ($row) {
                return $row->referral_code ? $row->referral_code : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'profile_photo', 'is_active']);

            return $table->make(true);
        }

        return view('admin.customers.index');
    }

    public function create()
    {
        abort_if(Gate::denies('customer_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.customers.create');
    }

    public function store(StoreCustomerRequest $request)
    {
        $data = $request->all();
        if (empty($data['referral_code'])) {
            $chars = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
            $last4 = substr(preg_replace('/\D/', '', $data['mobile_number'] ?? '0000'), -4);
            do {
                $random = '';
                for ($i = 0; $i < 4; $i++) $random .= $chars[random_int(0, strlen($chars) - 1)];
                $data['referral_code'] = 'UTL' . $last4 . $random;
            } while (Customer::where('referral_code', $data['referral_code'])->exists());
        }

        $customer = Customer::create($data);

        if ($request->input('profile_photo', false)) {
            $media = $customer->addMedia(storage_path('tmp/uploads/' . basename($request->input('profile_photo'))))->toMediaCollection('profile_photo');
            $customer->updateQuietly(['profile_photo' => $media->file_name]);
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $customer->id]);
        }

        return redirect()->route('admin.customers.index');
    }

    public function edit(Customer $customer)
    {
        abort_if(Gate::denies('customer_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.customers.edit', compact('customer'));
    }

    public function update(UpdateCustomerRequest $request, Customer $customer)
    {
        $data = $request->except('referral_code');
        $customer->update($data);

        if ($request->input('profile_photo', false)) {
            if (! $customer->profile_photo || $request->input('profile_photo') !== $customer->profile_photo->file_name) {
                if ($customer->getMedia('profile_photo')->count()) {
                    $customer->profile_photo->delete();
                }
                $media = $customer->addMedia(storage_path('tmp/uploads/' . basename($request->input('profile_photo'))))->toMediaCollection('profile_photo');
                $customer->updateQuietly(['profile_photo' => $media->file_name]);
            }
        } elseif ($customer->getMedia('profile_photo')->count()) {
            $customer->profile_photo->delete();
            $customer->updateQuietly(['profile_photo' => null]);
        }

        return redirect()->route('admin.customers.index');
    }

    public function show(Customer $customer)
    {
        abort_if(Gate::denies('customer_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $customer->load('customerKycRequests', 'customerMobileRecharges', 'customerDthRecharges', 'customerBillTransactions', 'customerBusBookings', 'customerWalletTopups', 'customerWithdrawalRequests', 'customerTransactions');

        return view('admin.customers.show', compact('customer'));
    }

    public function destroy(Customer $customer)
    {
        abort_if(Gate::denies('customer_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $customer->delete();

        return back();
    }

    public function massDestroy(MassDestroyCustomerRequest $request)
    {
        $customers = Customer::find(request('ids'));

        foreach ($customers as $customer) {
            $customer->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('customer_create') && Gate::denies('customer_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Customer();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}

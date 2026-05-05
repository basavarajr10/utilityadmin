<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyMobileRechargeRequest;
use App\Http\Requests\StoreMobileRechargeRequest;
use App\Http\Requests\UpdateMobileRechargeRequest;
use App\Models\Customer;
use App\Models\MobileRecharge;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class MobileRechargesController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('mobile_recharge_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = MobileRecharge::with(['customer'])->select(sprintf('%s.*', (new MobileRecharge)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'mobile_recharge_show';
                $editGate      = 'mobile_recharge_edit';
                $deleteGate    = 'mobile_recharge_delete';
                $crudRoutePart = 'mobile-recharges';

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

            $table->editColumn('txn', function ($row) {
                return $row->txn ? $row->txn : '';
            });
            $table->editColumn('mobile_number', function ($row) {
                return $row->mobile_number ? $row->mobile_number : '';
            });
            $table->editColumn('operator', function ($row) {
                return $row->operator ? $row->operator : '';
            });
            $table->editColumn('circle', function ($row) {
                return $row->circle ? $row->circle : '';
            });
            $table->editColumn('plan_name', function ($row) {
                return $row->plan_name ? $row->plan_name : '';
            });
            $table->editColumn('amount', function ($row) {
                return $row->amount ? $row->amount : '';
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? MobileRecharge::STATUS_SELECT[$row->status] : '';
            });
            $table->editColumn('api_ref', function ($row) {
                return $row->api_ref ? $row->api_ref : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'customer']);

            return $table->make(true);
        }

        $customers = Customer::get();

        return view('admin.mobileRecharges.index', compact('customers'));
    }

    public function create()
    {
        abort_if(Gate::denies('mobile_recharge_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $customers = Customer::pluck('first_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.mobileRecharges.create', compact('customers'));
    }

    public function store(StoreMobileRechargeRequest $request)
    {
        $mobileRecharge = MobileRecharge::create($request->all());

        return redirect()->route('admin.mobile-recharges.index');
    }

    public function edit(MobileRecharge $mobileRecharge)
    {
        abort_if(Gate::denies('mobile_recharge_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $customers = Customer::pluck('first_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $mobileRecharge->load('customer');

        return view('admin.mobileRecharges.edit', compact('customers', 'mobileRecharge'));
    }

    public function update(UpdateMobileRechargeRequest $request, MobileRecharge $mobileRecharge)
    {
        $mobileRecharge->update($request->all());

        return redirect()->route('admin.mobile-recharges.index');
    }

    public function show(MobileRecharge $mobileRecharge)
    {
        abort_if(Gate::denies('mobile_recharge_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $mobileRecharge->load('customer');

        return view('admin.mobileRecharges.show', compact('mobileRecharge'));
    }

    public function destroy(MobileRecharge $mobileRecharge)
    {
        abort_if(Gate::denies('mobile_recharge_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $mobileRecharge->delete();

        return back();
    }

    public function massDestroy(MassDestroyMobileRechargeRequest $request)
    {
        $mobileRecharges = MobileRecharge::find(request('ids'));

        foreach ($mobileRecharges as $mobileRecharge) {
            $mobileRecharge->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

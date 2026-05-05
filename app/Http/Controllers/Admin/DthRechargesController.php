<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyDthRechargeRequest;
use App\Http\Requests\StoreDthRechargeRequest;
use App\Http\Requests\UpdateDthRechargeRequest;
use App\Models\Customer;
use App\Models\DthRecharge;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class DthRechargesController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('dth_recharge_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = DthRecharge::with(['customer'])->select(sprintf('%s.*', (new DthRecharge)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'dth_recharge_show';
                $editGate      = 'dth_recharge_edit';
                $deleteGate    = 'dth_recharge_delete';
                $crudRoutePart = 'dth-recharges';

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
            $table->editColumn('subscriber', function ($row) {
                return $row->subscriber ? $row->subscriber : '';
            });
            $table->editColumn('provider', function ($row) {
                return $row->provider ? $row->provider : '';
            });
            $table->editColumn('pack_name', function ($row) {
                return $row->pack_name ? $row->pack_name : '';
            });
            $table->editColumn('amount', function ($row) {
                return $row->amount ? $row->amount : '';
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? DthRecharge::STATUS_SELECT[$row->status] : '';
            });
            $table->editColumn('api_ref', function ($row) {
                return $row->api_ref ? $row->api_ref : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'customer']);

            return $table->make(true);
        }

        $customers = Customer::get();

        return view('admin.dthRecharges.index', compact('customers'));
    }

    public function create()
    {
        abort_if(Gate::denies('dth_recharge_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $customers = Customer::pluck('first_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.dthRecharges.create', compact('customers'));
    }

    public function store(StoreDthRechargeRequest $request)
    {
        $dthRecharge = DthRecharge::create($request->all());

        return redirect()->route('admin.dth-recharges.index');
    }

    public function edit(DthRecharge $dthRecharge)
    {
        abort_if(Gate::denies('dth_recharge_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $customers = Customer::pluck('first_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $dthRecharge->load('customer');

        return view('admin.dthRecharges.edit', compact('customers', 'dthRecharge'));
    }

    public function update(UpdateDthRechargeRequest $request, DthRecharge $dthRecharge)
    {
        $dthRecharge->update($request->all());

        return redirect()->route('admin.dth-recharges.index');
    }

    public function show(DthRecharge $dthRecharge)
    {
        abort_if(Gate::denies('dth_recharge_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dthRecharge->load('customer');

        return view('admin.dthRecharges.show', compact('dthRecharge'));
    }

    public function destroy(DthRecharge $dthRecharge)
    {
        abort_if(Gate::denies('dth_recharge_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $dthRecharge->delete();

        return back();
    }

    public function massDestroy(MassDestroyDthRechargeRequest $request)
    {
        $dthRecharges = DthRecharge::find(request('ids'));

        foreach ($dthRecharges as $dthRecharge) {
            $dthRecharge->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

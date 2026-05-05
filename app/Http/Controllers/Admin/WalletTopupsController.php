<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyWalletTopupRequest;
use App\Http\Requests\StoreWalletTopupRequest;
use App\Http\Requests\UpdateWalletTopupRequest;
use App\Models\Customer;
use App\Models\WalletTopup;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class WalletTopupsController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('wallet_topup_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = WalletTopup::with(['customer'])->select(sprintf('%s.*', (new WalletTopup)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'wallet_topup_show';
                $editGate      = 'wallet_topup_edit';
                $deleteGate    = 'wallet_topup_delete';
                $crudRoutePart = 'wallet-topups';

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
            $table->editColumn('amount', function ($row) {
                return $row->amount ? $row->amount : '';
            });
            $table->editColumn('method', function ($row) {
                return $row->method ? WalletTopup::METHOD_SELECT[$row->method] : '';
            });
            $table->editColumn('gateway_ref', function ($row) {
                return $row->gateway_ref ? $row->gateway_ref : '';
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? WalletTopup::STATUS_SELECT[$row->status] : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'customer']);

            return $table->make(true);
        }

        $customers = Customer::get();

        return view('admin.walletTopups.index', compact('customers'));
    }

    public function create()
    {
        abort_if(Gate::denies('wallet_topup_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $customers = Customer::pluck('first_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.walletTopups.create', compact('customers'));
    }

    public function store(StoreWalletTopupRequest $request)
    {
        $walletTopup = WalletTopup::create($request->all());

        return redirect()->route('admin.wallet-topups.index');
    }

    public function edit(WalletTopup $walletTopup)
    {
        abort_if(Gate::denies('wallet_topup_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $customers = Customer::pluck('first_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $walletTopup->load('customer');

        return view('admin.walletTopups.edit', compact('customers', 'walletTopup'));
    }

    public function update(UpdateWalletTopupRequest $request, WalletTopup $walletTopup)
    {
        $walletTopup->update($request->all());

        return redirect()->route('admin.wallet-topups.index');
    }

    public function show(WalletTopup $walletTopup)
    {
        abort_if(Gate::denies('wallet_topup_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $walletTopup->load('customer');

        return view('admin.walletTopups.show', compact('walletTopup'));
    }

    public function destroy(WalletTopup $walletTopup)
    {
        abort_if(Gate::denies('wallet_topup_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $walletTopup->delete();

        return back();
    }

    public function massDestroy(MassDestroyWalletTopupRequest $request)
    {
        $walletTopups = WalletTopup::find(request('ids'));

        foreach ($walletTopups as $walletTopup) {
            $walletTopup->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

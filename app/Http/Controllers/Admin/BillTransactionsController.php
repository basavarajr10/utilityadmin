<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyBillTransactionRequest;
use App\Http\Requests\StoreBillTransactionRequest;
use App\Http\Requests\UpdateBillTransactionRequest;
use App\Models\BillTransaction;
use App\Models\Customer;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class BillTransactionsController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('bill_transaction_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = BillTransaction::with(['customer'])->select(sprintf('%s.*', (new BillTransaction)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'bill_transaction_show';
                $editGate      = 'bill_transaction_edit';
                $deleteGate    = 'bill_transaction_delete';
                $crudRoutePart = 'bill-transactions';

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
            $table->editColumn('category', function ($row) {
                return $row->category ? BillTransaction::CATEGORY_SELECT[$row->category] : '';
            });
            $table->editColumn('biller_name', function ($row) {
                return $row->biller_name ? $row->biller_name : '';
            });
            $table->editColumn('consumer_number', function ($row) {
                return $row->consumer_number ? $row->consumer_number : '';
            });
            $table->editColumn('amount', function ($row) {
                return $row->amount ? $row->amount : '';
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? BillTransaction::STATUS_SELECT[$row->status] : '';
            });
            $table->editColumn('bbps_ref', function ($row) {
                return $row->bbps_ref ? $row->bbps_ref : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'customer']);

            return $table->make(true);
        }

        $customers = Customer::get();

        return view('admin.billTransactions.index', compact('customers'));
    }

    public function create()
    {
        abort_if(Gate::denies('bill_transaction_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $customers = Customer::pluck('first_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.billTransactions.create', compact('customers'));
    }

    public function store(StoreBillTransactionRequest $request)
    {
        $billTransaction = BillTransaction::create($request->all());

        return redirect()->route('admin.bill-transactions.index');
    }

    public function edit(BillTransaction $billTransaction)
    {
        abort_if(Gate::denies('bill_transaction_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $customers = Customer::pluck('first_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $billTransaction->load('customer');

        return view('admin.billTransactions.edit', compact('billTransaction', 'customers'));
    }

    public function update(UpdateBillTransactionRequest $request, BillTransaction $billTransaction)
    {
        $billTransaction->update($request->all());

        return redirect()->route('admin.bill-transactions.index');
    }

    public function show(BillTransaction $billTransaction)
    {
        abort_if(Gate::denies('bill_transaction_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $billTransaction->load('customer');

        return view('admin.billTransactions.show', compact('billTransaction'));
    }

    public function destroy(BillTransaction $billTransaction)
    {
        abort_if(Gate::denies('bill_transaction_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $billTransaction->delete();

        return back();
    }

    public function massDestroy(MassDestroyBillTransactionRequest $request)
    {
        $billTransactions = BillTransaction::find(request('ids'));

        foreach ($billTransactions as $billTransaction) {
            $billTransaction->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

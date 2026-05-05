<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyBusBookingRequest;
use App\Http\Requests\StoreBusBookingRequest;
use App\Http\Requests\UpdateBusBookingRequest;
use App\Models\BusBooking;
use App\Models\Customer;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class BusBookingsController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('bus_booking_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = BusBooking::with(['customer'])->select(sprintf('%s.*', (new BusBooking)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'bus_booking_show';
                $editGate      = 'bus_booking_edit';
                $deleteGate    = 'bus_booking_delete';
                $crudRoutePart = 'bus-bookings';

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

            $table->editColumn('booking', function ($row) {
                return $row->booking ? $row->booking : '';
            });
            $table->editColumn('source', function ($row) {
                return $row->source ? $row->source : '';
            });
            $table->editColumn('destination', function ($row) {
                return $row->destination ? $row->destination : '';
            });

            $table->editColumn('seats', function ($row) {
                return $row->seats ? $row->seats : '';
            });
            $table->editColumn('passenger_details', function ($row) {
                return $row->passenger_details ? $row->passenger_details : '';
            });
            $table->editColumn('amount', function ($row) {
                return $row->amount ? $row->amount : '';
            });
            $table->editColumn('status', function ($row) {
                return $row->status ? BusBooking::STATUS_SELECT[$row->status] : '';
            });
            $table->editColumn('api_ref', function ($row) {
                return $row->api_ref ? $row->api_ref : '';
            });

            $table->rawColumns(['actions', 'placeholder', 'customer']);

            return $table->make(true);
        }

        $customers = Customer::get();

        return view('admin.busBookings.index', compact('customers'));
    }

    public function create()
    {
        abort_if(Gate::denies('bus_booking_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $customers = Customer::pluck('first_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.busBookings.create', compact('customers'));
    }

    public function store(StoreBusBookingRequest $request)
    {
        $busBooking = BusBooking::create($request->all());

        return redirect()->route('admin.bus-bookings.index');
    }

    public function edit(BusBooking $busBooking)
    {
        abort_if(Gate::denies('bus_booking_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $customers = Customer::pluck('first_name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $busBooking->load('customer');

        return view('admin.busBookings.edit', compact('busBooking', 'customers'));
    }

    public function update(UpdateBusBookingRequest $request, BusBooking $busBooking)
    {
        $busBooking->update($request->all());

        return redirect()->route('admin.bus-bookings.index');
    }

    public function show(BusBooking $busBooking)
    {
        abort_if(Gate::denies('bus_booking_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $busBooking->load('customer');

        return view('admin.busBookings.show', compact('busBooking'));
    }

    public function destroy(BusBooking $busBooking)
    {
        abort_if(Gate::denies('bus_booking_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $busBooking->delete();

        return back();
    }

    public function massDestroy(MassDestroyBusBookingRequest $request)
    {
        $busBookings = BusBooking::find(request('ids'));

        foreach ($busBookings as $busBooking) {
            $busBooking->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCommissionSettingRequest;
use App\Http\Requests\StoreCommissionSettingRequest;
use App\Http\Requests\UpdateCommissionSettingRequest;
use App\Models\CommissionSetting;
use App\Models\Transaction;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Yajra\DataTables\Facades\DataTables;

class CommissionSettingsController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('commission_setting_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        if ($request->ajax()) {
            $query = CommissionSetting::query()->select(sprintf('%s.*', (new CommissionSetting)->table));
            $table = Datatables::of($query);

            $table->addColumn('placeholder', '&nbsp;');
            $table->addColumn('actions', '&nbsp;');

            $table->editColumn('actions', function ($row) {
                $viewGate      = 'commission_setting_show';
                $editGate      = 'commission_setting_edit';
                $deleteGate    = 'commission_setting_delete';
                $crudRoutePart = 'commission-settings';

                return view('partials.datatablesActions', compact(
                    'viewGate',
                    'editGate',
                    'deleteGate',
                    'crudRoutePart',
                    'row'
                ));
            });

            $table->editColumn('id', fn ($row) => $row->id ?? '');
            $table->editColumn('service_type', fn ($row) => $row->service_type ? CommissionSetting::SERVICE_TYPE_SELECT[$row->service_type] : '');
            $table->editColumn('commission_pct', fn ($row) => $row->commission_pct ?? '');
            $table->editColumn('min_commission', fn ($row) => $row->min_commission ?? '');
            $table->editColumn('max_commission', fn ($row) => $row->max_commission ?? '');
            $table->editColumn('flat_charge', fn ($row) => $row->flat_charge ?? '');
            $table->editColumn('is_active', fn ($row) => '<input type="checkbox" disabled ' . ($row->is_active ? 'checked' : '') . '>');

            $table->rawColumns(['actions', 'placeholder', 'is_active']);

            return $table->make(true);
        }

        $commissions = CommissionSetting::all()->keyBy('service_type');
        $todayCommission = Transaction::whereDate('created_at', today())->sum('commission_earned');

        return view('admin.commissionSettings.index', compact('commissions', 'todayCommission'));
    }

    public function create()
    {
        abort_if(Gate::denies('commission_setting_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.commissionSettings.create');
    }

    public function store(StoreCommissionSettingRequest $request)
    {
        CommissionSetting::create($request->all());

        return redirect()->route('admin.commission-settings.index');
    }

    public function edit(CommissionSetting $commissionSetting)
    {
        abort_if(Gate::denies('commission_setting_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.commissionSettings.edit', compact('commissionSetting'));
    }

    public function update(UpdateCommissionSettingRequest $request, CommissionSetting $commissionSetting)
    {
        $commissionSetting->update($request->all());

        return redirect()->route('admin.commission-settings.index');
    }

    public function show(CommissionSetting $commissionSetting)
    {
        abort_if(Gate::denies('commission_setting_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.commissionSettings.show', compact('commissionSetting'));
    }

    public function destroy(CommissionSetting $commissionSetting)
    {
        abort_if(Gate::denies('commission_setting_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $commissionSetting->delete();

        return back();
    }

    public function massDestroy(MassDestroyCommissionSettingRequest $request)
    {
        CommissionSetting::find(request('ids'))->each->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function bulkUpdate(Request $request)
    {
        abort_if(Gate::denies('commission_setting_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        CommissionSetting::updateOrCreate(
            ['service_type' => $request->service_type],
            $request->only(['commission_pct', 'min_commission', 'max_commission', 'flat_charge', 'is_active'])
        );

        return redirect()->back()->with('success', 'Commission saved.');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCommissionSettingRequest;
use App\Http\Requests\StoreCommissionSettingRequest;
use App\Http\Requests\UpdateCommissionSettingRequest;
use App\Models\CommissionSetting;
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

            $table->editColumn('id', function ($row) {
                return $row->id ? $row->id : '';
            });
            $table->editColumn('service_type', function ($row) {
                return $row->service_type ? CommissionSetting::SERVICE_TYPE_SELECT[$row->service_type] : '';
            });
            $table->editColumn('commission_pct', function ($row) {
                return $row->commission_pct ? $row->commission_pct : '';
            });
            $table->editColumn('min_commission', function ($row) {
                return $row->min_commission ? $row->min_commission : '';
            });
            $table->editColumn('max_commission', function ($row) {
                return $row->max_commission ? $row->max_commission : '';
            });
            $table->editColumn('flat_charge', function ($row) {
                return $row->flat_charge ? $row->flat_charge : '';
            });
            $table->editColumn('is_active', function ($row) {
                return '<input type="checkbox" disabled ' . ($row->is_active ? 'checked' : null) . '>';
            });

            $table->rawColumns(['actions', 'placeholder', 'is_active']);

            return $table->make(true);
        }

        return view('admin.commissionSettings.index');
    }

    public function create()
    {
        abort_if(Gate::denies('commission_setting_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.commissionSettings.create');
    }

    public function store(StoreCommissionSettingRequest $request)
    {
        $commissionSetting = CommissionSetting::create($request->all());

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
        $commissionSettings = CommissionSetting::find(request('ids'));

        foreach ($commissionSettings as $commissionSetting) {
            $commissionSetting->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

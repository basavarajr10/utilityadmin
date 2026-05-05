<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyAppSettingRequest;
use App\Http\Requests\StoreAppSettingRequest;
use App\Http\Requests\UpdateAppSettingRequest;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AppSettingsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('app_setting_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.appSettings.index');
    }

    public function create()
    {
        abort_if(Gate::denies('app_setting_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.appSettings.create');
    }

    public function store(StoreAppSettingRequest $request)
    {
        $appSetting = AppSetting::create($request->all());

        return redirect()->route('admin.app-settings.index');
    }

    public function edit(AppSetting $appSetting)
    {
        abort_if(Gate::denies('app_setting_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.appSettings.edit', compact('appSetting'));
    }

    public function update(UpdateAppSettingRequest $request, AppSetting $appSetting)
    {
        $appSetting->update($request->all());

        return redirect()->route('admin.app-settings.index');
    }

    public function show(AppSetting $appSetting)
    {
        abort_if(Gate::denies('app_setting_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.appSettings.show', compact('appSetting'));
    }

    public function destroy(AppSetting $appSetting)
    {
        abort_if(Gate::denies('app_setting_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $appSetting->delete();

        return back();
    }

    public function massDestroy(MassDestroyAppSettingRequest $request)
    {
        $appSettings = AppSetting::find(request('ids'));

        foreach ($appSettings as $appSetting) {
            $appSetting->delete();
        }

        return response(null, Response::HTTP_NO_CONTENT);
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AppSetting;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AppSettingsController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('app_setting_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $settings = AppSetting::all()->groupBy('group');

        return view('admin.appSettings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        abort_if(Gate::denies('app_setting_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        foreach ($request->input('settings', []) as $key => $value) {
            AppSetting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
        }

        return redirect()->back()->with('success', 'Settings saved successfully.');
    }
}

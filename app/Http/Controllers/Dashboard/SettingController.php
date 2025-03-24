<?php

namespace App\Http\Controllers\Dashboard;

use Inertia\Inertia;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Session;

class SettingController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('setting_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $setting = Setting::active()->first();
        $logs    = ActivityLog::with(['user'])->latest('id')->paginate(10);

        return Inertia::render("Admin/Setting/Index", [
            'setting' => $setting,
            'logs'    => $logs,
        ]);
    }

    public function update(Request $request)
    {
        $request->validate([
            'exchange_rate' => 'required',
            'tax'           => 'required',
        ]);

        $setting = Setting::active()->first();

        $oldValue = clone $setting;

        $setting->update([
            'exchange_rate' => $request->exchange_rate,
            'tax'           => $request->tax,
        ]);


        $descriptions = [];

        if ($oldValue->exchange_rate != $setting->exchange_rate) {
            $descriptions[] = "Exchange rate was changes from $oldValue->exchange_rate to $setting->exchange_rate";
        }

        if ($oldValue->tax != $setting->tax) {
            $descriptions[] = "Tax was changes from $oldValue->tax to $setting->tax";
        }

        $data = [];

        foreach ($descriptions as $value) {
            $data[] = [
                'log_name'    => 'Setting',
                'description' => $value,
                'causer_id'   => auth()->user()->id,
                'created_at'  => now(),
            ];
        }

        ActivityLog::insert($data);

        return to_route('admin.settings.index');
    }

    function updateDeliveryStatus(Request $request)
    {
        $setting = Setting::active()->first();
        $setting->update([
            'delivery_fee_status' => $request->status,
        ]);
    }
}

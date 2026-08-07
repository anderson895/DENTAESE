<?php

namespace App\Http\Controllers;

use App\Models\SmsLog;
use Illuminate\Http\Request;

class SmsLogController extends Controller
{
    public function index(Request $request)
    {
        $logs = SmsLog::query()
            ->when($request->status, fn ($q, $status) => $q->where('status', $status))
            ->when($request->purpose, fn ($q, $purpose) => $q->where('purpose', $purpose))
            ->latest()
            ->paginate(25)
            ->withQueryString();

        $counts = SmsLog::selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $purposes = SmsLog::distinct()->whereNotNull('purpose')->pluck('purpose');

        return view('admin.sms-logs', [
            'logs'       => $logs,
            'counts'     => $counts,
            'purposes'   => $purposes,
            'senderName' => config('services.semaphore.sender_name'),
            'enabled'    => (bool) config('services.sms.enabled'),
        ]);
    }
}

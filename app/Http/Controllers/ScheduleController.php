<?php

namespace App\Http\Controllers;

use App\Models\DoctorSchedule;
use App\Models\Store;
use App\Models\StoreScheduleOverride;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    /**
     * Calendar UI page (admin) for clinic open days + doctor schedules.
     */
    public function index(Request $request)
    {
        $stores   = Store::orderBy('name')->get();
        $dentists = User::where('position', 'Dentist')->orderBy('lastname')->get();

        return view('admin.schedule.calendar', [
            'stores'   => $stores,
            'dentists' => $dentists,
        ]);
    }

    /**
     * Return all schedule data for a given month.
     */
    public function events(Request $request)
    {
        $request->validate([
            'store_id'   => 'nullable|exists:stores,id',
            'dentist_id' => 'nullable|exists:users,id',
            'year'       => 'required|integer|min:2000|max:2100',
            'month'      => 'required|integer|min:1|max:12',
        ]);

        $start = Carbon::create($request->year, $request->month, 1)->startOfMonth();
        $end   = (clone $start)->endOfMonth();

        $clinicOverrides = StoreScheduleOverride::query()
            ->when($request->store_id, fn($q) => $q->where('store_id', $request->store_id))
            ->whereBetween('schedule_date', [$start->toDateString(), $end->toDateString()])
            ->get();

        $doctorSchedules = DoctorSchedule::query()
            ->when($request->store_id,   fn($q) => $q->where('store_id', $request->store_id))
            ->when($request->dentist_id, fn($q) => $q->where('dentist_id', $request->dentist_id))
            ->whereBetween('schedule_date', [$start->toDateString(), $end->toDateString()])
            ->with('dentist:id,name,lastname')
            ->get();

        // Default weekly open_days for chosen store (used as baseline visualization)
        $store = $request->store_id ? Store::find($request->store_id) : null;

        return response()->json([
            'store' => $store ? [
                'id'           => $store->id,
                'name'         => $store->name,
                'open_days'    => $store->open_days ?? [],
                'opening_time' => optional($store->opening_time)->format('H:i'),
                'closing_time' => optional($store->closing_time)->format('H:i'),
            ] : null,
            'clinic_overrides' => $clinicOverrides->map(fn($o) => [
                'id'            => $o->id,
                'store_id'      => $o->store_id,
                'schedule_date' => $o->schedule_date->toDateString(),
                'is_open'       => (bool) $o->is_open,
                'opening_time'  => optional($o->opening_time)->format('H:i'),
                'closing_time'  => optional($o->closing_time)->format('H:i'),
                'reason'        => $o->reason,
            ]),
            'doctor_schedules' => $doctorSchedules->map(fn($d) => [
                'id'            => $d->id,
                'dentist_id'    => $d->dentist_id,
                'dentist_name'  => trim(($d->dentist->name ?? '') . ' ' . ($d->dentist->lastname ?? '')),
                'store_id'      => $d->store_id,
                'schedule_date' => $d->schedule_date->toDateString(),
                'start_time'    => optional($d->start_time)->format('H:i'),
                'end_time'      => optional($d->end_time)->format('H:i'),
                'status'        => $d->status,
                'notes'         => $d->notes,
            ]),
        ]);
    }

    /**
     * Save (upsert) a clinic open/closed override for a single date.
     */
    public function saveClinicOverride(Request $request)
    {
        $data = $request->validate([
            'store_id'      => 'required|exists:stores,id',
            'schedule_date' => 'required|date',
            'is_open'       => 'required|boolean',
            'opening_time'  => 'nullable|date_format:H:i',
            'closing_time'  => 'nullable|date_format:H:i',
            'reason'        => 'nullable|string|max:255',
        ]);

        $override = StoreScheduleOverride::updateOrCreate(
            [
                'store_id'      => $data['store_id'],
                'schedule_date' => $data['schedule_date'],
            ],
            [
                'is_open'      => $data['is_open'],
                'opening_time' => $data['opening_time'] ?? null,
                'closing_time' => $data['closing_time'] ?? null,
                'reason'       => $data['reason'] ?? null,
            ]
        );

        return response()->json(['status' => 'success', 'data' => $override]);
    }

    public function deleteClinicOverride(StoreScheduleOverride $override)
    {
        $override->delete();
        return response()->json(['status' => 'success']);
    }

    /**
     * Save (upsert) a doctor schedule entry for a single date.
     */
    public function saveDoctorSchedule(Request $request)
    {
        $data = $request->validate([
            'dentist_id'    => 'required|exists:users,id',
            'store_id'      => 'nullable|exists:stores,id',
            'schedule_date' => 'required|date',
            'start_time'    => 'nullable|date_format:H:i',
            'end_time'      => 'nullable|date_format:H:i|after:start_time',
            'status'        => 'required|in:available,off',
            'notes'         => 'nullable|string|max:255',
        ]);

        $schedule = DoctorSchedule::updateOrCreate(
            [
                'dentist_id'    => $data['dentist_id'],
                'store_id'      => $data['store_id'] ?? null,
                'schedule_date' => $data['schedule_date'],
            ],
            [
                'start_time' => $data['status'] === 'off' ? null : ($data['start_time'] ?? null),
                'end_time'   => $data['status'] === 'off' ? null : ($data['end_time'] ?? null),
                'status'     => $data['status'],
                'notes'      => $data['notes'] ?? null,
            ]
        );

        return response()->json(['status' => 'success', 'data' => $schedule]);
    }

    public function deleteDoctorSchedule(DoctorSchedule $schedule)
    {
        $schedule->delete();
        return response()->json(['status' => 'success']);
    }
}

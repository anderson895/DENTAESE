<?php

namespace App\Services;

use App\Models\Store;
use App\Models\User;
use App\Notifications\AppointmentNotification;
use Illuminate\Support\Facades\Log;

/**
 * Central helper for in-app (database) notifications.
 *
 * Keeps the audience rules in one place:
 *  - admins            → users with position 'admin'
 *  - branch staff      → dentists/receptionists assigned to a branch
 *  - patient           → the appointment owner
 */
class Notifier
{
    /**
     * Send a notification to a set of users, ignoring failures so a
     * notification problem never breaks the main action.
     */
    private static function send($users, string $title, string $message, ?string $url = null): void
    {
        $payload = ['title' => $title, 'message' => $message, 'url' => $url];

        foreach (collect($users)->filter()->unique('id') as $user) {
            try {
                $user->notify(new AppointmentNotification($payload));
            } catch (\Throwable $e) {
                Log::warning('Notification failed for user ' . ($user->id ?? '?') . ': ' . $e->getMessage());
            }
        }
    }

    /** All admin accounts. */
    public static function admins(string $title, string $message, ?string $url = null): void
    {
        self::send(User::where('position', 'admin')->get(), $title, $message, $url);
    }

    /** Dentists and receptionists assigned to a branch. */
    public static function branchStaff($storeId, string $title, string $message, ?string $url = null): void
    {
        if (!$storeId || $storeId === 'admin') {
            return;
        }

        $store = $storeId instanceof Store ? $storeId : Store::find($storeId);
        if (!$store) {
            return;
        }

        self::send($store->staff()->get(), $title, $message, $url);
    }

    /** A single user (e.g. the patient). */
    public static function user(?User $user, string $title, string $message, ?string $url = null): void
    {
        if (!$user) {
            return;
        }

        self::send([$user], $title, $message, $url);
    }

    /** Branch staff + all admins (for clinic-wide operational events). */
    public static function staffAndAdmins($storeId, string $title, string $message, ?string $url = null): void
    {
        self::branchStaff($storeId, $title, $message, $url);
        self::admins($title, $message, $url);
    }
}

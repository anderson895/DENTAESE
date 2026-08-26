{{-- Pending appointments na naghihintay ng approval.
     Ginagamit ng admin at ng branch dashboard. Sa admin view ay sumasaklaw ito
     sa lahat ng branch — tingnan ang AdminController::$pendingApprovals. --}}
<div class="bg-white border-l-4 border-yellow-400 border border-gray-200 shadow-md p-6 rounded-md mb-6">
    <div class="flex justify-between items-center mb-4">
        <div class="font-medium flex items-center gap-2">
            <i class="fa-solid fa-hourglass-half text-yellow-500"></i>
            Pending Appointments — For Approval
            <span class="text-xs px-2 py-0.5 rounded-full {{ $pendingApprovals->count() ? 'bg-yellow-100 text-yellow-800' : 'bg-gray-100 text-gray-500' }} font-semibold">
                {{ $pendingApprovals->count() }}
            </span>
        </div>
        <a href="{{ route('admin.booking', ['status' => 'pending']) }}"
           class="text-xs font-medium text-primary border border-gray-200 rounded-md px-3 py-1 hover:bg-gray-50">View All</a>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full min-w-[540px]">
            <tbody>
                @forelse ($pendingApprovals->take(5) as $pendingAppointment)
                <tr class="hover:bg-yellow-50 cursor-pointer transition"
                    onclick="window.location='{{ route('admin.booking', ['status' => 'pending']) }}'">
                    <td class="py-2 px-4 border-b border-gray-100">
                        <span class="text-gray-600 text-sm font-medium">
                            {{ $pendingAppointment->user->full_name ?? 'Unknown' }}
                        </span>
                    </td>
                    <td class="py-2 px-4 border-b border-gray-100">
                        <span class="text-[13px] font-medium text-gray-400">
                            <i class="fa-regular fa-calendar mr-1"></i>
                            {{ \Carbon\Carbon::parse($pendingAppointment->appointment_date)->format('M d, Y') }}
                            {{ \Carbon\Carbon::parse($pendingAppointment->appointment_time)->format('h:i A') }}
                        </span>
                    </td>
                    <td class="py-2 px-4 border-b border-gray-100">
                        <span class="text-[13px] font-medium text-gray-400">{{ $pendingAppointment->service_name }}</span>
                    </td>
                    <td class="py-2 px-4 border-b border-gray-100 text-right">
                        <span class="text-xs px-2 py-1 rounded-full bg-yellow-100 text-yellow-800 font-semibold">Pending</span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="py-2 px-4 text-center text-gray-400 text-sm">No pending appointments for approval. 🎉</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

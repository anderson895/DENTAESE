<?php

namespace App\Http\Controllers;

use App\Models\User;   

use App\Models\Message;
use App\Models\Store;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    
    public function index()
    {
        return view('admin.chat'); 
    }

public function branches()
{
    $patientId = auth()->id();

    $branches = Store::with(['messages' => function ($q) use ($patientId) {
        $q->where(function ($query) use ($patientId) {
            $query->where('sender_id', $patientId)
                  ->orWhere('receiver_id', $patientId);
        })
        ->latest()
        ->limit(1);
    }])
    ->get()
    ->map(function ($branch) use ($patientId) {
        return [
            'id' => $branch->id,
            'name' => $branch->name,
            'latest_message' => $branch->messages->first(),
            'unread_count' => Message::where('store_id', $branch->id)
                ->where('receiver_id', $patientId)
                ->where('is_read', false)
                ->count(),
        ];
    })
    //  Sort newest to oldest based on message timestamp
    ->sortByDesc(function ($branch) {
        return optional($branch['latest_message'])->created_at ?? now()->subYears(100);
    })
    ->values();

    return response()->json($branches);
}


    public function fetch($storeId, $userId)
    {
        // Staff opened this conversation → mark patient's messages as read
        Message::patientThread()
            ->where('store_id', $storeId)
            ->where('sender_id', $userId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $messages = Message::patientThread()
            ->where('store_id', $storeId)
            ->where(function ($q) use ($userId) {
                $q->where('sender_id', $userId)
                  ->orWhere('receiver_id', $userId);
            })
            ->orderBy('created_at', 'asc')
            ->get();

        return response()->json($messages);
    }

    // =====================================================================
    // BRANCH-TO-BRANCH (staff: Dentist / Receptionist / Admin)
    //
    // Branch inbox ang modelo: para sa buong branch ang mensahe, kaya kahit
    // sinong staff na naka-aktibo doon ay nakakabasa at nakakasagot.
    // =====================================================================

    /**
     * Kasalukuyang branch ng naka-login na staff. Null kapag "admin" view ang
     * napili — walang partikular na branch na magpapadala.
     */
    private function activeBranchId(): ?int
    {
        $branchId = session('active_branch_id');

        return is_numeric($branchId) ? (int) $branchId : null;
    }

    /**
     * Ibang branch, kasama ang huling mensahe at bilang ng hindi pa nababasa.
     */
    public function staffBranches()
    {
        $storeId = $this->activeBranchId();

        if (!$storeId) {
            return response()->json([]);
        }

        return response()->json(
            Store::where('id', '!=', $storeId)
                ->orderBy('name')
                ->get()
                ->map(function ($branch) use ($storeId) {
                    $latest = Message::betweenBranches($storeId, $branch->id)
                        ->latest('created_at')
                        ->first();

                    return [
                        'id'                  => $branch->id,
                        'name'                => $branch->name,
                        'address'             => $branch->address,
                        'latest_message'      => $latest && $latest->type === 'file'
                            ? '📎 ' . $latest->message
                            : $latest?->message,
                        'latest_message_time' => $latest?->created_at?->diffForHumans(),
                        'sort_time'           => $latest?->created_at ?? now()->subYears(100),
                        'unread_count'        => Message::where('store_id', $branch->id)
                            ->where('to_store_id', $storeId)
                            ->where('is_read', false)
                            ->count(),
                    ];
                })
                ->sortByDesc('sort_time')
                ->values()
        );
    }

    /**
     * Buong usapan ng aktibong branch at ng napiling branch.
     */
    public function branchMessages($otherStoreId)
    {
        $storeId = $this->activeBranchId();

        if (!$storeId) {
            return response()->json(['message' => 'Pumili muna ng branch.'], 422);
        }

        // Binuksan ng tumatanggap na branch → markahan nang nabasa.
        Message::where('store_id', $otherStoreId)
            ->where('to_store_id', $storeId)
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $messages = Message::betweenBranches($storeId, $otherStoreId)
            ->with('sender:id,name,lastname,position')
            ->orderBy('created_at', 'asc')
            ->get()
            ->map(function ($message) use ($storeId) {
                return [
                    'id'          => $message->id,
                    'message'     => $message->message,
                    'type'        => $message->type,
                    'file_url'    => $message->file_path ? asset('storage/' . $message->file_path) : null,
                    'mine'        => (int) $message->store_id === $storeId,
                    'sender_name' => trim(($message->sender->name ?? '') . ' ' . ($message->sender->lastname ?? '')),
                    'sender_role' => $message->sender->position ?? '',
                    'created_at'  => $message->created_at->format('M d, Y h:i A'),
                ];
            });

        return response()->json($messages);
    }

    public function sendBranchMessage(Request $request)
    {
        $storeId = $this->activeBranchId();

        if (!$storeId) {
            return response()->json(['message' => 'Pumili muna ng branch.'], 422);
        }

        $request->validate([
            'to_store_id' => 'required|exists:stores,id|different:' . $storeId,
            'message'     => 'required|string',
        ]);

        $message = Message::create([
            'store_id'    => $storeId,
            'to_store_id' => $request->to_store_id,
            'sender_id'   => Auth::id(),
            'receiver_id' => null, // branch inbox — walang partikular na tatanggap
            'message'     => $request->message,
            'type'        => 'text',
        ]);

        return response()->json(['status' => 'success', 'message' => $message]);
    }

    public function uploadBranchFile(Request $request)
    {
        $storeId = $this->activeBranchId();

        if (!$storeId) {
            return response()->json(['message' => 'Pumili muna ng branch.'], 422);
        }

        $request->validate([
            'to_store_id' => 'required|exists:stores,id|different:' . $storeId,
            'file'        => 'required|file|max:10240', // 10MB
        ]);

        $file = $request->file('file');
        $path = $file->store('chat_files', 'public');

        $message = Message::create([
            'store_id'    => $storeId,
            'to_store_id' => $request->to_store_id,
            'sender_id'   => Auth::id(),
            'receiver_id' => null,
            'message'     => $file->getClientOriginalName(),
            'file_path'   => $path,
            'type'        => 'file',
        ]);

        return response()->json([
            'status'    => 'success',
            'file_name' => $file->getClientOriginalName(),
            'file_url'  => asset('storage/' . $path),
            'message'   => $message,
        ]);
    }



public function store(Request $request)
{
    $request->validate([
        'store_id' => 'required|exists:stores,id',
        'user_id'  => 'required|exists:users,id',
        'message'  => 'required|string',
    ]);

    $message = Message::create([
        'store_id'    => $request->store_id,
        'sender_id'   => Auth::id(),          // ADMIN
        'receiver_id' => $request->user_id,   // PATIENT
        'message'     => $request->message,
        'type'        => 'text'
    ]);

    return response()->json([
        'status'  => 'success',
        'message' => $message
    ]);
}




public function patients()
{
    $storeId = session('active_branch_id');

    // Get all patients
    $patients = User::where('account_type', 'patient')
        ->get()
        ->map(function ($patient) use ($storeId) {
            // Get latest message between this patient and the branch
            $latestMessage = \App\Models\Message::where('store_id', $storeId)
                ->where(function ($q) use ($patient) {
                    $q->where('sender_id', $patient->id)
                      ->orWhere('receiver_id', $patient->id);
                })
                ->latest('created_at')
                ->with('store')
                ->first();

            return [
                'id' => $patient->id,
                'full_name' => trim($patient->name . ' ' . $patient->lastname),
                'latest_message' => $latestMessage?->message,
                'latest_message_time' => $latestMessage?->created_at
                    ? $latestMessage->created_at->diffForHumans()
                    : null,
                'branch_name' => $latestMessage?->store?->name,
                'sort_time' => $latestMessage?->created_at ?? now()->subYears(100),
                'unread_count' => \App\Models\Message::where('store_id', $storeId)
                    ->where('sender_id', $patient->id)
                    ->where('is_read', false)
                    ->count(),
            ];
        })
        // ✅ Sort by latest message timestamp descending (new → old)
        ->sortByDesc('sort_time')
        ->values();

    return response()->json($patients);
}


public function patientIndex()
{
    return view('client.chat'); // separate blade for patients
}

public function patientMessages($storeId)
{
    $userId = Auth::id(); // logged-in patient

    // Patient opened this conversation → mark branch messages as read
    Message::where('store_id', $storeId)
        ->where('receiver_id', $userId)
        ->where('is_read', false)
        ->update(['is_read' => true]);

    $messages = Message::where('store_id', $storeId)
        ->where(function ($q) use ($userId) {
            $q->where('sender_id', $userId)
              ->orWhere('receiver_id', $userId);
        })
        ->orderBy('created_at', 'asc')
        ->get();

    return response()->json($messages);
}

public function sendMessage(Request $request)
{
    $request->validate([
        'store_id' => 'required|exists:stores,id',
        'message'  => 'required|string',
    ]);

    // Find admin for this branch/store
    $receiverId = User::where('account_type', 'admin')->first()->id;

    $message = Message::create([
        'store_id'    => $request->store_id,
        'sender_id'   => Auth::id(),
        'receiver_id' => $receiverId,
        'message'     => $request->message,
        'type'        => 'text',
    ]);

    return response()->json([
        'status' => 'success',
        'message' => $message
    ]);
}


// THIS UPLOAD FUNCTION IS FOR PATIENTS
public function uploadFile(Request $request)
{
    $request->validate([
        'file' => 'required|file|max:10240', // 10MB
        'store_id' => 'required'
    ]);

    $file = $request->file('file');

    // Save file
    $path = $file->store('chat_files', 'public');

    // Save message
    $message = Message::create([
        'store_id' => $request->store_id,
        'sender_id' => auth()->id(),
        'message' => $file->getClientOriginalName(),
        'file_path' => $path,
        'type' => 'file'
    ]);

    return response()->json([
        'status' => 'success',
        'file_name' => $file->getClientOriginalName(),
        'file_url' => asset('storage/' . $path),
        'message' => $message
    ]);
}

// ADMIN FILE UPLOAD
public function adminUpload(Request $request)
{
    $request->validate([
        'file'     => 'required|file|max:10240',
        'store_id' => 'required|exists:stores,id',
        'user_id'  => 'required|exists:users,id', // 👈 PATIENT ID
    ]);

    $file = $request->file('file');
    $path = $file->store('chat_files', 'public');

    $message = Message::create([
        'store_id'    => $request->store_id,
        'sender_id'   => auth()->id(),        // ADMIN
        'receiver_id' => $request->user_id,   // PATIENT
        'message'     => $file->getClientOriginalName(),
        'file_path'   => $path,
        'type'        => 'file',
    ]);

    return response()->json([
        'status'    => 'success',
        'file_name'=> $file->getClientOriginalName(),
        'file_url' => asset('storage/' . $path),
        'message'  => $message
    ]);
}







}

<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use  App\Models\newuser;
use  App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\mailresponse;
use App\Models\Appointment;
use App\Models\medicine_batches;
use App\Models\Sale;
use App\Models\Service;
use App\Models\Store;
use Illuminate\Support\Carbon;
use DB;
use Illuminate\Support\Facades\Storage;
class AdminController extends Controller
{
    //
    public function Viewuser(Request $request){
        $id = $request->input('id');
        $type = $request->input('type');
        $user = '';
        if ($type == 'User'){
        $user = User::find($id);
        }
        if ($type == 'newuser'){
            $user = newuser::find($id);
            }
        if ($user) {
            return response()->json([
                'status' => 'success',
                'data' => $user
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found'
            ], 404);
        }
    }
    public function Dashboard(Request $request){

    //      $branchId = session('active_branch_id');

    // $appointmentsToday = Appointment::with('user') // Include user relationship
    //     ->where('store_id', $branchId)
    //     ->whereDate('appointment_date', Carbon::today())
    //     ->orderBy('appointment_time')
    //     ->get();

    //      $branchId = session('active_branch_id');

    // $expiringSoon = medicine_batches::with('medicine')
    //     ->where('store_id', $branchId)
    //     ->whereDate('expiration_date', '<=', now()->addMonth())
    //     ->where('quantity', '>', 0)
    //     ->orderBy('expiration_date', 'asc')
    //     ->get();
    //     return view('admin.dashboard', compact('appointmentsToday','expiringSoon'));

     $branchId = session('active_branch_id');

    // Appointments today
    $appointmentsToday = Appointment::with('user')
        ->where('store_id', $branchId)
        ->whereDate('appointment_date', Carbon::today())
        ->orderBy('appointment_time')
        ->get();

    // Expiring medicines
    $expiringSoon = medicine_batches::with('medicine')
        ->where('store_id', $branchId)
        ->whereDate('expiration_date', '<=', now()->addMonth())
        ->where('quantity', '>', 0)
        ->orderBy('expiration_date', 'asc')
        ->get();

    // DASHBOARD COUNTS
    $adminCount = User::where('position', 'admin')->count();
    $doctorCount = User::where('position', 'dentist')->count();
    $receptionistCount = User::where('position', 'receptionist')->count();
    $patientCount = User::where('position', 'patient')->count();
    $staffTotal = $adminCount + $doctorCount + $receptionistCount;
    $branchCount = Store::count();

      // KPI CARDS (THIS MONTH)
    
    $startOfMonth = Carbon::now()->startOfMonth();
    $endOfMonth = Carbon::now()->endOfMonth();

$monthlySalesTotal = Sale::where('status', 'completed')
    ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
    ->when($branchId !== 'admin', function ($query) use ($branchId) {
        $query->where('store_id', $branchId);
    })
    ->sum('total_amount');

$monthlyAppointmentTotal = Appointment::where('status', 'completed')
    ->whereBetween('appointment_date', [$startOfMonth, $endOfMonth])
    ->when($branchId !== 'admin', function ($query) use ($branchId) {
        $query->where('store_id', $branchId);
    })
    ->sum('total_price');

$accumulatedTotal = $monthlySalesTotal + $monthlyAppointmentTotal;


    

$stores = Store::select('id', 'name')->get();


$startOfMonth = Carbon::now()->startOfMonth();
$endOfMonth = Carbon::now()->endOfMonth();

$salesGrouped = Sale::where('status', 'completed')
    ->whereBetween('created_at', [$startOfMonth, $endOfMonth])
    ->get()
    ->groupBy('store_id')
    ->map(fn ($items) => $items->sum('total_amount'));

$appointmentsGrouped = Appointment::where('status', 'completed')
    ->whereBetween('appointment_date', [$startOfMonth, $endOfMonth])
    ->get()
    ->groupBy('store_id')
    ->map(fn ($items) => $items->count());
        

$salesPerBranch = $stores->map(function ($store) use ($salesGrouped) {
    return [
        'name'  => $store->name,
        'total' => $salesGrouped[$store->id] ?? 0,
    ];
});

$appointmentsPerBranch = $stores->map(function ($store) use ($appointmentsGrouped) {
    return [
        'name'  => $store->name,
        'total' => $appointmentsGrouped[$store->id] ?? 0,
    ];
});
    //    ACCUMULATED MONTHLY (ALL BRANCHES)

 $startOfYear = Carbon::now()->startOfYear();
$endOfYear = Carbon::now()->endOfYear();

// Monthly Sales (current year)
$monthlySales = Sale::select(
        DB::raw("MONTH(created_at) as month"),
        DB::raw("SUM(total_amount) as total")
    )
    ->where('status', 'completed')
    ->whereBetween('created_at', [$startOfYear, $endOfYear])
    ->groupBy(DB::raw("MONTH(created_at)"))
    ->orderBy('month')
    ->get();

// Monthly Appointments (current year)
$monthlyAppointments = Appointment::select(
        DB::raw("MONTH(appointment_date) as month"),
        DB::raw("COUNT(*) as total")
    )
    ->where('status', 'completed')
    ->whereBetween('appointment_date', [$startOfYear, $endOfYear])
    ->groupBy(DB::raw("MONTH(appointment_date)"))
    ->orderBy('month')
    ->get();

// Create array with 12 months initialized to 0
$monthlySalesArr = collect(range(1,12))->map(function($m) use ($monthlySales) {
    $monthData = $monthlySales->firstWhere('month', $m);
    return $monthData ? $monthData->total : 0;
});

$monthlyAppointmentsArr = collect(range(1,12))->map(function($m) use ($monthlyAppointments) {
    $monthData = $monthlyAppointments->firstWhere('month', $m);
    return $monthData ? $monthData->total : 0;
});


    return view('admin.dashboard', compact(
    'adminCount',
    'doctorCount',
    'receptionistCount',
    'staffTotal',
    'expiringSoon',
    'patientCount',
    'branchCount',
    'appointmentsToday',
      'monthlySalesTotal',
        'monthlyAppointmentTotal',
         'monthlySales',
        'monthlyAppointments',
        'salesPerBranch',
    'appointmentsPerBranch',
        'monthlySalesArr',       
    'monthlyAppointmentsArr' 

        
));

    }
    
    public function Logout(){
        Auth::logout();
        return redirect('/loginui');
    }
     public function try(){
          $stores = Store::all(); 
         $services = Service::all();

      $clients = User::where('account_type', 'patient')->orderBy('name')->get();


      //return view('admin.bookingtry', compact('stores','services','clients'));
        return view('admin.partials.booking_modal', compact('stores','services','clients'));

    }
    public function Useraccount(){
        return view('admin.useraccount');
    }
     public function Patientaccount(){
        return view('admin.patientaccount');
    }

    public function Userverify(){
        return view('admin.userverify');
    }
    public function Profile(){
        return view('admin.adminprofile');
    }
    
     public function Branch(){
        return view('admin.branch');
    }
    public function dentalchart(){
        return view('admin.dentalchart');
    }
    public function Services(){
        return view('admin.services');
    }
    public function Newuserlist(Request $request)
    {
        $perPage = 5;
        $search = $request->input('search');


        $query = newuser::query();
       if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', "%{$search}%")
              ->orWhere('user', 'like', "%{$search}%")
              ;
        });
    }
    
    
    $users = $query->paginate($perPage);
    
        return response()->json([
            'status' => 'success',
            'data' => $users->items(),
            'pagination' => [
                'total' => $users->total(),
                'per_page' => $users->perPage(),
                'current_page' => $users->currentPage(),
                'last_page' => $users->lastPage(),
                'next_page_url' => $users->nextPageUrl(),
                'prev_page_url' => $users->previousPageUrl(),
            ]
        ]);
    }

    //new user view
     public function show($id)
    {
        $user = newuser::findOrFail($id); // Fetch user by ID, fail if not found
        $users = User::where('account_type', 'patient')->get();

        return view('admin.partials.newuser-approval', compact('user','users')); 
    }
    public function Adduser(Request $request){
        // $name = $request->input('name');
        // $last_name = $request->input('last_name');
        // $middle_name = $request->input('middle_name');
        // $suffix = $request->input('suffix');
         $user = $request->input('user');
        // $position = $request->input('position');
        $password = $user . 'Dentaease';
        try {
            $user = new User();
            $user->name = $request->input('name');
            $user->lastname = $request->input('last_name');
            $user->middlename = $request->input('middle_name');
            $user->suffix = $request->input('suffix');
            $user->user = $request->input('user');
            $user->position = $request->input('position');
            $user->account_type = 'admin';
            $user->password = $password;
            $user->save();
    
            return response()->json(['status' => 'success', 'message' => 'User added successfully']);
        } catch (QueryException $e) {
            if ($e->errorInfo[1] == 1062) {
                return response()->json(['message' => 'Username already exists.'], 409);
            }
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
    public function Approveuser(Request $request){
        $id = $request->input('userid'); 
        $accounttype = "patient";
          
        $newUser = newuser::findOrFail($id);

       
        $user = new User();
        $user->name = $newUser->name;
        $user->middlename = $newUser->middlename;
        $user->lastname = $newUser->lastname;
        $user->suffix = $newUser->suffix;

        $user->email = $newUser->email;
        $user->birth_date = $newUser->birth_date;
        $user->birthplace = $newUser->birthplace;
        $user->current_address = $newUser->current_address;

        $user->contact_number = $newUser->contact_number;
        $user->password = $newUser->password;
        $user->user = $newUser->user;
        $user->verification_id = $newUser->verification_id;
       
        $user->account_type = $accounttype;
       
        $user->save();

        // Delete the user from the newuser table
        $newUser->delete();
        Mail::to($user->email)->send(new mailresponse($user));
        return response()->json([
            'status' => 'success',
            'message' => 'User approved and moved to users table.'
        ]);
        
    }

    public function destroy($id)
{
    $user = NewUser::findOrFail($id);

    // Optionally delete the verification image
    if ($user->verification_id && Storage::disk('public')->exists($user->verification_id)) {
        Storage::disk('public')->delete('temp_verifications/' . $user->verification_id);

    }

    $user->delete();

    return response()->json(['message' => 'User deleted successfully.']);
}

    public function removeFaceToken(Request $request)
    {
        $user = Auth::user();
        $user->face_token = null;
        $user->save();

        return response()->json([ 'status' => 'success','message' => 'Face token removed successfully.']);
    }
}

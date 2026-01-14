<?php

namespace App\Http\Controllers;
use App\Models\Appointment;
use App\Models\MedicalForm;
use Illuminate\Http\Request;
use App\Models\Store;
use App\Models\Service;
use Illuminate\Support\Facades\Auth;
class Clientside extends Controller
{
    //
    public function CDashboard(){
        return view('client.cdashboard');
    }

    public function CConsent(){
        return view('client.consent');
    }
    public function record(){
        return view('client.patient_record');
    }

    public function CProfile(){

        $medicalForm = MedicalForm::where('user_id', auth()->id())->first();
        return view('client.cprofile',compact('medicalForm'));
    }
    public function CForms(){
        return view('client.patient_record');
    }
    public function CBooking(){
        $stores = Store::all(); 
      
      
        return view('client.cbooking', compact('stores'));
    }
 public function CBookingo()
{
    $userId = auth()->id();

    // Ongoing appointments
    $incompleteAppointments = Appointment::with(['user', 'dentist', 'store'])
        ->where('user_id', $userId)
        ->whereNotIn('status', ['completed', 'cancelled', 'no_show'])
        ->orderBy('appointment_date', 'desc')
        ->get();

    // Completed appointments
    $completedAppointments = Appointment::with(['user', 'dentist', 'store'])
        ->where('user_id', $userId)
        ->whereIn('status', ['completed', 'no_show', 'cancelled'])
        ->orderBy('appointment_date', 'desc')
        ->get();

    $stores = Store::all();
    $services = Service::all();
    $notifications = Auth::user()->notifications()->latest()->take(10)->get();

   
    $processServices = function ($appointments) {
        return $appointments->map(function ($appt) {

            
            $serviceIds = is_string($appt->service_ids)
                ? json_decode($appt->service_ids, true)
                : $appt->service_ids;

           
            $names = Service::whereIn('id', $serviceIds ?? [])
                ->pluck('name')
                ->toArray();

           
            $appt->service_list = $names;

            return $appt;
        });
    };


    $incompleteAppointments = $processServices($incompleteAppointments);
    $completedAppointments = $processServices($completedAppointments);

    return view('client.cbookingongoing', compact(
        'incompleteAppointments',
        'completedAppointments',
        'stores',
        'services',
        'notifications'
    ));
}



 }

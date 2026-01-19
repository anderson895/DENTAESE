@extends('layout.auth')

@section('title','CProfile')

@section('auth-content')
<div class="container mx-auto p-6">

    <!-- Header -->
    <h2 class="text-2xl font-bold mb-6 text-center">Informed Consent</h2>

    <!-- Consent Text (Scrollable Box) -->
    <div class="bg-white p-6 rounded-lg shadow-md max-h-[70vh] overflow-y-auto leading-relaxed text-justify space-y-4">

        <p>
            <strong>TREATMENT TO BE DONE</strong><br>
            I understand and consent to have any treatment done by the dentist after the procedure.
            The risks, benefits, and costs have been fully explained.
        </p>

        <p>
            <strong>DRUGS & MEDICATIONS</strong><br>
            I understand that antibiotics, analgesics, and other medications may cause allergic reactions.
            <em>(Initial: ________)</em>
        </p>

        <p>
            <strong>CHANGES IN TREATMENT PLAN</strong><br>
            I understand that changes or additional procedures may be required during treatment.
        </p>

        <p>
            <strong>RADIOGRAPH</strong><br>
            I understand that dental x-rays may be required and do not guarantee 100% accuracy.
            <em>(Initial: ________)</em>
        </p>

        <p>
            <strong>REMOVAL OF TEETH</strong><br>
            I understand the alternatives, risks, and possible complications involved in tooth removal.
        </p>

        <p>
            <strong>CROWNS (CAPS) & BRIDGES</strong><br>
            I understand that temporary crowns may come off and timely return is required.
        </p>

        <p>
            <strong>ENDODONTICS (ROOT CANAL)</strong><br>
            I understand that root canal treatment has no guaranteed outcome.
        </p>

        <p>
            <strong>PERIODONTAL DISEASE</strong><br>
            I understand that periodontal disease may lead to tooth loss.
        </p>

        <p>
            <strong>FILLINGS</strong><br>
            I understand that sensitivity after fillings is common.
        </p>

        <p>
            <strong>DENTURES</strong><br>
            I understand that dentures may require adjustments and relines.
        </p>

        <p>
            Dentistry is not an exact science and results cannot be guaranteed.
        </p>

        <p>
            I authorize the dental team to proceed with treatment and accept financial responsibility.
        </p>

        <!-- Notes Section -->
        <div class="pt-4">
            <strong>Notes</strong>
            <ul class="list-disc ml-6 mt-2 text-sm space-y-2">
                <li>
                    Missed appointments without prior notice (No-Show) may incur a
                    <strong>₱200 no-show fee</strong>.
                </li>
                <li>
                    Rescheduling or cancellation must be made at least
                    <strong>24 hours in advance</strong>.
                </li>
                <li>
                    Repeated no-shows may affect future appointment bookings.
                </li>
            </ul>
        </div>

                <!-- Clinic Policies -->
        <div class="pt-4">
            <strong>Clinic Policies & Appointment Guidelines</strong>

            <ul class="list-disc ml-6 mt-3 space-y-3 text-sm text-justify">
                <li>
                    All patients must use the clinic's official appointment system to make appointments in advance.
                    Patients who walk in are dependent on availability.
                </li>

                <li>
                    Patients are unable to set a new appointment unless it is an emergency or urgent.
                </li>

                <li>
                    Patients are expected to arrive at least 10 minutes before their scheduled appointment.
                    If you are more than fifteen minutes late, the clinic may decide to reschedule or cancel.
                </li>

                <li>
                    Cancellations of appointments must be made at least 48 hours before the scheduled time.
                    Penalties or limitations on future reservations may be imposed for failure to notify the clinic.
                </li>

                <li>
                    All dental services must be paid for in full right after treatment,
                    unless the clinic management specifies.
                </li>

                <li>
                    Payments for completed services are nonrefundable.
                    Refunds for cancelled appointments, if any, are subject to clinic review and policy guidelines.
                </li>

                <li>
                    All patient information gathered by the clinic will be handled confidentially and safeguarded
                    in accordance with the Data Privacy Act.
                    Information may be used for medical, billing, and appointment purposes.
                </li>

                <li>
                    Patients must give informed permission before they have any dental operation.
                    The clinic maintains the right to refuse treatment if permission is not provided.
                </li>

                <li>
                    The clinic pays close attention to infection control, sanitation, and safety regulations
                    to provide a clean and safe environment for both patients and staff.
                </li>

                <li>
                    Patients are asked to show kindness to clinic staff and other patients.
                    Any violent or disruptive behavior may result in a refusal of service.
                </li>

                <li>
                    The clinic reserves the right to update or modify these policies at any time.
                    Updated policies will take effect immediately upon publishing or system update.
                </li>
            </ul>
        </div>


    </div>

    <!-- I Agree Button -->
    <form action="{{ route('consent.store') }}" method="POST" class="mt-6 text-center">
        @csrf
        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">
            I Agree
        </button>
    </form>

</div>
@endsection

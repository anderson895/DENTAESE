@extends('layout.auth')

@section('title', 'Terms and Conditions')

@section('auth-content')
{{-- Nilalaman galing sa Terms-and-Conditions-1.docx --}}
<div class="w-full max-w-3xl mx-auto my-8 bg-white rounded-lg shadow p-6 sm:p-10">

    <h1 class="text-2xl sm:text-3xl font-bold text-sky-600 text-center">Terms and Conditions</h1>

    <p class="mt-4 text-gray-700 leading-relaxed">
        The following Terms and Conditions are established to ensure the proper, secure, and efficient
        use of the Dental Management System. By using the system, all authorized users and patients
        agree to follow these guidelines to help maintain organized clinic operations, accurate patient
        records, and quality dental services.
    </p>

    <ol class="mt-8 space-y-6 text-gray-700 leading-relaxed">
        <li>
            <h2 class="font-semibold text-gray-900">1. Appointment Approval</h2>
            <p class="mt-1">
                All appointment requests submitted through the Dental Management System must be reviewed
                and approved by an authorized Dentist or Dental Receptionist. Please note that submitting
                an appointment request does not automatically confirm your appointment. Patients should
                wait for an official confirmation before visiting the clinic.
            </p>
        </li>

        <li>
            <h2 class="font-semibold text-gray-900">2. Authorized System Users</h2>
            <p class="mt-1">
                Access to the administrative features of the system is limited to authorized Dentists and
                Dental Receptionists only. These users are responsible for managing appointments,
                maintaining patient records, updating schedules, and performing other clinic-related
                administrative tasks.
            </p>
        </li>

        <li>
            <h2 class="font-semibold text-gray-900">3. Responsible Use of the System</h2>
            <p class="mt-1">
                All authorized users are expected to use the system responsibly, ethically, and
                professionally. The system should only be used for official clinic purposes. Carelessness,
                unauthorized activities, misuse of system features, or actions that may delay patient
                services should always be avoided to ensure smooth and efficient clinic operations.
            </p>
        </li>

        <li>
            <h2 class="font-semibold text-gray-900">4. Accuracy of Information</h2>
            <p class="mt-1">
                Patients are encouraged to provide complete, accurate, and up-to-date personal and medical
                information when using the system. Likewise, Dentists and Dental Receptionists are
                responsible for carefully recording and updating patient information, treatment details,
                and appointment records to maintain accurate and reliable data.
            </p>
        </li>

        <li>
            <h2 class="font-semibold text-gray-900">5. Timely Appointment Management</h2>
            <p class="mt-1">
                Dentists and Dental Receptionists should regularly monitor appointment requests and respond
                to them promptly by approving, rescheduling, or declining appointments when necessary.
                Timely management of appointments helps reduce waiting time and provides better service to
                patients.
            </p>
        </li>

        <li>
            <h2 class="font-semibold text-gray-900">6. Appointment Confirmation</h2>
            <p class="mt-1">
                Patients are advised to wait until they receive an official appointment confirmation through
                the Dental Management System. Appointment requests will remain in a pending status until
                they have been reviewed and approved by an authorized Dentist or Dental Receptionist.
            </p>
        </li>

        <li>
            <h2 class="font-semibold text-gray-900">7. Patient Confidentiality and Data Security</h2>
            <p class="mt-1">
                Protecting patient information is a shared responsibility. All patient records stored in the
                system must remain confidential and should only be accessed by authorized personnel. Users
                must handle patient information responsibly and comply with applicable data privacy laws and
                clinic policies.
            </p>
        </li>

        <li>
            <h2 class="font-semibold text-gray-900">8. Secure Account Usage</h2>
            <p class="mt-1">
                Each authorized user is responsible for protecting their login credentials. Usernames and
                passwords should never be shared with others, and users must ensure that unauthorized
                individuals cannot access their accounts.
            </p>
        </li>

        <li>
            <h2 class="font-semibold text-gray-900">9. Device Requirements</h2>
            <p class="mt-1">
                For the best user experience, Dentists and Dental Receptionists are encouraged to access the
                administrative dashboard using a desktop computer, laptop, or any device with a widescreen
                display. This helps ensure that appointments, patient records, reports, and other system
                features are displayed properly and can be managed efficiently.
            </p>
        </li>

        <li>
            <h2 class="font-semibold text-gray-900">10. System Availability</h2>
            <p class="mt-1">
                Although the clinic strives to keep the Dental Management System available at all times,
                temporary interruptions may occur due to scheduled maintenance, software updates, or
                unexpected technical issues. Every effort will be made to restore normal system operations
                as quickly as possible.
            </p>
        </li>

        <li>
            <h2 class="font-semibold text-gray-900">11. Compliance with Clinic Policies</h2>
            <p class="mt-1">
                All authorized users are expected to follow the clinic's policies, professional standards,
                and ethical practices while using the system. Any misuse of the system, unauthorized access,
                falsification of records, or violation of these Terms and Conditions may result in
                disciplinary action or suspension of system access.
            </p>
        </li>

        <li>
            <h2 class="font-semibold text-gray-900">12. Changes to the Terms and Conditions</h2>
            <p class="mt-1">
                The dental clinic reserves the right to update or revise these Terms and Conditions whenever
                necessary. Any changes will be made to improve the system, strengthen security, comply with
                applicable laws, and support the continuous improvement of clinic services.
            </p>
        </li>
    </ol>

    <div class="mt-10 pt-6 border-t text-center text-sm">
        <a href="{{ url()->previous() == url()->current() ? route('login') : url()->previous() }}"
           class="text-blue-500 hover:text-blue-700 underline transition">
            &larr; Back
        </a>
    </div>
</div>
@endsection

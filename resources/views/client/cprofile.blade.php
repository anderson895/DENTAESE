@extends('layout.cnav')
@section('title','CProfile')
@section('main-content')
<style>
    #video, #overlayCanvas {
        display: block;
        width: 320px;
        height: 240px;
    }
    
    #overlayCanvas {
        position: absolute;
        top: 0;
        left: 0;
        pointer-events: none;
    }
    
    .w-3.h-3.rounded-full {
        transition: all 0.3s ease;
    }
</style>

<!-- Tab Navigation -->
<div class="mb-6 border-b border-gray-300">
    <ul class="flex space-x-6 text-sm font-medium text-center text-gray-600" id="tabs">
        <li>
            <button class="tab-button border-b-2 py-2 px-4 hover:text-primary hover:border-primary active border-primary text-primary"
                data-tab="profile-tab">Profile</button>
        </li>
        <li>
            <button class="tab-button border-b-2 border-transparent py-2 px-4 hover:text-primary hover:border-primary"
                data-tab="medical-tab">Patient Information</button>
        </li>
        <li>
            <button class="tab-button border-b-2 border-transparent py-2 px-4 hover:text-primary hover:border-primary"
                data-tab="chart-tab">Dental Chart</button>
        </li>
        <li>
            <button class="tab-button border-b-2 border-transparent py-2 px-4 hover:text-primary hover:border-primary"
                data-tab="record-tab">Treatment Record</button>
        </li>
        <li>
            <button class="tab-button border-b-2 border-transparent py-2 px-4 hover:text-primary hover:border-primary"
                data-tab="medication-tab">Current Medication</button>
        </li>
        <li>
            <button class="tab-button border-b-2 border-transparent py-2 px-4 hover:text-primary hover:border-primary"
                data-tab="consent-tab">Consent</button>
        </li>
    </ul>
</div>

<div id="record-tab" class="tab-content hidden">
    @if($record)
        @include('admin.dental-chart.treatment-record', ['record' => $record])
    @else
        <p>No treatment record available.</p>
    @endif
</div>

<div id="medication-tab" class="tab-content hidden">
    @include('client.current-medication', ['currentMedications' => $currentMedications])
</div>

<div id="consent-tab" class="tab-content hidden">
    @include('client.consentpage')
</div>

<div id="profile-tab" class="tab-content">
<div class="flex flex-col lg:flex-row gap-5 items-stretch">

    {{-- LEFT: Profile Card --}}
    <div class="w-full lg:w-1/3 bg-white rounded-xl shadow-sm overflow-hidden flex flex-col">
        <div class="h-36 bg-gradient-to-r from-sky-400 to-primary"></div>
        <div class="px-6 pb-6 -mt-10 flex flex-col items-center flex-1">
            @if (Auth::user()->profile_image == null)
                <img src="{{ asset('images/defaultp.jpg') }}" alt="Profile picture"
                    class="w-24 h-24 rounded-full object-cover border-4 border-white shadow bg-white">
            @else
                <img src="{{ asset('storage/profile_pictures/' . Auth::user()->profile_image) }}" alt="Profile picture"
                    class="w-24 h-24 rounded-full object-cover border-4 border-white shadow bg-white">
            @endif
            <h2 class="mt-3 text-lg font-bold text-gray-800 text-center">{{ Auth::user()->name }} {{ Auth::user()->lastname }}</h2>
            <span class="text-xs text-gray-500 capitalize">{{ Auth::user()->account_type }}</span>

            <form class="w-full mt-5 space-y-4" method="POST" action="{{ route('profile.upload') }}" enctype="multipart/form-data">
                @csrf
                <div>
                    <label for="fname" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                    <input type="text" name="fname" id="fname"
                        value="{{ Auth::user()->lastname }}, {{ Auth::user()->name }} {{ Auth::user()->middlename }} {{ Auth::user()->suffix }}"
                        class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-600" readonly>
                </div>
                <div>
                    <label for="bday" class="block text-sm font-medium text-gray-700 mb-1">Birth Day</label>
                    <input type="date" name="bday" id="bday" value="{{ Auth::user()->birth_date }}"
                        class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-600" readonly>
                </div>
                <div>
                    <label for="profile_image" class="block text-sm font-medium text-gray-700 mb-1">Profile Picture</label>
                    <input type="file" name="profile_image" id="profile_image" accept="image/*"
                        class="w-full text-sm text-gray-600 border border-gray-200 rounded-lg cursor-pointer file:mr-3 file:py-2 file:px-3 file:border-0 file:bg-sky-50 file:text-sky-700 file:text-sm file:font-medium hover:file:bg-sky-100">
                </div>
                <button type="submit" class="w-full bg-primary hover:bg-sky-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                    <i class="fa-solid fa-upload mr-1"></i> Upload
                </button>
            </form>
        </div>
    </div>

    {{-- RIGHT: QR + Face Recognition + Account Settings --}}
    <div class="w-full lg:w-2/3 flex flex-col gap-5">
        <div class="flex flex-col md:flex-row gap-5">

            {{-- QR Code --}}
            <div class="flex-1 bg-white rounded-xl shadow-sm p-5">
                <h3 class="flex items-center gap-2 text-sm font-semibold text-gray-800 border-b border-gray-100 pb-3 mb-4">
                    <i class="fa-solid fa-qrcode text-primary"></i> My QR Code
                </h3>
                <div class="flex flex-col items-center">
                    @php
                        $myQrPath = Auth::user()->qr_code ? 'qr_codes/' . Auth::user()->qr_code : null;
                        $myQrExists = $myQrPath && \Illuminate\Support\Facades\Storage::disk('public')->exists($myQrPath);
                    @endphp
                    @if($myQrExists)
                        <img id="myQrImage" src="{{ asset('storage/qr_codes/' . Auth::user()->qr_code) }}" alt="User QR Code"
                            class="w-40 h-40 object-contain border border-gray-200 p-2 rounded-lg" />
                        <a id="myQrDownload" href="{{ asset('storage/qr_codes/' . Auth::user()->qr_code) }}" download="my-qr-code.png"
                            class="mt-4 w-full text-center bg-primary hover:bg-sky-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition">
                            <i class="fa-solid fa-download mr-1"></i> Download QR Code (.png)
                        </a>
                    @else
                        <img id="myQrImage" src="" alt="QR not available" class="w-40 h-40 object-contain border border-gray-200 p-2 rounded-lg hidden" />
                        <div id="myQrMissing" class="w-40 h-40 flex items-center justify-center border border-dashed border-red-400 text-red-600 text-xs text-center px-2 rounded-lg">
                            QR file is missing.<br>Click "Regenerate QR" below.
                        </div>
                        <a id="myQrDownload" href="#" download="my-qr-code.png"
                            class="mt-4 w-full text-center bg-primary hover:bg-sky-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition hidden">
                            <i class="fa-solid fa-download mr-1"></i> Download QR Code (.png)
                        </a>
                    @endif
                    <button id="regenerateMyQrBtn" type="button"
                        class="mt-2 w-full inline-flex items-center justify-center border border-orange-300 text-orange-600 hover:bg-orange-50 px-4 py-2 rounded-lg text-sm font-medium transition">
                        <i class="fa-solid fa-arrows-rotate mr-1"></i> Regenerate QR
                    </button>
                </div>
            </div>

            {{-- Face Recognition --}}
            <div class="flex-1 bg-white rounded-xl shadow-sm p-5 flex flex-col">
                <div class="flex items-center justify-between border-b border-gray-100 pb-3 mb-4">
                    <h3 class="flex items-center gap-2 text-sm font-semibold text-gray-800">
                        <i class="fa-solid fa-face-smile text-primary"></i> Face Recognition
                    </h3>
                    @if(Auth::user()->face_descriptor !== null && Auth::user()->face_descriptor !== "")
                        <button id="removeFaceToken" class="text-xs font-medium text-red-600 bg-red-50 hover:bg-red-100 px-3 py-1.5 rounded-lg transition">
                            <i class="fa-solid fa-trash-can mr-1"></i>Remove
                        </button>
                    @endif
                </div>

                {{-- Loading Spinner --}}
                <div id="loadingSpinner" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-[9999]">
                    <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-b-4 border-sky-500"></div>
                </div>

                {{-- Check face_descriptor instead of face_token --}}
                <div class="flex flex-col items-center justify-center flex-1 text-center gap-3 py-4">
                    @if(Auth::user()->face_descriptor !== null && Auth::user()->face_descriptor !== "")
                        <span class="w-14 h-14 rounded-full bg-green-100 text-green-600 flex items-center justify-center">
                            <i class="fa-solid fa-check text-xl"></i>
                        </span>
                        <p class="text-sm text-gray-600">Your face is registered. You can log in using face recognition.</p>
                        <button id="capturemodal" class="px-4 py-2 bg-sky-200 text-white rounded-lg text-sm cursor-not-allowed" disabled>
                            Face Registered
                        </button>
                    @else
                        <span class="w-14 h-14 rounded-full bg-sky-50 text-sky-500 flex items-center justify-center">
                            <i class="fa-solid fa-camera text-xl"></i>
                        </span>
                        <p class="text-sm text-gray-600">Register your face to log in using face recognition.</p>
                        <button id="capturemodal" class="px-4 py-2 bg-primary hover:bg-sky-700 text-white rounded-lg text-sm font-medium transition">
                            <i class="fa-solid fa-camera mr-1"></i> Capture & Register
                        </button>
                    @endif
                </div>

                {{-- Face Registration Modal --}}
                <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
                    <div class="bg-white p-6 rounded-xl shadow-lg w-fit">
                        <h2 class="text-lg font-semibold mb-4 text-gray-800 text-center">Face Registration</h2>

                        <div class="relative">
                            <div class="relative inline-block" style="padding: 8px; background: linear-gradient(to right, #10b981 var(--progress, 0%), #e5e7eb var(--progress, 0%)); border-radius: 0.5rem;">
                                <div class="relative inline-block">
                                    <video id="video" width="320" height="240" autoplay playsinline
                                        class="rounded-md block" style="width: 320px; height: 240px;"></video>
                                    <canvas id="overlayCanvas" width="320" height="240"
                                        class="absolute top-0 left-0 rounded-md pointer-events-none"
                                        style="width: 320px; height: 240px;"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4 space-y-2">
                            <div class="text-center text-xs text-gray-500">
                                <p id="debugInfo">FPS: --</p>
                            </div>
                            <div class="text-center">
                                <p id="instructionText" class="text-sm font-semibold text-gray-700">
                                    Move your head left and right
                                </p>
                                <p id="progressText" class="text-xs text-gray-500 mt-1">Progress: 0%</p>
                            </div>
                            <div class="flex justify-center gap-4 text-xs">
                                <div class="flex items-center gap-1">
                                    <span id="leftIndicator" class="w-3 h-3 rounded-full bg-gray-300"></span>
                                    <span>Left Turn</span>
                                </div>
                                <div class="flex items-center gap-1">
                                    <span id="rightIndicator" class="w-3 h-3 rounded-full bg-gray-300"></span>
                                    <span>Right Turn</span>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <button id="closemodal" type="button"
                                class="bg-gray-400 hover:bg-gray-500 text-white px-3 py-2 rounded-md">
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        {{-- Update Profile Form --}}
        <div class="bg-white rounded-xl shadow-sm p-5">
            <h3 class="flex items-center gap-2 text-sm font-semibold text-gray-800 border-b border-gray-100 pb-3 mb-4">
                <i class="fa-solid fa-user-gear text-primary"></i> Account Settings
            </h3>
            <form id="updateProfile" class="grid grid-cols-1 md:grid-cols-2 gap-4" action="">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="text" name="email" id="email" value="{{ Auth::user()->email }}"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                </div>
                <div>
                    <label for="contact" class="block text-sm font-medium text-gray-700 mb-1">Contact Number</label>
                    <input type="number" name="contact" id="contact" value="{{ Auth::user()->contact_number }}"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                </div>
                <div>
                    <label for="user" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                    <input type="text" name="user" id="user" value="{{ Auth::user()->user }}"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                    <div class="relative">
                        <input type="password" name="password" id="password" placeholder="Leave blank to keep current password"
                            class="w-full border border-gray-300 rounded-lg px-3 py-2 pr-16 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500">
                        <button type="button" onclick="toggleProfilePass()"
                            class="absolute inset-y-0 right-0 px-3 flex items-center text-primary text-xs font-medium">Show</button>
                    </div>
                </div>
                <input type="hidden" name="oldpassword" id="oldpassword" value="{{ Auth::user()->password }}">
                <div class="md:col-span-2 flex justify-end">
                    <button class="bg-primary hover:bg-sky-700 text-white text-sm font-medium px-6 py-2 rounded-lg transition" type="submit">
                        <i class="fa-solid fa-floppy-disk mr-1"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>

</div>
</div>

<div id="medical-tab" class="tab-content hidden">
    @if($patient)
        @include('client.patient_record', ['patient' => $patient])
    @else
        <p>No patient record available.</p>
    @endif
</div>

<div id="chart-tab" class="tab-content hidden">
    @if($patient)
        {{-- View-only: patients can see their dental chart but never edit it --}}
        @include('admin.dental-chart.index', ['patient' => $patient, 'chartReadonly' => true])
    @else
        <p>No dental chart available.</p>
    @endif
</div>


{{-- ===================== SCRIPTS ===================== --}}
<script>
function toggleProfilePass() {
    const input = document.getElementById('password');
    const btn = event.currentTarget;
    if (input.type === 'password') { input.type = 'text'; btn.textContent = 'Hide'; }
    else { input.type = 'password'; btn.textContent = 'Show'; }
}
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/@vladmandic/face-api/dist/face-api.min.js"></script>

{{-- Tab switching --}}
<script>
document.querySelectorAll(".tab-button").forEach(button => {
    button.addEventListener("click", () => {
        const tab = button.dataset.tab;
        document.querySelectorAll(".tab-button").forEach(btn => {
            btn.classList.remove("active", "border-primary", "text-primary");
            btn.classList.add("border-transparent");
        });
        button.classList.remove("border-transparent");
        button.classList.add("active", "border-primary", "text-primary");
        document.querySelectorAll(".tab-content").forEach(tc =>
            tc.classList.add("hidden")
        );
        document.getElementById(tab).classList.remove("hidden");
    });
});
</script>

{{-- ================= FACE CAPTURE & REGISTER ================= --}}
<script>
let modelsLoaded = false;
let isDetecting  = false;
let animationFrameId = null;

// Liveness tracking
let headMovementLeft  = false;
let headMovementRight = false;
let currentProgress   = 0;

// FPS tracking
let lastFrameTime = Date.now();
let frameCount    = 0;
let fps           = 0;

const openBtn  = document.getElementById('capturemodal');
const modal    = document.getElementById('modal');
const closeBtn = document.getElementById('closemodal');
const video    = document.getElementById('video');
let stream     = null;

// ─────────────────────────────────────────────
// Load face-api.js models (need faceRecognitionNet!)
// ─────────────────────────────────────────────
async function loadModels() {
    if (modelsLoaded) return;
    try {
        await faceapi.nets.tinyFaceDetector.loadFromUri('/models/tiny_face_detector');
        await faceapi.nets.faceLandmark68Net.loadFromUri('/models/face_landmark_68');
        await faceapi.nets.faceRecognitionNet.loadFromUri('/models/face_recognition'); // ← needed for descriptor
        modelsLoaded = true;
        console.log('✅ All models loaded');
    } catch (err) {
        console.error('❌ Model loading error:', err);
        Swal.fire('Error', 'Failed to load face detection models.', 'error');
    }
}

// ─────────────────────────────────────────────
// Progress tracking
// ─────────────────────────────────────────────
function updateProgress() {
    let progress = 0;
    if (headMovementLeft)  progress += 50;
    if (headMovementRight) progress += 50;
    currentProgress = Math.min(100, Math.round(progress));

    const videoContainer = document.querySelector('#video').parentElement;
    videoContainer.style.setProperty('--progress', currentProgress + '%');
    document.getElementById('progressText').textContent = `Progress: ${currentProgress}%`;

    if (!headMovementLeft && !headMovementRight) {
        document.getElementById('instructionText').textContent = 'Move your head left and right';
    } else if (headMovementLeft && !headMovementRight) {
        document.getElementById('instructionText').textContent = 'Now turn your head to the right';
    } else if (!headMovementLeft && headMovementRight) {
        document.getElementById('instructionText').textContent = 'Now turn your head to the left';
    } else {
        document.getElementById('instructionText').textContent = 'Verification complete!';
    }

    document.getElementById('leftIndicator').className  = headMovementLeft  ? 'w-3 h-3 rounded-full bg-green-500' : 'w-3 h-3 rounded-full bg-yellow-400 animate-pulse';
    document.getElementById('rightIndicator').className = headMovementRight ? 'w-3 h-3 rounded-full bg-green-500' : 'w-3 h-3 rounded-full bg-yellow-400 animate-pulse';

    // Auto-capture when 100%
    if (currentProgress === 100) {
        setTimeout(() => captureFaceAndRegister(), 500);
    }
}

function detectHeadMovement(landmarks) {
    const nose     = landmarks.getNose();
    const jawline  = landmarks.getJawOutline();
    const noseTip  = nose[3];
    const leftJaw  = jawline[0];
    const rightJaw = jawline[16];
    const faceWidth= rightJaw.x - leftJaw.x;
    const noseRatio= (noseTip.x - leftJaw.x) / faceWidth;

    if (noseRatio < 0.38 && !headMovementLeft) {
        headMovementLeft = true;
        console.log('✅ HEAD LEFT | Ratio:', noseRatio.toFixed(3));
        updateProgress();
    }
    if (noseRatio > 0.62 && !headMovementRight) {
        headMovementRight = true;
        console.log('✅ HEAD RIGHT | Ratio:', noseRatio.toFixed(3));
        updateProgress();
    }
}

function drawBoundingBox(detection, canvas) {
    const ctx    = canvas.getContext('2d');
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    if (!detection) return;

    const scaleX  = canvas.width  / video.videoWidth;
    const scaleY  = canvas.height / video.videoHeight;
    const box     = detection.detection.box;

    ctx.strokeStyle = '#10b981';
    ctx.lineWidth   = 3;
    ctx.strokeRect(box.x * scaleX, box.y * scaleY, box.width * scaleX, box.height * scaleY);

    ctx.fillStyle = 'rgba(16, 185, 129, 0.9)';
    ctx.fillRect(box.x * scaleX, box.y * scaleY - 25, 60, 23);
    ctx.fillStyle = '#ffffff';
    ctx.font      = 'bold 14px Arial';
    ctx.fillText('FACE', box.x * scaleX + 8, box.y * scaleY - 7);
}

// ─────────────────────────────────────────────
// Main detection loop
// ─────────────────────────────────────────────
async function detectFaceLoop() {
    if (!isDetecting) return;

    const overlayCanvas = document.getElementById('overlayCanvas');

    frameCount++;
    const now = Date.now();
    if (now - lastFrameTime > 1000) {
        fps           = frameCount;
        frameCount    = 0;
        lastFrameTime = now;
    }
    document.getElementById('debugInfo').textContent = `FPS: ${fps}`;

    if (video && !video.paused && !video.ended && video.readyState === video.HAVE_ENOUGH_DATA) {
        if (overlayCanvas.width !== video.videoWidth || overlayCanvas.height !== video.videoHeight) {
            overlayCanvas.width  = video.videoWidth;
            overlayCanvas.height = video.videoHeight;
        }

        try {
            const detection = await faceapi
                .detectSingleFace(video, new faceapi.TinyFaceDetectorOptions({ inputSize: 224, scoreThreshold: 0.5 }))
                .withFaceLandmarks();

            if (detection) {
                drawBoundingBox(detection, overlayCanvas);
                detectHeadMovement(detection.landmarks);
            } else {
                overlayCanvas.getContext('2d').clearRect(0, 0, overlayCanvas.width, overlayCanvas.height);
            }
        } catch (err) {
            console.error('Detection error:', err);
        }
    }

    animationFrameId = requestAnimationFrame(detectFaceLoop);
}

function startDetection() { isDetecting = true;  detectFaceLoop(); }
function stopDetection()  {
    isDetecting = false;
    if (animationFrameId) { cancelAnimationFrame(animationFrameId); animationFrameId = null; }
}

function stopCamera() {
    if (stream) { stream.getTracks().forEach(t => t.stop()); stream = null; }
}

function resetTracking() {
    headMovementLeft = headMovementRight = false;
    currentProgress  = fps = frameCount = 0;
    document.getElementById('instructionText').textContent = 'Move your head left and right';
    document.getElementById('progressText').textContent    = 'Progress: 0%';
    document.getElementById('debugInfo').textContent       = 'FPS: --';
    document.getElementById('leftIndicator').className     = 'w-3 h-3 rounded-full bg-gray-300';
    document.getElementById('rightIndicator').className    = 'w-3 h-3 rounded-full bg-gray-300';
    document.querySelector('#video').parentElement.style.setProperty('--progress', '0%');
}

// ─────────────────────────────────────────────
// Open modal
// ─────────────────────────────────────────────
openBtn.addEventListener('click', async () => {
    modal.classList.remove('hidden');
    resetTracking();
    try {
        stream = await navigator.mediaDevices.getUserMedia({
            video: { width: { ideal: 640 }, height: { ideal: 480 }, frameRate: { ideal: 30 } }
        });
        video.srcObject = stream;
        await new Promise(resolve => {
            video.onloadedmetadata = () => { video.play(); resolve(); };
        });
        console.log('📹 Camera ready:', video.videoWidth, 'x', video.videoHeight);
        await loadModels();
        setTimeout(() => startDetection(), 500);
    } catch (err) {
        console.error('❌ Webcam error:', err);
        Swal.fire('Error', 'Unable to access webcam.', 'error');
        modal.classList.add('hidden');
    }
});

// ─────────────────────────────────────────────
// Close modal
// ─────────────────────────────────────────────
closeBtn.addEventListener('click', () => {
    stopDetection();
    modal.classList.add('hidden');
    stopCamera();
    resetTracking();
});

// ─────────────────────────────────────────────
// Capture descriptor & register (NO image upload)
// ─────────────────────────────────────────────
async function captureFaceAndRegister() {
    stopDetection();
    document.getElementById('loadingSpinner').classList.remove('hidden');

    try {
        // Extract face descriptor (128-value Float32Array)
        const detection = await faceapi
            .detectSingleFace(video, new faceapi.TinyFaceDetectorOptions({ inputSize: 224, scoreThreshold: 0.5 }))
            .withFaceLandmarks()
            .withFaceDescriptor(); // ← THIS is what we need

        if (!detection) {
            document.getElementById('loadingSpinner').classList.add('hidden');
            Swal.fire('Error', 'No face detected. Please try again.', 'error');
            resetTracking();
            startDetection();
            return;
        }

        // Float32Array → regular Array → JSON string
        const descriptorJSON = JSON.stringify(Array.from(detection.descriptor));

        const formData = new FormData();
        formData.append('face_descriptor', descriptorJSON);

        const response = await fetch('/cregister-face', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                // NOTE: No Content-Type header — let browser set it for FormData
            },
            body: formData
        });

        // Handle session expired (302 redirect)
        if (response.redirected) {
            document.getElementById('loadingSpinner').classList.add('hidden');
            Swal.fire('Session Expired', 'Please log in again.', 'warning').then(() => {
                window.location.href = response.url;
            });
            return;
        }

        const data = await response.json();
        document.getElementById('loadingSpinner').classList.add('hidden');

        if (data.status === 'success') {
            Swal.fire('Success!', data.message || 'Face registered successfully!', 'success').then(() => {
                modal.classList.add('hidden');
                stopCamera();
                location.reload();
            });
        } else {
            Swal.fire('Error', data.message || 'Face registration failed.', 'error');
            resetTracking();
            startDetection();
        }

    } catch (err) {
        console.error('Register error:', err);
        document.getElementById('loadingSpinner').classList.add('hidden');
        Swal.fire('Error', 'Face registration failed: ' + err.message, 'error');
    }
}

// Preload models on page load
$(document).ready(function () {
    loadModels();
});
</script>

{{-- ================= REGENERATE MY QR ================= --}}
<script>
document.getElementById('regenerateMyQrBtn').addEventListener('click', () => {
    Swal.fire({
        title: 'Regenerate your QR code?',
        text: 'A new QR will be generated. Your old QR code will no longer work.',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: 'Yes, regenerate',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (!result.isConfirmed) return;

        const btn = document.getElementById('regenerateMyQrBtn');
        btn.disabled = true;
        btn.innerHTML = 'Generating...';

        fetch('{{ route("qr.regenerate.mine") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.status === 'success') {
                const img = document.getElementById('myQrImage');
                const missing = document.getElementById('myQrMissing');
                const dl = document.getElementById('myQrDownload');
                img.src = data.qr_path;
                img.classList.remove('hidden');
                if (missing) missing.remove();
                if (dl) {
                    dl.href = data.qr_path;
                    dl.classList.remove('hidden');
                }
                Swal.fire('Done!', data.message, 'success');
            } else {
                Swal.fire('Error', data.message || 'Failed to regenerate QR.', 'error');
            }
        })
        .catch(() => {
            Swal.fire('Error', 'Failed to regenerate QR.', 'error');
        })
        .finally(() => {
            btn.disabled = false;
            btn.innerHTML = '<i class="fa-solid fa-arrows-rotate mr-1"></i> Regenerate QR';
        });
    });
});
</script>

{{-- ================= REMOVE FACE ================= --}}
<script>
document.getElementById('removeFaceToken')?.addEventListener('click', () => {
    Swal.fire({
        title: 'Are you sure?',
        text: "This will remove your registered face.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Yes, remove it!'
    }).then((result) => {
        if (result.isConfirmed) {
            fetch('/cremove-face-token', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                Swal.fire('Removed!', data.message, 'success').then(() => location.reload());
            })
            .catch(() => {
                Swal.fire('Error', 'Failed to remove face.', 'error');
            });
        }
    });
});
</script>

{{-- ================= UPDATE PROFILE ================= --}}
<script>
$('#updateProfile').submit(function (event) {
    event.preventDefault();
    $.ajax({
        type: "patch",
        url: "{{ route('updateProfile') }}",
        data: {
            email    : $('input[name="email"]').val(),
            contact  : $('input[name="contact"]').val(),
            user     : $('input[name="user"]').val(),
            password : $('input[name="password"]').val(),
        },
        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
        success: function (response) {
            Swal.fire({
                title: response.status === 'success' ? 'Success!' : 'Error!',
                text : response.message,
                icon : response.status === 'success' ? 'success' : 'error',
            });
        },
        error: function (xhr) {
            if (xhr.status === 422) {
                const errors    = xhr.responseJSON.errors;
                let errorList   = '';
                for (let field in errors) errorList += `${errors[field].join(', ')}\n`;
                Swal.fire({ icon: 'error', title: 'Validation Error', text: errorList.trim() });
            } else {
                Swal.fire({ icon: 'error', title: 'Oops...', text: 'Something went wrong!' });
            }
        }
    });
});
</script>

{{-- ================= SLIDE NAVIGATION ================= --}}
<script>
document.addEventListener('DOMContentLoaded', () => {
    const slides    = document.querySelectorAll('.medical-form-slide');
    const nextBtn   = document.getElementById('nextBtn');
    const prevBtn   = document.getElementById('prevBtn');
    const indicator = document.getElementById('slideIndicator');
    let currentSlide = 0;

    function showSlide(index) {
        slides.forEach((slide, i) => slide.classList.toggle('hidden', i !== index));
        if (indicator) indicator.textContent = `${index + 1} of ${slides.length}`;
    }

    if (nextBtn && prevBtn) {
        nextBtn.addEventListener('click', () => { currentSlide = (currentSlide + 1) % slides.length; showSlide(currentSlide); });
        prevBtn.addEventListener('click', () => { currentSlide = (currentSlide - 1 + slides.length) % slides.length; showSlide(currentSlide); });
        showSlide(currentSlide);
    }
});
</script>

@endsection
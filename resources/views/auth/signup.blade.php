@extends('layout.auth')

@section('title', 'Signup')

@section('auth-content')
<div class="p-[50px] bg-sky-100">
<form id="signupForm" method="POST" enctype="multipart/form-data" class="space-y-8">
@csrf

<h2 class="text-2xl font-bold text-sky-600 text-center">Patient Registration</h2>

<!-- STEP LABELS -->
<div class="flex justify-between items-center text-sm font-semibold text-gray-600 mb-2">
    <div class="text-center flex-1"><span>1. Personal Info</span></div>
    <div class="text-center flex-1"><span>2. Account Setup</span></div>
    <div class="text-center flex-1"><span>3. Face Registration</span></div>
    <div class="text-center flex-1"><span>4. OTP Verification</span></div>
</div>

<!-- PROGRESS BAR -->
<div class="w-full h-2 bg-gray-200 rounded">
    <div id="progressBar" class="h-full bg-blue-600 rounded transition-all duration-300" style="width:25%"></div>
</div>

<!-- ================= STEP 1 ================= -->
<div class="step" id="step-1">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <input type="hidden" name="account_type" value="patient">
        <div>
            <label>First Name</label>
            <input type="text" name="name" class="w-full border p-2 rounded" required>
        </div>
        <div>
            <label>Middle Name</label>
            <input type="text" name="middlename" class="w-full border p-2 rounded">
        </div>
        <div>
            <label>Last Name</label>
            <input type="text" name="lastname" class="w-full border p-2 rounded" required>
        </div>
        <div>
            <label>Suffix</label>
            <select name="suffix" class="w-full border p-2 rounded">
                <option value="">-- Select --</option>
                <option>Jr.</option><option>Sr.</option><option>II</option>
            </select>
        </div>
        <div>
            <label>Birthdate</label>
            <input type="date" name="birth_date" class="w-full border p-2 rounded" required>
        </div>
        <div>
            <label>Birthplace</label>
            <input type="text" name="birthplace" class="w-full border p-2 rounded" required>
        </div>
    </div>
    <div class="mt-4">
        <label>Current Address</label>
        <input type="text" name="current_address" class="w-full border p-2 rounded" required>
    </div>
</div>

<!-- ================= STEP 2 ================= -->
<div class="step hidden" id="step-2">
    <div class="space-y-4">
        <div hidden>
            <input type="file" name="verification_id" class="w-full border p-2 rounded">
        </div>
        <div>
            <label>Email</label>
            <input type="email" name="email" class="w-full border p-2 rounded" required>
        </div>
        <div>
            <label>Contact Number</label>
            <input type="number" name="contact_number" class="w-full border p-2 rounded" required>
        </div>
        <div>
            <label>Username</label>
            <input type="text" name="user" class="w-full border p-2 rounded" required>
        </div>
        <div>
            <label>Password</label>
            <input type="password" id="password" name="password" class="w-full border p-2 rounded" required>
        </div>
        <div>
            <label>Confirm Password</label>
            <input type="password" id="confirm_password" name="confirm_password" class="w-full border p-2 rounded" required>
        </div>
    </div>
</div>

<!-- ================= STEP 3 ================= -->
<div class="step hidden text-center" id="step-3">
    <p class="mb-4 font-semibold text-gray-700">Please capture your face to continue</p>

    {{--
        NO server call here. The descriptor is stored in this hidden field
        and submitted together with the rest of the form in finalSignup().
        finalSignup() validates and saves it directly to the new user record.
    --}}
    <input type="hidden" id="face_descriptor" name="face_descriptor">

    <div id="faceStatus" class="hidden mb-4">
        <span class="inline-flex items-center gap-2 text-green-600 font-semibold">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            Face captured! You may proceed.
        </span>
    </div>

    <button type="button" id="capturemodal"
        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
        Capture &amp; Register Face
    </button>
</div>

<!-- ================= STEP 4 ================= -->
<div class="step hidden" id="step-4">
    <label>Enter OTP</label>
    <input type="text" id="otp" name="otp"
        class="w-full border p-2 rounded"
        placeholder="6-digit OTP" required>
</div>

<!-- NAV BUTTONS -->
<div class="flex justify-between pt-4 border-t">
    <button type="button" class="prev hidden bg-gray-500 text-white px-6 py-2 rounded">Back</button>
    <button type="button" class="next bg-blue-600 text-white px-6 py-2 rounded">Next</button>
    <button type="submit" class="submit hidden bg-green-600 text-white px-6 py-2 rounded">Submit</button>
</div>

</form>
</div>

<!-- ================= FACE MODAL ================= -->
<div id="modal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
    <div class="bg-white p-6 rounded-xl shadow-lg w-fit">
        <h2 class="text-lg font-semibold mb-4 text-gray-800 text-center">Face Registration</h2>
        <div class="relative">
            <div class="relative inline-block" style="padding: 8px; background: linear-gradient(to right, #10b981 var(--progress, 0%), #e5e7eb var(--progress, 0%)); border-radius: 0.5rem;">
                <div class="relative inline-block">
                    <video id="video" width="320" height="240" autoplay playsinline
                        class="rounded-md block" style="width:320px;height:240px;"></video>
                    <canvas id="overlayCanvas" width="320" height="240"
                        class="absolute top-0 left-0 rounded-md pointer-events-none"
                        style="width:320px;height:240px;"></canvas>
                </div>
            </div>
        </div>
        <div class="mt-4 space-y-2">
            <div class="text-center text-xs text-gray-500"><p id="debugInfo">FPS: --</p></div>
            <div class="text-center">
                <p id="instructionText" class="text-sm font-semibold text-gray-700">
                    Move your head left and right, then open your mouth
                </p>
                <p id="progressText" class="text-xs text-gray-500 mt-1">Progress: 0%</p>
            </div>
            <div class="flex justify-center gap-4 text-xs">
                <div class="flex items-center gap-1">
                    <span id="leftIndicator" class="w-3 h-3 rounded-full bg-gray-300"></span><span>Left Turn</span>
                </div>
                <div class="flex items-center gap-1">
                    <span id="rightIndicator" class="w-3 h-3 rounded-full bg-gray-300"></span><span>Right Turn</span>
                </div>
                <div class="flex items-center gap-1">
                    <span id="mouthIndicator" class="w-3 h-3 rounded-full bg-gray-300"></span><span>Open Mouth</span>
                </div>
            </div>
        </div>
        <div class="flex justify-end mt-4">
            <button id="closemodal" type="button"
                class="bg-gray-400 hover:bg-gray-500 text-white px-3 py-2 rounded-md">Cancel</button>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
{{-- No defer: must be available synchronously --}}
<script src="https://cdn.jsdelivr.net/npm/@vladmandic/face-api/dist/face-api.min.js"></script>

<style>
    #video, #overlayCanvas { display: block; width: 320px; height: 240px; }
    #overlayCanvas { position: absolute; top: 0; left: 0; pointer-events: none; }
    .w-3.h-3.rounded-full { transition: all 0.3s ease; }
</style>

{{-- ================= STEP NAVIGATION ================= --}}
<script>
let currentStep    = 1;
const totalSteps   = 4;
let faceRegistered = false;

function showStep(step) {
    $('.step').addClass('hidden');
    $('#step-' + step).removeClass('hidden');
    $('.prev').toggleClass('hidden', step === 1);
    $('.next').toggleClass('hidden', step >= totalSteps);
    $('.submit').toggleClass('hidden', step !== totalSteps);
    $('#progressBar').css('width', `${(step / totalSteps) * 100}%`);
}

$(document).ready(function () {
    showStep(currentStep);

    $('.next').click(function () {
        // Step 2: password match check
        if (currentStep === 2) {
            if ($('#password').val() !== $('#confirm_password').val()) {
                Swal.fire('Password Mismatch', 'Passwords do not match.', 'error');
                return;
            }
            currentStep++; showStep(currentStep); return;
        }

        // Step 3: face must be captured first; then send OTP before advancing
        if (currentStep === 3) {
            if (!faceRegistered) {
                Swal.fire('Face Required', 'Please capture your face first.', 'warning');
                return;
            }
            // Send OTP now (user is not logged in, we just need their email from the form)
            Swal.fire({ title: 'Sending OTP...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });
            const otpData = new FormData($('#signupForm')[0]);
            $.ajax({
                url: '{{ route("send.otp") }}',
                method: 'POST',
                data: otpData,
                processData: false,
                contentType: false,
                success: function () {
                    Swal.close();
                    currentStep++; showStep(currentStep);
                },
                error: function (xhr) {
                    Swal.fire('Error', xhr.responseJSON?.message ?? 'Failed to send OTP.', 'error');
                }
            });
            return;
        }

        if (currentStep < totalSteps) { currentStep++; showStep(currentStep); }
    });

    $('.prev').click(function () {
        if (currentStep > 1) { currentStep--; showStep(currentStep); }
    });

    // SUBMIT: verify OTP → finalSignup (face_descriptor already in form)
    $('#signupForm').on('submit', function (e) {
        e.preventDefault();
        const otp = $('#otp').val();
        if (otp.length !== 6) { Swal.fire('Invalid OTP', 'Enter 6-digit OTP', 'warning'); return; }

        Swal.fire({ title: 'Verifying OTP...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });

        $.ajax({
            url: '{{ route("verify.otp") }}',
            method: 'GET',
            data: { otp, _token: '{{ csrf_token() }}' },
            success: function (res) {
                Swal.fire('OTP Verified', res.message, 'success').then(() => {
                    // face_descriptor is in the form — finalSignup() saves it to the new user
                    $.ajax({
                        url: '{{ route("final.signup") }}',
                        method: 'POST',
                        data: new FormData($('#signupForm')[0]),
                        processData: false,
                        contentType: false,
                        success: function (res) {
                            Swal.fire('Account Created', res.message, 'success').then(() => {
                                localStorage.clear();
                                window.location.href = "{{ route('login') }}";
                            });
                        },
                        error: function (xhr) {
                            Swal.fire('Error', xhr.responseJSON?.message ?? 'Signup failed.', 'error');
                        }
                    });
                });
            },
            error: function (xhr) {
                Swal.fire('Error', xhr.responseJSON?.message ?? 'OTP verification failed.', 'error');
            }
        });
    });
});
</script>

{{-- ================= FACE CAPTURE (client-side only, no server call) ================= --}}
<script>
let modelsLoaded     = false;
let isDetecting      = false;
let animationFrameId = null;
let captureTriggered = false;

let headMovementLeft  = false;
let headMovementRight = false;
let mouthOpened       = false;
let currentProgress   = 0;
let lastFrameTime     = Date.now();
let frameCount        = 0;
let fps               = 0;

const openBtn  = document.getElementById('capturemodal');
const modal    = document.getElementById('modal');
const closeBtn = document.getElementById('closemodal');
const video    = document.getElementById('video');
let stream     = null;

async function loadModels() {
    if (modelsLoaded) return;
    try {
        await faceapi.nets.tinyFaceDetector.loadFromUri('/models/tiny_face_detector');
        await faceapi.nets.faceLandmark68Net.loadFromUri('/models/face_landmark_68');
        await faceapi.nets.faceRecognitionNet.loadFromUri('/models/face_recognition');
        modelsLoaded = true;
        console.log('✅ All models loaded');
    } catch (err) {
        console.error('❌ Model error:', err);
        Swal.fire('Error', 'Failed to load face detection models.', 'error');
    }
}

function updateProgress() {
    let p = 0;
    if (headMovementLeft)  p += 33.33;
    if (headMovementRight) p += 33.33;
    if (mouthOpened)       p += 33.34;
    currentProgress = Math.min(100, Math.round(p));

    document.querySelector('#video').parentElement.style.setProperty('--progress', currentProgress + '%');
    document.getElementById('progressText').textContent = `Progress: ${currentProgress}%`;

    if (!headMovementLeft && !headMovementRight && !mouthOpened) {
        document.getElementById('instructionText').textContent = 'Move your head left and right, then open your mouth';
    } else if (headMovementLeft && !headMovementRight && !mouthOpened) {
        document.getElementById('instructionText').textContent = 'Now turn your head to the right';
    } else if (!headMovementLeft && headMovementRight && !mouthOpened) {
        document.getElementById('instructionText').textContent = 'Now turn your head to the left';
    } else if (headMovementLeft && headMovementRight && !mouthOpened) {
        document.getElementById('instructionText').textContent = 'Great! Now open your mouth wide';
    } else if (mouthOpened && (!headMovementLeft || !headMovementRight)) {
        document.getElementById('instructionText').textContent = !headMovementLeft
            ? 'Now turn your head to the left'
            : 'Now turn your head to the right';
    } else {
        document.getElementById('instructionText').textContent = 'Verification complete!';
    }

    document.getElementById('leftIndicator').className  = headMovementLeft  ? 'w-3 h-3 rounded-full bg-green-500' : 'w-3 h-3 rounded-full bg-yellow-400 animate-pulse';
    document.getElementById('rightIndicator').className = headMovementRight ? 'w-3 h-3 rounded-full bg-green-500' : 'w-3 h-3 rounded-full bg-yellow-400 animate-pulse';
    document.getElementById('mouthIndicator').className = mouthOpened       ? 'w-3 h-3 rounded-full bg-green-500' : 'w-3 h-3 rounded-full bg-yellow-400 animate-pulse';

    if (currentProgress === 100 && !captureTriggered) {
        captureTriggered = true;
        setTimeout(() => captureFaceLocally(), 500);
    }
}

function detectMouthOpening(landmarks) {
    const mouth = landmarks.getMouth();
    const mar   = Math.abs(mouth[19].y - mouth[13].y) / Math.abs(mouth[6].x - mouth[0].x);
    if (mar > 0.35 && !mouthOpened) { mouthOpened = true; updateProgress(); }
}

function detectHeadMovement(landmarks) {
    const nose  = landmarks.getNose();
    const jaw   = landmarks.getJawOutline();
    const ratio = (nose[3].x - jaw[0].x) / (jaw[16].x - jaw[0].x);
    if (ratio < 0.38 && !headMovementLeft)  { headMovementLeft  = true; updateProgress(); }
    if (ratio > 0.62 && !headMovementRight) { headMovementRight = true; updateProgress(); }
}

function drawBoundingBox(detection, canvas) {
    const ctx = canvas.getContext('2d');
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    if (!detection) return;
    const sx = canvas.width / video.videoWidth, sy = canvas.height / video.videoHeight;
    const b  = detection.detection.box;
    ctx.strokeStyle = '#10b981'; ctx.lineWidth = 3;
    ctx.strokeRect(b.x*sx, b.y*sy, b.width*sx, b.height*sy);
    ctx.fillStyle = 'rgba(16,185,129,0.9)';
    ctx.fillRect(b.x*sx, b.y*sy - 25, 60, 23);
    ctx.fillStyle = '#fff'; ctx.font = 'bold 14px Arial';
    ctx.fillText('FACE', b.x*sx + 8, b.y*sy - 7);
}

async function detectFaceLoop() {
    if (!isDetecting) return;
    const overlay = document.getElementById('overlayCanvas');
    frameCount++;
    const now = Date.now();
    if (now - lastFrameTime > 1000) { fps = frameCount; frameCount = 0; lastFrameTime = now; }
    document.getElementById('debugInfo').textContent = `FPS: ${fps}`;

    if (video && !video.paused && !video.ended && video.readyState === video.HAVE_ENOUGH_DATA) {
        if (overlay.width !== video.videoWidth)  overlay.width  = video.videoWidth;
        if (overlay.height !== video.videoHeight) overlay.height = video.videoHeight;
        try {
            const det = await faceapi
                .detectSingleFace(video, new faceapi.TinyFaceDetectorOptions({ inputSize: 224, scoreThreshold: 0.5 }))
                .withFaceLandmarks();
            if (det) {
                drawBoundingBox(det, overlay);
                detectHeadMovement(det.landmarks);
                detectMouthOpening(det.landmarks);
            } else {
                overlay.getContext('2d').clearRect(0, 0, overlay.width, overlay.height);
            }
        } catch (err) { console.error('Detection error:', err); }
    }
    animationFrameId = requestAnimationFrame(detectFaceLoop);
}

function startDetection() { isDetecting = true; detectFaceLoop(); }
function stopDetection() {
    isDetecting = false;
    if (animationFrameId) { cancelAnimationFrame(animationFrameId); animationFrameId = null; }
}
function stopCamera() {
    if (stream) { stream.getTracks().forEach(t => t.stop()); stream = null; }
}
function resetTracking() {
    headMovementLeft = headMovementRight = mouthOpened = false;
    currentProgress = fps = frameCount = 0;
    captureTriggered = false;
    document.getElementById('instructionText').textContent = 'Move your head left and right, then open your mouth';
    document.getElementById('progressText').textContent    = 'Progress: 0%';
    document.getElementById('debugInfo').textContent       = 'FPS: --';
    document.getElementById('leftIndicator').className     = 'w-3 h-3 rounded-full bg-gray-300';
    document.getElementById('rightIndicator').className    = 'w-3 h-3 rounded-full bg-gray-300';
    document.getElementById('mouthIndicator').className    = 'w-3 h-3 rounded-full bg-gray-300';
    document.querySelector('#video').parentElement.style.setProperty('--progress', '0%');
}

openBtn.addEventListener('click', async () => {
    modal.classList.remove('hidden');
    resetTracking();
    try {
        stream = await navigator.mediaDevices.getUserMedia({
            video: { width: { ideal: 640 }, height: { ideal: 480 }, frameRate: { ideal: 30 } }
        });
        video.srcObject = stream;
        await new Promise(resolve => { video.onloadedmetadata = () => { video.play(); resolve(); }; });
        await loadModels();
        setTimeout(() => startDetection(), 500);
    } catch (err) {
        console.error('❌ Webcam error:', err);
        Swal.fire('Error', 'Unable to access webcam.', 'error');
        modal.classList.add('hidden');
    }
});

closeBtn.addEventListener('click', () => {
    stopDetection(); modal.classList.add('hidden'); stopCamera(); resetTracking();
});

// ─────────────────────────────────────────────
// captureFaceLocally: extract descriptor and store
// in hidden field ONLY — no server call needed here.
// The descriptor travels with the form to finalSignup().
// ─────────────────────────────────────────────
async function captureFaceLocally() {
    stopDetection();
    Swal.fire({ title: 'Capturing face...', allowOutsideClick: false, didOpen: () => Swal.showLoading() });

    try {
        const detection = await faceapi
            .detectSingleFace(video, new faceapi.TinyFaceDetectorOptions({ inputSize: 224, scoreThreshold: 0.5 }))
            .withFaceLandmarks()
            .withFaceDescriptor();

        if (!detection) {
            Swal.fire('No Face Detected', 'Please try again.', 'error');
            captureTriggered = false;
            resetTracking();
            startDetection();
            return;
        }

        // Store as JSON string in the hidden field
        const descriptorJSON = JSON.stringify(Array.from(detection.descriptor));
        document.getElementById('face_descriptor').value = descriptorJSON;

        faceRegistered = true;
        document.getElementById('faceStatus').classList.remove('hidden');
        document.getElementById('capturemodal').textContent = 'Re-capture Face';

        Swal.fire('Face Captured!', 'You can now proceed to the next step.', 'success').then(() => {
            modal.classList.add('hidden');
            stopCamera();
        });

    } catch (err) {
        console.error(err);
        Swal.fire('Error', err.message || 'Face capture failed.', 'error');
        captureTriggered = false;
    }
}

$(document).ready(function () { loadModels(); });
</script>

@endsection
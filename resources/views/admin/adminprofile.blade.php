@extends('layout.navigation')

@section('title','Profile')
@section('main-content')
<h1 class="text-2xl font-bold mb-4 text-accent">My Profile</h1>

<div class="flex flex-col lg:flex-row gap-5 items-stretch">

    <!-- LEFT: Profile Card -->
    <div class="w-full lg:w-1/3 bg-white rounded-xl shadow-sm overflow-hidden flex flex-col">
        <div class="h-36 bg-gradient-to-r from-sky-400 to-primary"></div>
        <div class="px-6 -mt-10 flex flex-col items-center">
            <img src="{{ Auth::user()->profile_image ? asset('storage/profile_pictures/' . Auth::user()->profile_image) : asset('images/defaultp.jpg') }}"
                alt="Profile picture"
                class="w-24 h-24 rounded-full object-cover border-4 border-white shadow bg-white">
            <h2 class="mt-3 text-lg font-bold text-gray-800 text-center">{{ Auth::user()->name }} {{ Auth::user()->lastname }}</h2>
            <span class="text-xs px-2 py-0.5 mt-1 rounded-full bg-sky-50 text-primary font-medium capitalize">{{ Auth::user()->position ?: Auth::user()->account_type }}</span>
        </div>

        <div class="flex flex-col gap-4 mt-4 px-6 pb-6">
            <form class="flex flex-col gap-4" method="POST" action="{{ route('profile.upload') }}" enctype="multipart/form-data">
                @csrf
                <div>
                    <label for="fname" class="block text-sm font-medium text-gray-700 mb-1">Name</label>
                    <input type="text" name="fname" id="fname"
                        class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-600"
                        value="{{ Auth::user()->lastname }}, {{ Auth::user()->name }} {{ Auth::user()->middlename }} {{ Auth::user()->suffix }}" readonly>
                </div>
                <div>
                    <label for="bday" class="block text-sm font-medium text-gray-700 mb-1">Birth Day</label>
                    <input type="date" name="bday" id="bday"
                        class="w-full bg-gray-50 border border-gray-200 rounded-lg px-3 py-2 text-sm text-gray-600"
                        value="{{ Auth::user()->birth_date }}" readonly>
                </div>
                <div>
                    <label for="profile_image" class="block text-sm font-medium text-gray-700 mb-1">Upload Profile Picture</label>
                    <input type="file" name="profile_image" id="profile_image" accept="image/*"
                        class="w-full text-sm text-gray-600 border border-gray-200 rounded-lg cursor-pointer file:mr-3 file:py-2 file:px-3 file:border-0 file:bg-sky-50 file:text-sky-700 file:text-sm file:font-medium hover:file:bg-sky-100">
                </div>
                <button type="submit" class="bg-primary hover:bg-sky-700 text-white text-sm font-medium px-4 py-2 rounded-lg transition self-start">
                    <i class="fa-solid fa-upload mr-1"></i> Upload
                </button>
            </form>
        </div>
    </div>

    <!-- RIGHT: QR + Face Recognition + Account Settings -->
    <div class="w-full lg:w-2/3 flex flex-col gap-5">
        <div class="flex flex-col md:flex-row gap-5">

            <!-- QR Code Card -->
            <div class="flex-1 bg-white rounded-xl shadow-sm p-5">
                <h3 class="flex items-center gap-2 text-sm font-semibold text-gray-800 border-b border-gray-100 pb-3 mb-4">
                    <i class="fa-solid fa-qrcode text-primary"></i> My QR Code
                </h3>
                <div class="flex flex-col items-center justify-center gap-3">
                    @php
                        $myQrPath = Auth::user()->qr_code ? 'qr_codes/' . Auth::user()->qr_code : null;
                        $myQrExists = $myQrPath && \Illuminate\Support\Facades\Storage::disk('public')->exists($myQrPath);
                    @endphp
                    @if($myQrExists)
                        <a id="myQrDownload" href="{{ asset('storage/qr_codes/' . Auth::user()->qr_code) }}" download="qr_code.png" class="flex flex-col items-center">
                            <img id="myQrImage" src="{{ asset('storage/qr_codes/' . Auth::user()->qr_code) }}" alt="QR Code"
                                class="w-32 h-32 object-contain border border-gray-200 p-2 rounded-lg hover:opacity-80" />
                            <p class="text-primary text-sm mt-2 text-center hover:underline">Download QR Code</p>
                        </a>
                    @else
                        <a id="myQrDownload" href="#" download="qr_code.png" class="flex-col items-center hidden">
                            <img id="myQrImage" src="" alt="QR Code" class="w-32 h-32 object-contain border border-gray-200 p-2 rounded-lg" />
                            <p class="text-primary text-sm mt-2 text-center hover:underline">Download QR Code</p>
                        </a>
                        <div id="myQrMissing" class="w-32 h-32 flex items-center justify-center border border-dashed border-red-400 text-red-600 text-xs text-center px-2 rounded-lg">
                            QR file is missing.<br>Click "Regenerate QR" below.
                        </div>
                    @endif
                    <button id="regenerateMyQrBtn" type="button"
                        class="inline-flex items-center justify-center border border-orange-300 text-orange-600 hover:bg-orange-50 px-4 py-2 rounded-lg text-sm font-medium transition">
                        <i class="fa-solid fa-arrows-rotate mr-1"></i> Regenerate QR
                    </button>
                </div>
            </div>

            <!-- Face Recognition Card -->
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

                <div id="loadingSpinner" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-[9999]">
                    <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-b-4 border-sky-500"></div>
                </div>

                @php $hasFace = Auth::user()->face_descriptor !== null && Auth::user()->face_descriptor !== ""; @endphp

                <div class="flex flex-col items-center justify-center flex-1 text-center gap-3 py-4">
                    @if($hasFace)
                        <span class="w-14 h-14 rounded-full bg-green-100 text-green-600 flex items-center justify-center">
                            <i class="fa-solid fa-check text-xl"></i>
                        </span>
                        <p class="text-sm text-gray-600">Your face is registered for login.</p>
                    @else
                        <span class="w-14 h-14 rounded-full bg-sky-50 text-sky-500 flex items-center justify-center">
                            <i class="fa-solid fa-camera text-xl"></i>
                        </span>
                        <p class="text-sm text-gray-600">Register your face to log in using face recognition.</p>
                    @endif
                    <button id="capturemodal" class="px-4 py-2 bg-primary hover:bg-sky-700 text-white rounded-lg text-sm font-medium transition">
                        <i class="fa-solid fa-camera mr-1"></i> {{ $hasFace ? 'Re-capture Face' : 'Capture & Register' }}
                    </button>
                </div>

                <!-- Modal: guided face capture (same flow as patient registration) -->
                <div id="modal" class="fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 hidden z-50">
                    <div class="bg-white p-6 rounded-xl shadow-lg w-fit">
                        <h2 class="text-lg font-semibold mb-4 text-gray-800 text-center">Face Registration</h2>

                        <div class="relative inline-block" style="padding: 8px; background: linear-gradient(to right, #10b981 var(--progress, 0%), #e5e7eb var(--progress, 0%)); border-radius: 0.5rem;">
                            <div class="relative inline-block">
                                <video id="video" width="320" height="240" autoplay playsinline
                                    class="rounded-md block" style="width:320px;height:240px;"></video>
                                <canvas id="overlayCanvas" width="320" height="240"
                                    class="absolute top-0 left-0 rounded-md pointer-events-none"
                                    style="width:320px;height:240px;"></canvas>
                            </div>
                        </div>

                        <div class="mt-4 space-y-2">
                            <div class="text-center text-xs text-gray-500"><p id="debugInfo">FPS: --</p></div>
                            <div class="text-center">
                                <p id="instructionText" class="text-sm font-semibold text-gray-700">
                                    Move your head left and right
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
                            </div>
                        </div>

                        <div class="flex justify-end mt-4">
                            <button id="closemodal" type="button"
                                class="bg-gray-400 hover:bg-gray-500 text-white px-3 py-2 rounded-md text-sm">Cancel</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Account Settings Card -->
        <div class="bg-white rounded-xl shadow-sm p-5">
            <h3 class="flex items-center gap-2 text-sm font-semibold text-gray-800 border-b border-gray-100 pb-3 mb-4">
                <i class="fa-solid fa-user-gear text-primary"></i> Account Settings
            </h3>
            <form id="updateProfile" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <input type="text" name="email" id="email"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500"
                        value="{{ Auth::user()->email }}">
                </div>
                <div>
                    <label for="contact" class="block text-sm font-medium text-gray-700 mb-1">Contact Number</label>
                    <input type="number" name="contact" id="contact"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500"
                        value="{{ Auth::user()->contact_number }}">
                </div>
                <div>
                    <label for="user" class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                    <input type="text" name="user" id="user"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500"
                        value="{{ Auth::user()->user }}">
                </div>
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">New Password</label>
                    <input type="password" name="password" id="password"
                        class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-sky-500"
                        placeholder="Leave blank to keep current password">
                </div>
                <div class="md:col-span-2 flex justify-end">
                    <button class="bg-primary hover:bg-sky-700 text-white text-sm font-medium px-6 py-2 rounded-lg transition" type="submit">
                        <i class="fa-solid fa-floppy-disk mr-1"></i> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
{{-- No defer: must be available synchronously --}}
<script src="https://cdn.jsdelivr.net/npm/@vladmandic/face-api/dist/face-api.min.js"></script>

<style>
    #video, #overlayCanvas { display: block; width: 320px; height: 240px; }
    #overlayCanvas { position: absolute; top: 0; left: 0; pointer-events: none; }
</style>

{{-- =========================================================================
     GUIDED FACE CAPTURE — same flow as patient registration.
     FIX: dati nagpapadala ito ng JPEG (face_image) pero 128-value na
     face_descriptor ang hinihingi ng /register-face, kaya laging
     "Failed to register face".
     ========================================================================= --}}
<script>
let modelsLoaded     = false;
let isDetecting      = false;
let animationFrameId = null;
let captureTriggered = false;

let headMovementLeft  = false;
let headMovementRight = false;
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
    } catch (err) {
        console.error('Model error:', err);
        Swal.fire('Error', 'Failed to load face detection models.', 'error');
    }
}

function updateProgress() {
    let p = 0;
    if (headMovementLeft)  p += 50;
    if (headMovementRight) p += 50;
    currentProgress = Math.min(100, Math.round(p));

    video.parentElement.parentElement.style.setProperty('--progress', currentProgress + '%');
    document.getElementById('progressText').textContent = `Progress: ${currentProgress}%`;

    const instruction = document.getElementById('instructionText');
    if (!headMovementLeft && !headMovementRight) {
        instruction.textContent = 'Move your head left and right';
    } else if (headMovementLeft && !headMovementRight) {
        instruction.textContent = 'Now turn your head to the right';
    } else if (!headMovementLeft && headMovementRight) {
        instruction.textContent = 'Now turn your head to the left';
    } else {
        instruction.textContent = 'Verification complete!';
    }

    document.getElementById('leftIndicator').className  = headMovementLeft  ? 'w-3 h-3 rounded-full bg-green-500' : 'w-3 h-3 rounded-full bg-yellow-400 animate-pulse';
    document.getElementById('rightIndicator').className = headMovementRight ? 'w-3 h-3 rounded-full bg-green-500' : 'w-3 h-3 rounded-full bg-yellow-400 animate-pulse';

    if (currentProgress === 100 && !captureTriggered) {
        captureTriggered = true;
        setTimeout(() => captureAndRegisterFace(), 500);
    }
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
    headMovementLeft = headMovementRight = false;
    currentProgress = fps = frameCount = 0;
    captureTriggered = false;
    document.getElementById('instructionText').textContent = 'Move your head left and right';
    document.getElementById('progressText').textContent    = 'Progress: 0%';
    document.getElementById('debugInfo').textContent       = 'FPS: --';
    document.getElementById('leftIndicator').className     = 'w-3 h-3 rounded-full bg-gray-300';
    document.getElementById('rightIndicator').className    = 'w-3 h-3 rounded-full bg-gray-300';
    video.parentElement.parentElement.style.setProperty('--progress', '0%');
}

openBtn.addEventListener('click', async () => {
    modal.classList.remove('hidden');
    resetTracking();

    if (!window.isSecureContext) {
        Swal.fire('Not Secure', 'Camera access requires HTTPS. Please open the site over a secure connection.', 'error');
        modal.classList.add('hidden');
        return;
    }

    try {
        stream = await navigator.mediaDevices.getUserMedia({
            video: { width: { ideal: 640 }, height: { ideal: 480 }, frameRate: { ideal: 30 } }
        });
        video.srcObject = stream;
        await new Promise(resolve => { video.onloadedmetadata = () => { video.play(); resolve(); }; });
        await loadModels();
        setTimeout(() => startDetection(), 500);
    } catch (err) {
        console.error('Webcam error:', err);
        Swal.fire('Error', 'Unable to access webcam.', 'error');
        modal.classList.add('hidden');
    }
});

closeBtn.addEventListener('click', () => {
    stopDetection(); modal.classList.add('hidden'); stopCamera(); resetTracking();
});

async function captureAndRegisterFace() {
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

        // Ipadala ang 128-value descriptor (ito ang hinihingi ng /register-face)
        const descriptorJSON = JSON.stringify(Array.from(detection.descriptor));

        const res = await fetch('/register-face', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ face_descriptor: descriptorJSON })
        });

        const data = await res.json().catch(() => ({}));

        if (!res.ok || data.status === 'error') {
            const msg = data.message
                || Object.values(data.errors || {}).flat()[0]
                || 'Failed to register face.';
            Swal.fire('Error', msg, 'error');
            captureTriggered = false;
            resetTracking();
            startDetection();
            return;
        }

        modal.classList.add('hidden');
        stopCamera();

        Swal.fire('Success!', data.message || 'Face registered successfully!', 'success')
            .then(() => location.reload());

    } catch (err) {
        console.error(err);
        Swal.fire('Error', err.message || 'Face capture failed.', 'error');
        captureTriggered = false;
    }
}

document.addEventListener('DOMContentLoaded', loadModels);
</script>


<script>
    ///update profile
    $('#updateProfile').submit(function (event) {
        event.preventDefault();
        var formData = {
                       
                        email : $('input[name="email"]').val(),
                       
                        contact : $('input[name="contact"]').val(),
                        user : $('input[name="user"]').val(),
                        password : $('input[name="password"]').val(),
                      

                    }
       $.ajax({
            type: "patch",
            url: "{{route('updateProfile')}}",
            data:formData,
            headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
            success: function (response) {
                if (response.status == 'success') {
                    Swal.fire({
                                title: 'Success!',
                                text: response.message,
                                icon: 'success',
                              
                            })
                } else {
                    Swal.fire({
                                title: 'Error!',
                                text: response.message,
                                icon: 'error',
                              
                            })
                }
            }, error: function (xhr) {
        if (xhr.status === 422) {
            const errors = xhr.responseJSON.errors;
            let errorList = '';

            for (let field in errors) {
                errorList += `${errors[field].join(', ')}\n`;
            }

            Swal.fire({
                icon: 'error',
                title: 'Validation Error',
                text: errorList.trim(),
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Something went wrong!',
            });
        }
    }
        });
    })


    ///regenerate QR
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
                    const dl = document.getElementById('myQrDownload');
                    const missing = document.getElementById('myQrMissing');
                    if (img) img.src = data.qr_path;
                    if (dl) {
                        dl.href = data.qr_path;
                        dl.classList.remove('hidden');
                        dl.classList.add('flex');
                    }
                    if (missing) missing.remove();
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

    ///remove face token
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
                fetch('/remove-face-token', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    Swal.fire('Removed!', data.message, 'success').then(() => {
                        location.reload(); // Optional: refresh to reflect change
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error', 'Failed to remove face token.', 'error');
                });
            }
        });
    });
    </script>

@endsection
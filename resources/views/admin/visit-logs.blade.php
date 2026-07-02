@extends('layout.navigation')

@section('title','Logs')
@section('main-content')
<div class="w-full max-w-5xl mx-auto p-6 bg-white shadow rounded-md">

    <!-- Tabs Header -->
    <div class="flex space-x-4 border-b mb-6">
        <button class="tab-button py-2 px-4 text-gray-600 border-b-2 border-transparent hover:text-blue-500" data-tab="logs-tab">
            Visit Logs
        </button>
        <button class="tab-button py-2 px-4 text-gray-600 border-b-2 border-transparent hover:text-blue-500" data-tab="scan-tab">
            Scan QR
        </button>
        <button class="tab-button py-2 px-4 text-gray-600 border-b-2 border-transparent hover:text-blue-500" data-tab="face-tab">
            Face Recognition
        </button>
    </div>

    <!-- Visit Logs Tab -->
    <div id="logs-tab" class="tab-content">
        <form method="GET" action="{{ route('logs') }}" class="mb-4">
            <label for="date" class="text-sm font-medium">Filter by date:</label>
            <input type="date" id="date" name="date" value="{{ $date }}" class="border px-2 py-1 rounded">
            <button type="submit" class="bg-blue-500 text-white px-3 py-1 rounded ml-2">Filter</button>
        </form>

        <div class="overflow-x-auto">
            <table class="w-full border text-sm text-left">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-4 py-2">User</th>
                        <th class="border px-4 py-2">Logged at Branch</th>
                        <th class="border px-4 py-2">Scanned At</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($logs as $log)
                        <tr>
                            <td class="border px-4 py-2">{{ $log->user->name ?? 'N/A' }}</td>
                            <td class="border px-4 py-2">
                                @if($log->store)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                                        </svg>
                                        {{ $log->store->name }}
                                    </span>
                                @elseif($log->appointment && $log->appointment->store)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                                        </svg>
                                        {{ $log->appointment->store->name }}
                                    </span>
                                @else
                                    <span class="text-gray-400">N/A</span>
                                @endif
                            </td>
                            <td class="border px-4 py-2">{{ \Carbon\Carbon::parse($log->scanned_at)->format('F j, Y g:i A') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="border px-4 py-2 text-center text-gray-500">No logs found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Scan QR Tab -->
    <div id="scan-tab" class="tab-content hidden">
        <div class="text-gray-700 text-sm">
            <h2 class="font-bold text-lg mb-4">Scan QR to Log Visit</h2>
            <div id="reader" style="width: 100%; max-width: 500px;"></div>
        </div>
    </div>

    <!-- Face Recognition Tab -->
    <div id="face-tab" class="tab-content hidden">
        <div class="text-gray-700">
            <h2 class="font-bold text-lg mb-4">Face Recognition to Log Visit</h2>

            <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-4">
                <p class="text-sm text-blue-800">
                    <strong>Instructions:</strong> Click the button below to start face recognition.
                    The system will automatically identify you and log your visit.
                </p>
            </div>

            <form id="faceLoginForm" method="post" class="flex flex-col gap-5 max-w-md">
                @csrf
                <div class="flex justify-center">
                    <button type="button" onclick="openFaceModal()"
                        class="bg-green-500 hover:bg-green-600 text-white font-medium rounded-md px-8 py-3 transition duration-150 text-lg">
                        Start Face Recognition
                    </button>
                </div>
            </form>

            <!-- Face Recognition Modal -->
            <div id="faceModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
                <div class="bg-white p-6 rounded-xl shadow-lg w-fit">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800 text-center">Face Recognition</h3>

                    <div class="relative">
                        <div class="relative inline-block" style="padding: 8px; background: linear-gradient(to right, #10b981 var(--progress, 0%), #e5e7eb var(--progress, 0%)); border-radius: 0.5rem;">
                            <div class="relative inline-block">
                                <video id="faceVideo" width="320" height="240" autoplay playsinline
                                    class="rounded-md block" style="width: 320px; height: 240px;"></video>
                                <canvas id="overlayCanvas" width="320" height="240"
                                    class="absolute top-0 left-0 rounded-md pointer-events-none"
                                    style="width: 320px; height: 240px;"></canvas>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4 space-y-2">
                        <div class="text-center text-xs text-gray-500">
                            <p id="faceDebugInfo">FPS: --</p>
                        </div>
                        <div class="text-center">
                            <p id="faceInstructionText" class="text-sm font-semibold text-gray-700">
                                Move your head left and right
                            </p>
                            <p id="faceProgressText" class="text-xs text-gray-500 mt-1">Progress: 0%</p>
                        </div>
                        <div class="flex justify-center gap-4 text-xs">
                            <div class="flex items-center gap-1">
                                <span id="faceLeftIndicator" class="w-3 h-3 rounded-full bg-gray-300"></span>
                                <span>Left Turn</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <span id="faceRightIndicator" class="w-3 h-3 rounded-full bg-gray-300"></span>
                                <span>Right Turn</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <button onclick="closeFaceModal()" type="button"
                            class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-md">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>

            <!-- Loader -->
            <div id="faceLoadingSpinner" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-[9999]">
                <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-b-4 border-blue-500"></div>
            </div>
        </div>
    </div>
</div>

<style>
    #faceVideo, #overlayCanvas {
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
    .w-3.h-3.rounded-full { transition: all 0.3s ease; }
</style>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/html5-qrcode"></script>
<script defer src="https://cdn.jsdelivr.net/npm/@vladmandic/face-api/dist/face-api.min.js"></script>

{{-- ================= TAB SWITCH ================= --}}
<script>
document.querySelectorAll('.tab-button').forEach(button => {
    button.addEventListener('click', () => {
        const tab = button.getAttribute('data-tab');
        document.querySelectorAll('.tab-content').forEach(c => c.classList.add('hidden'));
        document.getElementById(tab).classList.remove('hidden');
        document.querySelectorAll('.tab-button').forEach(b => b.classList.remove('text-blue-500', 'border-blue-500'));
        button.classList.add('text-blue-500', 'border-blue-500');
    });
});
document.querySelector('.tab-button').click();
</script>

{{-- ================= QR SCANNER ================= --}}
<script>
function onScanSuccess(qrMessage) {
    fetch("{{ route('scan.qr') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ qr_token: qrMessage })
    })
    .then(res => res.json())
    .then(data => {
        if (data.status === 'warning') {
            Swal.fire({ title: 'Already Logged', text: data.message, icon: 'warning' });
            return;
        }
        if (data.status === 'error') {
            Swal.fire({ title: 'Error', text: data.message, icon: 'error' });
            return;
        }

        const appointmentDetails = data.appointment
            ? `<div class="text-left mt-2 text-sm">
                <p><strong>Name:</strong> ${data.appointment.name}</p>
                <p><strong>Branch:</strong> ${data.appointment.branch}</p>
                <p><strong>Time:</strong> ${data.appointment.time}</p>
                <p><strong>Status:</strong> <span style="color:#16a34a;font-weight:600">${data.appointment.status}</span></p>
               </div>`
            : `<p style="font-size:0.875rem;color:#6b7280;margin-top:0.5rem">No appointment found for today.</p>`;

        Swal.fire({
            title: 'Visit Logged!',
            html: `<p>${data.message}</p>${appointmentDetails}`,
            icon: 'success'
        }).then(() => window.location.href = "{{ route('logs') }}");
    })
    .catch(() => Swal.fire({ title: 'Error', text: 'Something went wrong while scanning.', icon: 'error' }));
}

const html5QrcodeScanner = new Html5QrcodeScanner("reader", { fps: 10, qrbox: 250 });
html5QrcodeScanner.render(onScanSuccess);
</script>

{{-- ================= FACE RECOGNITION ================= --}}
<script>
let faceModelsLoaded      = false;
let isFaceDetecting       = false;
let faceAnimationFrameId  = null;

// Liveness tracking
let faceHeadMovementLeft  = false;
let faceHeadMovementRight = false;
let faceCurrentProgress   = 0;

// FPS tracking
let faceLastFrameTime = Date.now();
let faceFrameCount    = 0;
let faceFps           = 0;

// ─────────────────────────────────────────────
// Load models — faceRecognitionNet required!
// ─────────────────────────────────────────────
async function loadFaceModels() {
    if (faceModelsLoaded) return;
    try {
        await faceapi.nets.tinyFaceDetector.loadFromUri('/models/tiny_face_detector');
        await faceapi.nets.faceLandmark68Net.loadFromUri('/models/face_landmark_68');
        await faceapi.nets.faceRecognitionNet.loadFromUri('/models/face_recognition'); // ← needed for descriptor
        faceModelsLoaded = true;
        console.log('✅ Face models loaded');
    } catch (err) {
        console.error('❌ Model loading error:', err);
        Swal.fire('Error', 'Failed to load face detection models.', 'error');
    }
}

// ─────────────────────────────────────────────
// Liveness progress UI
// ─────────────────────────────────────────────
function updateFaceProgress() {
    let progress = 0;
    if (faceHeadMovementLeft)  progress += 50;
    if (faceHeadMovementRight) progress += 50;
    faceCurrentProgress = Math.min(100, Math.round(progress));

    document.querySelector('#faceVideo').parentElement.style.setProperty('--progress', faceCurrentProgress + '%');
    document.getElementById('faceProgressText').textContent = `Progress: ${faceCurrentProgress}%`;

    if (!faceHeadMovementLeft && !faceHeadMovementRight) {
        document.getElementById('faceInstructionText').textContent = 'Move your head left and right';
    } else if (faceHeadMovementLeft && !faceHeadMovementRight) {
        document.getElementById('faceInstructionText').textContent = 'Now turn your head to the right';
    } else if (!faceHeadMovementLeft && faceHeadMovementRight) {
        document.getElementById('faceInstructionText').textContent = 'Now turn your head to the left';
    } else {
        document.getElementById('faceInstructionText').textContent = 'Verification complete! Identifying...';
    }

    document.getElementById('faceLeftIndicator').className  = faceHeadMovementLeft  ? 'w-3 h-3 rounded-full bg-green-500' : 'w-3 h-3 rounded-full bg-yellow-400 animate-pulse';
    document.getElementById('faceRightIndicator').className = faceHeadMovementRight ? 'w-3 h-3 rounded-full bg-green-500' : 'w-3 h-3 rounded-full bg-yellow-400 animate-pulse';

    if (faceCurrentProgress === 100) {
        setTimeout(() => submitFaceRecognition(), 500);
    }
}

function detectFaceHeadMovement(landmarks) {
    const nose     = landmarks.getNose();
    const jawline  = landmarks.getJawOutline();
    const noseTip  = nose[3];
    const leftJaw  = jawline[0];
    const rightJaw = jawline[16];
    const noseRatio = (noseTip.x - leftJaw.x) / (rightJaw.x - leftJaw.x);

    if (noseRatio < 0.38 && !faceHeadMovementLeft) {
        faceHeadMovementLeft = true;
        console.log('✅ HEAD LEFT | Ratio:', noseRatio.toFixed(3));
        updateFaceProgress();
    }
    if (noseRatio > 0.62 && !faceHeadMovementRight) {
        faceHeadMovementRight = true;
        console.log('✅ HEAD RIGHT | Ratio:', noseRatio.toFixed(3));
        updateFaceProgress();
    }
}

function drawFaceBoundingBox(detection, canvas) {
    const video  = document.getElementById('faceVideo');
    const ctx    = canvas.getContext('2d');
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    if (!detection) return;

    const scaleX = canvas.width  / video.videoWidth;
    const scaleY = canvas.height / video.videoHeight;
    const box    = detection.detection.box;

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
    if (!isFaceDetecting) return;

    const video  = document.getElementById('faceVideo');
    const canvas = document.getElementById('overlayCanvas');

    faceFrameCount++;
    const now = Date.now();
    if (now - faceLastFrameTime > 1000) {
        faceFps = faceFrameCount; faceFrameCount = 0; faceLastFrameTime = now;
    }
    document.getElementById('faceDebugInfo').textContent = `FPS: ${faceFps}`;

    if (video && !video.paused && !video.ended && video.readyState === video.HAVE_ENOUGH_DATA) {
        if (canvas.width !== video.videoWidth || canvas.height !== video.videoHeight) {
            canvas.width = video.videoWidth; canvas.height = video.videoHeight;
        }
        try {
            const detection = await faceapi
                .detectSingleFace(video, new faceapi.TinyFaceDetectorOptions({ inputSize: 224, scoreThreshold: 0.5 }))
                .withFaceLandmarks();

            if (detection) {
                drawFaceBoundingBox(detection, canvas);
                detectFaceHeadMovement(detection.landmarks);
            } else {
                canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);
            }
        } catch (err) {
            console.error('Detection error:', err);
        }
    }

    faceAnimationFrameId = requestAnimationFrame(detectFaceLoop);
}

function startFaceDetection() { isFaceDetecting = true;  detectFaceLoop(); }
function stopFaceDetection()  {
    isFaceDetecting = false;
    if (faceAnimationFrameId) { cancelAnimationFrame(faceAnimationFrameId); faceAnimationFrameId = null; }
}

function resetFaceTracking() {
    faceHeadMovementLeft = faceHeadMovementRight = false;
    faceCurrentProgress = faceFps = faceFrameCount = 0;
    document.getElementById('faceInstructionText').textContent = 'Move your head left and right';
    document.getElementById('faceProgressText').textContent    = 'Progress: 0%';
    document.getElementById('faceDebugInfo').textContent       = 'FPS: --';
    document.getElementById('faceLeftIndicator').className     = 'w-3 h-3 rounded-full bg-gray-300';
    document.getElementById('faceRightIndicator').className    = 'w-3 h-3 rounded-full bg-gray-300';
    document.querySelector('#faceVideo').parentElement.style.setProperty('--progress', '0%');
}

// ─────────────────────────────────────────────
// Open / Close modal
// ─────────────────────────────────────────────
async function openFaceModal() {
    document.getElementById('faceModal').classList.remove('hidden');
    resetFaceTracking();

    try {
        const stream = await navigator.mediaDevices.getUserMedia({
            video: { width: { ideal: 640 }, height: { ideal: 480 }, frameRate: { ideal: 30 } }
        });
        const video = document.getElementById('faceVideo');
        video.srcObject = stream;

        await new Promise(resolve => {
            video.onloadedmetadata = () => { video.play(); resolve(); };
        });

        console.log('📹 Camera ready:', video.videoWidth, 'x', video.videoHeight);
        await loadFaceModels();
        setTimeout(() => startFaceDetection(), 500);

    } catch (err) {
        console.error('❌ Webcam error:', err);
        Swal.fire('Error', 'Unable to access webcam.', 'error');
        closeFaceModal();
    }
}

function closeFaceModal() {
    stopFaceDetection();
    document.getElementById('faceModal').classList.add('hidden');
    const video = document.getElementById('faceVideo');
    if (video.srcObject) {
        video.srcObject.getTracks().forEach(t => t.stop());
        video.srcObject = null;
    }
    resetFaceTracking();
}

// ─────────────────────────────────────────────
// Submit: extract descriptor → send to server
// ─────────────────────────────────────────────
async function submitFaceRecognition() {
    stopFaceDetection();
    document.getElementById('faceLoadingSpinner').classList.remove('hidden');

    try {
        const video = document.getElementById('faceVideo');

        // Extract 128-value face descriptor
        const detection = await faceapi
            .detectSingleFace(video, new faceapi.TinyFaceDetectorOptions({ inputSize: 224, scoreThreshold: 0.5 }))
            .withFaceLandmarks()
            .withFaceDescriptor(); // ← descriptor, not image

        if (!detection) {
            document.getElementById('faceLoadingSpinner').classList.add('hidden');
            Swal.fire('No Face Detected', 'Please position your face and try again.', 'warning');
            resetFaceTracking();
            startFaceDetection();
            return;
        }

        // Float32Array → plain Array → JSON string
        const descriptorJSON = JSON.stringify(Array.from(detection.descriptor));

        $.ajax({
            type: 'POST',
            url: '{{ route('scan.face') }}',
            data: {
                face_descriptor : descriptorJSON,
                _token          : '{{ csrf_token() }}'
            },
            success: function (response) {
                document.getElementById('faceLoadingSpinner').classList.add('hidden');

                if (response.status === 'warning') {
                    Swal.fire({ title: 'Already Logged', text: response.message, icon: 'warning' })
                        .then(() => window.location.href = response.redirect ?? "{{ route('logs') }}");
                    return;
                }

                if (response.status === 'error') {
                    Swal.fire('Error', response.message, 'error');
                    closeFaceModal();
                    return;
                }

                // success
                const appointmentDetails = response.appointment
                    ? `<div style="text-align:left;margin-top:0.5rem;font-size:0.875rem">
                            <p><strong>Branch:</strong> ${response.appointment.branch}</p>
                            <p><strong>Time:</strong> ${response.appointment.time}</p>
                            <p><strong>Status:</strong> <span style="color:#16a34a;font-weight:600">${response.appointment.status}</span></p>
                       </div>`
                    : `<p style="font-size:0.875rem;color:#6b7280;margin-top:0.5rem">No appointment found for today.</p>`;

                Swal.fire({
                    title: 'Visit Logged!',
                    html: `<strong>${response.user_name}</strong><br><p>${response.message}</p>${appointmentDetails}`,
                    icon: 'success'
                }).then(() => window.location.href = response.redirect);
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                document.getElementById('faceLoadingSpinner').classList.add('hidden');
                const msg = xhr.responseJSON?.message || 'Face recognition failed. Please try again.';
                Swal.fire('Error', msg, 'error');
                closeFaceModal();
            }
        });

    } catch (err) {
        console.error('submitFaceRecognition error:', err);
        document.getElementById('faceLoadingSpinner').classList.add('hidden');
        Swal.fire('Error', 'Something went wrong: ' + err.message, 'error');
        closeFaceModal();
    }
}

// Preload models on page load
$(document).ready(function () {
    loadFaceModels();
});
</script>
@endsection
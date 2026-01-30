@extends('layout.cnav')

@section('title','CProfile')
@section('main-content')
<style>
    input{
        border: 1px;
        background-color:#F5F5F5;
        padding: 2px;
    }
    
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
            <button class="tab-button border-b-2 border-transparent py-2 px-4 hover:text-blue-600 hover:border-blue-600 active"
                data-tab="profile-tab">Profile</button>
        </li>
        <li>
                    <button
                        class="tab-button border-b-2 border-transparent py-2 px-4 hover:text-blue-600 hover:border-blue-600"
                        data-tab="medical-tab">Patient Information</button>
                </li>
                <li>
                    <button
                        class="tab-button border-b-2 border-transparent py-2 px-4 hover:text-blue-600 hover:border-blue-600"
                        data-tab="chart-tab">Dental Chart</button>
                </li>
                <li>
                    <button
                        class="tab-button border-b-2 border-transparent py-2 px-4 hover:text-blue-600 hover:border-blue-600"
                        data-tab="record-tab">Treatment Record</button>
                </li>
                <li>
                    <button
                        class="tab-button border-b-2 border-transparent py-2 px-4 hover:text-blue-600 hover:border-blue-600"
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

<div id="consent-tab" class="tab-content hidden">
    @include('client.consentpage')
</div>

<div id="profile-tab" class="tab-content">
<div class="flex flex-col h-full ">
<div class="flex flex-row h-full  gap-5">
    <div class=" rounded-md flex flex-col w-[30%] bg-white">
        @if (Auth::user()->profile_image == null)
        <div class="basis-[30%] bg-cover bg-no-repeat bg-center bg-[url({{ asset('images/defaultp.jpg') }})]  ">
        @else
        <div class="basis-[30%] bg-cover bg-no-repeat bg-center bg-[url({{ asset('storage/profile_pictures/' . Auth::user()->profile_image) }})]  ">
        @endif
      
            
        </div>
        <div class="basis-[70%] flex flex-col p-5 overflow-y-auto">
            <form class="flex flex-col gap-3" method="POST" action="{{ route('profile.upload') }}" enctype="multipart/form-data">
                @csrf
        
                <label for="fname">Name:</label>
                <input type="text" name="fname" id="fname"
                    value="{{ Auth::user()->lastname }}, {{ Auth::user()->name }} {{ Auth::user()->middlename }} {{ Auth::user()->suffix }}"
                    readonly>
        
                <label for="bday">Birth Day:</label>
                <input type="date" name="bday" id="bday" value="{{ Auth::user()->birth_date }}" readonly>
        
                <label for="profile_picture">Upload Profile Picture:</label>
                <input type="file" name="profile_image" id="profile_image" accept="image/*" class="p-2 border rounded">
        
                <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded mt-3 w-max">Upload</button>
            </form>
        </div>
    </div>
    <div class="flex flex-col  basis-[70%] gap-5">
        <div class=" rounded-md grow-1 bg-white flex flex-row gap-3 p-5">
         <div class="basis-[50%] border">
              <div class="flex flex-col justify-center m-3 items-center">
                <img src="{{ asset('storage/qr_codes/' . Auth::user()->qr_code) }}" alt="User QR Code" class="mx-auto w-40 h-40 object-contain border p-2 rounded" />
                <a href="{{ asset('storage/qr_codes/' . Auth::user()->qr_code) }}" download
                   class="mt-4 inline-block bg-[#f84525] text-white px-4 py-2 rounded hover:bg-red-700 transition duration-200">
                    Download QR Code
                </a>
              </div>
            </div>
            <div class="basis-[50%] border flex flex-col">
                <div class="flex flex-row justify-between m-3">
                   
                    <p>Face Recognition</p><button id="removeFaceToken" class="bg-[#FF0000] p-1 rounded-sm text-white">Remove</button>
                </div>
              
                <div id="loadingSpinner" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-[9999]">
                    <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-b-4 border-blue-500"></div>
                </div>
               
                <br>
                @if(Auth::user()->face_token !== null && Auth::user()->face_token !== "")
                <button id="capturemodal" class="px-4 m-5 py-2 bg-blue-200 text-white rounded" disabled>Capture & Register</button>
                @else
                    <button id="capturemodal" class="px-4  m-5 py-2 bg-blue-500 text-white rounded" >Capture & Register</button>
                @endif
                

            <!-- Modal -->
            <div id="modal" class="fixed inset-0 bg-black bg-opacity-50 hidden flex items-center justify-center z-50">
                <div class="bg-white p-6 rounded-xl shadow-lg w-fit">
                    <h2 class="text-lg font-semibold mb-4 text-gray-800 text-center">Face Registration</h2>

                    <div class="relative">
                        <!-- Video with progress border -->
                        <div class="relative inline-block" style="padding: 8px; background: linear-gradient(to right, #10b981 var(--progress, 0%), #e5e7eb var(--progress, 0%)); border-radius: 0.5rem;">
                            <div class="relative inline-block">
                                <video id="video" width="320" height="240" autoplay playsinline class="rounded-md block" style="width: 320px; height: 240px;"></video>
                                <canvas id="overlayCanvas" width="320" height="240" class="absolute top-0 left-0 rounded-md pointer-events-none" style="width: 320px; height: 240px;"></canvas>
                            </div>
                        </div>
                        <canvas id="canvas" width="320" height="240" class="hidden"></canvas>
                    </div>

                    <div class="mt-4 space-y-2">
                        <!-- Debug info -->
                        <div class="text-center text-xs text-gray-500">
                            <p id="debugInfo">FPS: --</p>
                        </div>

                        <!-- Progress text -->
                        <div class="text-center">
                            <p id="instructionText" class="text-sm font-semibold text-gray-700">
                                Move your head left and right, then open your mouth
                            </p>
                            <p id="progressText" class="text-xs text-gray-500 mt-1">
                                Progress: 0%
                            </p>
                        </div>

                        <!-- Status indicators -->
                        <div class="flex justify-center gap-4 text-xs">
                            <div class="flex items-center gap-1">
                                <span id="leftIndicator" class="w-3 h-3 rounded-full bg-gray-300"></span>
                                <span>Left Turn</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <span id="rightIndicator" class="w-3 h-3 rounded-full bg-gray-300"></span>
                                <span>Right Turn</span>
                            </div>
                            <div class="flex items-center gap-1">
                                <span id="mouthIndicator" class="w-3 h-3 rounded-full bg-gray-300"></span>
                                <span>Open Mouth</span>
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center justify-end mt-4">
                        <button id="closemodal" type="button" class="bg-gray-400 hover:bg-gray-500 text-white px-3 py-2 rounded-md">
                            Cancel
                        </button>
                    </div>
                </div>
            </div>
             
            </div>
        </div>
        <div class=" rounded-md grow-1 bg-white">
            <div class="basis-[70%]  flex flex-col p-5 overflow-y-auto">
                <form id="updateProfile" class="flex flex-col gap-3" action="">
                  
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" value="{{Auth::user()->email}}">
                    <label for="contact">Contact Number</label>
                    <input type="number" name="contact" id="contact" value="{{Auth::user()->contact_number}}">
                    <label for="user">User</label>
                    <input type="text" name="user" id="user" value="{{Auth::user()->user}}">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" >
                    <input type="hidden" name="oldpassword" id="oldpassword" value="{{Auth::user()->password}}">
    
                    <button class="border rounded-md p-3" type="submit">Update</button>
    
                </form>
            </div>
        </div>
    </div>
</div>
{{-- <div class="mt-10 bg-white p-6 rounded shadow w-full">
    <h2 class="text-lg font-bold mb-4">Completed Appointments</h2>

    @if($completedAppointments->isEmpty())
        <p class="text-gray-500">You have no completed appointments.</p>
    @else
        <div class="hidden md:block">
           
            <table class="w-full text-sm border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-200 text-left">
                        <th class="px-3 py-2">Date</th>
                        <th class="px-3 py-2">Time</th>
                        <th class="px-3 py-2">Branch</th>
                        <th class="px-3 py-2">Dentist</th>
                        <th class="px-3 py-2">Description</th>
                        <th class="px-3 py-2">Work Done</th>
                        <th class="px-3 py-2">Total</th>
                        <th class="px-3 py-2">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($completedAppointments as $appointment)
                        <tr class="border-t border-gray-300">
                            <td class="px-3 py-2">{{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F j, Y') }}</td>
                            <td class="px-3 py-2">
                                {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }} -
                                {{ \Carbon\Carbon::parse($appointment->booking_end_time)->format('h:i A') }}
                            </td>
                            <td class="px-3 py-2">{{ $appointment->store->name }}</td>
                            <td class="px-3 py-2">{{ $appointment->dentist->name ?? 'N/A' }}</td>
                            <td class="px-3 py-2">{{ $appointment->desc }}</td>
                            <td class="px-3 py-2">{{ $appointment->work_done }}</td>
                            <td class="px-3 py-2">₱{{ number_format($appointment->total_price, 2) }}</td>
                            <td class="px-3 py-2 capitalize">{{ $appointment->status }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="md:hidden flex flex-col gap-4">
           
            @foreach($completedAppointments as $appointment)
                <div class="border border-gray-300 rounded p-3 shadow-sm text-sm">
                    <p><strong>Date:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_date)->format('F j, Y') }}</p>
                    <p><strong>Time:</strong> {{ \Carbon\Carbon::parse($appointment->appointment_time)->format('h:i A') }} - {{ \Carbon\Carbon::parse($appointment->booking_end_time)->format('h:i A') }}</p>
                    <p><strong>Branch:</strong> {{ $appointment->store->name }}</p>
                    <p><strong>Dentist:</strong> {{ $appointment->dentist->name ?? 'N/A' }}</p>
                    <p><strong>Description:</strong> {{ $appointment->desc }}</p>
                    <p><strong>Work Done:</strong> {{ $appointment->work_done }}</p>
                    <p><strong>Total:</strong> ₱{{ number_format($appointment->total_price, 2) }}</p>
                    <p><strong>Status:</strong> {{ ucfirst($appointment->status) }}</p>
                </div>
            @endforeach
        </div>
    @endif
</div> --}}

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
        @include('admin.dental-chart.index', ['patient' => $patient])
    @else
        <p>No dental chart available.</p>
    @endif
</div>




<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script defer src="https://cdn.jsdelivr.net/npm/@vladmandic/face-api/dist/face-api.min.js"></script>

<script>
document.querySelectorAll(".tab-button").forEach(button => {
    button.addEventListener("click", () => {
        const tab = button.dataset.tab;

        // Remove active class from all buttons
        document.querySelectorAll(".tab-button").forEach(btn =>
            btn.classList.remove("active", "border-blue-600", "text-blue-600")
        );
        button.classList.add("active", "border-blue-600", "text-blue-600");

        // Hide all tab content
        document.querySelectorAll(".tab-content").forEach(tc =>
            tc.classList.add("hidden")
        );

        // Show clicked tab
        document.getElementById(tab).classList.remove("hidden");
    });
    });
</script>

<!-- ================= FACE CAPTURE WITH VALIDATION ================= -->
<script>
let modelsLoaded = false;
let isDetecting = false;
let animationFrameId = null;

// Tracking variables
let headMovementLeft = false;
let headMovementRight = false;
let mouthOpened = false;
let currentProgress = 0;

// FPS tracking
let lastFrameTime = Date.now();
let frameCount = 0;
let fps = 0;

const openBtn = document.getElementById('capturemodal');
const modal = document.getElementById('modal');
const closeBtn = document.getElementById('closemodal');
const video = document.getElementById('video');
const canvas = document.getElementById('canvas');
const context = canvas.getContext('2d');
let stream = null;

async function loadModels() {
    if (modelsLoaded) return;
    
    try {
        await faceapi.nets.tinyFaceDetector.loadFromUri('/models/tiny_face_detector');
        await faceapi.nets.faceLandmark68Net.loadFromUri('/models/face_landmark_68');
        modelsLoaded = true;
        console.log('✅ Models loaded successfully');
    } catch (err) {
        console.error('❌ Model loading error:', err);
        Swal.fire('Error', 'Failed to load face detection models', 'error');
    }
}

function updateProgress() {
    let progress = 0;
    
    // Head movement left (33.33% of total)
    if (headMovementLeft) progress += 33.33;
    
    // Head movement right (33.33% of total)
    if (headMovementRight) progress += 33.33;
    
    // Mouth opened (33.33% of total)
    if (mouthOpened) progress += 33.34;
    
    currentProgress = Math.min(100, Math.round(progress));
    
    // Update visual progress
    const videoContainer = document.querySelector('#video').parentElement;
    videoContainer.style.setProperty('--progress', currentProgress + '%');
    
    document.getElementById('progressText').textContent = `Progress: ${currentProgress}%`;
    
    // Update instruction text
    if (!headMovementLeft && !headMovementRight && !mouthOpened) {
        document.getElementById('instructionText').textContent = 'Move your head left and right, then open your mouth';
    } else if (headMovementLeft && !headMovementRight && !mouthOpened) {
        document.getElementById('instructionText').textContent = 'Now turn your head to the right';
    } else if (!headMovementLeft && headMovementRight && !mouthOpened) {
        document.getElementById('instructionText').textContent = 'Now turn your head to the left';
    } else if (headMovementLeft && headMovementRight && !mouthOpened) {
        document.getElementById('instructionText').textContent = 'Great! Now open your mouth wide';
    } else if (mouthOpened && (!headMovementLeft || !headMovementRight)) {
        if (!headMovementLeft && !headMovementRight) {
            document.getElementById('instructionText').textContent = 'Now turn your head left and right';
        } else if (!headMovementLeft) {
            document.getElementById('instructionText').textContent = 'Now turn your head to the left';
        } else {
            document.getElementById('instructionText').textContent = 'Now turn your head to the right';
        }
    } else {
        document.getElementById('instructionText').textContent = 'Verification complete!';
    }
    
    // Update indicators
    if (headMovementLeft) {
        document.getElementById('leftIndicator').className = 'w-3 h-3 rounded-full bg-green-500';
    } else {
        document.getElementById('leftIndicator').className = 'w-3 h-3 rounded-full bg-yellow-400 animate-pulse';
    }
    
    if (headMovementRight) {
        document.getElementById('rightIndicator').className = 'w-3 h-3 rounded-full bg-green-500';
    } else {
        document.getElementById('rightIndicator').className = 'w-3 h-3 rounded-full bg-yellow-400 animate-pulse';
    }
    
    if (mouthOpened) {
        document.getElementById('mouthIndicator').className = 'w-3 h-3 rounded-full bg-green-500';
    } else {
        document.getElementById('mouthIndicator').className = 'w-3 h-3 rounded-full bg-yellow-400 animate-pulse';
    }
    
    // Auto-submit when complete
    if (currentProgress === 100) {
        setTimeout(() => {
            captureFaceAndRegister();
        }, 500);
    }
}

function detectMouthOpening(landmarks) {
    // Get mouth landmarks
    const mouth = landmarks.getMouth();
    
    // Get upper and lower lip points
    const upperLip = mouth[13];
    const lowerLip = mouth[19];
    
    // Calculate vertical distance between upper and lower lip
    const mouthOpenDistance = Math.abs(lowerLip.y - upperLip.y);
    
    // Get mouth width for normalization
    const leftMouthCorner = mouth[0];
    const rightMouthCorner = mouth[6];
    const mouthWidth = Math.abs(rightMouthCorner.x - leftMouthCorner.x);
    
    // Calculate mouth aspect ratio (height/width)
    const mouthAspectRatio = mouthOpenDistance / mouthWidth;
    
    // Threshold for mouth opening detection
    const MOUTH_OPEN_THRESHOLD = 0.35;
    
    // Detect mouth opening
    if (mouthAspectRatio > MOUTH_OPEN_THRESHOLD && !mouthOpened) {
        mouthOpened = true;
        console.log('✅ MOUTH OPENED | Ratio:', mouthAspectRatio.toFixed(3));
        updateProgress();
    }
}

function detectHeadMovement(landmarks) {
    const nose = landmarks.getNose();
    const jawline = landmarks.getJawOutline();
    
    const noseTip = nose[3];
    const leftJaw = jawline[0];
    const rightJaw = jawline[16];
    
    const faceWidth = rightJaw.x - leftJaw.x;
    const noseOffset = noseTip.x - leftJaw.x;
    const noseRatio = noseOffset / faceWidth;
    
    // Detect left turn
    if (noseRatio < 0.38 && !headMovementLeft) {
        headMovementLeft = true;
        console.log('✅ HEAD TURNED LEFT | Ratio:', noseRatio.toFixed(3));
        updateProgress();
    }
    
    // Detect right turn
    if (noseRatio > 0.62 && !headMovementRight) {
        headMovementRight = true;
        console.log('✅ HEAD TURNED RIGHT | Ratio:', noseRatio.toFixed(3));
        updateProgress();
    }
}

function drawBoundingBoxes(detection, video, canvas) {
    const ctx = canvas.getContext('2d');
    ctx.clearRect(0, 0, canvas.width, canvas.height);
    
    if (!detection) return;
    
    const { detection: faceDetection, landmarks } = detection;
    const scaleX = canvas.width / video.videoWidth;
    const scaleY = canvas.height / video.videoHeight;
    
    // Draw face box
    const box = faceDetection.box;
    const scaledBox = {
        x: box.x * scaleX,
        y: box.y * scaleY,
        width: box.width * scaleX,
        height: box.height * scaleY
    };
    
    ctx.strokeStyle = '#10b981';
    ctx.lineWidth = 3;
    ctx.strokeRect(scaledBox.x, scaledBox.y, scaledBox.width, scaledBox.height);
    
    // Label
    ctx.fillStyle = 'rgba(16, 185, 129, 0.9)';
    ctx.fillRect(scaledBox.x, scaledBox.y - 25, 60, 23);
    ctx.fillStyle = '#ffffff';
    ctx.font = 'bold 14px Arial';
    ctx.fillText('FACE', scaledBox.x + 8, scaledBox.y - 7);
}

// MAIN DETECTION LOOP
async function detectFaceLoop() {
    if (!isDetecting) return;
    
    const overlayCanvas = document.getElementById('overlayCanvas');
    
    // Calculate FPS
    frameCount++;
    const now = Date.now();
    if (now - lastFrameTime > 1000) {
        fps = frameCount;
        frameCount = 0;
        lastFrameTime = now;
    }
    
    // Update debug info
    document.getElementById('debugInfo').textContent = `FPS: ${fps}`;
    
    if (video && !video.paused && !video.ended && video.readyState === video.HAVE_ENOUGH_DATA) {
        // Match canvas size
        if (overlayCanvas.width !== video.videoWidth || overlayCanvas.height !== video.videoHeight) {
            overlayCanvas.width = video.videoWidth;
            overlayCanvas.height = video.videoHeight;
        }
        
        try {
            const detection = await faceapi
                .detectSingleFace(video, new faceapi.TinyFaceDetectorOptions({
                    inputSize: 224,
                    scoreThreshold: 0.5
                }))
                .withFaceLandmarks();
            
            if (detection) {
                drawBoundingBoxes(detection, video, overlayCanvas);
                detectHeadMovement(detection.landmarks);
                detectMouthOpening(detection.landmarks);
            } else {
                const ctx = overlayCanvas.getContext('2d');
                ctx.clearRect(0, 0, overlayCanvas.width, overlayCanvas.height);
            }
        } catch (err) {
            console.error('Detection error:', err);
        }
    }
    
    // Continue loop
    animationFrameId = requestAnimationFrame(detectFaceLoop);
}

function startDetection() {
    console.log('🎬 Starting detection loop...');
    isDetecting = true;
    detectFaceLoop();
}

function stopDetection() {
    console.log('⏹️ Stopping detection loop...');
    isDetecting = false;
    if (animationFrameId) {
        cancelAnimationFrame(animationFrameId);
        animationFrameId = null;
    }
}

function resetTracking() {
    headMovementLeft = false;
    headMovementRight = false;
    mouthOpened = false;
    currentProgress = 0;
    fps = 0;
    frameCount = 0;
    
    document.getElementById('instructionText').textContent = 'Move your head left and right, then open your mouth';
    document.getElementById('progressText').textContent = 'Progress: 0%';
    document.getElementById('debugInfo').textContent = 'FPS: --';
    document.getElementById('leftIndicator').className = 'w-3 h-3 rounded-full bg-gray-300';
    document.getElementById('rightIndicator').className = 'w-3 h-3 rounded-full bg-gray-300';
    document.getElementById('mouthIndicator').className = 'w-3 h-3 rounded-full bg-gray-300';
    
    const videoContainer = document.querySelector('#video').parentElement;
    videoContainer.style.setProperty('--progress', '0%');
}

openBtn.addEventListener('click', async () => {
    modal.classList.remove('hidden');
    resetTracking();

    try {
        // Request camera with specific constraints
        stream = await navigator.mediaDevices.getUserMedia({ 
            video: {
                width: { ideal: 640 },
                height: { ideal: 480 },
                frameRate: { ideal: 30 }
            }
        });
        
        video.srcObject = stream;
        
        // Wait for video to actually start playing
        await new Promise((resolve) => {
            video.onloadedmetadata = () => {
                video.play();
                resolve();
            };
        });
        
        console.log('📹 Camera started - resolution:', video.videoWidth, 'x', video.videoHeight);
        
        // Load models
        await loadModels();
        
        // Small delay then start detection
        setTimeout(() => {
            startDetection();
        }, 500);
        
    } catch (err) {
        console.error("❌ Webcam error:", err);
        Swal.fire('Error', 'Unable to access webcam', 'error');
        modal.classList.add('hidden');
    }
});

closeBtn.addEventListener('click', () => {
    stopDetection();
    modal.classList.add('hidden');
    stopCamera();
    resetTracking();
});

function stopCamera() {
    if (stream) {
        stream.getTracks().forEach(track => track.stop());
        stream = null;
    }
}

function captureFaceAndRegister() {
    stopDetection();
    
    // Draw video frame onto canvas
    context.drawImage(video, 0, 0, canvas.width, canvas.height);

    // Convert canvas to Blob
    canvas.toBlob(function(blob) {
        let formData = new FormData();
        formData.append('face_image', blob, 'face_capture.jpg');

        // Show loading spinner
        document.getElementById('loadingSpinner').classList.remove('hidden');

        fetch('/cregister-face', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            console.log(data);

            // Hide loading spinner
            document.getElementById('loadingSpinner').classList.add('hidden');

            // ✅ SUCCESS
            if (data.status === 'success') {
                Swal.fire({
                    title: 'Success!',
                    text: data.message || 'Face registered successfully!',
                    icon: 'success',
                    confirmButtonText: 'OK'
                }).then(() => {
                    document.getElementById('modal').classList.add('hidden');
                    location.reload();
                });
            }

            // ❌ DUPLICATE FACE / ERROR
            else {
                Swal.fire({
                    title: 'Error',
                    text: data.message || 'Face registration failed.',
                    icon: 'error',
                    confirmButtonText: 'OK'
                });
            }

        })
        .catch(error => {
            console.error('Error:', error);
            document.getElementById('loadingSpinner').classList.add('hidden');

            Swal.fire({
                title: 'Error!',
                text: 'Failed to register face.',
                icon: 'error',
                confirmButtonText: 'OK'
            });
        });
    }, 'image/jpeg');
}

// Load models on page load
$(document).ready(function() {
    loadModels();
});
</script>

<script>
    document.getElementById('removeFaceToken').addEventListener('click', () => {
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
                    Swal.fire('Removed!', data.message, 'success').then(() => {
                        location.reload();
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire('Error', 'Failed to remove face token.', 'error');
                });
            }
        });
    });

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
            }, 
            error: function (xhr) {
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
</script>

<script>
document.addEventListener('DOMContentLoaded', () => {
    const slides = document.querySelectorAll('.medical-form-slide');
    const nextBtn = document.getElementById('nextBtn');
    const prevBtn = document.getElementById('prevBtn');
    const indicator = document.getElementById('slideIndicator');
    let currentSlide = 0;

    function showSlide(index) {
        slides.forEach((slide, i) => {
            slide.classList.toggle('hidden', i !== index);
        });
        indicator.textContent = `${index + 1} of ${slides.length}`;
    }

    if (nextBtn && prevBtn) {
        nextBtn.addEventListener('click', () => {
            currentSlide = (currentSlide + 1) % slides.length;
            showSlide(currentSlide);
        });

        prevBtn.addEventListener('click', () => {
            currentSlide = (currentSlide - 1 + slides.length) % slides.length;
            showSlide(currentSlide);
        });

        showSlide(currentSlide);
    }
});
</script>
@endsection
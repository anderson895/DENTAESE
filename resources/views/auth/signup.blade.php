@extends('layout.auth')

@section('title', 'Signup')

@section('auth-content')
<div class="p-[50px] bg-sky-100">
<form id="signupForm" method="POST" enctype="multipart/form-data" class="space-y-8">
@csrf

<h2 class="text-2xl font-bold text-sky-600 text-center">Patient Registration</h2>

<!-- STEP LABELS -->
<div class="flex justify-between items-center text-sm font-semibold text-gray-600 mb-2">
    <div class="text-center flex-1"><span id="label-step-1">1. Personal Info</span></div>
    <div class="text-center flex-1"><span id="label-step-2">2. Account Setup</span></div>
    <div class="text-center flex-1"><span id="label-step-3">3. Face Registration</span></div>
    <div class="text-center flex-1"><span id="label-step-4">4. OTP Verification</span></div>
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
        <div>
            <label>Valid ID</label>
            <input type="file" name="verification_id" class="w-full border p-2 rounded" required>
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
    <p class="mb-4 font-semibold text-gray-700">
        Please register your face to continue
    </p>

    <input hidden type="text" id="face_token" name="face_token">

    <button type="button"
        id="capturemodal"
        class="px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
        Capture & Register Face
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

<!-- JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script defer src="https://cdn.jsdelivr.net/npm/@vladmandic/face-api/dist/face-api.min.js"></script>

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

<script>
let currentStep = 1;
const totalSteps = 4;
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

    /* NEXT BUTTON */
    $('.next').click(function () {
        /* STEP 2 → PASSWORD VALIDATION ONLY */
        if (currentStep === 2) {
            const password = $('#password').val();
            const confirmPassword = $('#confirm_password').val();

            if (password !== confirmPassword) {
                Swal.fire('Password Mismatch', 'Passwords do not match.', 'error');
                return;
            }

            currentStep++;
            showStep(currentStep);
            return;
        }

        /* STEP 3 → REQUIRE FACE REGISTRATION */
        if (currentStep === 3 && !faceRegistered) {
            Swal.fire('Face Required', 'Please register your face first.', 'warning');
            return;
        }

        if (currentStep === 3 && faceRegistered) {
            currentStep++;
            showStep(currentStep);
            return;
        }

        if (currentStep < totalSteps) {
            currentStep++;
            showStep(currentStep);
        }
    });

    /* PREV BUTTON */
    $('.prev').click(function () {
        if (currentStep > 1) {
            currentStep--;
            showStep(currentStep);
        }
    });

    /* PASSWORD TOGGLE */
    $('#showPassword').on('change', function () {
        $('#password').attr('type', this.checked ? 'text' : 'password');
    });

    $('#showConfirmPassword').on('change', function () {
        $('#confirm_password').attr('type', this.checked ? 'text' : 'password');
    });

    /* SUBMIT → OTP VERIFY → FINAL SIGNUP */
    $('#signupForm').on('submit', function (e) {
        e.preventDefault();
        const otp = $('#otp').val();

        if (otp.length !== 6) {
            Swal.fire('Invalid OTP', 'Enter 6-digit OTP', 'warning');
            return;
        }

        Swal.fire({
            title: 'Verifying OTP...',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        $.ajax({
        url: '{{ route("verify.otp") }}',
        method: 'GET',
        data: { otp, _token: '{{ csrf_token() }}' },
        success: function (res) {
            Swal.fire('OTP Verified', res.message, 'success').then(() => {
                // Submit final signup including face_token
                const finalFormData = new FormData($('#signupForm')[0]);
                $.ajax({
                    url: '{{ route("final.signup") }}',
                    method: 'POST',
                    data: finalFormData,
                    processData: false,
                    contentType: false,
                    success: function (res) {
                        Swal.fire('Account Created', res.message, 'success').then(() => {
                            localStorage.clear();
                            window.location.href = "{{ route('login') }}";
                        });
                    },
                    error: function (xhr) {
                        Swal.fire('Error', xhr.responseJSON.message, 'error');
                    }
                });
            });
        },
        error: function (xhr) {
            Swal.fire('Error', xhr.responseJSON.message, 'error');
        }
    });

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
        closeModal();
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

async function captureFaceAndRegister() {
    stopDetection();
    
    context.drawImage(video, 0, 0, canvas.width, canvas.height);

    canvas.toBlob(async (blob) => {
        if (!blob) {
            return Swal.fire('Error', 'Failed to capture image.', 'error');
        }

        const formData = new FormData();
        formData.append('face_image', blob, 'face.jpg');
        formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

        Swal.fire({
            title: 'Registering face...',
            allowOutsideClick: false,
            didOpen: () => Swal.showLoading()
        });

        try {
            const res = await fetch('/cregister-face-registration', {
                method: 'POST',
                body: formData,
                credentials: 'same-origin',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            const text = await res.text();
            let data;
            try { data = JSON.parse(text); } catch { throw new Error('Invalid server response.'); }

            if (!res.ok) throw new Error(data.message || 'Face registration failed.');

            // ✅ FACE SUCCESS
            faceRegistered = true;
            $('#face_token').val(data.face_token); // store token for final signup

            Swal.fire('Success', data.message, 'success');
            modal.classList.add('hidden');
            stopCamera();

            // --- SEND OTP ---
            const otpFormData = new FormData($('#signupForm')[0]);
            otpFormData.append('_token', '{{ csrf_token() }}');

            Swal.fire({
                title: 'Sending OTP...',
                allowOutsideClick: false,
                didOpen: () => Swal.showLoading()
            });

            $.ajax({
                url: '{{ route("send.otp") }}',
                method: 'POST',
                data: otpFormData,
                processData: false,
                contentType: false,
                success: function () {
                    Swal.close();
                    currentStep++;
                    showStep(currentStep);
                },
                error: function (xhr) {
                    Swal.close();
                    Swal.fire('Error', xhr.responseJSON.message, 'error');
                }
            });

        } catch (err) {
            console.error(err);
            Swal.fire('Error', err.message || 'Face registration failed.', 'error');
        }

    }, 'image/jpeg');
}

// Load models on page load
$(document).ready(function() {
    loadModels();
});
</script>

@endsection
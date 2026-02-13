@extends('layout.auth')
@section('title', 'Face Recognition')

@section('auth-content')
<div class="p-[50px] bg-sky-100">
    <form id="loginForm" method="post" class="flex flex-col gap-5">
        <div class="text-center">
            <h2 class="text-2xl font-bold text-sky-600">
                Scan your face to login
            </h2>
            <p class="text-sm text-gray-600 mt-1">
                Please look at the camera
            </p>
        </div>

        @csrf

        <div class="flex justify-center">
            <button type="button" onclick="openModal()" class="bg-green-500 hover:bg-green-600 text-white font-medium rounded-md px-6 py-3 transition">
                Start Face Scan
            </button>
        </div>

        <div class="text-center mt-4 space-y-2 text-sm text-gray-700">
            <p>
                Login using 
                <a href="{{ route('loginui') }}" class="text-blue-500 underline">Password</a> 
                or 
                <a href="{{ route('Qr') }}" class="text-blue-500 underline">QR</a>
            </p>
            <p>
                Don't have an account? 
                <a href="{{ route('signupui') }}" class="text-blue-500 underline">Sign up</a>
            </p>
        </div>

        <!-- Face Login Modal -->
        <div id="videoModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
            <div class="bg-white p-6 rounded-xl shadow-lg w-fit">
                <h3 class="text-lg font-semibold mb-4 text-gray-800 text-center">
                    Face Recognition
                </h3>

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
                    <button onclick="closeModal()" type="button" class="bg-gray-400 hover:bg-gray-500 text-white px-3 py-2 rounded-md">
                        Cancel
                    </button>
                </div>
            </div>
        </div>

        <!-- Loader -->
        <div id="loadingSpinner" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 z-[9999]">
            <div class="animate-spin rounded-full h-16 w-16 border-t-4 border-b-4 border-sky-500"></div>
        </div>
    </form>
</div>

<!-- Scripts -->
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
                submitFaceRecognition();
            }, 500);
        }
    }

    function detectMouthOpening(landmarks) {
        // Get mouth landmarks
        const mouth = landmarks.getMouth();
        
        // Get upper and lower lip points
        // Point 51 is top of upper lip (center)
        // Point 57 is bottom of lower lip (center)
        const upperLip = mouth[13]; // Index 13 in mouth array (point 62 in full landmarks)
        const lowerLip = mouth[19]; // Index 19 in mouth array (point 66 in full landmarks)
        
        // Calculate vertical distance between upper and lower lip
        const mouthOpenDistance = Math.abs(lowerLip.y - upperLip.y);
        
        // Get mouth width for normalization
        const leftMouthCorner = mouth[0];
        const rightMouthCorner = mouth[6];
        const mouthWidth = Math.abs(rightMouthCorner.x - leftMouthCorner.x);
        
        // Calculate mouth aspect ratio (height/width)
        const mouthAspectRatio = mouthOpenDistance / mouthWidth;
        
        // Threshold for mouth opening detection (adjust if needed)
        // Typical values: closed mouth ~0.1-0.2, open mouth ~0.4+
        const MOUTH_OPEN_THRESHOLD = 0.35;
        
        // Detect mouth opening
        if (mouthAspectRatio > MOUTH_OPEN_THRESHOLD && !mouthOpened) {
            mouthOpened = true;
            console.log('✅ MOUTH OPENED | Ratio:', mouthAspectRatio.toFixed(3));
            updateProgress();
        }
        
        // Debug info (optional - comment out in production)
        // console.log('Mouth ratio:', mouthAspectRatio.toFixed(3));
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
        
        const video = document.getElementById('video');
        const canvas = document.getElementById('overlayCanvas');
        
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
            if (canvas.width !== video.videoWidth || canvas.height !== video.videoHeight) {
                canvas.width = video.videoWidth;
                canvas.height = video.videoHeight;
            }
            
            try {
                const detection = await faceapi
                    .detectSingleFace(video, new faceapi.TinyFaceDetectorOptions({
                        inputSize: 224,
                        scoreThreshold: 0.5
                    }))
                    .withFaceLandmarks();
                
                if (detection) {
                    drawBoundingBoxes(detection, video, canvas);
                    detectHeadMovement(detection.landmarks);
                    detectMouthOpening(detection.landmarks);
                } else {
                    const ctx = canvas.getContext('2d');
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
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

    async function openModal() {
        document.getElementById('videoModal').classList.remove('hidden');
        resetTracking();

        try {
            // Request camera with specific constraints
            const stream = await navigator.mediaDevices.getUserMedia({ 
                video: {
                    width: { ideal: 640 },
                    height: { ideal: 480 },
                    frameRate: { ideal: 30 }
                }
            });
            
            const video = document.getElementById('video');
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
    }

    function closeModal() {
        stopDetection();
        document.getElementById('videoModal').classList.add('hidden');

        const video = document.getElementById('video');
        if (video.srcObject) {
            video.srcObject.getTracks().forEach(track => track.stop());
            video.srcObject = null;
        }
        
        resetTracking();
    }

    function submitFaceRecognition() {
        stopDetection();
        
        const video = document.getElementById('video');
        const canvas = document.getElementById('canvas');
        const context = canvas.getContext('2d');

        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        const imageBase64 = canvas.toDataURL('image/jpeg');

        document.getElementById('loadingSpinner').classList.remove('hidden');

        $.ajax({
            type: 'POST',
            url: '{{ route('login-face') }}',
            data: {
                image_base64: imageBase64,
                _token: '{{ csrf_token() }}'
            },
            success: function (response) {
                document.getElementById('loadingSpinner').classList.add('hidden');

                if (response.status === "success") {
                    Swal.fire('Success', response.message, 'success')
                        .then(() => window.location.href = response.redirect);
                } else {
                    Swal.fire('Error', response.message, 'error');
                    closeModal();
                }
            },
            error: function () {
                document.getElementById('loadingSpinner').classList.add('hidden');
                Swal.fire('Error', 'Face recognition failed', 'error');
                closeModal();
            }
        });
    }

    $(document).ready(function () {
        loadModels();
        openModal();

        $('#loginForm').submit(function (event) {
            event.preventDefault();
        });
    });
</script>
@endsection
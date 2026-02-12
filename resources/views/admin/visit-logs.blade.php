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
                <button type="button" onclick="openFaceModal()" class="bg-green-500 hover:bg-green-600 text-white font-medium rounded-md px-8 py-3 transition duration-150 text-lg">
                    Start Face Recognition
                </button>
            </div>
        </form>

        <!-- Face Recognition Modal -->
        <div id="faceModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
            <div class="bg-white p-6 rounded-xl shadow-lg w-fit">
                <h3 class="text-lg font-semibold mb-4 text-gray-800 text-center">
                    Face Recognition
                </h3>

                <div class="relative">
                    <!-- Video with progress border -->
                    <div class="relative inline-block" style="padding: 8px; background: linear-gradient(to right, #10b981 var(--progress, 0%), #e5e7eb var(--progress, 0%)); border-radius: 0.5rem;">
                        <div class="relative inline-block">
                            <video id="faceVideo" width="320" height="240" autoplay playsinline class="rounded-md block" style="width: 320px; height: 240px;"></video>
                            <canvas id="overlayCanvas" width="320" height="240" class="absolute top-0 left-0 rounded-md pointer-events-none" style="width: 320px; height: 240px;"></canvas>
                        </div>
                    </div>
                    <canvas id="faceCanvas" width="320" height="240" class="hidden"></canvas>
                </div>

                <div class="mt-4 space-y-2">
                    <!-- Debug info -->
                    <div class="text-center text-xs text-gray-500">
                        <p id="faceDebugInfo">FPS: --</p>
                    </div>

                    <!-- Progress text -->
                    <div class="text-center">
                        <p id="faceInstructionText" class="text-sm font-semibold text-gray-700">
                            Move your head left and right, then open your mouth
                        </p>
                        <p id="faceProgressText" class="text-xs text-gray-500 mt-1">
                            Progress: 0%
                        </p>
                    </div>

                    <!-- Status indicators -->
                    <div class="flex justify-center gap-4 text-xs">
                        <div class="flex items-center gap-1">
                            <span id="faceLeftIndicator" class="w-3 h-3 rounded-full bg-gray-300"></span>
                            <span>Left Turn</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <span id="faceRightIndicator" class="w-3 h-3 rounded-full bg-gray-300"></span>
                            <span>Right Turn</span>
                        </div>
                        <div class="flex items-center gap-1">
                            <span id="faceMouthIndicator" class="w-3 h-3 rounded-full bg-gray-300"></span>
                            <span>Open Mouth</span>
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-end mt-4">
                    <button onclick="closeFaceModal()" type="button" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-md">
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

<!-- Scripts -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://unpkg.com/html5-qrcode"></script>
<script defer src="https://cdn.jsdelivr.net/npm/@vladmandic/face-api/dist/face-api.min.js"></script>

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
    
    .w-3.h-3.rounded-full {
        transition: all 0.3s ease;
    }
</style>

<!-- Tab Switch Script -->
<script>
    document.querySelectorAll('.tab-button').forEach(button => {
        button.addEventListener('click', () => {
            const tab = button.getAttribute('data-tab');

            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });

            document.getElementById(tab).classList.remove('hidden');

            document.querySelectorAll('.tab-button').forEach(btn => {
                btn.classList.remove('text-blue-500', 'border-blue-500');
            });

            button.classList.add('text-blue-500', 'border-blue-500');
        });
    });

    // Auto-select first tab on page load
    document.querySelector('.tab-button').click();
</script>

<!-- QR Scanner Script -->
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
            Swal.fire({
                title: 'Scan Successful!',
                text: data.message,
                icon: 'success',
                confirmButtonText: 'OK'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('logs') }}";
                }
            });
        })
        .catch(err => {
            console.error('Error scanning QR:', err);
            Swal.fire({
                title: 'Error',
                text: 'Something went wrong while scanning.',
                icon: 'error'
            });
        });
    }

    const html5QrcodeScanner = new Html5QrcodeScanner(
        "reader", { fps: 10, qrbox: 250 }
    );
    html5QrcodeScanner.render(onScanSuccess);
</script>

<!-- Face Recognition Script -->
<!-- Face Recognition Script -->
<script>
    let faceModelsLoaded = false;
    let isFaceDetecting = false;
    let faceAnimationFrameId = null;
    
    // Tracking variables
    let faceHeadMovementLeft = false;
    let faceHeadMovementRight = false;
    let faceMouthOpened = false;
    let faceCurrentProgress = 0;
    
    // FPS tracking
    let faceLastFrameTime = Date.now();
    let faceFrameCount = 0;
    let faceFps = 0;

    async function loadFaceModels() {
        if (faceModelsLoaded) return;
        
        try {
            await faceapi.nets.tinyFaceDetector.loadFromUri('/models/tiny_face_detector');
            await faceapi.nets.faceLandmark68Net.loadFromUri('/models/face_landmark_68');
            faceModelsLoaded = true;
            console.log('✅ Face models loaded successfully');
        } catch (err) {
            console.error('❌ Model loading error:', err);
            Swal.fire('Error', 'Failed to load face detection models', 'error');
        }
    }

    function updateFaceProgress() {
        let progress = 0;
        
        if (faceHeadMovementLeft) progress += 33.33;
        if (faceHeadMovementRight) progress += 33.33;
        if (faceMouthOpened) progress += 33.34;
        
        faceCurrentProgress = Math.min(100, Math.round(progress));
        
        // Update visual progress
        const videoContainer = document.querySelector('#faceVideo').parentElement;
        videoContainer.style.setProperty('--progress', faceCurrentProgress + '%');
        
        document.getElementById('faceProgressText').textContent = `Progress: ${faceCurrentProgress}%`;
        
        // Update instruction text
        if (!faceHeadMovementLeft && !faceHeadMovementRight && !faceMouthOpened) {
            document.getElementById('faceInstructionText').textContent = 'Move your head left and right, then open your mouth';
        } else if (faceHeadMovementLeft && !faceHeadMovementRight && !faceMouthOpened) {
            document.getElementById('faceInstructionText').textContent = 'Now turn your head to the right';
        } else if (!faceHeadMovementLeft && faceHeadMovementRight && !faceMouthOpened) {
            document.getElementById('faceInstructionText').textContent = 'Now turn your head to the left';
        } else if (faceHeadMovementLeft && faceHeadMovementRight && !faceMouthOpened) {
            document.getElementById('faceInstructionText').textContent = 'Great! Now open your mouth wide';
        } else if (faceMouthOpened && (!faceHeadMovementLeft || !faceHeadMovementRight)) {
            if (!faceHeadMovementLeft && !faceHeadMovementRight) {
                document.getElementById('faceInstructionText').textContent = 'Now turn your head left and right';
            } else if (!faceHeadMovementLeft) {
                document.getElementById('faceInstructionText').textContent = 'Now turn your head to the left';
            } else {
                document.getElementById('faceInstructionText').textContent = 'Now turn your head to the right';
            }
        } else {
            document.getElementById('faceInstructionText').textContent = 'Verification complete! Identifying...';
        }
        
        // Update indicators
        document.getElementById('faceLeftIndicator').className = faceHeadMovementLeft 
            ? 'w-3 h-3 rounded-full bg-green-500' 
            : 'w-3 h-3 rounded-full bg-yellow-400 animate-pulse';
        
        document.getElementById('faceRightIndicator').className = faceHeadMovementRight 
            ? 'w-3 h-3 rounded-full bg-green-500' 
            : 'w-3 h-3 rounded-full bg-yellow-400 animate-pulse';
        
        document.getElementById('faceMouthIndicator').className = faceMouthOpened 
            ? 'w-3 h-3 rounded-full bg-green-500' 
            : 'w-3 h-3 rounded-full bg-yellow-400 animate-pulse';
        
        // Auto-submit when complete
        if (faceCurrentProgress === 100) {
            setTimeout(() => {
                submitFaceRecognition();
            }, 500);
        }
    }

    function detectFaceMouthOpening(landmarks) {
        const mouth = landmarks.getMouth();
        const upperLip = mouth[13];
        const lowerLip = mouth[19];
        const mouthOpenDistance = Math.abs(lowerLip.y - upperLip.y);
        
        const leftMouthCorner = mouth[0];
        const rightMouthCorner = mouth[6];
        const mouthWidth = Math.abs(rightMouthCorner.x - leftMouthCorner.x);
        
        const mouthAspectRatio = mouthOpenDistance / mouthWidth;
        const MOUTH_OPEN_THRESHOLD = 0.35;
        
        if (mouthAspectRatio > MOUTH_OPEN_THRESHOLD && !faceMouthOpened) {
            faceMouthOpened = true;
            console.log('✅ MOUTH OPENED | Ratio:', mouthAspectRatio.toFixed(3));
            updateFaceProgress();
        }
    }

    function detectFaceHeadMovement(landmarks) {
        const nose = landmarks.getNose();
        const jawline = landmarks.getJawOutline();
        
        const noseTip = nose[3];
        const leftJaw = jawline[0];
        const rightJaw = jawline[16];
        
        const faceWidth = rightJaw.x - leftJaw.x;
        const noseOffset = noseTip.x - leftJaw.x;
        const noseRatio = noseOffset / faceWidth;
        
        if (noseRatio < 0.38 && !faceHeadMovementLeft) {
            faceHeadMovementLeft = true;
            console.log('✅ HEAD TURNED LEFT | Ratio:', noseRatio.toFixed(3));
            updateFaceProgress();
        }
        
        if (noseRatio > 0.62 && !faceHeadMovementRight) {
            faceHeadMovementRight = true;
            console.log('✅ HEAD TURNED RIGHT | Ratio:', noseRatio.toFixed(3));
            updateFaceProgress();
        }
    }

    function drawFaceBoundingBoxes(detection, video, canvas) {
        const ctx = canvas.getContext('2d');
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        
        if (!detection) return;
        
        const { detection: faceDetection } = detection;
        const scaleX = canvas.width / video.videoWidth;
        const scaleY = canvas.height / video.videoHeight;
        
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
        
        ctx.fillStyle = 'rgba(16, 185, 129, 0.9)';
        ctx.fillRect(scaledBox.x, scaledBox.y - 25, 60, 23);
        ctx.fillStyle = '#ffffff';
        ctx.font = 'bold 14px Arial';
        ctx.fillText('FACE', scaledBox.x + 8, scaledBox.y - 7);
    }

    async function detectFaceLoop() {
        if (!isFaceDetecting) return;
        
        const video = document.getElementById('faceVideo');
        const canvas = document.getElementById('overlayCanvas');
        
        faceFrameCount++;
        const now = Date.now();
        if (now - faceLastFrameTime > 1000) {
            faceFps = faceFrameCount;
            faceFrameCount = 0;
            faceLastFrameTime = now;
        }
        
        document.getElementById('faceDebugInfo').textContent = `FPS: ${faceFps}`;
        
        if (video && !video.paused && !video.ended && video.readyState === video.HAVE_ENOUGH_DATA) {
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
                    drawFaceBoundingBoxes(detection, video, canvas);
                    detectFaceHeadMovement(detection.landmarks);
                    detectFaceMouthOpening(detection.landmarks);
                } else {
                    const ctx = canvas.getContext('2d');
                    ctx.clearRect(0, 0, canvas.width, canvas.height);
                }
            } catch (err) {
                console.error('Detection error:', err);
            }
        }
        
        faceAnimationFrameId = requestAnimationFrame(detectFaceLoop);
    }

    function startFaceDetection() {
        console.log('🎬 Starting face detection loop...');
        isFaceDetecting = true;
        detectFaceLoop();
    }

    function stopFaceDetection() {
        console.log('⏹️ Stopping face detection loop...');
        isFaceDetecting = false;
        if (faceAnimationFrameId) {
            cancelAnimationFrame(faceAnimationFrameId);
            faceAnimationFrameId = null;
        }
    }

    function resetFaceTracking() {
        faceHeadMovementLeft = false;
        faceHeadMovementRight = false;
        faceMouthOpened = false;
        faceCurrentProgress = 0;
        faceFps = 0;
        faceFrameCount = 0;
        
        document.getElementById('faceInstructionText').textContent = 'Move your head left and right, then open your mouth';
        document.getElementById('faceProgressText').textContent = 'Progress: 0%';
        document.getElementById('faceDebugInfo').textContent = 'FPS: --';
        document.getElementById('faceLeftIndicator').className = 'w-3 h-3 rounded-full bg-gray-300';
        document.getElementById('faceRightIndicator').className = 'w-3 h-3 rounded-full bg-gray-300';
        document.getElementById('faceMouthIndicator').className = 'w-3 h-3 rounded-full bg-gray-300';
        
        const videoContainer = document.querySelector('#faceVideo').parentElement;
        videoContainer.style.setProperty('--progress', '0%');
    }

    async function openFaceModal() {
        // REMOVED: User selection validation
        document.getElementById('faceModal').classList.remove('hidden');
        resetFaceTracking();

        try {
            const stream = await navigator.mediaDevices.getUserMedia({ 
                video: {
                    width: { ideal: 640 },
                    height: { ideal: 480 },
                    frameRate: { ideal: 30 }
                }
            });
            
            const video = document.getElementById('faceVideo');
            video.srcObject = stream;
            
            await new Promise((resolve) => {
                video.onloadedmetadata = () => {
                    video.play();
                    resolve();
                };
            });
            
            console.log('📹 Camera started - resolution:', video.videoWidth, 'x', video.videoHeight);
            
            await loadFaceModels();
            
            setTimeout(() => {
                startFaceDetection();
            }, 500);
            
        } catch (err) {
            console.error("❌ Webcam error:", err);
            Swal.fire('Error', 'Unable to access webcam', 'error');
            closeFaceModal();
        }
    }

    function closeFaceModal() {
        stopFaceDetection();
        document.getElementById('faceModal').classList.add('hidden');

        const video = document.getElementById('faceVideo');
        if (video.srcObject) {
            video.srcObject.getTracks().forEach(track => track.stop());
            video.srcObject = null;
        }
        
        resetFaceTracking();
    }

    function submitFaceRecognition() {
        stopFaceDetection();
        
        const video = document.getElementById('faceVideo');
        const canvas = document.getElementById('faceCanvas');
        const context = canvas.getContext('2d');

        context.drawImage(video, 0, 0, canvas.width, canvas.height);
        const imageBase64 = canvas.toDataURL('image/jpeg');

        document.getElementById('faceLoadingSpinner').classList.remove('hidden');

        const formData = {
            image_base64: imageBase64,
            _token: '{{ csrf_token() }}'
        };

        $.ajax({
            type: 'POST',
            url: '{{ route('scan.face') }}',
            data: formData,
            success: function (response) {
                document.getElementById('faceLoadingSpinner').classList.add('hidden');

                if (response.status === "success") {
                    Swal.fire({
                        title: 'Success!',
                        html: `<strong>${response.user_name}</strong><br>${response.message}`,
                        icon: 'success',
                        confirmButtonText: 'OK'
                    }).then(() => {
                        window.location.href = response.redirect;
                    });
                } else {
                    Swal.fire('Error', response.message, 'error');
                    closeFaceModal();
                }
            },
            error: function (xhr) {
                console.error(xhr.responseText);
                document.getElementById('faceLoadingSpinner').classList.add('hidden');
                Swal.fire('Error', 'Face recognition failed', 'error');
                closeFaceModal();
            }
        });
    }

    // Load models on page load
    $(document).ready(function() {
        loadFaceModels();
    });
</script>
@endsection
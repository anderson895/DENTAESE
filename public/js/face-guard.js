/**
 * FaceGuard — mga kondisyon ng face recognition (final defense revision 10/12/26).
 *
 * Ginagamit ng lahat ng face screen: signup (step 3), face login, patient at
 * staff profile, at Visit Logs. Bago umusad ang head-turn na liveness check,
 * dapat pasado muna ang frame sa:
 *   - isang mukha lang ang nasa camera,
 *   - nasa loob ng bilog ang mukha (hindi masyadong malayo o malapit),
 *   - sapat ang liwanag.
 * Ang "cap" at "filters" sa guidelines screen ay paalala lang — hindi ito
 * kayang tukuyin ng face-api.
 *
 * Kailangan ang face-api.js (window.faceapi), pero sa loob lang ng mga function
 * ito ginagamit kaya ayos lang kahit naka-defer ang face-api sa pahina.
 *
 *   const result = await FaceGuard.check(video);
 *   FaceGuard.drawGuide(overlayCanvas, video, result);
 *   FaceGuard.showCondition(conditionEl, result);
 *   if (result.ok) detectHeadMovement(result.detection.landmarks);
 *
 *   const shot = await FaceGuard.capture(video);   // shot.descriptor kapag shot.ok
 */
(function () {
    // Mga sukat na puwedeng i-tune sa totoong device.
    var CIRCLE_RADIUS     = 0.42; // radius ng bilog, kumpara sa mas maikling gilid ng video
    var CENTER_TOLERANCE  = 0.40; // layo ng gitna ng mukha sa gitna ng bilog (x radius)
    var MIN_FACE_SIZE     = 0.60; // lapad ng face box / radius — mas maliit = masyadong malayo
    var MAX_FACE_SIZE     = 1.90; // mas malaki = lampas na sa bilog (masyadong malapit)
    var MIN_FACE_FRACTION = 0.10; // mas makitid sa 10% ng frame = hindi binibilang na mukha
    // Liwanag (average luma, 0-255). Sadyang mababa ang "too dark" para hindi
    // mapagkamalang madilim ang mukha ng may mas maitim na balat.
    var DARK_FRAME  = 45;
    var DARK_FACE   = 40;
    var BRIGHT_FACE = 230;

    var MESSAGES = {
        none:     'No face detected. Look at the camera and move a little closer.',
        multiple: 'Multiple faces detected. Only one person should be in the frame.',
        outside:  'Keep your face inside the circle.',
        far:      'Move closer to the camera.',
        close:    'Move a little farther from the camera.',
        dark:     'Too dark. Move to a brighter place.',
        bright:   'Too bright. Avoid strong light on your face.',
    };

    var sampleCanvas = null;

    // Pareho sa dating detectSingleFace options ng lahat ng face screen.
    function detectorOptions() {
        return new faceapi.TinyFaceDetectorOptions({ inputSize: 224, scoreThreshold: 0.5 });
    }

    function circleFor(width, height) {
        return { x: width / 2, y: height / 2, r: Math.min(width, height) * CIRCLE_RADIUS };
    }

    function boxOf(face) {
        return (face.detection || face).box;
    }

    // Average na liwanag ng isang bahagi ng video, sa maliit na 32x32 na sample.
    function meanLuma(video, sx, sy, sw, sh) {
        if (!sampleCanvas) {
            sampleCanvas = document.createElement('canvas');
            sampleCanvas.width = 32;
            sampleCanvas.height = 32;
        }
        var ctx = sampleCanvas.getContext('2d', { willReadFrequently: true });
        ctx.drawImage(video, sx, sy, sw, sh, 0, 0, 32, 32);

        var px = ctx.getImageData(0, 0, 32, 32).data;
        var sum = 0;
        for (var i = 0; i < px.length; i += 4) {
            sum += 0.299 * px[i] + 0.587 * px[i + 1] + 0.114 * px[i + 2];
        }
        return sum / (px.length / 4);
    }

    function fail(code, extra) {
        var result = { ok: false, code: code, message: MESSAGES[code], faces: [] };
        for (var key in extra) result[key] = extra[key];
        return result;
    }

    function evaluate(video, detections) {
        var w = video.videoWidth;
        var h = video.videoHeight;

        // Ang maliliit na detection (poster, anino, taong malayo sa likod) ay
        // hindi binibilang para hindi laging "multiple faces".
        var faces = detections.filter(function (d) {
            return boxOf(d).width >= w * MIN_FACE_FRACTION;
        });

        if (faces.length === 0) {
            if (detections.length) return fail('far');
            // Walang makitang mukha — kadalasan dahil madilim ang kwarto.
            if (w && h && meanLuma(video, 0, 0, w, h) < DARK_FRAME) return fail('dark');
            return fail('none');
        }
        if (faces.length > 1) {
            return fail('multiple', { faces: faces });
        }

        var face = faces[0];
        var box  = boxOf(face);
        var c    = circleFor(w, h);
        var info = { faces: faces, detection: face };

        // Liwanag muna: kapag madilim, iyon ang unang dapat ayusin. Sinusukat
        // ang mukha mismo at ang buong frame (para sa backlight at madilim na kwarto).
        var bx = Math.max(0, box.x);
        var by = Math.max(0, box.y);
        var bw = Math.min(w - bx, box.width);
        var bh = Math.min(h - by, box.height);
        if (bw > 0 && bh > 0) {
            var faceLuma  = meanLuma(video, bx, by, bw, bh);
            var frameLuma = meanLuma(video, 0, 0, w, h);
            if (frameLuma < DARK_FRAME || faceLuma < DARK_FACE) return fail('dark', info);
            if (faceLuma > BRIGHT_FACE) return fail('bright', info);
        }

        var dx = box.x + box.width / 2 - c.x;
        var dy = box.y + box.height / 2 - c.y;
        if (Math.sqrt(dx * dx + dy * dy) > c.r * CENTER_TOLERANCE) return fail('outside', info);
        if (box.width < c.r * MIN_FACE_SIZE) return fail('far', info);
        if (box.width > c.r * MAX_FACE_SIZE) return fail('close', info);

        return { ok: true, code: 'ok', message: '', faces: faces, detection: face };
    }

    window.FaceGuard = {
        messages: MESSAGES,

        // Sinusuri ang kasalukuyang frame. Ibinabalik ang { ok, code, message, detection }.
        check: async function (video) {
            var detections = await faceapi
                .detectAllFaces(video, detectorOptions())
                .withFaceLandmarks();
            return evaluate(video, detections);
        },

        // Huling pagkuha ng descriptor: dapat EKSAKTONG isang mukha para hindi
        // mairehistro o makilala ang maling tao. Hindi na inuulit dito ang
        // bilog at liwanag — sinuri na iyon habang nagli-liveness check.
        capture: async function (video) {
            var detections = await faceapi
                .detectAllFaces(video, detectorOptions())
                .withFaceLandmarks()
                .withFaceDescriptors();

            var w = video.videoWidth;
            var faces = detections.filter(function (d) {
                return boxOf(d).width >= w * MIN_FACE_FRACTION;
            });

            if (faces.length !== 1) {
                return fail(faces.length ? 'multiple' : 'none', { faces: faces });
            }
            return { ok: true, code: 'ok', message: '', faces: faces, descriptor: faces[0].descriptor };
        },

        // Bilog na gabay: madilim sa labas, berde kapag pasado, amber kapag hindi.
        // Pulang kahon ang bawat mukha kapag higit sa isa.
        drawGuide: function (canvas, video, result) {
            var w = video.videoWidth;
            var h = video.videoHeight;
            if (!canvas || !w || !h) return;

            if (canvas.width !== w)  canvas.width  = w;
            if (canvas.height !== h) canvas.height = h;
            // Para tumapat sa video kahit 16:9 o portrait ang camera (contain din ang <video>).
            canvas.style.objectFit = 'contain';

            var ctx = canvas.getContext('2d');
            var c   = circleFor(w, h);
            ctx.clearRect(0, 0, w, h);

            // Buong frame na may butas na bilog (evenodd) = madilim lang sa labas.
            ctx.fillStyle = 'rgba(0, 0, 0, 0.45)';
            ctx.beginPath();
            ctx.rect(0, 0, w, h);
            ctx.moveTo(c.x + c.r, c.y);
            ctx.arc(c.x, c.y, c.r, 0, Math.PI * 2);
            ctx.fill('evenodd');

            ctx.lineWidth   = Math.max(3, Math.round(w / 160));
            ctx.strokeStyle = result && result.ok ? '#10b981' : '#f59e0b';
            ctx.beginPath();
            ctx.arc(c.x, c.y, c.r, 0, Math.PI * 2);
            ctx.stroke();

            if (result && result.code === 'multiple') {
                ctx.strokeStyle = '#ef4444';
                result.faces.forEach(function (face) {
                    var b = boxOf(face);
                    ctx.strokeRect(b.x, b.y, b.width, b.height);
                });
            }
        },

        // Ipinapakita kung aling kondisyon ang hindi pa pasado (walang laman kapag ok).
        showCondition: function (el, result) {
            if (!el) return;
            el.textContent = result && !result.ok ? result.message : '';
        },

        // Linisin ang overlay at ang mensahe (hal. sa reset o pagsara ng modal).
        clear: function (canvas, conditionEl) {
            if (canvas) canvas.getContext('2d').clearRect(0, 0, canvas.width, canvas.height);
            if (conditionEl) conditionEl.textContent = '';
        },

        // Lipat sa pagitan ng guidelines at camera sa loob ng face modal.
        showStep: function (modal, step) {
            if (!modal) return;
            modal.querySelectorAll('[data-face-step]').forEach(function (el) {
                el.classList.toggle('hidden', el.getAttribute('data-face-step') !== step);
            });
        },
    };
})();

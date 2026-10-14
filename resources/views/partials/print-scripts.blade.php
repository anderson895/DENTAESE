{{--
    Isang shared na print helper para sa buong system.

    window.printSection(elementId, options)
        options.paper   : @page size — 'Letter' (default), 'legal', '4in 6in', ...
        options.scale    : porsyento ng laki (80 para sa reports, 100 sa Dental Chart)
        options.padding : margin ng papel na inuulit kada pahina
        options.title    : pamagat ng print job
        options.css      : dagdag na CSS para sa partikular na layout

    window.printReceipt(elementId, title)
        Shortcut para sa lahat ng resibo — default na 4x6 ang papel.

    Lahat ng printout ay may footer na "Printed: <petsa/oras>" at "By: <user>".
    Karaniwan ay galing ito sa partials/print-header, pero kung walang header
    ang isang seksyon ay idinadagdag ito rito — para walang printout na
    lumalabas nang walang tala kung kailan at sino ang nagprint.

    Nagpiprint ito sa loob ng nakatagong iframe: hindi na sinisira ang kasalukuyang
    pahina (dating ginagawa ng document.body.innerHTML = ...) kaya wala nang reload
    pagkatapos, at hindi rin ito hinaharang ng popup blocker.

    TABLET / PHONE: hindi iniimprenta ng Chrome sa Android (at Safari sa iPad) ang
    iframe — buong tab ang napi-print (Chromium issue 41323115), kaya kasama ang
    sidebar at nahahati sa dalawang pahina ang printout. Sa mga device na iyon, sa
    mismong pahina tayo nagpi-print: kinokopya ang seksyon sa #app-print-root at may
    print-only na CSS na nagtatago sa lahat ng iba pa (printInPage).
--}}
@php
    $printFooterUser = auth()->check()
        ? trim((auth()->user()->name ?? '').' '.(auth()->user()->lastname ?? ''))
        : '';
@endphp
<script>
(function () {
    var PRINT_USER = @json($printFooterUser);

    // Oras ng makina sa sandaling nagprint — mas tumpak kaysa sa oras ng
    // pag-render ng pahina, na maaaring ilang oras nang luma.
    function printedStamp() {
        var months = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                      'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        var d = new Date();
        var hours = d.getHours();
        var suffix = hours >= 12 ? 'PM' : 'AM';
        hours = hours % 12 || 12;

        function pad(n) { return (n < 10 ? '0' : '') + n; }

        return months[d.getMonth()] + ' ' + pad(d.getDate()) + ', ' + d.getFullYear() +
               ' ' + pad(hours) + ':' + pad(d.getMinutes()) + ' ' + suffix;
    }

    // Idinadagdag lang kapag walang dalang footer ang seksyon (hal. hindi
    // kasama ang partials/print-header) para hindi ito madoble. Kung mayroon
    // na, ina-update na lang ang oras — oras ng pag-render kasi ang nakasulat
    // doon, hindi oras ng pagprint.
    function ensurePrintFooter(doc, sheet) {
        var existing = sheet.querySelectorAll('.clinic-print-footer');
        if (existing.length) {
            existing.forEach(function (node) {
                var stamp = node.querySelector('[data-printed-at]');
                if (stamp) stamp.textContent = 'Printed: ' + printedStamp();
            });
            return;
        }

        var footer = doc.createElement('div');
        footer.className = 'clinic-print-footer';
        footer.setAttribute('style',
            'position:fixed; left:10mm; right:10mm; bottom:6mm; padding:4px 0 0;' +
            'border-top:1px solid #999; display:flex; justify-content:space-between;' +
            "align-items:center; font-family:'Times New Roman', Georgia, serif;" +
            'font-size:8pt; color:#444;');

        var printedAt = doc.createElement('div');
        printedAt.textContent = 'Printed: ' + printedStamp();
        footer.appendChild(printedAt);

        if (PRINT_USER) {
            var printedBy = doc.createElement('div');
            printedBy.textContent = 'By: ' + PRINT_USER;
            footer.appendChild(printedBy);
        }

        sheet.appendChild(footer);
    }

    function copyStylesInto(doc) {
        // Isinasama ang lahat ng stylesheet ng parent page (kasama ang <style>
        // na ginagawa ng Tailwind CDN) para pareho ang itsura sa iframe.
        document.querySelectorAll('link[rel="stylesheet"], style').forEach(function (node) {
            doc.head.appendChild(doc.importNode(node, true));
        });
    }

    function syncFormValues(source, clone) {
        // Hindi dala ng cloneNode ang kasalukuyang halaga ng mga input, at
        // attributes lang ang nire-render sa ibang document — kaya attribute
        // ang isinusulat natin, hindi property.
        var originals = source.querySelectorAll('input, select, textarea');
        var copies    = clone.querySelectorAll('input, select, textarea');

        originals.forEach(function (el, i) {
            var copy = copies[i];
            if (!copy) return;

            if (el.type === 'checkbox' || el.type === 'radio') {
                if (el.checked) copy.setAttribute('checked', 'checked');
                else copy.removeAttribute('checked');
                return;
            }

            if (el.tagName === 'SELECT') {
                Array.prototype.forEach.call(copy.options, function (opt, j) {
                    if (j === el.selectedIndex) opt.setAttribute('selected', 'selected');
                    else opt.removeAttribute('selected');
                });
                return;
            }

            if (el.tagName === 'TEXTAREA') {
                copy.textContent = el.value;
                return;
            }

            copy.setAttribute('value', el.value);
        });
    }

    // Mga panuntunan para sa laman ng printout — iisa para sa iframe at sa
    // in-page na pagprint para pareho ang labas. Ang `scope` ay prefix ng
    // bawat selector: '' sa iframe (sariling document iyon), '#app-print-root '
    // sa in-page (para hindi tamaan ang ibang bahagi ng pahina).
    function contentRules(scope, padding) {
        function sel(list) {
            return list.split(',').map(function (s) { return scope + s.trim(); }).join(', ');
        }

        return sel('.print-sheet') + ' { padding: ' + padding + '; -webkit-box-decoration-break: clone; box-decoration-break: clone; }' +
            sel('.no-print, .print\\:hidden') + ' { display: none !important; }' +
            // Ang mga print-only na bloke ay dapat makita sa printout.
            sel('.hidden.print\\:block') + ' { display: block !important; }' +
            sel('thead') + ' { display: table-header-group; }' +
            sel('tr, img, svg') + ' { page-break-inside: avoid; break-inside: avoid; }' +
            sel('h1, h2, h3, h4, .pda-section-title, .print-keep-next') + ' { page-break-after: avoid; break-after: avoid-page; }' +
            sel('.print-keep-together') + ' { page-break-inside: avoid; break-inside: avoid; }' +
            sel('*') + ' { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }';
    }

    // Android, iPhone at iPad: buong tab ang napi-print kapag galing sa iframe.
    function needsInPagePrint() {
        var ua = navigator.userAgent || '';
        if (/Android|iPhone|iPad|iPod/i.test(ua)) return true;
        // iPadOS 13+ ay nagpapakilalang Mac.
        if (navigator.platform === 'MacIntel' && navigator.maxTouchPoints > 1) return true;
        // Android tablet na naka-"Desktop site" (walang "Android" sa UA) pero
        // touch pa rin ang pangunahing input.
        return !!(window.matchMedia && window.matchMedia('(hover: none) and (pointer: coarse)').matches);
    }

    // Nasa totoong pahina ang kopya sa in-page na pagprint, kaya inaalis ang
    // makakagulo roon: script, name ng form controls (para hindi maagaw ng
    // kopyang radio ang "checked" ng orihinal) at mga Alpine/Livewire attribute.
    // Hindi inaalis ang id — ginagamit ito ng print CSS ng ilang pahina
    // (hal. #patient-form), at nauuna naman sa DOM ang orihinal.
    function sanitizeClone(root) {
        root.querySelectorAll('script').forEach(function (node) { node.remove(); });

        root.querySelectorAll('input, select, textarea, button').forEach(function (el) {
            el.removeAttribute('name');
            el.removeAttribute('form');
        });

        [root].concat(Array.prototype.slice.call(root.querySelectorAll('*'))).forEach(function (el) {
            Array.prototype.slice.call(el.attributes).forEach(function (attr) {
                var n = attr.name;
                if (n.indexOf('x-') === 0 || n.indexOf('wire:') === 0 || n.charAt(0) === '@' || n.charAt(0) === ':') {
                    el.removeAttribute(n);
                }
            });
        });
    }

    var titleBeforePrint = null;

    function removeInPagePrint() {
        var oldRoot  = document.getElementById('app-print-root');
        var oldStyle = document.getElementById('app-print-style');
        if (oldRoot) oldRoot.remove();
        if (oldStyle) oldStyle.remove();
    }

    function printInPage(source, paper, scale, padding, options) {
        var style = document.createElement('style');
        style.id = 'app-print-style';
        style.textContent =
            '@page { size: ' + paper + '; margin: 0; }' +
            '@media screen { #app-print-root { display: none !important; } }' +
            '@media print {' +
                // Walang nakapirming taas o overflow — kung mayroon, nagdadagdag
                // ang mobile print engine ng blankong pahina.
                'html, body { height: auto !important; min-height: 0 !important; overflow: visible !important;' +
                    ' margin: 0 !important; padding: 0 !important; background: #fff !important; visibility: visible !important; }' +
                'body { zoom: ' + scale + '%; }' +
                'body > *:not(#app-print-root) { display: none !important; }' +
                '#app-print-root { display: block !important; font-family: system-ui, sans-serif; }' +
                contentRules('#app-print-root ', padding) +
                (options.css || '') +
            '}';
        document.head.appendChild(style);

        var clone = source.cloneNode(true);
        syncFormValues(source, clone);
        sanitizeClone(clone);

        var sheet = document.createElement('div');
        sheet.className = 'print-sheet';
        sheet.appendChild(clone);
        ensurePrintFooter(document, sheet);

        var root = document.createElement('div');
        root.id = 'app-print-root';
        root.setAttribute('x-ignore', '');      // huwag galawin ng Alpine
        root.setAttribute('aria-hidden', 'true');
        root.appendChild(sheet);
        document.body.appendChild(root);

        // Pamagat ng print job / PDF habang nagpi-print; ibinabalik pagkatapos.
        // Isang beses lang itinatabi ang orihinal kahit sunod-sunod ang print.
        if (titleBeforePrint === null) titleBeforePrint = document.title;
        if (options.title) document.title = options.title;
        window.addEventListener('afterprint', function () {
            if (titleBeforePrint !== null) document.title = titleBeforePrint;
            titleBeforePrint = null;
        }, { once: true });

        // Sadyang iniiwan ang #app-print-root hanggang sa susunod na print:
        // muling nire-render ng Android ang preview kapag pinalitan ang papel o
        // printer. Nakatago naman ito sa screen.
        window.print();
    }

    window.printSection = function (elementId, options) {
        // Alisin muna ang lumang kopya para ang orihinal na seksyon ang mahanap.
        removeInPagePrint();

        var source = document.getElementById(elementId);
        if (!source) return;

        options = options || {};
        var paper   = options.paper   || 'Letter';
        var scale   = options.scale   || 80;
        var padding = options.padding || '12mm 12mm 18mm';

        if (needsInPagePrint()) {
            printInPage(source, paper, scale, padding, options);
            return;
        }

        var oldFrame = document.getElementById('app-print-frame');
        if (oldFrame) oldFrame.remove();

        var frame = document.createElement('iframe');
        frame.id = 'app-print-frame';
        frame.setAttribute('aria-hidden', 'true');
        frame.style.cssText = 'position:fixed;right:0;bottom:0;width:0;height:0;border:0;';
        document.body.appendChild(frame);

        var doc = frame.contentDocument || frame.contentWindow.document;
        doc.title = options.title || document.title;

        copyStylesInto(doc);

        var style = doc.createElement('style');
        style.textContent =
            '@page { size: ' + paper + '; margin: 0; }' +
            'html, body { margin:0 !important; background:#fff !important; visibility:visible !important; }' +
            'body { zoom: ' + scale + '%; font-family: system-ui, sans-serif; }' +
            contentRules('', padding) +
            (options.css || '');
        doc.head.appendChild(style);

        var clone = source.cloneNode(true);
        syncFormValues(source, clone);

        var sheet = doc.createElement('div');
        sheet.className = 'print-sheet';
        sheet.appendChild(doc.importNode(clone, true));
        ensurePrintFooter(doc, sheet);
        doc.body.appendChild(sheet);
        doc.body.classList.add('tw-ready');

        // Bigyan ng sandali ang iframe para maisapatupad ang mga stylesheet.
        setTimeout(function () {
            frame.contentWindow.focus();
            frame.contentWindow.print();
        }, 400);
    };

    // Lahat ng resibo ng system ay 4x6 (10 x 15 cm) ang default na papel.
    // Ang max-width + auto margin ang pumipigil na mapunta ito sa kaliwang-itaas
    // na sulok kapag Letter/A4/Long ang piniling papel sa print dialog.
    var RECEIPT_CSS =
        '.print-sheet { width: 100%; max-width: 4in; margin: 0 auto; }' +
        '.print-sheet, .print-sheet * { font-size: 8pt !important; line-height: 1.35 !important; }' +
        '.clinic-print-header { padding: 0 0 4px !important; margin-bottom: 6px !important; gap: 6px !important; }' +
        '.clinic-print-header img { width: 32px !important; height: 32px !important; }' +
        '.clinic-print-header > div > div:first-child { font-size: 11pt !important; }' +
        '.print-sheet h2 { font-size: 9pt !important; margin: 2px 0 4px !important; }' +
        // Kailangan ng .print-sheet prefix para talunin ang `.print-sheet *` sa taas.
        '.print-sheet .clinic-print-footer { left: 4mm !important; right: 4mm !important; bottom: 3mm !important; font-size: 6pt !important; }' +
        '.print-sheet table { width: 100% !important; }' +
        '.print-sheet td, .print-sheet th { padding: 2px !important; }';

    window.printReceipt = function (elementId, title) {
        window.printSection(elementId, {
            paper: '4in 6in',
            scale: 100,
            padding: '5mm 5mm 9mm',
            title: title || 'Receipt',
            css: RECEIPT_CSS,
        });
    };
})();
</script>

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

    Nagpiprint ito sa loob ng nakatagong iframe: hindi na sinisira ang kasalukuyang
    pahina (dating ginagawa ng document.body.innerHTML = ...) kaya wala nang reload
    pagkatapos, at hindi rin ito hinaharang ng popup blocker.
--}}
<script>
(function () {
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

    window.printSection = function (elementId, options) {
        var source = document.getElementById(elementId);
        if (!source) return;

        options = options || {};
        var paper   = options.paper   || 'Letter';
        var scale   = options.scale   || 80;
        var padding = options.padding || '12mm 12mm 18mm';

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
            '.print-sheet { padding: ' + padding + '; -webkit-box-decoration-break: clone; box-decoration-break: clone; }' +
            '.no-print, .print\\:hidden { display: none !important; }' +
            // Ang mga print-only na bloke ay dapat makita sa loob ng iframe.
            '.hidden.print\\:block { display: block !important; }' +
            'thead { display: table-header-group; }' +
            'tr, img, svg { page-break-inside: avoid; break-inside: avoid; }' +
            'h1,h2,h3,h4,.pda-section-title,.print-keep-next { page-break-after: avoid; break-after: avoid-page; }' +
            '.print-keep-together { page-break-inside: avoid; break-inside: avoid; }' +
            '* { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }' +
            (options.css || '');
        doc.head.appendChild(style);

        var clone = source.cloneNode(true);
        syncFormValues(source, clone);

        var sheet = doc.createElement('div');
        sheet.className = 'print-sheet';
        sheet.appendChild(doc.importNode(clone, true));
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

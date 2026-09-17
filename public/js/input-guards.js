/**
 * Mga pangkalahatang bantay sa input. Naka-delegate sa document kaya tumatalab
 * din sa mga field na idinagdag pagkatapos mag-load (modal, Livewire, atbp.).
 *
 *   class="js-digits-only"    -> numero lang ang natatanggap
 *   class="js-mobile-number"  -> numero lang, 11 digit, laging nagsisimula sa 09
 *
 * Habang nagta-type lang ito tumatalab. SADYANG hindi ginagalaw ang mga
 * halagang galing sa database: may lumang tala na "N/A" o 12-digit na numero,
 * at kung tahimik nating lilinisin iyon ay baka ma-save ang maling numero nang
 * hindi napapansin ng gumagamit. Ang pattern/validation na ang magsasabi sa
 * kanila na may dapat ayusin.
 *
 * Panig-kliyente lang ito — nananatiling kailangan ang validation sa server.
 */
(function () {
    function digitsOnly(value) {
        return (value || '').replace(/\D+/g, '');
    }

    // May mga lumang tala na naka-imbak bilang +639171234567 o 639171234567.
    // Ginagawa itong 09171234567 sa halip na basta putulin sa 11 digit — kung
    // pinutol lang, magiging 63917123456 at mali na ang buong numero.
    function toLocalMobile(digits) {
        if (digits.indexOf('63') === 0 && digits.length > 11) return '0' + digits.slice(2);
        return digits;
    }

    function clean(el) {
        var cleaned;

        if (el.classList.contains('js-mobile-number')) {
            cleaned = toLocalMobile(digitsOnly(el.value)).slice(0, 11);
        } else {
            cleaned = digitsOnly(el.value);
            var max = parseInt(el.getAttribute('maxlength'), 10);
            if (max > 0) cleaned = cleaned.slice(0, max);
        }

        if (cleaned === el.value) return;

        // Pinapanatili ang posisyon ng cursor para hindi tumalon sa dulo kapag
        // may tinanggal na karakter sa gitna.
        var pos = el.selectionStart;
        var removed = el.value.length - cleaned.length;
        el.value = cleaned;

        if (el.type === 'text' && pos !== null) {
            var next = Math.max(0, pos - removed);
            try { el.setSelectionRange(next, next); } catch (e) { /* hindi suportado */ }
        }
    }

    function isGuarded(el) {
        return el && el.classList && (
            el.classList.contains('js-digits-only') ||
            el.classList.contains('js-mobile-number')
        );
    }

    document.addEventListener('input', function (e) {
        if (isGuarded(e.target)) clean(e.target);
    }, true);

    document.addEventListener('paste', function (e) {
        if (!isGuarded(e.target)) return;
        // Hayaang mag-paste muna, saka linisin — mas simple kaysa i-parse ang clipboard.
        var el = e.target;
        setTimeout(function () { clean(el); }, 0);
    }, true);
})();

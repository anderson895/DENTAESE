/**
 * Cascading address dropdowns: Province -> City/Municipality -> Barangay.
 *
 * Kailangan muna ang public/js/ph-address.js (doon galing ang window.PH_ADDRESS).
 * Ang mga select ay hinahanap sa pamamagitan ng data-address-role attribute,
 * kaya walang nakapirming id at pwedeng maulit sa iisang pahina.
 *
 *   const addr = window.initAddressCascade(document.getElementById('step-1'));
 *   addr.setValue('Bulacan', 'Marilao', 'Patubig');   // hal. pag-restore
 *
 * Birthplace (Province -> City/Municipality, buong Pilipinas) — kailangan ang
 * public/js/ph-birthplace.js (window.PH_BIRTHPLACE) at data-birthplace-role:
 *
 *   const bp = window.initBirthplaceCascade(document.getElementById('step-1'));
 *   bp.setValue('Bulacan', 'Marilao');
 */
(function () {
    function fillOptions(select, items, placeholder) {
        select.innerHTML = '';

        var blank = document.createElement('option');
        blank.value = '';
        blank.textContent = placeholder;
        select.appendChild(blank);

        items.forEach(function (name) {
            var option = document.createElement('option');
            option.value = name;
            option.textContent = name;
            select.appendChild(option);
        });
    }

    window.initAddressCascade = function (root) {
        root = root || document;

        var data    = window.PH_ADDRESS || {};
        var provSel = root.querySelector('[data-address-role="province"]');
        var muniSel = root.querySelector('[data-address-role="municipality"]');
        var brgySel = root.querySelector('[data-address-role="barangay"]');

        if (!provSel || !muniSel || !brgySel) return null;

        function municipalitiesOf(province) {
            return data[province] ? Object.keys(data[province]) : [];
        }

        function barangaysOf(province, municipality) {
            return (data[province] && data[province][municipality]) || [];
        }

        function refreshMunicipalities() {
            var items = municipalitiesOf(provSel.value);
            fillOptions(muniSel, items, items.length
                ? '-- Select City / Municipality --'
                : '-- Select a province first --');
        }

        function refreshBarangays() {
            var items = barangaysOf(provSel.value, muniSel.value);
            fillOptions(brgySel, items, items.length
                ? '-- Select Barangay --'
                : '-- Select a city / municipality first --');
        }

        // Ang markup ay may dalang kasalukuyang halaga sa data-selected para
        // tumugma pa rin kahit hindi pa napupuno ang mga option sa ibaba.
        var initial = {
            province:     provSel.getAttribute('data-selected') || '',
            municipality: muniSel.getAttribute('data-selected') || '',
            barangay:     brgySel.getAttribute('data-selected') || '',
        };

        fillOptions(provSel, Object.keys(data), '-- Select Province --');

        provSel.addEventListener('change', function () {
            refreshMunicipalities();
            refreshBarangays();
        });

        muniSel.addEventListener('change', refreshBarangays);

        var api = {
            setValue: function (province, municipality, barangay) {
                provSel.value = province || '';
                refreshMunicipalities();
                muniSel.value = municipality || '';
                refreshBarangays();
                brgySel.value = barangay || '';
            },
        };

        api.setValue(initial.province, initial.municipality, initial.barangay);

        return api;
    };

    // Dalawang antas lang ang Birthplace (walang barangay) at iba ang data
    // nito — buong bansa, hindi lang ang mga lalawigan ng Current Address.
    window.initBirthplaceCascade = function (root) {
        root = root || document;

        var data    = window.PH_BIRTHPLACE || {};
        var provSel = root.querySelector('[data-birthplace-role="province"]');
        var muniSel = root.querySelector('[data-birthplace-role="municipality"]');

        if (!provSel || !muniSel) return null;

        function refreshMunicipalities() {
            var items = data[provSel.value] || [];
            fillOptions(muniSel, items, items.length
                ? '-- Select City / Municipality --'
                : '-- Select a province first --');
        }

        var initial = {
            province:     provSel.getAttribute('data-selected') || '',
            municipality: muniSel.getAttribute('data-selected') || '',
        };

        fillOptions(provSel, Object.keys(data), '-- Select Province --');
        provSel.addEventListener('change', refreshMunicipalities);

        var api = {
            setValue: function (province, municipality) {
                provSel.value = province || '';
                refreshMunicipalities();
                muniSel.value = municipality || '';
            },
        };

        api.setValue(initial.province, initial.municipality);

        return api;
    };
})();

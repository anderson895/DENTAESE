/**
 * Cascading address dropdowns: Province -> City/Municipality -> Barangay.
 *
 * Kailangan muna ang public/js/ph-address.js (doon galing ang window.PH_ADDRESS).
 * Ang mga select ay hinahanap sa pamamagitan ng data-address-role attribute,
 * kaya walang nakapirming id at pwedeng maulit sa iisang pahina.
 *
 *   const addr = window.initAddressCascade(document.getElementById('step-1'));
 *   addr.setValue('Bulacan', 'Marilao', 'Patubig');   // hal. pag-restore
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
})();

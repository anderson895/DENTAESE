{{--
    Current Address — dropdown na ang Province / City-Municipality / Barangay
    para hindi na nade-depende sa pagta-type ang tatlong ito (PSGC data).
    Kailangan ng pahina ang public/js/ph-address.js at address-select.js, saka
    tawagin ang window.initAddressCascade() sa container ng mga field na ito.

    Optional na variable:
        $values — array ng kasalukuyang halaga, hal. old() o galing sa user record.
--}}
@php
    $addr = $values ?? [];
    $addrValue = fn ($key) => old($key, $addr[$key] ?? '');
@endphp

<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
    <div>
        <label>Province</label>
        <select name="address_province" data-address-role="province"
                data-selected="{{ $addrValue('address_province') }}"
                class="w-full border p-2 rounded bg-white" required>
            <option value="">-- Select Province --</option>
        </select>
    </div>
    <div>
        <label>City / Municipality</label>
        <select name="address_municipality" data-address-role="municipality"
                data-selected="{{ $addrValue('address_municipality') }}"
                class="w-full border p-2 rounded bg-white" required>
            <option value="">-- Select a province first --</option>
        </select>
    </div>
    <div>
        <label>Barangay</label>
        <select name="address_barangay" data-address-role="barangay"
                data-selected="{{ $addrValue('address_barangay') }}"
                class="w-full border p-2 rounded bg-white" required>
            <option value="">-- Select a city / municipality first --</option>
        </select>
    </div>
    <div>
        <label>Street</label>
        <input type="text" name="address_street" class="w-full border p-2 rounded" required
               maxlength="50" placeholder="Street" value="{{ $addrValue('address_street') }}">
    </div>
    <div>
        <label>House Number</label>
        <input type="text" name="address_house_number" class="w-full border p-2 rounded"
               maxlength="50" placeholder="House Number" value="{{ $addrValue('address_house_number') }}">
    </div>
    <div>
        <label>Other Details</label>
        <input type="text" name="address_other_details" class="w-full border p-2 rounded"
               maxlength="50" placeholder="Apartment, Unit, Landmark, etc."
               value="{{ $addrValue('address_other_details') }}">
    </div>
</div>

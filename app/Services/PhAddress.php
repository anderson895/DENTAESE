<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * Sagot sa tanong na "totoo ba ang piniling address?".
 *
 * Dropdown na ang address sa registration, pero kaya pa ring i-post ang kahit
 * anong halaga nang diretso sa endpoint — kaya dito sinasala ang province /
 * city-municipality / barangay laban sa parehong PSGC data na ginagamit ng
 * mga dropdown (resources/data/ph-address.json).
 */
class PhAddress
{
    /** @var array<string, array<string, string[]>>|null */
    private static ?array $data = null;

    /**
     * @return array<string, array<string, string[]>>
     */
    public static function all(): array
    {
        if (self::$data === null) {
            $path = resource_path('data/ph-address.json');
            $raw  = is_file($path) ? file_get_contents($path) : '';
            self::$data = json_decode($raw ?: '{}', true) ?: [];
        }

        return self::$data;
    }

    /**
     * @return string[]
     */
    public static function provinces(): array
    {
        return array_keys(self::all());
    }

    /**
     * @return string[]
     */
    public static function municipalities(?string $province): array
    {
        return array_keys(self::all()[$province] ?? []);
    }

    /**
     * @return string[]
     */
    public static function barangays(?string $province, ?string $municipality): array
    {
        return self::all()[$province][$municipality] ?? [];
    }

    public static function hasProvince(?string $province): bool
    {
        return $province !== null && array_key_exists($province, self::all());
    }

    public static function hasMunicipality(?string $province, ?string $municipality): bool
    {
        return $municipality !== null
            && array_key_exists($municipality, self::all()[$province] ?? []);
    }

    public static function hasBarangay(?string $province, ?string $municipality, ?string $barangay): bool
    {
        return $barangay !== null
            && in_array($barangay, self::barangays($province, $municipality), true);
    }

    /**
     * Mga validation rule para sa tatlong magkakaugnay na address field.
     * Ang bawat antas ay sinusuri laban sa napili sa itaas nito, kaya hindi
     * pwedeng ipares ang barangay ng ibang bayan.
     *
     * @return array<string, array<int, mixed>>
     */
    public static function rules(Request $request, bool $required = true): array
    {
        $province     = $request->input('address_province');
        $municipality = $request->input('address_municipality');

        $presence = $required ? 'required' : 'nullable';

        // Rule::in (hindi ang "in:a,b,c" na string) — may barangay na may kuwit
        // sa pangalan, tulad ng "Hermogenes C. Concepcion, Sr.", at mahahati
        // iyon nang mali kapag string ang ginamit.
        return [
            'address_province'     => [$presence, 'string', Rule::in(self::provinces())],
            'address_municipality' => [$presence, 'string', Rule::in(self::municipalities($province))],
            'address_barangay'     => [$presence, 'string', Rule::in(self::barangays($province, $municipality))],
        ];
    }

    /**
     * @return array<string, string>
     */
    public static function messages(): array
    {
        return [
            'address_province.in'     => 'Please choose a province from the list.',
            'address_municipality.in' => 'Please choose a city/municipality that belongs to the selected province.',
            'address_barangay.in'     => 'Please choose a barangay that belongs to the selected city/municipality.',
        ];
    }
}

<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;

/**
 * Step 1 ng signup (final defense revision 10/12/26):
 *  - 2 taong gulang pataas lang ang puwedeng magparehistro.
 *  - Dropdown na ang Birthplace (Province -> City/Municipality, buong Pilipinas),
 *    kaya tinatanggihan ng server ang halagang wala sa listahan.
 *
 * DatabaseTransactions (hindi RefreshDatabase): ang totoong local na `dentaease`
 * DB ang tinatamaan ng tests.
 */
class SignupStepOneValidationTest extends TestCase
{
    use DatabaseTransactions;

    private function validStepOne(array $overrides = []): array
    {
        return array_merge([
            'step'                    => 1,
            'account_type'            => 'patient',
            'name'                    => 'Juan',
            'lastname'                => 'Dela Cruz',
            'birth_date'              => now()->subYears(25)->toDateString(),
            'birthplace_province'     => 'Bulacan',
            'birthplace_municipality' => 'Marilao',
            'address_province'        => 'Bulacan',
            'address_municipality'    => 'Marilao',
            'address_barangay'        => 'Prenza I',
            'address_street'          => 'Rizal St.',
        ], $overrides);
    }

    public function test_valid_step_one_passes(): void
    {
        $this->postJson(route('signup.validateStep'), $this->validStepOne())
            ->assertOk();
    }

    public function test_patient_younger_than_two_is_rejected(): void
    {
        $this->postJson(route('signup.validateStep'), $this->validStepOne([
            'birth_date' => now()->subYear()->toDateString(),
        ]))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['birth_date' => 'You must be at least 2 years old to register.']);
    }

    public function test_patient_exactly_two_years_old_is_accepted(): void
    {
        $this->postJson(route('signup.validateStep'), $this->validStepOne([
            'birth_date' => now()->subYears(2)->toDateString(),
        ]))
            ->assertOk();
    }

    public function test_birthplace_outside_the_five_address_provinces_is_accepted(): void
    {
        // Buong Pilipinas ang Birthplace, hindi lang ang mga lalawigan ng Current Address.
        $this->postJson(route('signup.validateStep'), $this->validStepOne([
            'birthplace_province'     => 'Cebu',
            'birthplace_municipality' => 'Cebu City',
        ]))
            ->assertOk();
    }

    public function test_unknown_birthplace_province_is_rejected(): void
    {
        $this->postJson(route('signup.validateStep'), $this->validStepOne([
            'birthplace_province' => 'Atlantis',
        ]))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['birthplace_province', 'birthplace_municipality']);
    }

    public function test_birthplace_municipality_must_belong_to_the_province(): void
    {
        $this->postJson(route('signup.validateStep'), $this->validStepOne([
            'birthplace_province'     => 'Cebu',
            'birthplace_municipality' => 'Marilao',
        ]))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['birthplace_municipality'])
            ->assertJsonMissingValidationErrors(['birthplace_province']);
    }

    public function test_non_string_birthplace_province_is_rejected_without_crashing(): void
    {
        $this->postJson(route('signup.validateStep'), $this->validStepOne([
            'birthplace_province' => ['Bulacan'],
        ]))
            ->assertStatus(422)
            ->assertJsonValidationErrors(['birthplace_province', 'birthplace_municipality']);
    }
}

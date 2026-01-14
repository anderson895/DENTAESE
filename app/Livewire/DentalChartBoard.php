<?php

namespace App\Livewire;

use App\Models\DentalChart;
use App\Models\User;
use Livewire\Component;

class DentalChartBoard extends Component
{
    public $patient;
    public $chart = [];
    public function mount(User $patient)
    {
        $this->patient = $patient;

        // load chart as array for Livewire binding
        $this->chart = DentalChart::firstOrCreate([
            'patient_id' => $patient->id,
        ])->toArray();
    }

   public function updated($propertyName, $value)
{
  

    $data = collect($this->chart)
        ->only((new DentalChart)->getFillable())
        ->toArray();

    $data['patient_id'] = $this->patient->id;

    DentalChart::updateOrCreate(
        ['patient_id' => $this->patient->id],
        $data
    );
}
    public function render()
    {
        return view('livewire.dental-chart-board');
    }

public function toothImage($tooth)
{
    $condition = $this->chart["tooth_{$tooth}_condition"] ?? '';
    $treatment = $this->chart["tooth_{$tooth}_treatment"] ?? '';

    // SURGERY / EXTRACTIONS
    if (in_array($treatment, ['X', 'XO'])) {
        return 'images/teeth/abutment.png'; // updated extracted image
    }

    // RESTORATIONS / TREATMENTS
    return match ($treatment) {
        'JC' => 'images/teeth/crown.png',
        'Imp' => 'images/teeth/implant.png',
        'S' => 'images/teeth/sealant.png',
        'Am' => 'images/teeth/amalgam.png', // new possible treatment
        'P' => 'images/teeth/pontic.png',   // if pontic is used
        default => match ($condition) {
            'D'  => 'images/teeth/decayed.png',
            'M', 'MO' => 'images/teeth/missing.png',
            'Im' => 'images/teeth/impacted.png',
            'Un' => 'images/teeth/unerupted.png',
            default => 'images/teeth/normal.png',
        },
    };
}

}

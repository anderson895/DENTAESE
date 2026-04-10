<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use BaconQrCode\Renderer\Image\SvgImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;

class RegenerateQrCodes extends Command
{
    protected $signature   = 'qr:regenerate';
    protected $description = 'Regenerate all existing SVG QR codes to PNG format using GD';

    public function handle()
    {
        $users = User::whereNotNull('qr_token')->get();

        if ($users->isEmpty()) {
            $this->info('No users with QR tokens found.');
            return;
        }

        $this->info("Found {$users->count()} users. Regenerating QR codes...");
        $bar = $this->output->createProgressBar($users->count());
        $bar->start();

        foreach ($users as $user) {
            try {
                // Delete old SVG
                $oldSvg = 'qr_codes/qr_' . $user->id . '.svg';
                if (Storage::disk('public')->exists($oldSvg)) {
                    Storage::disk('public')->delete($oldSvg);
                }

                // Generate PNG via GD
                $newFilename = 'qr_' . $user->id . '.png';
                $pngData     = $this->generatePngViaGd($user->qr_token, 300);

                Storage::disk('public')->put("qr_codes/{$newFilename}", $pngData);

                $user->qr_code = $newFilename;
                $user->save();

            } catch (\Exception $e) {
                $this->newLine();
                $this->error("Failed for user ID {$user->id}: " . $e->getMessage());
            }

            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Done! All QR codes regenerated as PNG.');
    }

    private function generatePngViaGd(string $token, int $size): string
    {
        $encoded   = \BaconQrCode\Encoder\Encoder::encode($token, \BaconQrCode\Common\ErrorCorrectionLevel::M());
        $matrix    = $encoded->getMatrix();
        $matrixSize = $matrix->getWidth();

        $scale  = (int) floor($size / ($matrixSize + 2));
        $margin = (int) floor(($size - ($matrixSize * $scale)) / 2);

        $img   = imagecreatetruecolor($size, $size);
        $white = imagecolorallocate($img, 255, 255, 255);
        $black = imagecolorallocate($img, 0, 0, 0);
        imagefill($img, 0, 0, $white);

        for ($y = 0; $y < $matrixSize; $y++) {
            for ($x = 0; $x < $matrixSize; $x++) {
                if ($matrix->get($x, $y) === 1) {
                    $x1 = $margin + $x * $scale;
                    $y1 = $margin + $y * $scale;
                    imagefilledrectangle($img, $x1, $y1, $x1 + $scale - 1, $y1 + $scale - 1, $black);
                }
            }
        }

        ob_start();
        imagepng($img);
        $png = ob_get_clean();
        imagedestroy($img);

        return $png;
    }
}
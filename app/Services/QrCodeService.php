<?php

declare(strict_types=1);

namespace App\Services;

use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;

class QrCodeService
{
    /**
     * Générer un QR code pour un relevé de notes
     *
     * @param  string  $verificationUrl  URL de vérification complète
     * @return string Data URI (base64) du QR code
     */
    public function generateTranscriptQrCode(string $verificationUrl): string
    {
        $builder = new Builder(
            writer: new PngWriter(),
            writerOptions: [],
            validateResult: false,
            data: $verificationUrl,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::High,
            size: 200,
            margin: 10,
            roundBlockSizeMode: RoundBlockSizeMode::Margin,
        );

        $result = $builder->build();

        // Retourner en Data URI pour intégration directe dans PDF
        return $result->getDataUri();
    }
}

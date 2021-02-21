<?php

namespace App\Libraries;

use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\LabelAlignment;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Response\QrCodeResponse;

class MyQrcode
{
    private $label;

    private $size = 300;

    private $margin = 10;


    public function setSize($size)
    {
        $this->size = $size;
    }

    public function setMagin($margin)
    {
        $this->margin = $margin;
    }

    public function setLabel($label)
    {
        $this->label = $label;
    }

    public function CreateQrcodeToFile($data, $namafile)
    {
        $qrCode = new QrCode($data);
        $qrCode->setSize($this->size);
        $qrCode->setMargin($this->margin);

        // Set advanced options
        $qrCode->setWriterByName('png');
        $qrCode->setEncoding('UTF-8');
        $qrCode->setErrorCorrectionLevel(ErrorCorrectionLevel::HIGH());
        $qrCode->setForegroundColor(['r' => 0, 'g' => 0, 'b' => 0, 'a' => 0]);
        $qrCode->setBackgroundColor(['r' => 255, 'g' => 255, 'b' => 255, 'a' => 0]);

        $qrCode->setLabel($this->label, 16, __DIR__ . '/../../vendor/endroid/qr-code/assets/fonts/noto_sans.otf', LabelAlignment::CENTER());

        $qrCode->setRoundBlockSize(true, QrCode::ROUND_BLOCK_SIZE_MODE_MARGIN); // The size of the qr code is shrinked, if necessary, but the size of the final image remains unchanged due to additional margin being added (default)
        $qrCode->setRoundBlockSize(true, QrCode::ROUND_BLOCK_SIZE_MODE_ENLARGE); // The size of the qr code and the final image is enlarged, if necessary
        $qrCode->setRoundBlockSize(true, QrCode::ROUND_BLOCK_SIZE_MODE_SHRINK); // The size of the qr code and the final image is shrinked, if necessary
        $namaqrcode = 'ukey/' . $namafile . '.png';
        $qrCode->writeFile($namaqrcode);
    }
}

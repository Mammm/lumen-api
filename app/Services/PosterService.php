<?php


namespace App\Services;


use Intervention\Image\Facades\Image;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PosterService
{
    private string $qrCodeFormat = "png";
    private int $qrCodeSize = 184;

    /**
     * 创建二维码
     * @param string $content
     * @return string
     */
    public function makeQrCodeImage(string $content): string
    {
        return QrCode::format($this->qrCodeFormat)
            ->margin(0)
            ->size($this->qrCodeSize)
            ->generate($content, new_tmp_file($this->qrCodeFormat));
    }

    /**
     * 创建二维码海报
     * @param string $backgroundImg
     * @param string $qrCodeImg
     * @return false|string
     */
    public function makePosterImage(string $backgroundImg, string $qrCodeImg)
    {
        $postPath = new_tmp_file("jpg");

        Image::make($backgroundImg)
            ->insert($qrCodeImg, 'bottom-left', 35, 30)
            ->save($postPath);

        return $postPath;
    }
}

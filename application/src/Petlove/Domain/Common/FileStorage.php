<?php

namespace Petlove\Domain\Common;

use Symfony\Component\HttpFoundation\File\UploadedFile;

interface FileStorage
{
    /**
     * @param UploadedFile $file
     * @param string $fileName
     * @return string
     */
    public function upload(UploadedFile $file, $fileName);

    /**
     * @param string $fileName
     */
    public function getFileUrl($fileName);

    /**
     * @param string $extension
     * @return bool
     */
    public function checkSupportedExtensions($extension);
}

<?php

namespace Petlove\Infrastructure\Common;

use Petlove\Domain\Common\FileStorage;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class HdFileStorage implements FileStorage
{
    /** @var string */
    private $baseDir;
    /** @var string|null */
    private $baseUrl;

    private $extensions = ['png', 'jpg', 'jpeg', 'pdf', 'svg', 'tif', 'tiff'];

    public function __construct($mediaDir, $mediaUrl)
    {
        $this->baseDir = rtrim($mediaDir, "/");
        $this->baseUrl = rtrim($mediaUrl, "/");
    }

    /**
     * @return string
     * @internal
     */
    public function getBaseDir()
    {
        return $this->baseDir;
    }

    /**
     * @param UploadedFile $file
     * @param string $fileName
     * @return string
     */
    public function upload(UploadedFile $file, $fileName)
    {
        $fileName = ltrim($fileName, "/");
        $path = $this->baseDir . "/" . $fileName;

        if (!file_exists(dirname($path))) {
            mkdir(dirname($path), 0777, true);
        }

        $path = $this->baseDir . "/" . dirname($fileName);
        $file->move($path, basename($fileName));

        return realpath($path . "/" . basename($fileName));
    }

    /**
     * @param string $filename
     * @return float
     */
    public function getFileUrl($filename)
    {
        return $this->baseUrl . "/" . $filename;
    }

    /**
     * @param string $extension
     * @return bool
     */
    public function checkSupportedExtensions($extension)
    {
        return in_array($extension, $this->extensions);
    }
}

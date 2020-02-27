<?php

namespace App\Services;

use Str;
use App\Models\Picture\Picture;

class PictureService
{
    /** @var \Illuminate\Filesystem\FilesystemAdapter */
    public $localDisk;

    /** @var string */
    public static $picturesDirectory = 'uploads' . DIRECTORY_SEPARATOR  . 'pictures';

    public function __construct()
    {
        $this->localDisk = \Storage::disk(config('filesystems.public'));
    }

    /**
     * Get directory for pictures
     *
     * @return string
     */
    public static function getPicturesDirectory()
    {
        return static::$picturesDirectory;
    }

    /**
     * Store picture to local Storage, save picture to DB and start Job
     *
     * @param string $fileContent
     * @param string $fileExtension
     * @return bool|Picture
     * @throws
     */
    public function process(string $fileContent, $fileExtension)
    {
        //Generate name
        $fileName = $this->generateRandomName($fileExtension);

        //Save file to local storage
        $result = $this->storeLocal($fileContent, $fileName);

        if(!$result) {
            throw new \Exception('Файл не сохранен на сервере');
        }
        //Save to DB
        $picture = new Picture();
        $picture->filename = $fileName;
        $picture->hash = Str::random(16);

        if(!$picture->save()) {
            throw new \Exception('Изображение не сохранено в базе данных');
        }

        return $picture;
    }

    /**
     * Save file to local storage
     *
     * @param $fileContent
     * @param string $fileName
     * @return bool
     */
    protected function storeLocal($fileContent, $fileName)
    {
        return $this->localDisk->put(PictureService::getPicturesDirectory() . DIRECTORY_SEPARATOR . $fileName, $fileContent);
    }

    /**
     * Generate random name for file
     *
     * @param string $extension
     * @return string
     */
    protected function generateRandomName($extension = 'png')
    {
        return Str::random(16) . '.' . $extension;
    }
}
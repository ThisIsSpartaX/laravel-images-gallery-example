<?php

namespace App\Services;

use Str;
use App\Jobs\PictureProcessJob;
use App\Models\Picture\Picture;
use GuzzleHttp\Exception\ClientException;

class PictureService
{
    /** @var \Illuminate\Filesystem\FilesystemAdapter */
    public $localDisk;

    /** @var string */
    public static $picturesDirectory = 'uploads' . DIRECTORY_SEPARATOR  . 'pictures';

    /** @var string */
    public static $picturesS3Directory = 'uploads/pictures';

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
     * Get directory for pictures on S3
     *
     * @return string
     */
    public static function getPicturesS3Directory()
    {
        return static::$picturesS3Directory;
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

        $filePath = \Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix() . PictureService::getPicturesDirectory() . DIRECTORY_SEPARATOR .  $fileName;

        //Save file to local storage
        $result = $this->storeLocal($fileContent, $fileName);

        if($result) {
            //Save to DB
            $picture = new Picture();
            $picture->filename = $fileName;
            $picture->hash = Str::random(16);
            if(!$picture->save()) {
                throw new \Exception('Изображение не сохранено в базе данных');
            }

            //Get sizes for resize
            $sizes = $this->getSizes($fileName);

            //Dispatch Job
            PictureProcessJob::dispatch($picture, $filePath, $fileName, $sizes);

            return $picture;
        }
        return false;
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
        return \Storage::disk('local')->put(PictureService::getPicturesDirectory() . DIRECTORY_SEPARATOR . $fileName, $fileContent);
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

    /**
     * Get URL for file
     *
     * @param string $fileName
     * @param string|null $subDirectory
     * @return string
     */
    public static function getFileUrl(string $fileName, $subDirectory = '')
    {
        return config('filesystems.disks.s3.url') . '/' . static::getPicturesS3Directory() . '/' . ($subDirectory ? $subDirectory . '/' : '') . $fileName;
    }

    /**
     * Parse image sizes for Kraken Service
     *
     * @param string $fileName
     * @return array
     */
    protected function getSizes(string $fileName)
    {
        $configSizes = config('kraken.sizes');

        $sizes = [];
        $i = 0;
        foreach ($configSizes as $configSize) {
            $sizes[$i]['id'] = $configSize['id'];
            if(isset($configSize['width'])) {
                $sizes[$i]['width'] = $configSize['width'];
            }
            if(isset($configSize['height'])) {
                $sizes[$i]['height'] = $configSize['height'];
            }
            $sizes[$i]['strategy'] = $configSize['strategy'];
            $sizes[$i]['storage_path'] =  static::getPicturesS3Directory() . '/' . $configSize['id'] . '/' . $fileName;
            if(isset($configSize['lossy'])) {
                $sizes[$i]['lossy'] = $configSize['lossy'];
            }
            if(isset($configSize['quality'])) {
                $sizes[$i]['quality'] = $configSize['quality'];
            }
            $i++;
        }

        return $sizes;
    }
}
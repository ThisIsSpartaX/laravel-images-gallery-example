<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Services\KrakenService;
use App\Models\Picture\Picture;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;

class PictureProcessJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Picture $pictureRecord;

    protected string $filePath;

    protected string $fileName;

    protected array $sizes;

    protected KrakenService $service;

    /**
     * Create a new job instance.
     *
     * @param Picture $pictureRecord
     * @param string $filePath
     * @param string $fileName
     * @param array $sizes
     *
     * @return void
     */
    public function __construct(Picture $pictureRecord, string $filePath, string $fileName, array $sizes)
    {
        $this->pictureRecord = $pictureRecord;
        $this->filePath = $filePath;
        $this->fileName = $fileName;
        $this->sizes = $sizes;
        $this->service = new KrakenService();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::info('Start PictureProcessJob');
        $params = array(
            'file' => $this->filePath,
            'wait' => true,
            'resize' => $this->sizes,
            's3_store' => [
                'key'    => config('filesystems.disks.s3.key'),
                'secret' => config('filesystems.disks.s3.secret'),
                'bucket' => config('filesystems.disks.s3.bucket'),
                'region' => config('filesystems.disks.s3.region'),
            ]
        );
        $data = $this->service->upload($params);
        $this->pictureRecord->is_completed = true;
        $this->pictureRecord->save();
        Log::info($data);
    }
}

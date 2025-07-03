<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Laravel\Jetstream\Features;

trait HasBackgroundPhoto
{
    /**
     * Update the user's background photo.
     *
     * @param  \Illuminate\Http\UploadedFile  $photo
     * @return void
     */
    public function updateBackgroundPhoto(UploadedFile $photo)
    {
        tap($this->background_photo_path, function ($previous) use ($photo) {
            $this->forceFill([
                'background_photo_path' => $photo->storePublicly(
                    'background-photos', ['disk' => $this->backgroundPhotoDisk()]
                ),
            ])->save();

            if ($previous) {
                Storage::disk($this->backgroundPhotoDisk())->delete($previous);
            }
        });
    }

    /**
     * Delete the user's background photo.
     *
     * @return void
     */
    public function deleteBackgroundPhoto()
    {
        // if (! Features::managesbackgroundPhotos()) {
        //     return;
        // }

        Storage::disk($this->backgroundPhotoDisk())->delete($this->background_photo_path);

        $this->forceFill([
            'background_photo_path' => null,
        ])->save();
    }

    /**
     * Get the URL to the user's background photo.
     *
     * @return string
     */
    public function getBackgroundPhotoUrlAttribute()
    {
        return $this->background_photo_path
                    ? Storage::disk($this->backgroundPhotoDisk())->url($this->background_photo_path)
                    : $this->defaultBackgroundPhotoUrl();
        //return 'https://perksweet-uploads.s3.amazonaws.com/background-photos/owHkz1aEtaLLshsAhDzfUgHazpUhsQjvoMaGJ3fC.jpg';
    }

    /**
     * Get the default background photo URL if no background photo has been uploaded.
     *
     * @return string
     */
    protected function defaultBackgroundPhotoUrl()
    {
        $name = $this->name;

        $result = explode(' ', $name);

        if (count($result) > 2) {
            $name = $result[1].' '.$result[2];
        }

        return 'https://ui-avatars.com/api/?name='.urlencode($name).'&color=7F9CF5&background=EBF4FF';
    }

    /**
     * Get the disk that background photos should be stored on.
     *
     * @return string
     */
    protected function backgroundPhotoDisk()
    {
        return isset($_ENV['VAPOR_ARTIFACT_NAME']) ? 's3' : config('jetstream.profile_photo_disk', 'public');
    }
}

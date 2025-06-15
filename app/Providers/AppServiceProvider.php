<?php

namespace App\Providers;

use App\Modules\ImageUpload\CloudinaryImageManager;
use App\Modules\ImageUpload\ImageManagerInterface;
use App\Modules\ImageUpload\LocalImageManager;
use Cloudinary\Cloudinary;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // Cloudinary の設定が存在する場合のみバインド（CIなど環境未設定時のエラー防止）
        if (env('CLOUDINARY_CLOUD_NAME') && env('CLOUDINARY_API_KEY') && env('CLOUDINARY_API_SECRET')) {
            $this->app->bind(Cloudinary::class, function () {
                return new Cloudinary([
                    'cloud' => [
                        'cloud_name' => config('cloudinary.cloud_name'),
                        'api_key'    => config('cloudinary.api_key'),
                        'api_secret' => config('cloudinary.api_secret'),
                    ],
                ]);
            });
        }

        // ImageManagerInterface のバインド
        if ($this->app->environment('production')) {
            $this->app->bind(ImageManagerInterface::class, CloudinaryImageManager::class);
        } else {
            $this->app->bind(ImageManagerInterface::class, LocalImageManager::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

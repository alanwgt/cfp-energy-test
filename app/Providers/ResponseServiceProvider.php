<?php

namespace App\Providers;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\ServiceProvider;

class ResponseServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        \Response::macro('ok', function (array|AnonymousResourceCollection|JsonResource $data) {
            if ($data instanceof JsonResource) {
                $data = $data->response()->getData(true);
            }

            return response()->json($data);
        });
    }
}

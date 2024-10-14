<?php

namespace App\Providers;

use OpenAI\Client;
use Illuminate\Support\ServiceProvider;

class OpenAIServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register()
    {
        $this->app->singleton(Client::class, function ($app) {
            return new Client([
                'api_key' => config('openai.api_key'),
            ]);
        });
    }
    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\FormularioRepositoryInterface;
use App\Repositories\FormularioRepository;
use App\Interfaces\FormularioServiceInterface;
use App\Services\FormularioService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(FormularioRepositoryInterface::class, FormularioRepository::class);
        $this->app->bind(FormularioServiceInterface::class, FormularioService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

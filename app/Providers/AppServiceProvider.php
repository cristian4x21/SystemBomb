<?php
namespace App\Providers;
use Illuminate\Support\ServiceProvider;
use App\Contracts\ResourceRepositoryInterface;
use App\Repositories\EloquentResourceRepository;
class AppServiceProvider extends ServiceProvider
{
    // Registro en el contenedor IoC: integración de las capas 6 y 7.
    public function register(): void {
        $this->app->bind(ResourceRepositoryInterface::class, EloquentResourceRepository::class);
    }
    public function boot(): void {}
}

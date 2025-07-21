<?php
// Proveedor de servicios para la gestión de rutas en la aplicación
namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    // Método para registrar servicios, actualmente vacío
    public function register(): void
    {
        
    }

    // Método que se ejecuta al iniciar el proveedor de servicios
    public function boot(): void
    {
        // Mapea las rutas de la API
        $this->mapApiRoutes();
    }

    // Método para definir las rutas de la API
    protected function mapApiRoutes(): void
    {
        Route::prefix('v1') // Define el prefijo de las rutas como 'v1'
            ->middleware('api') // Aplica el middleware 'api'
            ->group(base_path('routes/api.php')); // Agrupa las rutas desde el archivo api.php

    }

}

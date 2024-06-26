<?php

namespace EmilioPuljiz\ApiWhatsappBusiness;

use Illuminate\Support\ServiceProvider;

class ApiWhatsappBusinessServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     */
    public function boot(): void
    {
        if (! class_exists('CreateWhatsappConfigurationsTable')) {
            $this->publishes([
                __DIR__.'/../database/migrations/2023_04_21_110851_create_whatsapp_configurations_table.php' => database_path('migrations/'.date('Y_m_d_His', time()).'_create_whatsapp_configurations_table.php'),
            ], 'emiliopuljiz-api-whatsapp-business-migrations');
        }

        if (! class_exists('CreateWhatsappNotificationsTable')) {
            $this->publishes([
                __DIR__.'/../database/migrations/2024_03_04_161027_create_whatsapp_notifications_table.php' => database_path('migrations/'.date('Y_m_d_His', time()).'_create_whatsapp_notifications_table.php'),
            ], 'emiliopuljiz-api-whatsapp-business-migrations');
        }
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
    }
}

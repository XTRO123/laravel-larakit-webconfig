<?php

namespace Larakit\Webconfig;

use Larakit\ServiceProvider;

class LarakitServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;


    public function boot() {
        include __DIR__ . '/../../routes.php';
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register() {
        $this->larapackage('larakit/laravel-larakit-webconfig', 'larakit_webconfig');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides() {
        return [];
    }

}

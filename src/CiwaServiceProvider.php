<?php

namespace Dcolsay\Ciwa;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;


class CiwaServiceProvider extends PackageServiceProvider
{
    protected $commands = [
    ];

    protected $migrations = [
    ];

    public function configurePackage(Package $package) : void
    {
        $package
            ->name('ciwa')
            ->hasConfigFile('ciwa');
    }

    public function registeringPackage()
    {
    }

    public function packageRegistered()
    {
        // $this->mergeConfigFrom(__DIR__ . '/../config/permission.php', 'permission');
        // $this->mergeConfigFrom(__DIR__ . '/../config/media-library.php', 'media-library');
    }

    public function bootingPackage()
    {
        // if ($this->app->runningInConsole()){
        //     $this->beforeRunningInConsole();
        // }
    }

    public function packageBooted()
    {
    }

    public function beforeRunningInConsole()
    {
        // $this->configureMigrations();
    }

    public function afterRunningInConsole()
    {

    }

    protected function configureMigrations()
    {
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
    }
}

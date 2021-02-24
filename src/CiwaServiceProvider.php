<?php

namespace Dcolsay\Ciwa;

use Dcolsay\Ciwa\Headings\HeadingFormatter;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Spatie\LaravelPackageTools\Package;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
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
        // HeadingRowFormatter::extend('ciwa', [HeadingFormatter::class, 'format']);
        HeadingRowFormatter::extend('ciwa', function($value){
            if(blank($value))
                return;

            return HeadingFormatter::format($value);
        });
        // HeadingRowFormatter::extend('ciwa', function($value) {
        //     dd($value);
        //     $value = Str::lower($value);
        //     $headings =   [
        //         'customercode' => 'customer_code',
        //         'companyname' => 'company_name',

        //         'legalform' => 'legal_form',
        //         'legalformlookup' => 'legal_form',

        //         'businessstatuslookup' => 'business_status',
        //         'businessstatus' => 'business_status',

        //         'establishmentdate' => 'establishment_date', // @todo Champ obligatoire

        //         'industrysector' => 'industry_sector',
        //         'industrysectorlookup' => 'industry_sector',

        //         'registrationnumber' => 'registration_number',
        //         'identificationnumbersregistrationnumber' => 'registration_number',
        //         'identificationnumber' => 'registration_number',

        //         'registrationnumberissuercountrylookup' => 'registration_number_issuer_country',
        //         'identificationnumbersregistrationnumberissuercountrylookup' => 'registration_number_issuer_country',

        //         'mainaddressline' => 'address_line',
        //         'mainaddressaddressline' => 'address_line',

        //         'mobilephone' => 'mobile_phone',
        //         'contactsmobilephone' => 'mobile_phone',

        //         'fixedline' => 'fixed_line',
        //         'contactsfixedline' => 'fixed_line',

        //         'email' => 'email',
        //         'contactsemail' => 'email',
        //     ];

        //     $value = (Arr::exists($headings, $value))
        //          ? $headings[$value]
        //          : $value;

        //     return $value;
        // });
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

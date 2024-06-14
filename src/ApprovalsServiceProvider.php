<?php

namespace bebo925\Approvals;

use bebo925\Approvals\Commands\ApprovalsCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class ApprovalsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('approvals')
            // ->hasConfigFile()
            ->hasMigration('create_approvals_table');
    }
}

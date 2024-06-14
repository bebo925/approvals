<?php

namespace bebo925\Approvals;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use bebo925\Approvals\Commands\ApprovalsCommand;

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
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_approvals_table')
            ->hasCommand(ApprovalsCommand::class);
    }
}

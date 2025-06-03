<?php

namespace Silaswint\LaravelImpersonateGuest\App\Providers;

use Inertia\Inertia;
use Spatie\LaravelPackageTools\Commands\InstallCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Illuminate\Support\Facades\Event;
use Illuminate\Auth\Events;
use Silaswint\LaravelImpersonateGuest\App\Interfaces\HasImpersonateGuest;
use Silaswint\LaravelImpersonateGuest\App\Listeners\Login\ClearImpersonationGuestSession;
use function Silaswint\LaravelImpersonateGuest\App\auth;
use function Silaswint\LaravelImpersonateGuest\App\config;

class LaravelImpersonateGuestProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        $package
            ->name('laravel-impersonate-guest')
            ->hasConfigFile()
            ->hasRoutes('web')
            ->hasInstallCommand(function (InstallCommand $command) {
                $command->publishConfigFile();
            });
    }

    public function packageBooted(): void
    {
        Event::listen(Events\Login::class, ClearImpersonationGuestSession::class);

        Inertia::share([
            'isImpersonatingGuest' => fn () => isImpersonatingGuest(),
            'canImpersonateGuest' => function () {
                /** @var HasImpersonateGuest $user */
                $user = auth()->user();

                return config('impersonate-guest.enabled') && auth()->check() && $user?->canImpersonateGuest();
            },
        ]);
    }
}

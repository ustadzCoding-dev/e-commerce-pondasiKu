<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Opcodes\LogViewer\LogFile;
use Opcodes\LogViewer\LogFolder;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        Gate::define('viewLogViewer', fn (?User $user) => (bool) $user?->isAdmin);
        Gate::define('downloadLogFile', fn (?User $user, LogFile $file) => (bool) $user?->isAdmin);
        Gate::define('downloadLogFolder', fn (?User $user, LogFolder $folder) => (bool) $user?->isAdmin);
        Gate::define('deleteLogFile', fn (?User $user, LogFile $file) => (bool) $user?->isAdmin);
        Gate::define('deleteLogFolder', fn (?User $user, LogFolder $folder) => (bool) $user?->isAdmin);
    }
}

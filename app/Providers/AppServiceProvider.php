<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Model::preventLazyLoading(! app()->isProduction());

        Gate::before(function (User $user, string $ability): ?bool {
            if ($ability === 'updateRole') {
                return null;
            }

            return $user->isAdmin() ? true : null;
        });

        Gate::define('manage-categories', fn (User $user) => $user->isAdmin());
        Gate::define('manage-tags', fn (User $user) => $user->isAdmin());
        Gate::define('manage-users', fn (User $user) => $user->isAdmin());
    }
}

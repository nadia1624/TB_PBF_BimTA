<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // Model::class => ModelPolicy::class,
    ];

    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Definisi Gate untuk role admin
        Gate::define('admin', function (User $user) {
            return $user->role === 'admin';
        });

        // Definisi Gate untuk role dosen
        Gate::define('dosen', function (User $user) {
            return $user->role === 'dosen';
        });

        // Definisi Gate untuk role mahasiswa
        Gate::define('mahasiswa', function (User $user) {
            return $user->role === 'mahasiswa';
        });

        // Gate untuk mengecek apakah user adalah admin atau dosen
        Gate::define('admin-dosen', function (User $user) {
            return in_array($user->role, ['admin', 'dosen']);
        });

        // Gate untuk mengecek apakah user bukan mahasiswa
        Gate::define('bukan-mahasiswa', function (User $user) {
            return !($user->role === 'mahasiswa');
        });
    }
}

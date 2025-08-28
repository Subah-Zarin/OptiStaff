<?php

namespace App\Providers;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Force HTTPS in non-local environments
        if ($this->app->environment() !== 'local') {
            URL::forceScheme('https');
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Custom password reset URL
        ResetPassword::createUrlUsing(function ($notifiable, string $token) {
            $email = urlencode($notifiable->getEmailForPasswordReset());
            return config('app.frontend_url') . "/password-reset/{$token}?email={$email}";
        });
    }
    public static function redirectTo()
{
    $user = auth()->user();
    if ($user && $user->role === 'admin') {
        return '/admin/dashboard';
    }
    return '/home';
}

}

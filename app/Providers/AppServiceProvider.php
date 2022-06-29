<?php

namespace App\Providers;
use App\Http\Controllers\SMSApiController;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Twilio\Rest\Client;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        //
        \Blade::directive('role', function($expression) {
            return "<?php if(Auth::user()->user_role == {$expression}): ?>";
        });

        \Blade::directive('endrole', function($expression) {
            return "<?php endif; ?>";
        });

        $sms = new SMSApiController();
        View::share('smsCreadits', $sms->checkCredits());
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

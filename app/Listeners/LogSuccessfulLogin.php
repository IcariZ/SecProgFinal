<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Support\Facades\Log;

class LogSuccessfulLogin
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(Login $event): void
    {
        $ip = request()->ip();
        
        Log::info('User Login IP:', [
            'user' => $event->user->email,
            'ip' => $ip
        ]);

        $event->user->update([
            'ip_address' => $ip
        ]);
    }
}
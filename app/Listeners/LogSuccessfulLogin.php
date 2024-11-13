<?php

namespace App\Listeners;

use Illuminate\Auth\Events\Login;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogSuccessfulLogin
{
    protected $request;

    public function __construct(Request $request) 
    {
        $this->request = $request;
    }

    public function handle(Login $event): void
    {
        $ip = $this->getIpAddress();
        
        Log::info('User Login IP:', [
            'user' => $event->user->email,
            'ip' => $ip
        ]);

        $event->user->update([
            'ip_address' => $ip,
            'last_activity' => now()
        ]);
    }

    protected function getIpAddress()
    {
        $request = $this->request;
        
        $ipHeaders = [
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR', 
            'HTTP_X_FORWARDED',
            'HTTP_X_CLUSTER_CLIENT_IP',
            'HTTP_FORWARDED_FOR',
            'HTTP_FORWARDED',
            'REMOTE_ADDR'
        ];

        foreach ($ipHeaders as $header) {
            if ($request->server($header)) {
                $ips = explode(',', $request->server($header));
                return trim($ips[0]);
            }
        }

        return $request->ip();
    }
}
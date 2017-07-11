<?php

namespace App\Http\Middleware;

use Closure;

class Client
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        switch($this->auth->user()->role_id)
        {
            case '1':
                # ·Administrator
                // return redirect()->to('admin.dashboard');
                break;
            case '2':
                # ·Leader
                return redirect()->to('leader.dashboard');
                break;
            case '3':
                # ·Developer
                return redirect()->to('developer.dashboard');
                break;
            case '4':
                # ·Client
                return redirect()->to('dashboard');
                break;
            default:
                return redirect()->to('login');
                break;
        }
        return $next($request);
    }
}

<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsUserAge
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(!Auth::check()){
            return redirect()->route('login');
        }
        $user = Auth::user();
        $now = Carbon::now();

        $dateOfBirth = Carbon::createFromFormat('Y-m-d H:i:s', $user->dob);
        $age = $now->diffInYears($dateOfBirth);
        if($age <= 18){
            return redirect()->route('home');
        }
        //search tren Carbon.nextbon
        // dd($dateOfBirth->format('Y-m-d'));
        return $next($request);
    }
}

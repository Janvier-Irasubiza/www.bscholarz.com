<?php

namespace App\Http\Middleware;

use App\Models\Applicant_info;
use Closure;
use Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\Subscriber;

class Client
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the client is authenticated
        if (!Auth::guard('client')->check()) {
            // Handle unauthenticated requests with 'plb' query
            if ($request->has('plb')) {
                $response = $this->handlePlb($request);
                if ($response) {
                    return $response;
                }
            }

            // Handle unauthenticated AJAX requests
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthenticated'], 401);
            }

            // Redirect to login for standard requests
            return redirect()->route('login')->with('error', 'You have to Login first!');
        }

        // Allow the request to proceed
        return $next($request);
    }

    /**
     * Handle requests with the 'plb' query parameter.
     */
    private function handlePlb(Request $request): ?Response
    {
        $subscriber = Subscriber::find($request->plb);

        // If no subscriber is found, return to the previous page
        if (!$subscriber) {
            return back()->with('error', 'Subscriber not found.');
        }

        $client = Applicant_info::where('email', $subscriber->email)->first();

        // If no client is found, redirect to register
        if (!$client) {
            return redirect()->route('register');
        }

        // Redirect based on whether the client has set a password
        if (is_null($client->password)) {
            return redirect()->route('set-password', ['plb' => $request->query('plb')]);
        }

        return redirect()->route('login');
    }

}

<?php
declare(strict_types=1);

namespace App\Http\Middleware;

use App\User;
use Closure;

class CheckRole
{


    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @param  $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        /*
            @var User $user
        */
        $user = $request->user();
        if ($user->getRole() !== $role) {
            return redirect()->route('guest.index');
        }

        return $next($request);

    }//end handle()


}//end class

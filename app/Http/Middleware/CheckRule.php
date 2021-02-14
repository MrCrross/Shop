<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use App\Models\Rule;
use App\Models\User;
use Illuminate\Http\Request;

class CheckRule
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next, $rule)
    {
        /* @var User $user */
        $user = User::find(auth()->id());
        /* @var Rule $rule */
        $rule = Rule::findByName($rule);

        if(!$rule)
        {
            throw new Exception("Rule not found");
        }

        if(!$user || !$user->hasRule($rule))
        {
            return response()->json([
                'message' => 'Unauthenticated'
            ], 401);
        }

        return $next($request);
    }
}

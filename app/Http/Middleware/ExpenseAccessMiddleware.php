<?php

namespace App\Http\Middleware;

use App\Models\Expense;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ExpenseAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user_id = $request->user()->id;
        $expense_id = $request->id;

        $expense = Expense::find($expense_id);

        if($expense && $expense->user_id != $user_id)
            return response(array('message' => 'No authorization to access this resource'), 401);

        return $next($request);
    }
}

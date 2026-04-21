<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        // chưa login
        if (!session('user')) {
            return redirect('/login');
        }

        $userRole = session('role');

        // nếu có truyền role và không nằm trong danh sách
        if (!empty($roles) && !in_array($userRole, $roles)) {
            return redirect('/home'); // hoặc trang bạn muốn
        }

        return $next($request);
    }
}

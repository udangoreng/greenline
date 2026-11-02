<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
class AdminAuth {
    public function handle(Request $r, Closure $next) {
        return session('admin') ? $next($r) : redirect('/admin/login');
    }
}

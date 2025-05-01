<?php

namespace middleware;

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class CheckAuth
{
    public function __invoke($request, $response, $next)
    {
        if (!isset($_SESSION['user_id'])) {
            // Use Klein's response methods for better control
            $response->code(401);
            return $response->json([
                'success' => false,
                'message' => 'Unauthorized'
            ]);
        }

        return $next($request, $response);
    }
}

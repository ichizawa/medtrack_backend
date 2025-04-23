<?php

namespace middleware;

session_start();

class CheckAuth
{
    public function __invoke($request, $response, $next)
    {
        if (!isset($_SESSION['user_id'])) {
            // Optionally set HTTP status code
            http_response_code(401);
            return json_encode(['success' => false, 'message' => 'Unauthorized']);
        }

        return $next($request, $response);
    }
}

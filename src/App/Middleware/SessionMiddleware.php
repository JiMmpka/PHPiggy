<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Exceptions\SessioneXception;
use Framework\Contracts\MiddlewareInterface;

class SessionMiddleware implements MiddlewareInterface
{
    public function process(callable $next)
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            throw new SessionException("Session already active.");
        }

        if (headers_sent($filename, $line)) {
            throw new SessionException("Headers already sent. Consider output buffering. Data outputted {$filename} - Line: {$line}");
        }

        session_set_cookie_params([
            'secure' => $_ENV['APP_ENV'] === "production",
            'httponly' => true,
            'samesite' => 'lax'
        ]);

        session_start();

        $next();

        session_write_close();
    }
}

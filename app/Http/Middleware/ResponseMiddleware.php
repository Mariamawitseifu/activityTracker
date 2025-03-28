<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ResponseMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     */
    public function handle(Request $request, Closure $next): JsonResponse
    {
        $response = $next($request);

        if ($response->isSuccessful()) {
            return self::sendSuccess($request, $response);
        }

        return self::sendError($response);
    }

    private static function sendSuccess($request, $response)
    {
        return response()->json([
            'success' => true,
            'message' => $response->statusText(),
            'status' => $response->status() ?? 200,
            'data' => $response->original ? $response->original : [],
        ], $response->status() ?? 200);
    }

    private static function sendError($response)
    {
        return response()->json([
            'success' => false,
            'message' => $response->statusText(),
            'status' => $response->status() ?? 500,
            'data' => [
                'message' => $response->original['message'] ?? $response->original['error'] ?? $response->original['errors'] ?? $response->original['message'] ?? 'An error occurred',
                'errors' => $response->original['errors'] ?? [],
            ] ?? [],
        ], $response->status() ?? 500);
    }
}

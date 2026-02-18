<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ConvertAssetsToRelative
{
    public function handle(Request $request, Closure $next)
    {
        $response = $next($request);

        if ($response->headers->get('content-type') && str_contains($response->headers->get('content-type'), 'html')) {
            $content = $response->getContent();
            // Reemplaza URLs absolutas de assets con relativas
            $content = preg_replace(
                '/href="https?:\/\/[^"]*\/build\/assets\/([^"]*)"/',
                'href="/build/assets/$1"',
                $content
            );
            $content = preg_replace(
                '/src="https?:\/\/[^"]*\/build\/assets\/([^"]*)"/',
                'src="/build/assets/$1"',
                $content
            );
            $response->setContent($content);
        }

        return $response;
    }
}

<?php

namespace App\Http\Middleware;

use App\Models\ArticleView;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TrackArticleViews
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        if (
            $request->isMethod('GET') &&
            $request->routeIs('articles.show') &&
            $response->isSuccessful()
        ) {
            ArticleView::create([
                'url' => $request->path(),
            ]);
        }

        return $response;
    }
}

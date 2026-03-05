<?php

namespace App\Providers;

use App\Models\Category;
use App\Models\News;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {

            $categories = Category::with(['subcategories' => function ($query) {
                $query->where('status', 1);
            }])
                ->where('status', 1)
                ->orderBy('name')
                ->get();

            $categoriesFooter = Category::where('status', 1)
                ->latest()
                ->take(21)
                ->get();

            $trendingNews = cache()->remember('trending_news', 60, function () {
                return News::where('status', 'published')
                    ->with(['category', 'subcategory'])
                    ->orderBy('views', 'desc')   // based on views
                    ->get();
            });

            $view->with([
                'categories'   => $categories,
                'trendingNews' => $trendingNews,
                'categoriesFooter' => $categoriesFooter
            ]);
        });
    }
}

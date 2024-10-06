<?php

namespace App\Providers;

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
        View::composer('home', function ($view) {
            $latestTask = [
                'id' => 3,
                'title' => 'Название задачи',
                'description' => 'Описание задачи',
                'created_at' => '2024-10-01',
                'updated_at' => '2024-10-01',
                'status' => false,
                'priority' => 'Высокий',
                'assignee' => 'Имя исполнителя'
            ];
            $view->with('latestTask', $latestTask);
        });
    }
}

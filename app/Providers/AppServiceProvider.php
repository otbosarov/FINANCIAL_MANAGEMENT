<?php

namespace App\Providers;

use App\Interfaces\IncomeExpanseInterface;
use App\Interfaces\TypeInterface;
use App\Interfaces\UserInterface;
use App\Repositories\IncomeExpanseRepository;
use App\Repositories\TypeRepository;
use App\Repositories\UserRepository;
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
        // Event::listen(QueryExecuted::class, function ($query) {
        //     Log::info("sql: " . $query->sql);
        // });
        $this->app->singleton(UserInterface::class, UserRepository::class);
        $this->app->singleton(TypeInterface::class, TypeRepository::class);
        $this->app->singleton(IncomeExpanseInterface::class, IncomeExpanseRepository::class);
    }
}

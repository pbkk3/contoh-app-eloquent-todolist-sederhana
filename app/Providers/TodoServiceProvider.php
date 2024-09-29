<?php

namespace App\Providers;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;
use App\Services\TodoService;
use App\Services\Impl\TodoServiceImpl;

class TodoServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public array $singletons = [
        TodoService::class => TodoServiceImpl::class
    ];

    public function provides(): array
    {
        return [TodoService::class];
    }
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}

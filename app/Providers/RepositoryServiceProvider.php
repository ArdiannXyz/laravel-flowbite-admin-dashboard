<?php

namespace App\Providers;

use App\Repositories\Eloquent\CategoryRepository;
use App\Repositories\Contracts\CategoryRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
    }
}
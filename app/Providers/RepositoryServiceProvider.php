<?php

namespace App\Providers;

use App\Interfaces\AdminRepositoryInterface;
use App\Interfaces\AuthRepositoryInterface;
use App\Interfaces\BookLoanRepositoryInterface;
use App\Interfaces\BookRepositoryInterface;
use App\Interfaces\GenreRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\AdminRepository;
use App\Repositories\AuthRepository;
use App\Repositories\BookLoanRepository;
use App\Repositories\BookRepository;
use App\Repositories\GenreRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(GenreRepositoryInterface::class, GenreRepository::class);
        $this->app->bind(BookRepositoryInterface::class, BookRepository::class);
        $this->app->bind(BookLoanRepositoryInterface::class, BookLoanRepository::class);
        $this->app->bind(AdminRepositoryInterface::class, AdminRepository::class);
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

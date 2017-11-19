<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(\App\Repositories\UserRepository::class, \App\Repositories\UserRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\AlunoRepository::class, \App\Repositories\AlunoRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\TurmaRepository::class, \App\Repositories\TurmaRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\AlunoTurmaRepository::class, \App\Repositories\AlunoTurmaRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\ProfessoreRepository::class, \App\Repositories\ProfessoreRepositoryEloquent::class);
        $this->app->bind(\App\Repositories\AvaliacoeRepository::class, \App\Repositories\AvaliacoeRepositoryEloquent::class);
        //:end-bindings:
    }
}

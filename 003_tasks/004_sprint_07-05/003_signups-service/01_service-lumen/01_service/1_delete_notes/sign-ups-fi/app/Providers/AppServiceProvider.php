<?php

namespace App\Providers;

use Domain\Common\Bus\CommandBus;
use Illuminate\Support\ServiceProvider;
use Infrastructure\Common\Bus\CommandBusFactory;
use Infrastructure\Common\Bus\SyncCommandBus;
use Infrastructure\Common\Services\ElasticSearchClientFactory;
use Infrastructure\Inscription\ElasticInscriptionRepository;
use Infrastructure\Student\ElasticStudentRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(
            'Elasticsearch\Client', function($app) {
                return (new ElasticSearchClientFactory)($app);
            }
        );

        $this->app->bind(
            'League\Tactician\CommandBus', function($app){
                return (new CommandBusFactory)($app);
            }
        );

        $this->app->bind(
            'Domain\Student\StudentRepository', function($app){
                return new ElasticStudentRepository(
                    $app->get('Elasticsearch\Client')
                );
            }
        );

        $this->app->bind(
            'Domain\Inscription\Contract\InscriptionRepository', function($app){
            return new ElasticInscriptionRepository(
                $app->get('Elasticsearch\Client')
            );
        }
        );
    }
}

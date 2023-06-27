<?php

use Enqueue\SimpleClient\SimpleClient;
use Infrastructure\Inscription\ElasticInscriptionRepository;
use Infrastructure\Student\ElasticStudentRepository;
use Laravel\Lumen\Testing\TestCase as BaseTestCase;
use League\Tactician\CommandBus;
use Psr\Log\LoggerInterface;

abstract class TestCase extends BaseTestCase
{
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }

//    protected function setUp(): void
//    {
//        parent::setUp(); // TODO: Change the autogenerated stub
//        $this->studentRepository = $this->app->get(ElasticStudentRepository::class);
//        $this->inscriptionRepository = $this->app->get(ElasticInscriptionRepository::class);
//        $this->client = $this->app->get(SimpleClient::class);
//        $this->logger = $this->app->get(LoggerInterface::class);
//        $this->commandBus = $this->app->get(CommandBus::class);
//    }
}

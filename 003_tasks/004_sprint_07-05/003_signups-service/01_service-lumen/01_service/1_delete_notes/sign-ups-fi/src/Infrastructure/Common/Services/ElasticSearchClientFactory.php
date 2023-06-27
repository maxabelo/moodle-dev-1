<?php
declare(strict_types=1);

namespace Infrastructure\Common\Services;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Psr\Container\ContainerInterface;

class ElasticSearchClientFactory
{
    public function __invoke(ContainerInterface $container): Client
    {
        $config = config('elasticsearch');
        
        $builder = ClientBuilder::create();
        $type = $config['type'];

        $builder = $type == 'hosts' 
            ? $this->configByHosts($builder, $config) 
            : $this->configByCloudId($builder, $config)
        ;

        $client = $builder->build();

        // Overload client with custom prefix;
        $client->prefix = $config['prefix'];
        
        return $client;
    }

    /**
     * Get the Builder configurated using Hosts
     *
     * @param ClientBuilder $builder
     * @param array $config
     * @return ClientBuilder
     */
    protected function configByHosts(ClientBuilder $builder, $config)
    {
        $builder->setHosts($config['hosts']);
        
        return $builder;
    }

    /**
     * Get the Builder configurated using CloudID and Api Keys
     *
     * @param ClientBuilder $builder
     * @param array $config
     * @return ClientBuilder
     */
    protected function configByCloudId(ClientBuilder $builder, $config)
    {
        $cloud = $config['cloud'];

        $builder->setElasticCloudId($cloud['id']);
        $builder->setApiKey($cloud['api_id'], $cloud['api_key']);

        return $builder;
    }
}
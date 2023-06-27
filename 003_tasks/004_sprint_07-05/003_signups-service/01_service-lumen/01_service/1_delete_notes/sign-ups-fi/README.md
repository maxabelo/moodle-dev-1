# Students Sign-Ups & Updates Microservice v2.0

> I was created to handle new Students Sign-Ups in the Sagittarius-A project. 

> I am stateless, I have an Restful API interface and will communicate asynchronously with the World (and other microservices) through a Message Broker (RabbitMQ). 

> I am developed using Hexagonal Architecture ([Tactical DDD patterns](https://gitlab.fbr.group/rafael.nevarez/ddd-legos)). Also I am based on Lumen Microframework using mySQL and Elasticsearch.

## Official Documentation:

> Documentation for the framework can be found on the [Lumen website](https://lumen.laravel.com/docs).

> The official documentation of the queue broker is available on the [RabbitMQ website](https://www.rabbitmq.com/documentation.html).

> The official documentation of the non-relational database used is available on the [ElasticSearch website](https://www.elastic.co/guide/index.html).

> Documentation for the API can be found in the OpenAPI specification [openapi.yaml](https://www.openapis.org/) and AsyncAPI specification [asyncapi.yaml](https://www.asyncapi.com/docs).


## Development Environment:

> Docker compose used to create the containers:

- RabbitMq
- Elasticsearch
- SingUps (Alpine - Lumen)

> The help commands to help you build the project are found in the following [Doc](https://docs.google.com/document/d/16628cfp-0V3FMJwjxw813sF_KwE3-0GVfwtpdg-kXWU/edit)

## Resources:
> List of the libraries used.

<details><summary><b> Show resources </b></summary>

- [php](https://www.php.net/releases/8.1/en.php)
- [assert]()
- [elasticsearch]()
- [amqp-bunny]()
- [laravel-queue]()
- [simple-client]()
- [guzzle]()
- [lumen-framework]()
- [fractal]()
- [tactician]()
- [uri]()
- [php-enum]()
- [json-api]()
- [psr7]()
- [php-amqplib]()
- [rabbitmq-bundle]()
- [ddd-legos]()
- [data-transfer-object]()
- [mockery]()
- [phpunit]()

</details>

## Quick Overview:

<details><summary><b>The initial structure of the project with installed dependencies will be as follows:</b></summary>

```
sign-ups
├── app
│   ├── Console
│   |   ├── Commands
│   |   ├── Factory
│   |   └── Importers
│   ├── Exceptions
│   ├── Http
│   |   ├── Controllers
│   |   |   └── V2
│   |   ├── Middleware
│   |   ├── Resources
│   |   |   ├── Schemas
│   |   |   └── Serializers
│   ├── Providers
│   ├── Queue
│   |   ├── Extensions
│   |   ├── Processors
│   |   |   ├── Inscription
│   |   |   └── Student
├── bootstrap
├── config
├── database
├── etc
│   ├── docker
│   |   ├── nginx
│   |   ├── php
│   |   ├── runit
│   |   └── supervisor
│   ├── gCloud
│   ├── kubernetes
│   |   ├── beta
│   |   └── production
│   ├── secrets***
│   ├── secrets.example.yaml
│   └── secrets.tar.gz.ssl
├── public
│   ├── favicon.ico
│   ├── .htaccess
│   └── index.php
├── resources
│   └── views
├── routes
├── src
│   ├── Application
│   │   ├── Common
|   |   │   │   └── DTOs
│   │   ├── Inscription
|   │   │   ├── Commands
|   │   │   └── Handlres
│   │   ├── Services
|   │   │   ├── StudentWithInscription
|   |   │   │   ├── Commands
|   |   │   │   └── Handlres
│   │   ├── Student
|   │   │   ├── Commands
|   │   │   └── Handlres
│   ├── Domain
│   │   ├── Events
│   │   ├── Inscription
|   │   │   ├── Contract
|   │   │   ├── Entities
|   │   │   ├── Events
|   │   │   └── ValueObjects
│   │   ├── Services
|   │   │   └── StudentWithInscription
│   │   ├── Student
|   │   │   ├── Events
|   │   │   └── ValueObjects
│   ├── Infrastructure
│   │   ├── Common
|   │   │   ├── Bus
|   |   │   │   ├── Inflector
|   │   │   |   ├── Locator
|   │   │   |   └── Middleware
|   │   │   ├── Repository
|   │   │   └── Services
│   │   ├── Events
|   │   │   └── RabbitMq
│   │   ├── Inscription
│   │   └── Student
├── storage
│   ├── app
│   ├── framework
│   │   ├── cache
|   │   └── views
│   └── logs
├── test
│   ├── Domain
│   │   ├── Inscription
|   │   │   ├── Entities
|   │   │   └── ValueObjects
│   ├── InscriptionTest
│   └── StudentTest 
├── vendor***
├── .dockerignore
├── .editorconfig
├── .env.example
├── .gitignore
├── artisan
├── asyncapi.yaml
├── composer.json
├── composer.lock
├── docker-compose-dev.yaml
├── docker-compose.yaml
├── Dockerfile
├── Dockerfile.dev
├── openapi.yaml
├── phpunit.xml
└── README.md
```
</details>

## License:

> This microservice is open-sourced software licensed unde the [MIT license](https://opensource.org/licenses/MIT).

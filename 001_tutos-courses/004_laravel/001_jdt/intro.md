# Laravel 9 - Juan de la Torre

## Intro - Curso
- --- Que es Laravel? Instalacion y mas
  - Laravel es 1 Framework MVC escrito en PHP para aplicaciones web Full Stack y modernas.
	- Provee una sintaxis elegante y simple, con una gran experiencia para Developers.
	- Similar a Django o Ruby on Rails q son frameworks con baterias incluidas
  	  - Utilizan el Patron Active Record  <-- Mata a las Arquitecturas limpias ya q acopla el codigo demasiado

  - -- Que incluye Laravel?
    - Laravel al ser 1 framework con baterias incluidas nos provee de:
	   - Authentications, Seguridad, ORM, Migrations y conexiones a DB
	   - CLI, Testing, Routing, Template Engien, Notificaciones
	   - Puedes desarrollar API para consumirlas con 1 front aparte q no este embebido en el MVC de laravel
	- Es 1 framework orientado a objetos
	- Se recomienda W Laravel con Docker    <---   algo bueno entre tanto php mvc :( 



  - -- Levantar Laravel con Docker
    - Una vez tenemos instalado Docker y Docker Compose podemos ejecutar el siguiente comando para crear 1 proyecto de laravel:        `curl -s https://laravel.build/devstagram | bash`
      - Esto hara pull de algunas imagenes que se requieren como:
        - selenium, redi, mysql, meilisearch, mailpit
        - Solo esperamos q se cree y ya podremos levantar el proyecto de laravel
          - Una vez finaliza nos pide ejecutar el vendor:   `cd devstagram && ./vendor/bin/sail up`

	- -- Levantar el Servidor de Laravel
  	  - Como estamos W con Docker, NO es necesario usar el     `php:artisan-serve`      ya q con Docker nos basamos en el    vendor
	    - Para Levantar todos los servicios de Laravel ejecutamos:
	    	`./vendor/bin/sail up`




### Sail
- --- Sail nos permite interactuar con Docker
  - Laravel utiliza Docker en las versiones mas reciente de Laravel
    - Sail es 1 CLI q nos permite comunicarnos e interactuar con los archivos de Docker para arrancar servicios, llamar    artisan    , o instalar dependencias de NPM.
	  - Al W con Docker vamos a utilizar     `sail`     antes de cualquier comando
  	    - Cuando usamos     sail,    php   es opcional en el comando:
			 ```bash
			 	sail php artisan migrate
				sail artisan migrate

				# node
				sail npm install

				# run project
				sail up
				lsu
				php artisan up

				# versions
				sail php -v

				# 
				sail mysql
			 ```








## OOP in PHP
- --- Es 1 paradigma de Programacion q prioriza las Classes y Objects en lugar de Fn
  - La OOP tiene 4 pilares fundamentales q son: 
    - Abstraccion, Encapsulamiento, Herencia, Polimorfismo



















# Sign Ups
- --- Levantar el servicio
  - Levantar con docker compose para desarrollo
    - Como no se mapea los     vendors     debemos attacharnos al contenedor de    signups    y ejecutar el comando      `composer install`
      - Con esto ya se levanta todo, y como ya tenemos los demas servicios
	  	- Solo necesitamos las    EnvV   para conectarnos a la DB e   IMPORTAR    data a esta DB de ElasticSearch


  - En este punto ya nos funca el endpint       `http://localhost:8080/v2/sign-ups`
	- Pero para poder ir a    http://localhost:8080/v2/sign-ups/students
	  - ANTES debo poder importar datos de la DB


  - Ya levantado el servico, y una vez DENTRO del Container de SIGNUPS tenemos los commands:
	- Comando de importacion
	  `php artisan import:students -s sirius`
	- Comando para consumir las cosas
	  `php /app/artisan queue:consume --message-limit=200 --time-limit=20 --memory-limit=50`








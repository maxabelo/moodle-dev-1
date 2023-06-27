# PostgreSQL y PgAdmin en docker-compose

## Inicio
  - En una sola linea container con: Nombre del Container | User | Password | Nombre de la DB | Puerto Publico para conectarnos desde nuestra PC/HOST

      docker run --name some-postgres -e POSTGRES_USER=alex -e POSTGRES_PASSWORD=password -e POSTGRES_DB=myalexdb -p 5432:5432 -d postgres


      docker run --name some-postgres -e POSTGRES_PASSWORD=mysecretpassword -p 5432:5432 -d postgres



  
 ## Con Docker Compose
  - Creamos el    docker-compose.yml
    - Cuando termine y todo este bien vamos al navegador:
      - Ingresamos al puert establecido en el .yml
          localhost:80
      - Ingresamos con las credenciales establecidas en el  .yml
    
  - Nos conectamos al Postgres en el Container
    - Click derecho > Register > Server > 'Damos Nombre' > 
      Connection:
        Host name/address: Como es a un Container - Nombre del servicio
          - postgres
        Port: Puerto publico que establecimos en el  .yml
          - 5432
        Username: User en el  .yml
          - alex
        Password: Pass en el  .yml
          - password
      SAVE

# Docker & PostgreSQL - postgres y DBeaver

## Init
  - Descargar el container de Postgres
    - Password es la unica Environment Variable requerida para correr este container
      - El user (USER_NAME) por default q se crea es   postgres
    
        docker pull postgres
        docker run -e POSTGRES_PASSWORD=password postgres

      - Crear un User adicional al creado por default:
        docker run -e POSTGRES_USER=alex  -e POSTGRES_PASSWORD=password postgres


      - Crear una DB con Name Personalizado | User | -d = En modo dtach/background
        docker run -e POSTGRES_USER=alex -e POSTGRES_PASSWORD=password -e POSTGRES_DB=myalexdb -d postgres

        docker ps   <-   Ver su  ID  para conectarnso a ese container



      - Dar nombre personalizado al Container
        docker run --name some-alex-postgres  -e POSTGRES_USER=alex -e POSTGRES_PASSWORD=password -e POSTGRES_DB=myalexdb -d postgres

        docker exec -it some-alex-postgres bash     <-  Ejecutamos en interactivo el container

        psql -U alex --password --db myalexdb   <- Ya adentro, me conecto a la DB creada

        SELECT current_user;                    <-  Ver el user






    - Ejecutar el container desde al bash > Conectarnos a Postgres
        docker exec -it ID/NAME bash
        psql -U USER_NAME --password


    - Ahora ya tengo una instancia de Postgres y ya podemos escribir cualquier consulta
      - Comandos Postgres
          CREATE DATABASE <name>;     <-    Crear una DB
          \l                          <-    Lista las DB
          crtl+d                      <-    Salir de psql  -  2 veces: salir del container exec






  - Exponer el puerto del contianer / Hacer publico 1 puerto
      docker ps
        - 5432/tcp  <-  Puerto dentro del container 
      
    docker run --name some-alex-postgres -e POSTGRES_USER=alex -e POSTGRES_PASSWORD=password -e POSTGRES_DB=myalexdb -p 5432:5432 -d postgres

    docker run --name some-alex-postgres -e POSTGRES_USER=alex -e POSTGRES_PASSWORD=password -e POSTGRES_DB=myalexdb -d -p 5432:5432  postgres

      -p 5432:5432
        5432:   <-  Puerto en nuestra maquina
        :5432   <-  Puerto en el container



# Curso Profesional de Base de Datos

## Intro
  - DB
    - W con DB Relacionales: Coleccion de tablas q almacenan info en forma estructurada
    - Tablas con filas y columnas
      - columnas son atributos de una tabla
      - filas son registros o tuplas
    - Cada tabla tiene una Primary Key
    - DB relacional es un conjunto de tablas q almacenan entidades, entidades q poseen atributos q son representados mediante columnas
      - Cada entidad debe poseer 1 atributo que la haga unica



  - Para W con BD relacionales usaremos un SGBD, en este curso MySQL
    - Lenguaje de consultas SQL
    - Dependiendo el SGBD puede cambiar la sintaxis de SQL
      

  - Yo tengo MySQL con Docker
    - Para acceder al contenedor y poder acceder a MySQL:
        `docker exec -it CONTAINER_ID bash`
    - Conectarnos a MySQL una vez dentro del container
      - user y pass definidas en la creacion de la imagen
        `mysql -u root -p`







  =======================================================================
  -- Curso como tal:
    - Variables pertenecen a la Session, si cerramos se pierden:
      - Declarar variables:     SET @name = "Alex", @gestor = "MySQL";
      - Get value variable:     SELECT @name, @gestor;

    - Crear DB:                 CREATE DATABASE libreria_cf;
    - Ver DB:                   SHOW DATABASES;
    - Eliminar DB:              DROP DATABASE libreria_cf_delete;

    - Seleccionar DB para w con ella        USE libreria_cf;
      - Todas las sentencias SQL se aplicaran a ese DB
    - Crear tablas:             `CREATE TABLE authors(colum_1, colum_n)`;
    - Listar tablas:            SHOW TABLES;
    - Ver en q DB estamos W:    SELECT DATABASE();
    - Eliminar tablas:          DROP TABLE authors;
      - Elimina con todos sus registros.

    - Listar las columnas con el data type q aceptan  <-   definicion de la tabla
                                    SHOW COLUMNS FROM authors;
                                    DESC authors;

    - Crear tablas similares a una existente
            CREATE TABLE users LIKE authors;

    - Insertar registros en una tabla:
      - INSERT INTO table(colums) VALUES(values)

    - Ejecutar un archivo .sql
      - Como estoy W con Docker:
        - Sin auth en MySQL:
          - Creo 1 volumen q mapee este dir con uno en el container
          - Entro al container
          - Ejecuto:
              `mysql -u root -p < /home/docs/sentencias.sql`
        - Auth en MySQL:
              `SOURCE /home/docs/sentencias.sql;`

        
    - Ejecutar sentencias SQL al inicar sesion con MySQL:
      - Todo tipo de sentencias
          `mysql -u root -p libreria_cf -e "SELECT * FROM authors"`



  

  -- constraints
    - Restricciones q podemos colocar a nuestras tablas para q estas NO almacenen datos corruptos, nulos o vacios.
      - Obtener la fecha actual
        - SELECT current_timestamp;
        - SELECT NOW();
      - Solo se puede tener 1 PK x tabla
      - Foreing Key: Sirven para hacer referencias entre tablas


  -- Modificar 1 tabla existente:  alter table
    - Agregar 1 Columna
        `ALTER TABLE books ADD sales INT UNSIGNED NOT NULL;`
        `ALTER TABLE books ADD stock INT UNSIGNED NOT NULL DEFAULT 12;`
        `ALTER TABLE usuarios ADD email VARCHAR(50);`
    - Eliminar 1 columna
        `ALTER TABLE books DROP COLUMN stock;`
    - Modificar el data type de una Column
        `ALTER TABLE usuarios MODIFY telefono VARCHAR(50);`
    - Generar 1 PK a 1 tabla:
        `ALTER TABLE usuarios ADD id INT UNSIGNED NOT NULL AUTO_INCREMENT, ADD PRIMARY KEY (id);`
    - Agregar 1 FK a 1 tabla:
        `ALTER TABLE usuarios ADD FOREIGN KEY(grupo_id) REFERENCES grupos(grupo_id);`
    - Eliminar una FK de 1 tabla:
        `ALTER TABLE usuarios DROP FOREIGN KEY grupo_id;`



  -- Consultas
    - Algunas consultas
        select * from books WHERE title = 'Title 6';


    - diferente:  !=  <>
    - operadores logicos:   AND, OR, NOT
        SELECT * FROM books WHERE title = "Sombra del viento" AND author_id = 1;
        SELECT * FROM books WHERE title = "Sombra del viento" AND author_id = 1 AND sales = 0;

        // trae nulls
        select * from authors where pseudonym IS null;        
        select * from authors where pseudonym IS NOT null;

        // // BETWEEN entre FECHAS
        `select title, publication_date from books where publication_date BETWEEN '1995-01-01' AND '2000-02-24';`

 
    - Consultas con condiciones en un array        IN
        SELECT * FROM books WHERE title IN ('Title 1', 'Title 4', 'Title 6');

    - Valores unicos en 1 query      DISTINCT
        SELECT DISTINCT title FROM  books;

    - Alias    AS
        SELECT author_id, title AS book_title FROM books;
        SELECT libros.author_id AS id, libros.title AS titulo FROM books AS libros;

    

    - Actualizar 1 registro:  UPDATE table SET columnaModificar=newValue WHERE conditino;    <-  usar PK
        `UPDATE books SET description = 'New description', sales = 120 WHERE book_id = 12;`
        `UPDATE books SET description = 'New description', sales = 120 WHERE title = 'Title 6';`

    - Eliminar Registros:     delete from table;   <-  Elimina Todos los registros.
        `DELETE FROM books WHERE book_id = 7;`
        `DELETE FROM books WHERE sales > 100;`

    -- Eliminar en cascada:   CASCADE
      - Protege la integridad referencial, NO podemos eliminar una PK q es usada como FK en otra tabla
        - En la definicino de la tabla debe estar el ON DELETE CASCADE
          - Asi se elimina el author con sus libros (pk con las fk)
                `DELETE FROM authors WHERE author_id = 1;`
        - Modificar la columna ya creada:
                `ALTER TABLE books ADD FOREIGN KEY (author_id) REFERENCES authors(author_id) ON DELETE CASCADE;`

    - Eliminar todos los registros de la tabla  <- restaura la definicion de la tabla - el  ID autoincremental se reinicia a 0
        `TRUNCATE TABLE books;`   <--  resetea la definicion, toda la metadata se va
        `DELETE FROM books;`      <--  mantiene la metadata, el ID autoincremental se conserva

          - delete permite recuperar datos eliminados, truncate NO
            - truncate NO dispara ningun trigger


    


    -- En SQL podemos W con FUNCIONES 
      - Todas las f(x) necesita retornar algun value
      - X lo tanto las podemos usar dentro de sentencias y clausulas (select, where, set, etc)
        - SQL ya trae sus funciones propias para:
          - string
          - nums
          - dates
          - condicionales


      - Funciones sobre Strings
        - concat()
            `SELECT CONCAT(name, ' ',lastname) AS full_name FROM authors;`
        - length()
            `SELECT * FROM authors WHERE LENGTH(name) > 12;`
        - upper()  |  lower()
            `SELECT UPPER(name), LOWER(lastname) FROM authors;`
        - trim()
            `SELECT TRIM("    spaces at the beginning and at the end    ") AS trim;`
        - left / right - Substring en base a las positions indicadas
            `SELECT LEFT('This is a string', 5) AS substring_left, RIGHT('This is another string', 6) AS substring_right;`

        - LIKE %pattern%:
          - title beginning with Sombra:    `SELECT * FROM books WHERE title LIKE 'Sombra%';`


      - Funciones sobre numeros
        - random devuelve un Float, lo podemos redondear con round
              `SELECT ROUND(RAND() * 10) AS random_between_0_10;`
        - establecer # de decimales
              `SELECT TRUNCATE(1.123456789, 3);`
        - Potencia de 1 numero:
              `SELECT POWER(2, 3);`   <- 2^3

      
      - Funciones sobre Fechas
        - Podemos extraer la info de la fecha, creamos una variable de la currect date:  SET @now = NOW();  <- timestamp (complete)
            `SELECT SECOND(@now), HOUR(@now), MONTH(@now), YEAR(@now);`
            `SELECT DAYOFWEEK(@now), DAYOFMONTH(@now), DAYOFYEAR(@now);`


        - fecha actual en date yyyy-MM-dd   `SELECT CURDATE()`
            `SELECT * FROM books WHERE DATE(publication_date) = CURDATE();`

        - Operaciones con fechas:
            fecha +/- INTERVAL value TYPE[SECOND/MINUTE/HOUR/DAY/WEEK/MONTH/YEAR]
              `SELECT @now + INTERVAL 30 DAY;`
    

    - Funciones sobre condiciones
      - IF(condition, true, false);   true-q retornar si es true
          `SELECT IF(pages > 500, "Exists", "Does not exist") FROM books;`
      - IFNULL(column, 'q retorna')
          `SELECT IFNULL(pseudonym, "El autor no tiene pseudonym") FROM authors;`



    -- Crear funciones
      - Se cambia el delimitador para definir la f(x) y luego se lo vuelve a cambiar al original.
      - get all functions
        `select routine_name from information_schema.routines where routine_schema = database() and routine_type = 'FUNCTION';`
      - delete fucntions
        `DROP FUNCTION name;`

      - cambiar el # de pages de los books con una f(x) personalizada
          `UPDATE books SET pages = get_pages();`


      - LIKE %pattern%:
          - title beginning with Sombra:    `SELECT * FROM books WHERE title LIKE 'Sombra%';`
          - coincidencia en algun sitio:    `SELECT * FROM books WHERE title LIKE '%del%';`
          - espacios a respetar:            `SELECT * FROM books WHERE title LIKE '__b__'; `      <- rabia
          - 2do sea o y el resto no importa:    `SELECT * FROM books WHERE title LIKE '_o%';`

          - Expresiones regulares:  REGEXP
            - titulos q inicien con h,l,d     `SELECT title FROM books WHERE title REGEXP '^[HLD]';`
          

      - ORDER BY  ASC/DESC    <- ASC x default
          `SELECT title FROM books ORDER BY title;`
          `SELECT title FROM books ORDER BY title DESC;`
          `SELECT * FROM books ORDER BY pages;`
          `SELECT * FROM books ORDER BY title, pages;`

        - get last element of a table with ORDER BY:
          `SELECT * FROM books ORDER BY book_id DESC LIMIT 1;`
        

      - LIMIT
          `SELECT title FROM books WHERE author_id = 3 LIMIT 2;`
          - 2 valores: index, quantity    <- paginar registros
            `SELECT book_id, title FROM books LIMIT 5, 5;`    <- trae a partir del 6 hasta el 10
          



    - Funciones de agregacion: solo W sobre valores != null
      - count/min/max/avg
      - Get la cantidad de registros con count(*/id/pk)
          `SELECT COUNT(*) FROM books;`
            `SELECT MAX(book_id) FROM books;`   <- solo si es autoincremental y no ha fallado/eliminado
      - Obtener los q NO son null
          `SELECT COUNT(*) FROM authors WHERE pseudonym IS NOT NULL;`
          `SELECT COUNT(pseudonym) AS total FROM authors;`
      - sum: igual solo W con values != null
          `SELECT SUM(sales) FROM books;`
      - max/min/avg
          `SELECT MAX(sales) FROM books;`
          `SELECT MIN(sales) FROM books;`
          `SELECT AVG(sales) FROM books;`   <-  retorn double
          
      - Agrupamiento
        - Para agrupar colums en donde existe 1 funcion de Agregacion
          - Obtener el id del author con mas ventas
            `SELECT author_id, SUM(sales) AS total FROM books GROUP BY author_id ORDER BY total DESC LIMIT 1;`
        
      - Having
        - las funciones de agregacion    NOOOO   pueden ser condicionadas x un WHERE
          - autores cuyas ventas sean > 1500
            `SELECT author_id, SUM(sales) AS total FROM books GROUP BY author_id HAVING SUM(sales) > 1500;`


      - Union: combina multipes datasets
        - Deben retornar la MISMA cantidad de columns
            `SELECT CONCAT(name, ' ', lastname) AS full_name FROM authors UNION SELECT CONCAT(name, ' ', lastname) AS full_name FROM users;`

            ```sql
              SELECT CONCAT(name, ' ', lastname) AS full_name, email, '' AS country FROM users
              UNION
              SELECT CONCAT(name, ' ', lastname) AS full_name, '' AS email, country  FROM authors;
            ```


    -- Subconsultas
      - IN xq retorna una lista de id
        ```sql
        SELECT CONCAT(name, ' ', lastname) AS full_name
        FROM authors
        WHERE author_id IN (
          SELECT author_id
          FROM books
          GROUP BY author_id
          HAVING SUM(sales) > (SELECT AVG(sales) FROM books)
        );
        ```

    - EXIST: true/false si existe o no 1 registro o grupo de registros
      ```sql
      SELECT IF(
        EXISTS(SELECT book_id FROM books WHERE title LIKE '%Viento%'),
        'Disponible',
        'No disponible'
      ) AS disponible;
      ```



  -- JOINS
    - combinar info de varias tablas



  -- Vistas



  -- Procedimientos  / Store Procedures
    - Los store procedures son rutinas q se ejecutan directamente en el motor de DB
      - NO retornan values, pero SI reciben aprametros
      - El SGBD los w a su criterio
      - NO sepueden actualizar, se los debe eliminar y crear otro
      - puede usar 2 bucles


  -- Transacciones
    - Varios usuarios pueden hacer querys a la DB al mismo tiempo
    - Tipos de bloqueo
      - MyISAM excluye del bloque las consultas
      - InnoDB hace q todas las sentencias causen 1 bloqueo

    - Transacciones
      - Mecanismo q nos permite agrupar N cantidad de Sentencias SQL en 1 sola, de modo q todas o ningua de ellas tengan exito.
      - 3 estdos de la transaccino
        - antes/durante/despues
          -  durante: los cambios son reversibles
      - SOLO se modificara la DB cuando TODAS las Sentencias hayan tenido Exito
        - COMMIT;   <- si todo OK finalizamos la transaccion y persistimos  los cambios en DB
        - ROLLBACK; <- 1 error y finalizamos la transaccion SIN persistir los cambios
      
      - X lo general se usan Transacciones en los PROCEDURES
        

  

    -- Triggers
      - Se pueden generar Triggers para C/evento de mysql (INSERT, DELETE, UPDATE)
        - new
        - old








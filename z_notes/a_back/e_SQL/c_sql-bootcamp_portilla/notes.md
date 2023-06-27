


## Instalacion:
  - En mi caso montamos con Docker Compose PostgreSQL y PGAdmin


  - Containers independientes:

    ```
      # Postgres with user AND DB:

      docker run --name some-postgres -e POSTGRES_USER=alex -e POSTGRES_PASSWORD=password -e POSTGRES_DB=myalexdb -p 5432:5432 -d postgres

        # Conectarme con pgadmin: Da error el restore pero si le carga
          host: localhost
          port: 5432



      # Default postgres container:

      docker run --name some-postgres -e POSTGRES_PASSWORD=mysecretpassword -p 5432:5432 -d postgres

        # Conectarme con pgadmin:
          host: localhost
          port: 5432
          user: postgres
          pass: mysecretpassword
    ```


  --- Container con puerto expuesto | name | user | DB creada:
    
    ```
      docker run --name some-postgres  -e POSTGRES_USER=alex -e POSTGRES_PASSWORD=root -e POSTGRES_DB=myalexdb -p 5432:5432 -d  postgres

      docker exec -it some-postgres bash

      psql -U alex --password --db myalexdb

      SELECT current_user; 
    ```




## Init:

  - Clic D en  postgre-connection > Create > Database... > 'Damos nombre: dvdrental' > Save Icon
  - Restore ls DB: 
    - Clic D en  dvdrental > Restore >
        Format: Custom or tar
        Filename: Path del archivo comprimido que tiene la DB q queremos restaurar
        
  - pgAdmin4:
    - En la DB > Schemas > Tables     <-   Podemos ver las tablas de la DB

  - Gran parte de ser bueno con SQL es saber transformar una pregunta/situacion comercial en una Query Real.


  - Hacer Todo lo posible por EVITAR nombres de Columnas identicos a las Key Words de SQL.




## SQL Statement Fundamentals:
  - SELECT: Recuperar informacion/datos de una Tabla dentro de una DB

        SELECT colum_name FROM table_name



    - DISTINC: Recupera solo los Unique Values de una columna

        SELECT DISTINC colum FROM table;

        - Devolvera los valores unicos de esa columna:
        ```sql
          SELECT DISTINCT rental_rate FROM film;
        ```



    - AS:   Dar otro alias/name a la columnaa
      ```sql
        SELECT DISTINCT rental_rate AS rental_rate_rename FROM film;
      ```




    - COUNT: devuelve el Numero de ROWS/Filas que coincidan con una condición específica
      - No importa que columna le pasas xq todas van a tener el mismo numero de filas en la Tabla
        - Lo mas comun es pasarle el   *   en lugar de una columna

      ```sql
        SELECT COUNT(*) FROM table_name

        -- Saber cuantos amounts distintos existen:
        SELECT COUNT(DISTINCT amount) FROM payment;
      ```


    

    - SELECT WHERE:
      - Permite especificar Condiciones en las Columnas para que se devuelvan las filas/rows
        - Comparison Operators
        - Logical Operators
  
    ```sql
      SELECT title, rental_rate, replacement_cost FROM film WHERE rental_rate > 4 AND replacement_cost >= 19.99 AND rating = 'R';
    ```




    - ORDER BY:
      - Va al final de la Query
        - El valor que ORDER BY usa por default es   ASC.
      - Puedo Ordenar en Base a Columnas que NO solicito en mi SELECT statement.

    ```sql
      -- Ordenar elementos duplicados, 1st en base a store_id, luego en base a first_name
      SELECT store_id, first_name, last_name FROM customer ORDER BY store_id, first_name ASC;
    ```

    


    - LIMIT:
      - Limita el # de rows/filas que se van a retornar con una query
      - Va al mismisimo final de la Query

      ```sql
        -- 10 most recent purchases:
        SELECT * FROM payment ORDER BY payment_date DESC LIMIT 10;
      ```




    - BETWEEN: Se lo usa con el  WHERE
      - Numbers:              [start, end]
      - Dates without hours:  (start, end)

      - NOT   valores q NO se incluyan en el rango

    ```sql
      SELECT * FROM payment WHERE amount BETWEEN 8 AND 9;
    ```




    - IN
      - SELECT todos los Valores de la Tabla que indiquemos en el Lista.
      - Podemos seleccionar los valore q NO esten contemplados en la lista

    ```sql
      SELECT COUNT(*) FROM payment WHERE amount IN (0.99, 1.98, 1.99);    -- 3301

      SELECT COUNT(*) FROM payment WHERE amount NOT IN (0.99, 1.98, 1.99);    -- 11295
    ```




  - LIKE  &   ILIKE
    - LIKE:   case-sensitive
    - ILIKE:  case-insensitive
    - PostgreSQL acepta Regex

      %     ←    Coincide con cualquier Secuencia de caracteres.
      _ 	  ←    SOLO permite 1 caracter q coincida. Coincide con cualquier Caracter Individual.
          ```sql
          -- Solo puede tener 1 caracter antes de   her%
          SELECT * FROM customer WHERE first_name LIKE '_her%'; -- Cherly
          ```















## GROUP BY Statements
  
  - Most Common Aggregate Functions:

    AVG()		  –	  returns average/promedio value
    COUNT()   – 	returns number of rows
    MAX()		  – 	returns maximum value
    MIN()		  – 	returns minimum value
    SUM()		  –	  returns the sum of all values - column


  - NOTAS: Aggregate functions SOLO se pueden usar con SELECT and HAVING statements.
    AVG()    returns a floating point value con muchos decimales.
      ROUND()   para especificar la cantidad de decimales q queramos.

    COUNT()    simply return the numbers of ROWS. Por convención puedes pasarle solo el  *  COUNT(*)



  - GROUP BY 
    - Permite agrupar Columnas por alguna Categoria.
    - GROUP BY debe aparecer Despues de un  FROM  o un  WHERE  statement.
    - La   category_col  a ser agrupada debe aparecer en el  SELECT y en el  GROUP BY.
  
  ```sql
    -- Cuanto gasto en total el customer atendido por el staff
    SELECT staff_id, customer_id, SUM(amount) FROM payment GROUP BY staff_id, customer_id ORDER BY staff_id, SUM(amount) DESC;

    -- What is the average replacement cost per MPAA rating?
    SELECT rating, ROUND(AVG(replacement_cost), 2) FROM film GROUP BY rating ORDER BY AVG(replacement_cost) DESC;
  ```









## HAVING
  - Si queremos filtrar el resultado del Aggregate  usamos Having.
    - HAVING puede entenderse como un Where statement pero Solo para algo q se ha agregado a través de un GROUP BY.

    ```sql
      SELECT customer_id, SUM(amount) FROM payment
      WHERE staff_id = 2
      GROUP BY customer_id
      HAVING SUM(amount) > 100
      ORDER BY SUM(amount) DESC;
    ```









## JOIN
  - AS statement:
    - Renombrar una columna.
    - Se ejecuta siempre al Final de toda Query. X eso no se usa este alias en operaciones

  ```sql
    SELECT customer_id, SUM(amount) AS total_spent FROM payment GROUP BY customer_id HAVING SUM(amount) > 100;
  ```




  - INNER JOIN:
    - Es la Interseccion en un diagrama de Venn.
    - Podemos especificar las col q queremos seleccionar:
      - Si es unica, solo colocamos el nombre de la col
      - Si es comun para ambas tablas, Especificamos la tabla
    - Es una JOIN simetrico, da lo mismo A INNER JOIN B q B INNER JOIN A.

  ```sql
    SELECT payment_id, payment.customer_id, first_name
    FROM payment
    INNER JOIN customer
    ON payment.customer_id = customer.customer_id;
  ```



  - Full Outer Joins:
    - Es la Union completa de las 2 tablas en donde se llenara con  Null  en las columnas que no tengan valores en comun.


    - WHERE + FULL OUTER JOIN     <--  Opposite of INNER JOIN
      - Toma Solo los Unique Values de cada tabla.
      - Toma la Union de A y B SIN las Intersecciones.

  ```sql
    -- Verificar politica de provacidad.Si tenemos info de algun customer es xq ha hecho algun payment. NO hay uniques en ninguna tabla.
    SELECT * FROM customer
    FULL OUTER JOIN payment
    ON customer.customer_id = payment.customer_id
    WHERE customer.customer_id IS null OR payment.payment_id IS null;
  ```



  - LEFT OUTER JOIN:
    - Trae a todos los Values de la tabla A/Left Incluidos los de la Interseccion con B/Right.
    
    - WHERE + LEFT OUTER JOIN:
      - Trae a los values UNICOS de la tabla A/Left. Excluye a la interseccion.

  ```sql
    -- Titulos q no estan en el inventario. Excluye la interseccion.
    SELECT film.film_id, film.title, inventory_id, store_id
    FROM film
    LEFT JOIN inventory 
    ON inventory.film_id = film.film_id
    WHERE inventory.film_id IS NULL;
  ```



  - Right Joins:
    - Lo mismo que el LEFT JOIN solo que intercambiando las tablas.
    - Podemos usar un LEFT JOIN cambiando las tablas y ya tendriamos un RIGHT JOIN.



  - Challenge
    - DOBLE JOIN en una query
      
    ```sql
      SELECT title, first_name, last_name  FROM actor
      INNER JOIN film_actor
      ON actor.actor_id = film_actor.actor_id
      INNER JOIN film
      ON film_actor.film_id = film.film_id
      WHERE first_name = 'Nick' AND last_name = 'Wahlberg';
    ```








## Advanced SQL Commands





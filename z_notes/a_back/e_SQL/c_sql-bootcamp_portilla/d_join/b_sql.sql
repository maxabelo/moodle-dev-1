-- -- JOINS:

-- AS statement:
SELECT COUNT(*) AS num_transactions FROM payment;

SELECT customer_id, SUM(amount) AS total_spent FROM payment GROUP BY customer_id HAVING SUM(amount) > 100;








-- INNER JOIN: PostgreSQL es lo suficientemente inteligente para hacer el SELECT sin establecer la tabal de aqeullas columnas unicas. Si NO es unique, debo especificar la tabla.
-- Solo los customer q aparezcan en las 2 tablas: la match_column en una DB bien disenada debe tener el mismo nombre en ambas tablas.
SELECT payment_id, payment.customer_id, first_name
FROM payment
INNER JOIN customer
ON payment.customer_id = customer.customer_id;









-- FULL OUTER JOIN:

-- Verificar politica de provacidad. NO deveriamos tener info de quien nunca haya hecho un payment.
-- Si tenemos info de algun customer es xq ha hecho algun payment. NO hay uniques en ninguna tabla.
SELECT * FROM customer
FULL OUTER JOIN payment
ON customer.customer_id = payment.customer_id
WHERE customer.customer_id IS null OR payment.payment_id IS null;









-- Left Outer Join
SELECT film.film_id, film.title, inventory_id, store_id
FROM film
LEFT JOIN inventory 
ON inventory.film_id = film.film_id;



-- Titulos q NO tenemos en nuestro inventario y x tanto NO estan en las tiendas. SOLO A/Left
SELECT film.film_id, film.title, inventory_id, store_id
FROM film
LEFT JOIN inventory 
ON inventory.film_id = film.film_id
WHERE inventory.film_id IS NULL;

-- Comprobacion:
select film_id, title from film where film.title = 'Alice Fantasia'; -- 14
select * from inventory where inventory.film_id = 14; -- Empty



-- Titulos unicos en la tienda 2:
SELECT COUNT(DISTINCT film.title)
FROM film
LEFT JOIN inventory 
ON inventory.film_id = film.film_id
WHERE store_id = 2; -- 762









-- Right Joins:
-- Lo mismo que el LEFT JOIN con la tabla invertida.








-- JOIN Challenges:
SELECT district, email FROM address
INNER JOIN customer
ON address.address_id = customer.address_id
WHERE district = 'California';




SELECT title, first_name, last_name  FROM actor
INNER JOIN film_actor
ON actor.actor_id = film_actor.actor_id
INNER JOIN film
ON film_actor.film_id = film.film_id
WHERE first_name = 'Nick' AND last_name = 'Wahlberg';






















SELECT first_name, last_name, email FROM customer;
-- SELECT count(customer_id) FROM customer; -- Numero total de customers
-- SELECT count(*) FROM customer; -- Numero total de customers



-- SELECT DISTINCT
SELECT * FROM film;
SELECT DISTINCT release_year FROM film;
SELECT DISTINCT rental_rate FROM film;
SELECT DISTINCT replacement_cost, title, description FROM film;


-- Challenge:
SELECT * FROM film;
SELECT DISTINCT rating FROM film;
SELECT COUNT(DISTINCT rating) FROM film; -- 5






-- COUTN(conditon)
SELECT * FROM payment;
SELECT COUNT(amount) FROM payment;
SELECT COUNT(*) FROM payment;


SELECT DISTINCT amount FROM payment;
SELECT COUNT(DISTINCT amount) FROM payment; -- 19






-- WHERE | Comparison Operators | Logical Operators
SELECT * FROM customer WHERE first_name = 'Jared';


SELECT * FROM film WHERE rental_rate > 4;
SELECT count(*) FROM film WHERE rental_rate > 4; -- 336

SELECT * FROM film WHERE replacement_cost >= 19.99;
SELECT title, description, release_year, rental_rate, replacement_cost FROM film WHERE replacement_cost >= 19.99;
SELECT count(*) FROM film WHERE replacement_cost >= 19.99; -- 536
SELECT count(*) FROM film WHERE replacement_cost <= 19.99; -- 514


SELECT * FROM film WHERE rental_rate > 4 AND replacement_cost >= 19.99;
SELECT title, description, release_year, rental_rate, replacement_cost FROM film WHERE rental_rate > 4 and replacement_cost >= 19.99;
SELECT count(*) FROM film WHERE rental_rate > 4 and replacement_cost >= 19.99; -- 173

SELECT MAX(replacement_cost) as max_replacement_cost FROM film; -- Valor Max de reemplazo: 29.99

SELECT title, rental_rate, replacement_cost FROM film WHERE rental_rate > 4 and replacement_cost >= 19.99 and rating = 'R';
SELECT count(*) FROM film WHERE rental_rate > 4 AND replacement_cost >= 19.99 and rating = 'R'; -- 34
SELECT count(*) FROM film WHERE rating = 'R' OR rating = 'PG-13'; -- 418


--   !=
SELECT * FROM film WHERE rating != 'R';
SELECT count(*) FROM film WHERE rating != 'R'; -- 805

SELECT * FROM film WHERE rating != 'R' AND rating != 'PG-13';
SELECT * FROM film WHERE rating NOT IN ('R', 'PG-13');
SELECT COUNT(*) FROM film WHERE rating NOT IN ('R', 'PG-13');  --  582
SELECT COUNT(*) FROM film WHERE rating != 'R' AND rating != 'PG-13'; -- 582


-- Challenge: SELECT WHERE
SELECT * FROM customer;
SELECT email FROM customer WHERE first_name = 'Nancy' and last_name = 'Thomas';

SELECT * FROM film;
SELECT description FROM film WHERE title = 'Outlaw Hanky';

SELECT * FROM address;
SELECT phone FROM address WHERE address = '259 Ipoh Drive';






-- ORDER BY:
SELECT * FROM customer;
SELECT * FROM customer ORDER BY first_name;
SELECT * FROM customer ORDER BY first_name DESC

SELECT store_id, first_name, last_name FROM customer ORDER BY store_id, first_name; -- ordena por store_id y por first_name
SELECT store_id, last_name FROM customer ORDER BY store_id, first_name; -- lo mismo de arriba







-- BETWEEN: Numbers [start, end]   |   Dates (start, end)  <-  without hours
SELECT * FROM payment WHERE amount BETWEEN 8 AND 9;

SELECT COUNT(*) FROM payment;  -- 14596
SELECT COUNT(*) FROM payment WHERE amount BETWEEN 8 AND 9;  -- 439
SELECT COUNT(*) FROM payment WHERE amount NOT BETWEEN 8 AND 9; -- 14157

SELECT * FROM payment WHERE amount BETWEEN 8 AND 9 ORDER BY amount ASC;


-- Dates without hours:  (start, end)
SELECT * FROM payment WHERE payment_date BETWEEN '2007-02-01' AND '2007-02-15' -- 03 -> 14
SELECT * FROM payment WHERE payment_date BETWEEN '2007-02-01' AND '2007-02-14' -- 03 -> 13 = Nothing








-- IN:  (i, i_2, ..., i_n)
SELECT DISTINCT amount FROM payment ORDER BY amount;

SELECT COUNT(DISTINCT amount) FROM payment; -- 19
SELECT COUNT(*) FROM payment;   -- 14596
SELECT COUNT(*) FROM payment WHERE amount IN (0.99, 1.98, 1.99);    -- 3301
SELECT COUNT(*) FROM payment WHERE amount NOT IN (0.99, 1.98, 1.99);    -- 11295 - los q NO estan en la lista


-- String
SELECT * FROM customer WHERE first_name IN ('John', 'Jake', 'Julie');

SELECT * FROM customer WHERE first_name LIKE 'J%' ORDER BY  store_id, last_name;  -- 65







-- LIKE and ILIKE  |  LIKE - case-sensitive  |  ILIKE - case-insensitive:
SELECT COUNT(*) FROM customer WHERE first_name LIKE 'J%'; -- 65

-- FN comienza x J y LN x S, ordenamos en base a FN ASC:  <--  case-sensitive  |  ILIKE - case-insensitive
SELECT * FROM customer WHERE first_name LIKE 'J%' AND last_name ILIKE 's%' ORDER BY first_name ASC;

-- Con   _   solo puede tener 1 caracter antes del resto del string
SELECT * FROM customer WHERE first_name LIKE '_her%'; -- Cheryl, ....

-- Solo las q empiezan x 'A*', EXCEPTO aquellas cuyo last_name inician por 'B*'
SELECT * FROM customer WHERE first_name LIKE 'A%' AND last_name NOT LIKE 'B%' ORDER BY last_name;









-- General Challenge 1:
SELECT COUNT(*) FROM payment WHERE amount > 5.00; -- 3618

SELECT COUNT(*) FROM actor WHERE first_name LIKE 'P%';  -- 5

SELECT COUNT(DISTINCT(district)) FROM address;  -- 378

SELECT DISTINCT(district) FROM address;

SELECT COUNT(*) FROM film WHERE rating = 'R' AND replacement_cost BETWEEN 5 AND 15; -- 52

SELECT title FROM film WHERE title LIKE '%Truman%';
SELECT COUNT(*) FROM film WHERE title LIKE '%Truman%'; -- 5









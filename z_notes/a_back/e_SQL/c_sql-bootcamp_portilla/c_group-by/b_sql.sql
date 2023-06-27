-- Aggregate Functions:

SELECT MIN(replacement_cost) FROM film; -- $9.99
SELECT MAX(replacement_cost) FROM film; -- $29.99

SELECT MAX(replacement_cost), MIN(replacement_cost) FROM film; --  $9.99 | $29.99

SELECT MAX(replacement_cost) AS max_replacement_cost FROM film; -- $29.99



SELECT COUNT(*) FROM film;  -- 1000




-- AVG()  &   ROUND(#, Decimales):
SELECT AVG(replacement_cost) FROM film;  -- 19.9840000000000000

SELECT ROUND(AVG(replacement_cost)) FROM film;     -- 20
SELECT ROUND(AVG(replacement_cost), 2) FROM film;  -- 19.98




-- SUM():
SELECT SUM(replacement_cost) FROM film;  -- 19984.00










-- GROUP BY:
SELECT * FROM payment;

SELECT customer_id FROM payment GROUP BY customer_id ORDER BY customer_id;
SELECT distinct(customer_id) FROM payment ORDER BY customer_id;  -- = q arriba, but ...


-- What customer spends the MOST money in total?
SELECT customer_id, SUM(amount) FROM payment GROUP BY customer_id ORDER BY SUM(amount) DESC LIMIT 1; -- 148 - $211.55

-- What is the total number of transactions per customer?
SELECT customer_id, COUNT(amount) FROM payment
GROUP BY customer_id
ORDER BY COUNT(amount) DESC;



-- Multimple column
SELECT * FROM payment limit 2;

-- Cuanto gasto en total el customer atendido por el staff
SELECT staff_id, customer_id, SUM(amount) FROM payment GROUP BY staff_id, customer_id ORDER BY staff_id, SUM(amount) DESC;



-- DATE:  DATE(col_date_data)  <-  Solo date, without time/hours
SELECT * FROM payment;

SELECT DATE(payment_date) FROM payment;


-- Dias con > transacciones
SELECT DATE(payment_date), SUM(amount) FROM payment
GROUP BY DATE(payment_date)
ORDER BY SUM (amount) DESC;



-- Challenge - GROUP BY:
SELECT staff_id, COUNT(*) FROM payment GROUP BY staff_id;

SELECT rating, AVG(replacement_cost) FROM film GROUP BY rating;
SELECT rating, ROUND(AVG(replacement_cost), 2) FROM film GROUP BY rating ORDER BY AVG(replacement_cost) DESC;

SELECT customer_id, SUM(amount) FROM payment GROUP BY customer_id ORDER BY SUM(amount) DESC LIMIT 5;










-- HAVING:
-- Esto funciona. Lo q NOO se puede hacer es filtrar amount con where xq sum(amount) no va a suceder hasta q se llama el group by
SELECT customer_id, SUM(amount) FROM payment
WHERE customer_id NOT IN (184, 87, 477)
GROUP BY customer_id;


-- Filtra las SUM(amount) > 100 en este caso
SELECT customer_id, SUM(amount) FROM payment
GROUP BY customer_id
HAVING SUM(amount) > 127
ORDER BY SUM(amount);


-- How many customers are there per store?
SELECT store_id, COUNT(*) FROM customer GROUP BY store_id;

SELECT store_id, COUNT(customer_id) FROM customer GROUP BY store_id HAVING COUNT(*) > 300; -- store_id = 1




-- HAVING Challenges:
select customer_id, COUNT(amount) from payment GROUP BY customer_id HAVING COUNT(*) >= 40;


SELECT customer_id, SUM(amount) FROM payment
WHERE staff_id = 2
GROUP BY customer_id
HAVING SUM(amount) > 100
ORDER BY SUM(amount) DESC;









-- -- Assessment Test 1
-- Return the customer IDs of customers who have spent at least $110 with the staff member who has an ID of 2. 
SELECT customer_id, SUM(amount) FROM payment WHERE staff_id = 2 GROUP BY customer_id HAVING sum(amount) >= 110;



-- How many films begin with the letter J?
SELECT COUNT(*) FROM film WHERE title LIKE 'J%';



-- What customer has the highest customer ID number whose name starts with an 'E' and has an address ID lower than 500?
SELECT first_name, last_name, customer_id, address_id  FROM customer 
WHERE first_name LIKE 'E%' AND address_id < 500
ORDER BY customer_id DESC LIMIT 1;













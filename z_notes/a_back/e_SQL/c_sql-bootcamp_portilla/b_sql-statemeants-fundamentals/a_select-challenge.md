# Basic Challenges:

## SELECT - Challenge:
  - Situation:
    - We want to send out a promotional email to our existing customers!

  - Chanllenge:
    - Grap ther first and las names of every customer and their email address.


  - Answer:

    ```sql
      SELECT first_name, last_name, email FROM customer;

      -- SELECT count(customer_id) FROM customer; -- Numero total de customers
    ```






## DISTINCT - Challenge:
  - Situation:
    - An Australian visitor isn't familiar with MPAA movie ratings (e.g. PG, PG-13, R, etc.)  
    - We want to know the types of ratings we have in our DB.
    - What ratings do we have available?

  - SLQ Challenge:
    - Retrieve the distinct rating types our films could have in our DB

  - Answer:
    ```sql
      SELECT DISTINCT rating FROM film;
    ```






## SELECT WHERE - Challenge:
  - Situation:
    - A customer forgot their wallet at our store! We need to track down their email to inform them.
    - What is ther email for ther customer with the name Nancy Thomas?

    ```sql
      SELECT email FROM customer WHERE first_name = 'Nancy' AND last_name = 'Thomas';
    ```


    - A customer wants to know what the movie 'Outlaw Hanky' is about.
    - Could you give them the description for the movie 'Outlaw Hanky;

    ```sql
      SELECT description FROM film WHERE title = 'Outlaw Hanky';
    ```


    - Can yo get the phone numbre for the customer who lives at '259 Ipoh Drive'

    ```sql
      SELECT phone FROM address WHERE address = '259 Ipoh Drive';
    ```






## ORDER BY - LIMIT -- Challenge:
  - Question:
    - We want to reward our first 10 paying customers.
    - What are the customer ids of the first 10 customers who created a payment?
      - Oldest customers

  ```sql
    SELECT customer_id FROM payment ORDER BY payment_date LIMIT 10;
  ```


    - A customer wants to quickly rent a video to watch over their short lunch breack
    - What are ther litles of ther 5 shortest (in length of runtimer) movies?
      - s

    ```sql
      SELECT MIN(length) FROM film; -- 46
      SELECT title, description, length FROM film WHERE length <= 46 ORDER BY length LIMIT 5;

      SELECT title, description, length FROM film ORDER BY length LIMIT 5;
    ```


    - If the previous custumer can whatch any movies that is 50 minutes or less in run time, how many options does she have?
    
    ```sql
      SELECT count(*) FROM film WHERE length <= 50;
    ```
    












# General Challenge: S2 - SQL Statement Fundamentals

## How many payments transactions where greate than $5.00?
    ```sql
      SELECT COUNT(*) FROM payment WHERE amount > 5.00; -- 3618
    ```


## How many actors have a first name that starts with the letter P?
    ```sql
      SELECT COUNT(*) FROM actor WHERE first_name LIKE 'P%'; -- 5
    ```


## How many unique districts are our customer from?
    ```sql
      SELECT COUNT(DISTINCT(district)) FROM address;  -- 378
    ```


## Retrieve the list of names of the different districts from the previous question.
  ```sql
    SELECT DISTINCT(district) FROM address;
  ```


## How many films have a rating of R and a replacement cost between $5 and $5?
  ```sql
    SELECT COUNT(*) FROM film WHERE rating = 'R' AND replacement_cost BETWEEN 5 AND 15; -- 52
  ```


## How many films have the word Truman SOMEWHERE in the title?
  ```sql
    SELECT COUNT(*) FROM film WHERE title LIKE '%Truman%'; -- 5
  ```

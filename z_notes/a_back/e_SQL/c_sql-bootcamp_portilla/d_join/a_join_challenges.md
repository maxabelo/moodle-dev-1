# JOIN Challenges

  -- California sales tax laws have changeded and we need to alert our customer to this through email.
    - What are the emails of the customers who live in California?

    - Answer:
    
  ```sql
    SELECT district, email FROM address
    INNER JOIN customer
    ON address.address_id = customer.address_id
    WHERE district = 'California';
  ```






  -- A customer walks in and is a huge fan of the actor "Nick Wahlberg" and wants to know which movies he is in.
    - Get a list of all the movies "Nick Wahlberg" has been in.
    - Esto requiere de un JOIN DOBLE.
      - Tiene una tabla intermedia/3 con solo los id que las une (film_actor)
        - Aqui los id de cada tabla principal son las    Foreign Keys

    - Answer:

  ```sql
    SELECT title, first_name, last_name  FROM actor
    INNER JOIN film_actor
    ON actor.actor_id = film_actor.actor_id
    INNER JOIN film
    ON film_actor.film_id = film.film_id
    WHERE first_name = 'Nick' AND last_name = 'Wahlberg';
```





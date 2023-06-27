# Basic Challenges:

## GROUP BY Challenge:
  -- We have 2 staff members, with Staff IDs 1 and 2. We want to give a bonus to the staff menber that handled the most payments. (Most in terms of number of payments processes, not total dollar amount).
  - How many payments did each staff member handle and who gets the bonus?
  
  - Answer:
  ```sql
    SELECT staff_id, COUNT(*) FROM payment GROUP BY staff_id;
  ```



  -- Corporate HQ is conducting a study on the relationship between replacement cost and movie MPAA rating (e.g. G, OG, R, etc.)
    - What is the average replacement cost per MPAA rating?
      - Note: You may need to expand the AVG column to view correct results.

  - Answer:
  ```sql
    select rating, ROUND(AVG(replacement_cost), 2) from film group by rating order by AVG(replacement_cost) DESC;
  ```



  -- We're running a promotion to reward our top 5 customer with coupons.
    - What are the customer ids of the top 5 customers by total spend?

  - Answer:
  ```sql
    SELECT customer_id, SUM(amount) FROM payment GROUP BY customer_id ORDER BY SUM(amount) DESC LIMIT 5;
  ```







## HAVING - Challenge Tasks
  -- We're launching a platinum service for our most loyal customer. We will assign platinium status to customers that have had 40 or more transaction payments.
    - What customer_ids are eligible for platinum status?
  
  - Answer:
    ```sql
      SELECT customer_id, COUNT(amount) FROM payment GROUP BY customer_id HAVING COUNT(amount) >= 40;
    ```



  -- What are the customer ids of customers who have spent more than $100 in payment transactions with our staff_id member 2?
  
  - Answer:
    ```sql
      SELECT customer_id, SUM(amount) FROM payment
      WHERE staff_id = 2
      GROUP BY customer_id
      HAVING SUM(amount) > 100
      ORDER BY SUM(amount) DESC;

      -- Or:
      SELECT customer_id, SUM(amount) FROM payment WHERE staff_id = 2 GROUP BY customer_id HAVING SUM(amount) > 100 ORDER BY SUM(amount) DESC;
    ```



# Assessment Test 1
  -- Return the customer IDs of customers who have spent at least $110 with the staff member who has an ID of 2.
  
    The answer should be customers 187 and 148.


  
  -- How many films begin with the letter J?

    The answer should be 20.



  -- What customer has the highest customer ID number whose name starts with an 'E' and has an address ID lower than 500?

    The answer is Eddie Tomlin



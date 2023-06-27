SELECT CONCAT(name, ' ', lastname) AS full_name, email, '' AS country FROM users
UNION
SELECT CONCAT(name, ' ', lastname) AS full_name, '' AS email, country  FROM authors;

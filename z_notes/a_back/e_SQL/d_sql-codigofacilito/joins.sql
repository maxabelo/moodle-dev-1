-- -- INNER JOIN: interseccion de tablas/conjuntos - datos en comun entre tablas  -  ON: orden es indiferente
SELECT 
  b.title,
  CONCAT(a.name, ' ', a.lastname) AS author_full_name,
  b.publication_date
FROM books AS b
INNER JOIN authors AS a ON b.author_id = a.author_id;

-- ON nos permite condicionar aun mas la union: union de solo aquellos 1 tiene pseudonym
SELECT 
  b.title,
  CONCAT(a.name, ' ', a.lastname) AS author_full_name,
  b.publication_date
FROM books AS b
INNER JOIN authors AS a ON b.author_id = a.author_id AND a.pseudonym IS NOT NULL;



-- -- LEFT JOIN = LEFT OUTER JOIN: Toda la tabla left (incluida la interseccion con b, asi da toda la a)
-- relaciones de MUCHOS A MUCHOS necesitamos una tabla intermedia (manyTomany / N:N)
  -- NO tiene PK, solo FK de las tablas con relacion N:N
CREATE TABLE books_users(
  book_id INT UNSIGNED NOT NULL,
  user_id INT UNSIGNED NOT NULL,

  FOREIGN KEY (book_id) REFERENCES books(book_id),
  FOREIGN KEY (user_id) REFERENCES users(user_id),

  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- left join: traera todos los de A y aquellos q no tengan B los poblara con null - la tabla princial (a) sera la del FROM
SELECT
  CONCAT(name, " ", lastname) AS user_full_name,
  bl.book_id
FROM users as u
LEFT JOIN books_users AS bl ON u.user_id = bl.user_id;
-- solo los q han alquilado 1 book
SELECT
  CONCAT(name, " ", lastname) AS user_full_name,
  bl.book_id
FROM users as u
LEFT JOIN books_users AS bl ON u.user_id = bl.user_id
WHERE bl.book_id IS NOT NULL;
-- los q no han alguilado 1 libro
SELECT
  CONCAT(name, " ", lastname) AS user_full_name,
  bl.book_id
FROM users as u
LEFT JOIN books_users AS bl ON u.user_id = bl.user_id
WHERE bl.book_id IS NULL;



-- -- RIGHT JOIN = RIGHT OUTER JOIN: peso en B: lb=1, u=b
SELECT
  CONCAT(name, " ", lastname) AS user_full_name,
  bl.book_id
FROM books_users AS bl
RIGHT JOIN users as u ON u.user_id = bl.user_id;



-- -- Multiples Join
-- u, bl, b, a - user q haya alquilado 1 book q haya sido escrito x 1 author con pseudonym en el current day
SELECT DISTINCT CONCAT(u.name, ' ', u.lastname) AS user_full_name
FROM users AS u
INNER JOIN books_users AS bl ON u.user_id = bl.user_id AND DATE(bl.created_at) = CURDATE()
INNER JOIN books AS b ON bl.book_id = b.book_id
INNER JOIN authors AS a ON b.author_id = a.author_id AND a.pseudonym IS NOT NULL;


-- -- Productos cartesianos
-- a c/u le corresponde 1 b
SELECT u.username, b.title FROM users AS u CROSS JOIN books AS b ORDER BY u.username;
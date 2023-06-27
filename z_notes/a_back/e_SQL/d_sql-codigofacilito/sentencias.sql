/* 
  Tipo de entidades  ->  Autores
    Name: autores

  - lluvia de ideas
    name, gender, date of birth, country

  - column and data type
    name  VARCHAR(50) <- almacenar Strings  - 50 limite
    gender CHAR(1)     <- cadena alfanumerica - 0-255char
    date_of_birth  DATE   <- formato yyyy-MM-dd
    country VARCHAR(40)

  - normalizacion
    - verificar q no tengamos columnas duplicadas o compuestas
    author_id INT       <- # enteros - primary key
    name  VARCHAR(50) <- almacenar Strings  - 50 limite
    lastname VARCHAR(50)
    gender CHAR(1)     <- cadena alfanumerica - 0-255char   <- F/M
    date_of_birth  DATE   <- formato yyyy-MM-dd
    country VARCHAR(40)


  - generar la tabla
      CREATE TABLE authors(
        colums
      );
 */


-- Condicionar algunas sentencias
DROP DATABASE IF EXISTS libreria_cf;
CREATE DATABASE IF NOT EXISTS libreria_cf;

USE libreria_cf;

-- -- Definicion de la tabla - crear tabla
-- not null/unique   <-   constraints   - UNSIGNED > NO negativos
CREATE TABLE IF NOT EXISTS authors(
  author_id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,   -- Solo 1 PK x tabla
  name VARCHAR(25) NOT NULL,
  lastname VARCHAR(25) NOT NULL,
  pseudonym VARCHAR(25) UNIQUE,
  -- gender CHAR(1) NOT NULL ,
  gender ENUM('M', 'F'),  -- ENUM hasta 4 registros
  date_of_birth DATE NOT NULL,
  country VARCHAR(40) NOT NULL,
  created_at DATETIME DEFAULT current_timestamp
);

-- 1 autor muchos libors, 1 libro 1 author - Relacion  OneToMany
CREATE TABLE IF NOT EXISTS books(
  book_id INTEGER UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  title VARCHAR(50) NOT NULL,
  description VARCHAR(250),
  pages INTEGER UNSIGNED NOT NULL DEFAULT 0,
  publication_date DATE NOT NULL DEFAULT(CURRENT_DATE),
  sales INT UNSIGNED NOT NULL DEFAULT 0,
  created_at DATETIME DEFAULT current_timestamp,

  -- Foreign Key
  author_id INTEGER UNSIGNED NOT NULL,
  FOREIGN KEY (author_id) REFERENCES authors(author_id) ON DELETE CASCADE  -- FOREIGN KEY (column) REFERENCES table_references(primary_key) - CASCADE elimina en cascada, es decir, si se elimina el author, tb se eliminan sus libros, esto debe ser asi xq la relacion en OneToMany
);

CREATE TABLE users(
  user_id INT UNSIGNED PRIMARY KEY AUTO_INCREMENT,
  name VARCHAR(25) NOT NULL,
  lastname VARCHAR(25),
  username VARCHAR(25) NOT NULL,
  email VARCHAR(50) NOT NULL,
  created_at DATETIME DEFAULT current_timestamp
);

CREATE TABLE books_users(
  book_id INT UNSIGNED NOT NULL,
  user_id INT UNSIGNED NOT NULL,

  FOREIGN KEY (book_id) REFERENCES books(book_id),
  FOREIGN KEY (user_id) REFERENCES users(user_id),

  -- fecha en la q se rento el book
  created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);





-- -- Insertar registros en 1 tabla
-- INSERT INTO authors (author_id, name, lastname, gender, date_of_birth, country) VALUES(1, 'Test author', 'Test lastname', 'M', '2022-02-21', 'Ecuador');

-- -- Podemos insertar solo algunos datos
-- INSERT INTO authors (author_id, name) VALUES(1, 'Test author');

-- Insertar multiples registros en 1 query - tuplas
INSERT INTO authors (name, lastname, gender, date_of_birth, country) VALUES ('Test author', 'Test lastname', 'M', '2022-02-21', 'Germany'), ('Test author 2', 'Test lastname', 'M', '2022-02-21', 'Spain'), ('Test author 3', 'Test lastname', 'M', '2022-02-21', 'Peru'), ('Test author 4', 'Test lastname', 'M', '2022-02-21', 'Ecuador'), ('Test author 4', 'Test lastname', 'M', '2022-02-21', 'Argentina'), ('Test author 4', 'Test lastname', 'M', '2022-02-21', 'Italy'), ('Test author 4', 'Test lastname', 'M', '2022-02-21', 'Canada');

INSERT INTO authors (name, lastname, pseudonym, gender, date_of_birth, country) VALUES('Test author', 'Test lastname', 'Some pseudonym','M', '2022-02-21', 'Ecuador');


-- Integridad referencial: La foreign key de un registro siempre debera ser una primary key valida
INSERT INTO books (author_id, title, description, pages, publication_date)
  VALUES  (1, 'Title 1', 'Some description', 822, '2000-12-21'),
          (1, 'Title 2', 'Some description', 384, '1995-01-21'),
          (1, 'Sombra del viento', 'Some description', 320, '2000-12-21'),

          (2, 'Title 4', 'Some description', 420, '2000-12-21'),
          (2, 'Laplace 5', 'Some description', 420, '2000-01-21'),
          (2, 'Title 6', 'Some description', 320, '2000-02-21'),
          (2, 'Sombra 7', 'Some description', 220, '2000-03-21'),

          (3, 'Ann 8', 'Some description', 120, '2000-10-21'),
          (3, 'LHopital 9', 'Some description', 720, '2000-12-21'),
          (3, 'Dona 10', 'Some description', 620, '2000-11-21'),
          (3, 'Title 11', 'Some description', 520, '2000-12-21'),
          (3, 'Title 11', 'Some description', 123, '2000-12-21'),
          (3, 'Title 11', 'Some description', 432, '2000-12-21'),

          (4, 'Title 12', 'Some description', 990, '2002-12-21'),
          (4, 'Rabia', 'Some description', 990, '2002-12-21'),
          (4, 'El juego del angel', 'Some description', 990, '2002-12-21'),
          (4, 'Hospital 13', 'Some description', 420, '2000-12-21'),

          (5, 'Guerra 13', 'Some description', 453, '2000-12-21');

INSERT INTO books (author_id, title, description, pages)
  VALUES  (4, 'Title 14', 'Some description', 420);

INSERT INTO books (author_id, title, publication_date)
VALUES (1, 'Carrie','1974-01-01'),
      (1, 'El misterio de Salmes Lot','1975-01-01'),
      (1, 'El resplando','1977-01-01'),
      (1, 'Rabia','1977-01-01'),
      (1, 'El umbral de la noche','1978-01-01'),
      (1, 'La danza de la muerte','1978-01-01'),
      (1, 'La larga marcha','1979-01-01'),
      (1, 'La zona muerta','1979-01-01'),
      (1, 'Ojos de fuego','1980-01-01'),
      (1, 'Cujo','1981-01-01'),
      (1, 'La torre oscura 1 El pistolero','1982-01-01'),
      (1, 'La torre oscura 2 La invocación','1987-01-01'),
      (1, 'Apocalipsis','1990-01-01'),
      (1, 'La torre oscura 3 Las tierras baldías','1991-01-01'),
      (1, 'La torre oscura 4 Bola de cristal','1997-01-01'),
      (1, 'La torre oscura 5 Los de Calla','2003-01-01'),
      (1, 'La torre oscura 6 La torre oscura','2004-01-01'),
      (1, 'La torre oscura 7 Canción de Susannah','2004-01-01'),
      (1, 'La niebla','1981-01-01'),

      (2, 'Harry Potter y la Piedra Filosofal', '1997-06-30'),
      (2, 'Harry Potter y la Cámara Secreta', '1998-07-2'),
      (2, 'Harry Potter y el Prisionero de Azkaban','1999-07-8'),
      (2, 'Harry Potter y el Cáliz de Fuego','2000-03-20'),
      (2, 'Harry Potter y la Orden del Fénix','2003-06-21'),
      (2, 'Harry Potter y el Misterio del Príncipe','2005-06-16'),
      (2, 'Harry Potter y las Reliquias de la Muerte','2007-07-21'),

      (3, 'Origen', '2017-01-01'),
      (3, 'Inferno', '2013-01-01'),
      (3, 'El simbolo perdido', '2009-01-01'),
      (3, 'El código Da Vinci', '2006-01-01'),
      (3, 'La consipiración', '2003-01-01'),

      (4, 'Al calor del verano', '1982-01-01'),
      (4, 'Un asunto pendiente', '1987-01-01'),
      (4, 'Juicio Final', '1992-01-01'),
      (4, 'La sombra', '1995-01-01'),
      (4, 'Juego de ingenios', '1997-01-01'),
      (4, 'El psicoanalista', '2002-01-01'),
      (4, 'La historia del loco', '2004-01-01'),
      (4, 'El hombre equivocado', '2006-01-01'),
      (4, 'El estudiante', '2014-01-01'),

      (5, 'El hobbit','1937-01-01'),
      (5, 'Las dos torres','1954-01-01'),
      (5, 'El señor de los anillos','1954-01-01'),
      (5, 'La comunidad del anillo','1954-01-01'),
      (5, 'El retorno del rey','1955-01-01'),

      (6, 'La niebla','1914-01-01'),

      (7, 'Eva','2017-01-01'),
      (7, 'Falcó','2016-01-01'),
      (7, 'Hombre buenos','2015-01-01'),
      (7, 'Los barcos se pierden en tierra','2011-01-01'),

      (8, 'Juego de tronos','1996-08-01'),
      (8, 'Choque de reyes','1998-11-16'),
      (8, 'Tormenta de espadas','2005-10-17'),
      (8, 'Festin de cuervos','2011-07-12'),
      (8, 'Danza de dragones','2011-07-12');





INSERT INTO users (name, lastname, username, email)
VALUES  ('Alex', 'Axes', 'alexAxes21', 'alex@alex.com'),
        ('Pedro', 'Fuentes', 'pedro24', 'pedro@fuente.com'),
        ('Maximo', 'Sals', 'masSl44', 'mas@sl.com'),
        ('Minpro', 'Menin', 'menos23', 'menos@ks.com'),
        ('Tame', 'Impala', 'coolGroup', 'tame@impala.com'),
        ('Julia', 'Stone', 'juliaStone33', 'julia@stone.com');


INSERT INTO books_users (book_id, user_id)
VALUES  (1, 1), (1, 2), (1, 3), (2, 1), (3, 1), (3, 2), (4, 2);




ALTER TABLE books ADD stock INT UNSIGNED DEFAULT 10;
ALTER TABLE authors ADD COLUMN quantity_books INT DEFAULT 0;
UPDATE books SET sales = ROUND(RAND() * 100) * 7;
UPDATE books SET pages = ROUND(RAND() * 100) * 10;






-- -- Subcnosultas
-- SET @average_sales = (SELECT AVG(sales) FROM books);   --356.8889
-- SELECT author_id FROM books GROUP BY author_id HAVING SUM(sales) > @average_sales;  -- autores cuyas ventas > avg

-- subconsulta: 1ro se ejecutan las consultas anidadas hasta al principal  - nombre del autor cuyas sales > avg
SELECT CONCAT(name, ' ', lastname) AS full_name
FROM authors
WHERE author_id IN (
  SELECT author_id
  FROM books
  GROUP BY author_id
  HAVING SUM(sales) > (SELECT AVG(sales) FROM books)
);


-- -- EXIST: no intersa el campo de la consulta dentro del exist
SELECT IF(
  EXISTS(SELECT book_id FROM books WHERE title LIKE '%Viento%'),
  'Disponible',
  'No disponible'
) AS disponible;




-- 


SHOW TABLES;

SELECT * FROM authors;
SELECT * FROM books;
SELECT * FROM users;
SELECT * FROM books_users;







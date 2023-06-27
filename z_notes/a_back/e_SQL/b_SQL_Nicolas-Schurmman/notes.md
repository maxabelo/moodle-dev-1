# Docker MySQL and MySQL WorkBench


## Instalations
  - MySQL WorkBench: Solo se lo instala y ya. Para q funcione tambien necesita   gnome-keyring

    sudo pacman -Sy mysql-workbench gnome-keyring --needed --noconfirm


  - User Root por default
      docker run --name some-mysql -e MYSQL_ROOT_PASSWORD=root -p 3306:3306 -d mysql

      

  -- Data Types in SQL:
    - INT       <-  Integer
    - FLOAT     <-  Float
    - VARCHAR   <-  String



    docker run --name some-mysql -p 3306:3306 -e MYSQL_ROOT_PASSWORD=root -e MYSQL_DATABASE=testdb -e MYSQL_USER=admin -e MYSQL_PASSWORD=root -d mysql










<!-- --------------------------------------------------------- -->
# Querys

## Intro a las Operaciones CRUD Basicas

CREATE DATABASE holamundo;
SHOW DATABASES;


USE holamundo;

<!-- CREATE TABLE animals (
	id	int,
    tipo	varchar(255),
    estado	varchar(255),
    PRIMARY KEY (id)
); -->

-- INSERT INTO animals (tipo, estado) VALUES ('Chanchito', 'Feliz');

ALTER TABLE animals MODIFY COLUMN id int auto_increment;

SHOW CREATE TABLE animals;


-- Create tables and Insert its values:
CREATE TABLE `animals` (
  `id` int NOT NULL AUTO_INCREMENT,
  `tipo` varchar(255) DEFAULT NULL,
  `estado` varchar(255) DEFAULT NULL,
  PRIMARY KEY (`id`)
);

INSERT INTO animals (tipo, estado) VALUES ('chanchito', 'feliz');
INSERT INTO animals (tipo, estado) VALUES ('dragon', 'feliz');
INSERT INTO animals (tipo, estado) VALUES ('felipe', 'sad');



-- Listar registros:
SELECT * FROM animals;
SELECT * FROM animals WHERE id = 1;
SELECT * FROM animals WHERE estado = 'feliz';
SELECT * FROM animals WHERE estado = 'feliz' AND tipo = 'felipe';



-- Update: Only with ID:
UPDATE animals SET estado = 'feliz x3' WHERE id = 3;
SELECT * FROM animals;



-- Delete: Only with ID:
DELETE from animals where estado = 'feliz'; -- error

DELETE from animals where id = 3;
SELECT * FROM animals;












## User Table

-- Create user table and insert some data
CREATE TABLE user (
  id int not null auto_increment,
  name varchar(50) not null,
  edad int not null,
  email varchar(100) not null,
  primary key(id)
);

INSERT INTO user (name, edad, email) VALUES ('Oscar', 25, 'oscar@gmail.com');
INSERT INTO user (name, edad, email) VALUES ('Layla', 15, 'layla@gmail.com');
INSERT INTO user (name, edad, email) VALUES ('Nicolas', 36, 'nico@gmail.com');
INSERT INTO user (name, edad, email) VALUES ('Chanchito', 7, 'chanchito@gmail.com');




-- SELECT command in depth:
SELECT * FROM user;
SELECT * FROM user LIMIT 1; -- 1er registro q encuentre | left > right

-- Conditional search
select * from user where edad > 15;
select * from user where edad >= 15;
select * from user where edad > 20 AND email = 'nico@gmail.com';
select * from user where edad > 20 OR email = 'layla@gmail.com';

select * from user where email != 'layla@gmail.com';

select * from user where edad BETWEEN 15 AND 30;

-- LIKE:  Inclye esto en su value?
select * from user where email LIKE '%gmail%`';	-- como el * en bash | *gmail*
select * from user where email LIKE '%gmail';	  -- *gmail
select * from user where email LIKE 'oscar%'; 	-- oscar*

-- Sort data:
select * from user ORDER BY edad ASC;
select * from user ORDER BY edad DESC;

-- Max and Min value:
select max(edad) as mayor_column from user; 	-- as: alias/nombre a la columna
select min(edad) as menor_column from user;

-- SELECT a columnas de interes:
SELECT id, name FROM user;
SELECT id, name AS nombre_papu FROM user; 	-- cambiar alias de la columna













## JOIN:
  - Todos los nombres de las tablas deben estar en Singular
  - Trae Todos los registros asociados con User y SOLO los productos que estén asociados a 1 registro de la tabla de user.
  
      SELECT u.id, u.email, p.name FROM user u LEFT JOIN product p ON u.id = p.created_by;

          - u <- alias de la tabla user
          - Traeme todos los registros de la tabla user que satisfagan la query del SELECT, y solo los registros de Product q tengan relacion con user, si no tienen relacion pues ponles null




-- JOIN: (Foreign keys)
CREATE TABLE products (
	id int not null auto_increment,
    name varchar(50) not null,
    created_by int not null,
    marca varchar(50) not null,
    primary key(id),
    
    foreign key(created_by) references user(id)
);

SHOW DATABASES;

rename table products to product;

-- Insertar Values de una
INSERT INTO product (name, created_by, marca)
VALUES
	('ipad', 1, 'apple'),
    ('iphone', 1, 'apple'),
    ('watch', 2, 'apple'),
    ('macbook', 1, 'apple'),
    ('imac', 3, 'apple'),
    ('ipad mini', 2, 'apple');

select * from product;



-- Left join: Si no tiene relacion le coloca Null
SELECT u.id, u.email, p.name as product_name FROM user u LEFT JOIN product p ON u.id = p.created_by;
-- SELECT u.id, u.name as user_name, u.email, p.name as product_name, p.marca FROM user u LEFT JOIN product p ON u.id = p.created_by;



-- Right join: Ya NO trae los user sin productos relacionados | ordena en base al INSERT INTO q los agrego
SELECT u.id, u.email, p.name as product_name FROM user u RIGHT JOIN product p ON u.id = p.created_by;



-- Inner Join: Todos los productos registrados a 1 user | ordena en base al foreign key (111 22 3)
SELECT u.id, u.email, p.name as product_name FROM user u INNER JOIN product p ON u.id = p.created_by;



-- Cross Join: 
SELECT u.id, u.name, p.id, p.name FROM user u CROSS JOIN product p;



-- Group by:
SELECT count(id), marca FROM product GROUP BY marca; -- agrupamos x la marca

SELECT count(p.id), u.name FROM product p LEFT JOIN user u ON u.id = p.created_by GROUP BY p.created_by; -- productos x user


-- Having: Condicion Coutn > 2    <-- todas estas fn de aggregation NO pueden ser condicionadas x WHERE, asi q usa HAVING
SELECT count(p.id), u.name FROM product p LEFT JOIN user u
ON u.id = p.created_by GROUP BY p.created_by
HAVING count(p.id) >= 2;



-- DROP: Eliminar 1 Tabla
DROP table product;
DROP TABLE animals;
DROP TABLE user;



-- Cardinalidad
CREATE TABLE IF NOT EXISTS `mydb`.`user` (
  `id` INT NOT NULL,
  `username` VARCHAR(16) NOT NULL,
  `email` VARCHAR(255) NOT NULL,
  `password` VARCHAR(32) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `username_UNIQUE` (`username` ASC) VISIBLE,
  UNIQUE INDEX `email_UNIQUE` (`email` ASC) VISIBLE);

-- index: Toman estos fields y los cargan en memoria. Busqueda de estos registros mucho mas rapida.










## Modelos de Entidad - Relacion en MySQL Workbench
  - Home Icon > Tablas relaconadas Icon > + Icon > Add Diagram Icon 

        - PK: Primary Key
        - NN: Not null
        - UQ: Unique
  
  - File > Export > Forward Engineer
    - Nombre > Next > Next 
      - Copiamos el codigo / Guardamos como file










docker start 9933beb0059b
-- Solo para pruebas en dev, xq se elimina todo. Tener un SEED
DROP DATABASE IF EXISTS todos;
CREATE DATABASE IF NOT EXISTS todos;
USE todos;


-- CREATE TABLE users (
-- 	-- UNSIGNED: NO acepta negaticos, sin signo
-- 	id INT UNSIGNED NOT NULL AUTO_INCREMENT,
-- 	name VARCHAR(255) NOT NULL,
-- 	email VARCHAR(255) NOT NULL,
-- 	password VARCHAR(255) NOT NULL,

-- 	PRIMARY KEY (id),
-- 	UNIQUE (email)
-- );



CREATE TABLE users (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(255) NOT NULL,
	email VARCHAR(255) NOT NULL UNIQUE,
	password VARCHAR(255) NOT NULL

	-- INDEX(name)
);


CREATE TABLE tasks (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	user_id INT UNSIGNED NOT NULL,
	title VARCHAR(255) NOT NULL,

	-- 2^9 = 512 | max de char q puedes colocar
	description VARCHAR(512) NOT NULL,

	-- status ENUM('COMPLETED', 'NOT COMPLETED', 'WORK IN PROGRESS'),
	completed TINYINT NOT NULL DEFAULT FALSE,	-- int d 1 byte: 0 false, 1 true

	due_date DATETIME NOT NULL,


	FOREIGN KEY (user_id) REFERENCES users(id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
		-- ON DELETE RESTRICT
);



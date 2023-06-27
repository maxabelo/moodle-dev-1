DROP DATABASE IF EXISTS departments;
CREATE DATABASE IF NOT EXISTS departments;
USE departments;


CREATE TABLE buildings (
	city VARCHAR(255) NOT NULL,
	number INT UNSIGNED NOT NULL, -- no se AUTO_INCREMENT, si quieres q se AUTO_INCREMENT x Ciudad puedes usar Triggers


	-- -- PK compuesta
	PRIMARY KEY (city, number)
);


CREATE TABLE departments (
	number VARCHAR(255) PRIMARY KEY,	-- si es PK NO hace falta el NOT NULL
	name VARCHAR(255) NOT NULL UNIQUE,
	annual_badget DECIMAL (9, 2) NOT NULL,


	-- -- -- FK Compuesta
	city VARCHAR(255) NOT NULL,
	building_number INT UNSIGNED NOT NULL,

	FOREIGN KEY (city, building_number) REFERENCES buildings(city, number)
		ON UPDATE CASCADE
		ON DELETE RESTRICT
);




-- -- -- Entidad Debil
	-- La PK esta compuesta d 2 campos, de los cuales 1 es FK
CREATE TABLE employees (
	number INT UNSIGNED NOT NULL,
	department_number VARCHAR(255) NOT NULL,
	name VARCHAR(255) NOT NULL,


	-- -- FK Compuesta
	manage_number INT UNSIGNED NOT NULL,
	manage_department_number VARCHAR(255) NOT NULL,


	-- -- PK Compuesta
	PRIMARY KEY (number, department_number),

 

	FOREIGN KEY (department_number) REFERENCES departments(number)
		ON UPDATE CASCADE
		ON DELETE RESTRICT,

	-- -- FK Compuesta
	FOREIGN KEY (manage_number, manage_department_number) REFERENCES employees(number, department_number)
		ON UPDATE CASCADE
		ON DELETE RESTRICT
);



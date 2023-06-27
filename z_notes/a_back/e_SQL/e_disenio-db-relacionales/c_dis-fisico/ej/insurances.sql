DROP DATABASE IF EXISTS insurances;
CREATE DATABASE IF NOT EXISTS insurances;
USE insurances;


CREATE TABLE clients (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	id_document_number VARCHAR(255) NOT NULL UNIQUE,
	name VARCHAR(255) NOT NULL
);

CREATE TABLE insurances (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	client_id INT UNSIGNED NOT NULL,

	-- -- podemos aplicar CONSTRAINT (restricciones):
	-- percentage_covered TINYINT UNSIGNED NOT NULL CHECK (percentage_covered <= 100),
	percentage_covered TINYINT UNSIGNED NOT NULL,

	start_date DATETIME NOT NULL,
	end_date DATETIME NOT NULL,

 
 	-- -- calculos con float NO son precisos, no usar float cuando hay dinero de x medio
		-- 1 # de 8 digitos de los cuales 2 son decimales	<- DECIMAL especifico para Money
	annual_cost DECIMAL(8, 2) NOT NULL,


	type ENUM("VEHICLE", "PROPERTY"),


	FOREIGN KEY (client_id) REFERENCES clients(id)
		ON UPDATE CASCADE
		ON DELETE RESTRICT,


 	-- -- Todo es un  CONSTRAINT:  x eso se puede omitir
	-- CONSTRAINT ck_percentage_covered_less_than_100 CHECK (percentage_covered <= 100)
	CHECK (percentage_covered <= 100)
);





-- -- -- Jerarquias de Generalizacion:
CREATE TABLE vehicles (
	insurance_id INT UNSIGNED NOT NULL,
	price DECIMAL(8, 2) NOT NULL, -- max: 999 999,99
	plate_number VARCHAR(255) NOT NULL UNIQUE,

	FOREIGN KEY (insurance_id) REFERENCES insurances(id)
		ON UPDATE CASCADE
		ON DELETE RESTRICT
);

CREATE TABLE properties (
	insurance_id INT UNSIGNED NOT NULL,
	area DECIMAL(6, 2) NOT NULL,
	city VARCHAR(255) NOT NULL,
	street VARCHAR(255) NOT NULL,
	number VARCHAR(255) NOT NULL,
	unit VARCHAR(255) NULL,

	FOREIGN KEY (insurance_id) REFERENCES insurances(id)
		ON UPDATE CASCADE
		ON DELETE RESTRICT
);





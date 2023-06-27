DROP DATABASE IF EXISTS chat_rooms;
CREATE DATABASE IF NOT EXISTS chat_rooms;
USE chat_rooms;


CREATE TABLE users (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	name VARCHAR(255) NOT NULL,
	email VARCHAR(255) NOT NULL UNIQUE,
	password VARCHAR(255) NOT NULL,
	username VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE rooms (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	user_id INT UNSIGNED NOT NULL,
	name VARCHAR(255) NOT NULL,
	description VARCHAR(512) NOT NULL,
	is_private TINYINT NOT NULL,

	FOREIGN KEY (user_id) REFERENCES users(id)
		ON UPDATE CASCADE
		ON DELETE RESTRICT
);

CREATE TABLE user_room (
	user_id INT UNSIGNED NOT NULL,
	room_id INT UNSIGNED NOT NULL,

	-- PK combinacion de FK: para evitar q 1 user se una varias veces a la misma room. Evitar repetir combinaciones
	PRIMARY KEY (user_id, room_id),


	FOREIGN KEY (user_id) REFERENCES users(id)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	FOREIGN KEY (room_id) REFERENCES rooms(id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);


-- Aqui si se pueden repetir combinaciones x eso NO hay PK. 1 user envia varios msgs a la misma sala
CREATE TABLE messages (
	user_id INT UNSIGNED NOT NULL,
	room_id INT UNSIGNED NOT NULL,
	content VARCHAR(512) NOT NULL,
	`date` DATETIME NOT NULL,

	FOREIGN KEY (user_id) REFERENCES users(id)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	FOREIGN KEY (room_id) REFERENCES rooms(id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

CREATE TABLE invitations(
	user_id INT UNSIGNED NOT NULL,
	room_id INT UNSIGNED NOT NULL,
	link VARCHAR(255) NOT NULL,

	PRIMARY KEY(user_id, room_id),
	

	FOREIGN KEY (user_id) REFERENCES users(id)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	FOREIGN KEY (room_id) REFERENCES rooms(id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);



CREATE TABLE roles (
	id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	room_id INT UNSIGNED NOT NULL,
	name VARCHAR(255) NOT NULL,
	description VARCHAR(255) NOT NULL,

	FOREIGN KEY (room_id) REFERENCES rooms(id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);

CREATE TABLE user_role (
	user_id INT UNSIGNED NOT NULL,
	role_id INT UNSIGNED NOT NULL,

	-- PK combinacion de FK evita repetir combinaciones
	PRIMARY KEY (user_id, role_id),


	FOREIGN KEY (user_id) REFERENCES users(id)
		ON UPDATE CASCADE
		ON DELETE CASCADE,
	FOREIGN KEY (role_id) REFERENCES roles(id)
		ON UPDATE CASCADE
		ON DELETE CASCADE
);


-- -- -- Insertar datos
INSERT INTO users (name, email, password) VALUES 
('Alex', 'axes@gmail.com', '1234'),
('Alexa', 'alexa@gmail.com', '1234'),
('Felipe', 'felipe@gmail.com', '1234'),
('Fernanda', 'fernanda@gmail.com', '1234');


-- INSERT INTO tasks (user_id, title, description, completed, due_date) VALUES
-- (1, 'Is al Tia', 'Comprar algun dulce', false, '2023-08-01 15:21:33');

INSERT INTO tasks (user_id, title, description, completed, due_date) VALUES
(1, 'Ir al Tia', 'Comprar toallas', false, '2023-01-02 09:21:33'),
(2, 'Aprender Microservices with Node.js + TS', 'Aprender todo lo relacionado a Microservices con Node.js y TypeScrip', false, '2023-01-21 09:21:33'),
(3, 'Aprender Laravel', 'Aprender Laravel para el Backend y usar APIs en lucar de MVC puro', false, '2023-02-21 19:21:33'),
(2, 'Aprender Go', 'Aprender Backend con Go para grear RESTful API con Arquitectura Hexagonal', false, '2023-03-21 19:21:33'),
(2, 'Aprender Vue.js', 'Aprender Vue.js con TypeScript y Pinia para el State', false, '2023-01-12 19:21:33');







-- -- -- UPDATE de datos
UPDATE tasks SET title = 'Ir al SuperMaxi' WHERE id = 1;
UPDATE tasks SET completed = true WHERE id = 2;
-- update a todos los registros del usuer 2
UPDATE tasks SET due_date = '2023-06-27 09:21:33' WHERE user_id = 2;







-- -- -- DELETE: Siempre colocar WHERE
DELETE FROM tasks WHERE id = 6;
-- delete todas las tasks de 1 user, desde Tasks
DELETE FROM tasks WHERE user_id = 2;

-- CASCADE: Eliminar 1 user y x tanto todas sus tasks
DELETE FROM users WHERE id = 2;










-- -- Visualizar Datos
SELECT * FROM users;
SELECT * FROM tasks;



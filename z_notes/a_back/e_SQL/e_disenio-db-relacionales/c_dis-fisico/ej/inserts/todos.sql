-- -- -- Insertar datos
INSERT INTO users (name, email, password) VALUES 
('Alex', 'axes@gmail.com', '1234'),
('Alexa', 'alexa@gmail.com', '1234'),
('Felipe', 'felipe@gmail.com', '1234'),
('Fernanda', 'fernanda@gmail.com', '1234');


-- -- Como completed es DEFAULT FALSE, no importa q lo agregue o no en la insercion
-- INSERT INTO tasks (user_id, title, description, due_date) VALUES
-- (1, 'Is al Tia', 'Comprar algun dulce', '2023-08-01 15:21:33');

INSERT INTO tasks (user_id, title, description, completed, due_date) VALUES
(1, 'Ir al Tia', 'Comprar toallas', false, '2023-01-02 09:21:33'),
(2, 'Aprender Microservices with Node.js + TS', 'Aprender todo lo relacionado a Microservices con Node.js y TypeScrip', false, '2023-01-21 09:21:33'),
(3, 'Aprender Laravel', 'Aprender Laravel para el Backend y usar APIs en lucar de MVC puro', false, '2023-02-21 19:21:33'),
(2, 'Aprender Go', 'Aprender Backend con Go para grear RESTful API con Arquitectura Hexagonal', false, '2023-03-21 19:21:33'),
(2, 'Aprender Vue.js', 'Aprender Vue.js con TypeScript y Pinia para el State', false, '2023-01-12 19:21:33');




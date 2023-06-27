INSERT INTO users (name, email, password) VALUES
('Alex', 'alex@axes.com', '123'),
('Nate', 'nate@gentile.com', '123'),
('Fer', 'fer@gmail.com', '123');


INSERT INTO accounts (user_id, name, description, balance) VALUES
(1, 'Name 1', 'Description 1', 120),
(2, 'Name 2', 'Description 2', 501),
(3, 'Name 3', 'Description 3', 450);



-- -- transaccion de Dinero en la app Without Transactions
INSERT INTO transfers (from_account_id, to_account_id, amount, date, status) VALUES
(2, 1, 300, '2023-06-12', 'PAYED');

UPDATE accounts SET balance = balance - 300 WHERE id = 2;

UPDATE accounts SET balance = balance + 300 WHERE id = 1;










START TRANSACTION;


INSERT INTO transfers (from_account_id, to_account_id, amount, date, status) VALUES
(1, 3, 21, '2023-06-12', 'PAYED');

UPDATE accounts SET balance = balance - 21 WHERE id = 1;

UPDATE accounts SET balance = balance + 21 WHERE id = 3;




-- commit persiste los cambios en DB de forma permanente
COMMIT;

-- terminar la transaccion SIN presistir los cambios en DB
ROLLBACK;






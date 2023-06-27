-- -- 

START TRANSACTION;

SET @book_id = 20, @user_id = 333;

UPDATE books SET stock = stock - 1 WHERE book_id = @book_id;
SELECT stock FROM books WHERE book_id = @book_id;

INSERT INTO books_users(book_id, user_id) VALUES(@book_id, @user_id);
SELECT * FROM books_users;

-- commit persiste los cambios en DB de forma permanente
COMMIT;

-- terminar la transaccion SIN presistir los cambios en DB
ROLLBACK;
DELIMITER //

CREATE PROCEDURE prestamo(user_id INT, book_id INT)
BEGIN
  INSERT INTO books_users(book_id, user_id) VALUES (book_id, user_id);
  UPDATE books SET stock = stock - 1 WHERE books.book_id = book_id;
END //


DELIMITER ;


-- Ver los procedures
select routine_name from information_schema.routines where routine_schema = database() and routine_type = 'PROCEDURE';

-- invocar el procedure
CALL prestamo(3, 21);
-- se actualiza
select * from books WHERE book_id = 21; 

-- eliminar prodecures
DROP PROCEDURE prestamo;



-- -- OUT: recibir valores desde los procedures, ya q no retornan nada, podemos hacer este truco con una var externa
DELIMITER //

CREATE PROCEDURE prestamo(user_id INT, book_id INT, OUT quantity INT)
BEGIN
  INSERT INTO books_users(book_id, user_id) VALUES (book_id, user_id);
  UPDATE books SET stock = stock - 1 WHERE books.book_id = book_id;
  SET quantity = (SELECT stock FROM books WHERE books.book_id = book_id);
END //


DELIMITER ;

CALL prestamo



-- Los procedures estan pensados para realizar acciones complejas
DELIMITER //

CREATE PROCEDURE prestamoNew(user_id INT, book_id INT, OUT quantity INT)
BEGIN
  SET quantity = (SELECT stock FROM books WHERE books.book_id = book_id);

  IF quantity > 0 THEN
    INSERT INTO books_users(book_id, user_id) VALUES (book_id, user_id);
    UPDATE books SET stock = stock - 1 WHERE books.book_id = book_id;

    SET quantity = quantity -1;

  -- ELSEIF condition

  ELSE
    SELECT "No es posible realizar el prestamo" AS error_message;
  END IF;
  
END //


DELIMITER ;




-- -- Casos
DELIMITER //

CREATE PROCEDURE tipo_lector(user_id INT)
BEGIN
  SET @quantity = (SELECT COUNT(*) FROM books_users AS bu WHERE bu.user_id = user_id);

  CASE
    WHEN @quantity > 20 THEN
      SELECT "Fanatico" AS message;
    WHEN @quantity > 10 AND @quantity < 20 THEN
      SELECT "Aficionado" AS message;
    WHEN @quantity > 5 AND @quantity < 10 THEN
      SELECT "Promedio" AS message;
    ELSE
      SELECT "Nuevo" AS message;
  END CASE;
END//


DELIMITER ;



-- -- Con MySQL podemos W con 2 loops: WHILE and REPEAT
DELIMITER //

CREATE PROCEDURE libros_azar()
BEGIN
  SET @i = 0;

  WHILE @i < 5 DO
    SELECT book_id, title FROM books ORDER BY RAND() LIMIT 1;
    SET @i = @i + 1;
  END WHILE;
END//

DELIMITER ;


CALL libros_azar();


-- repeat
DELIMITER //

CREATE PROCEDURE libros_azar()
BEGIN
  SET @i = 0;

  REPEAT
    SELECT book_id, title FROM books ORDER BY RAND() LIMIT 1;
    SET @i = @i + 1;

    -- se ejecuta HASTA q la condicion se cumpla, da true y para
    UNTIL @i >= 5
  END REPEAT;
END//

DELIMITER ;

CALL libros_azar();



-- -- Prodecures con Transacciones
DELIMITER //

CREATE PROCEDURE prestamo_transaction(user_id INT, book_id INT)
BEGIN

  -- Si ocurre una sql exception hacemos un ROLLBACK
  DECLARE EXIT HANDLER FOR SQLEXCEPTION
  BEGIN
    ROLLBACK;
  END;


  START TRANSACTION;

  INSERT INTO books_users(book_id, user_id) VALUES (book_id, user_id);
  UPDATE books SET stock = stock - 1 WHERE books.book_id = book_id;

  COMMIT;

END //


DELIMITER ;



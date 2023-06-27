/*  
CREATE TRIGGER 

 */

DELIMITER //

CREATE TRIGGER after_insert_update_books
AFTER INSERT ON books
-- Lo q se ara con cada insert en db: NEW es la iteracion/registro actual
FOR EACH ROW
BEGIN
  UPDATE authors SET quantity_books = quantity_books + 1 WHERE author_id = NEW.author_id;
END;
//

DELIMITER ;



INSERT INTO books (author_id, title, publication_date) VALUES (1, 'Arean 21', '2015-09-01');
SELECT * FROM authors;




-- -- Evento DELETE: Decrecer c/vez q se elimine 1 book de la db  - ODL = registro eliminado
DELIMITER //

CREATE TRIGGER after_delete_update_books
AFTER DELETE ON books

FOR EACH ROW
BEGIN
  UPDATE authors SET quantity_books = quantity_books - 1 WHERE author_id = OLD.author_id;
END;
//

DELIMITER ;


-- Eliminar el ultimo registro de una tabla
DELETE FROM books ORDER BY book_id DESC LIMIT 1;

SELECT book_id, title FROM books;
SELECT * FROM authors WHERE author_id = 1;






-- -- Evento UPDATE: modificar author, decrece el old y aumenta new
DELIMITER //

CREATE TRIGGER after_update_update_books
AFTER UPDATE ON books

FOR EACH ROW
BEGIN
  -- despues del update != antes del update
  IF(NEW.author_id != OLD.author_id) THEN
    UPDATE authors SET quantity_books = quantity_books + 1 WHERE author_id = NEW.author_id;
    UPDATE authors SET quantity_books = quantity_books - 1 WHERE author_id = OLD.author_id;
  END IF;
END;
//

DELIMITER ;



UPDATE books SET author_id = 2 WHERE book_id = 62;
SELECT author_id, name, quantity_books FROM authors;




-- -- Get triggers
SHOW TRIGGERS \G;

-- delete trigger
DROP TRIGGER IF EXISTS libreria_cf.after_delete_update_books;











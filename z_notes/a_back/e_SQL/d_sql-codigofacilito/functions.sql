DELIMITER //

CREATE FUNCTION agregar_dias(fecha DATE, dias INT)
RETURNS DATE
DETERMINISTIC
BEGIN
  RETURN fecha + INTERVAL dias DAY;
END//


DELIMITER ;



SELECT agregar_dias(@now, 60);



-- 2) podemos llamar functions inside of own functions
DELIMITER //

CREATE FUNCTION get_pages()
RETURNS INT
DETERMINISTIC
BEGIN
  SET @pages = (SELECT (ROUND(RAND() * 100) * 4));
  RETURN @pages;
END//

DELIMITER ;

UPDATE books SET pages = get_pages();




--3)




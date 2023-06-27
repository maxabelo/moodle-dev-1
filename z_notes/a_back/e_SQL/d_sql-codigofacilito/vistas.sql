-- -- cantidad de libros alquilados x user: crear view o modificarla si existe
CREATE OR REPLACE VIEW prestamos_users_vw AS 

SELECT u.user_id, u.name, u.email, u.username, COUNT(u.user_id) AS total_prestamos
FROM users AS u
INNER JOIN books_users AS bl ON u.user_id = bl.user_id AND bl.created_at >= CURDATE() - INTERVAL 5 YEAR
GROUP BY u.user_id;


-- podemos tratarlas como tablas
SELECT * from prestamos_users_vw;

-- ver views
SHOW TABLES;
-- eliminar vista
DROP VIEW prestamos_users_vw;
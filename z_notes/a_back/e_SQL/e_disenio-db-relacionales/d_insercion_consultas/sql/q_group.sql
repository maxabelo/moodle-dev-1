-- -- -- ¿Cuánto dinero hemos ingresado con todos los seguros vendidos hasta la fecha?
SELECT SUM(annual_cost) AS total_revenues FROM insurances;


-- -- ¿Cuánto cuesta el seguro más caro? ¿Y el más barato?
SELECT MAX(annual_cost), MIN(annual_cost) FROM insurances;




-- -- -- SUBCONSULTAS
-- -- ¿Cuál es el seguro más caro? ¿Y el más barato?
SELECT * FROM insurances
WHERE annual_cost = (SELECT MAX(annual_cost) FROM insurances);
SELECT * FROM insurances ORDER BY annual_cost DESC LIMIT 1;


SELECT * FROM insurances
WHERE annual_cost = (SELECT MIN(annual_cost) FROM insurances);
SELECT * FROM insurances ORDER BY annual_cost ASC LIMIT 1;






-- -- ¿Quién ha contratado el seguro más caro?
SELECT clients.id, clients.name FROM clients
JOIN insurances ON insurances.client_id = clients.id
ORDER BY annual_cost DESC LIMIT 1;




-- -- ¿Cuánto dinero hemos ingresado con los seguros contratados en 2021?
SELECT SUM(annual_cost) FROM insurances
WHERE EXTRACT(YEAR FROM start_date) = 2021;





-- -- ¿Cuál es el precio promedio de los vehículos que hemos asegurado?
SELECT AVG(price) FROM vehicles;






-- -- ¿Cuántos seguros de propiedad hemos vendido?
SELECT COUNT(*) FROM insurances WHERE insurances.type = 'PROPERTY';
SELECT COUNT(*) FROM properties;	-- si el back esta bien hecho






-- -- ¿Cuánto hemos ingresado en total con cada tipo de seguro?
-- GROUP BY: Agrupar la informacion donde existen Funciones de Agregacion (sum, min, max, etc.)
SELECT type, SUM(annual_cost) FROM insurances GROUP BY type;





-- -- ¿Cuánto nos ha pagado en total cada cliente?
SELECT clients.id, clients.name, SUM(annual_cost) FROM clients
JOIN insurances ON insurances.client_id = clients.id
GROUP BY clients.id;

SELECT client_id, SUM(annual_cost) FROM insurances GROUP BY client_id;





-- -- ¿Cuánto nos ha pagado en total cada cliente por cada tipo de seguro?
SELECT client_id, type, SUM(annual_cost) FROM insurances GROUP BY client_id, type;

SELECT client_id, clients.name, type, SUM(annual_cost) FROM clients
JOIN insurances ON insurances.client_id = clients.id
GROUP BY client_id, type;





-- -- ¿Cuánto seguros de coche y de propiedad tiene cada cliente?
SELECT client_id, type, COUNT(*) FROM insurances GROUP BY client_id, type;


SELECT client_id, clients.name, type, COUNT(*) FROM clients
JOIN insurances ON insurances.client_id = clients.id
GROUP BY client_id, type;
















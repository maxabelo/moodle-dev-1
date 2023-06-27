SELECT * FROM clients
JOIN insurances ON insurances.client_id = clients.id;


-- -- -- JOINS:
-- Si la COLUMN NO se repite, puedo ahorrarme la rf a la tabal
SELECT 
	clients.id AS client_id,
	clients.name,
	insurances.type,
	insurances.annual_cost
FROM clients
JOIN insurances ON insurances.client_id = clients.id;


-- renombrar tablas
SELECT 
	c.id AS client_id,
	c.name,
	i.type,
	i.annual_cost
FROM clients c
JOIN insurances i ON i.client_id = c.id;



SELECT clients.id AS client_id, name, type, annual_cost FROM clients
JOIN insurances ON insurances.client_id = clients.id;






-- -- -- Queremos saber el número de matrícula, precio y coste anual del seguro de todos los vehículos que tenemos almacenados.

SELECT 
	vehicles.plate_number,
	vehicles.price,
	insurances.annual_cost,
	insurances.type
FROM vehicles
JOIN insurances ON vehicles.insurance_id = insurances.id
WHERE insurances.type = 'VEHICLE'; -- solo x seguridad, el back deberia controlar eso


SELECT plate_number, price, annual_cost, type FROM insurances
JOIN vehicles ON insurances.id = vehicles.insurance_id
WHERE insurances.type = 'VEHICLE';




-- -- -- De cada cliente que tiene propiedades aseguradas queremos saber su nombre, los metros cuadrados de la propiedad, la ciudad donde se ubica dicha propiedad y el coste anual del seguro.
SELECT
	clients.name,
	properties.area,
	properties.city,
	insurances.annual_cost
FROM clients
JOIN insurances ON insurances.client_id = clients.id
JOIN properties ON properties.insurance_id = insurances.id;
-- WHERE insurances.type = 'PROPERTY'; -- El back ya debio asegurar la consistenciad de los datos. 




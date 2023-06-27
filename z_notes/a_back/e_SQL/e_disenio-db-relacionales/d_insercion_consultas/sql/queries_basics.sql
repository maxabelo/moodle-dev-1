SELECT * FROM insurances WHERE annual_cost > 400;


SELECT * FROM insurances WHERE percentage_covered >= 30;



-- -- ¿Qué seguros han sido contratados antes del año 2021?
-- SELECT * FROM insurances WHERE start_date < '2021-01-01';

SELECT * FROM insurances WHERE EXTRACT(YEAR FROM start_date) < 2021;





-- -- ¿Cuáles son los seguros que han sido contradados entre el año 2019 y 2021?
-- SELECT * FROM insurances WHERE start_date BETWEEN '2019-01-01' AND '2021-12-30';

SELECT * FROM insurances WHERE EXTRACT(YEAR FROM start_date) BETWEEN 2019 AND 2021;
-- between es inclusivo en ambos extremos [a, b]



-- -- Queremos saber cuáles son los seguros con un valor superior a 400€ o que hayan sido contratados en el año 2019 para ofrecer un descuento a sus dueños.
SELECT * FROM insurances
WHERE annual_cost > 400 OR EXTRACT(YEAR FROM start_date) = 2019;





-- -- -- Extraer partes de la fecha (year, month)
SELECT id, EXTRACT(YEAR FROM start_date) FROM insurances;
SELECT id, EXTRACT(MONTH FROM start_date) FROM insurances;
SELECT id, EXTRACT(DAY FROM start_date) FROM insurances;









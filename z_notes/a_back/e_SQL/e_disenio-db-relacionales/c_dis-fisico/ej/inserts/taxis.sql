INSERT INTO parkings (city, street, number) VALUES
('Barcelona', 'Av. Bilbao', '3DF'),
('Barcelona', 'Av. La Sagrada Familia', '21SF'),
('Barcelona', 'Av. Manolo Cuevas', '12');



INSERT INTO vehicles (parking_id, plate_number,	brand,	model) VALUES
(1, '123DBZ', 'Tesla', 'S'),
(1, '443DBZ', 'Toyota', 'Corolla'),
(2, '531FTZ', 'Toyota', 'Sienna'),
(3, '312DJE', 'Peugeot', '508');




UPDATE vehicles SET parking_id = 1 WHERE id = 1;	-- si no hago WHERE se lo coloca a todos

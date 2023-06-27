# Diseno de Bases de Datos Relacionales con MySQL

## Diseno Fisico
- --- El Dis. Fisico es el ultima fase del dis. de DB Relacionales
	- Es llevar las Tablas del Dis. Fisico a Disco, a DB Relacionales, como en este caso con MySQL

  - En cuanto a las DB q NO tiene un Dis. Fisico tenemos a MongoDB
    - No tiene el Dis. Fisico como tal ya que la info se organiza por Documentos












## Conectarse a MySQL

### Conectarnos a MySQL que corre en un Docker Container  🐳 

- -- Para acceder al Container debemos saber su ID, asi q     `docker ps -a`

  - Ejecutamos el bash del container para incresar a el 
		`		docker exec -it ID bash`

	- Conectarnos a MySQL una vez dentro del container
      - user y pass definidas en la creacion de la imagen
        `mysql -u root -p`

  - O en 1 solo comando:
    - Podemos proveer de una el pass en el comando:
      `docker exec -it ID mysql -u root -proot`


  - Instalamos: Para gestionar la DB desde VSCODE
      MySQL v4.5.12
        Weijan Chen
        database-client.com





### Conectarnos a MySQL que corre en Xampp
- -- Simplemente corremos Xamp
	- Vemos que nos de repuesta el: 		`mysql --version`
	- Nos conectamos:		`msql -h 127.0.0.1 -P 3306 -u root -p`
		`									 msql -u root`














## Crear bases de datos y tablas con SQL
- -- Debemos proporcionar a la DB 1 desc. SQL con todas las tablas q queremos crear y el formato de c/tabla
  - SQL se usa en DB Relacionales (SQL = Structure Query Language)
    - Usado para crear tablas, attrubutes
    - Operaciones CRUD
    - Muy enfocado a la Consulta de Datos

	- En MySQL podemos crear varias DB que cohexistiran en la misma instancia de MySQL, y el programa las manejara x separado
  	- El conjunto de Tablas q tiene en un Disenio se denomina  `Schema`
    	- Cada   `Schema`   debe ir en una DB separada

		- En SQL x Default todo aceptas Nulls




- -- Dis. Fisico
  - Debemos crear una DB en MySQL
`  			CREATE DATABASE todos;`

  - Seleccionamos la DB para W con ella
`			USE todos;`


  - Crear tablas
    - Para cadenas de char. cortas como email, names, titles, se suele poner   `varchar(255)`
      - Creamos una tabla basica sin FK, PK, ni nada.
`			CREATE TABLE users(id int, name varchar(255), email varchar(255), password varchar(255));`

      - Ver el Formato q tiene 1 Tabla
`			DISCRIBE users;`
        - id int(11)
          - Ese 11 NO son Ni los Bytes ni los Bits
          - El valor Minimo de 1 Int es de 32 bits
            - El valor Min de 1 Int de 32 bits con Signo es  -2^31 = -2147483648
              - Entonces tiene  11  posiciones incluyendo el Signo
						- Si el   Int   NO acepta Negativos sera SIN Signos, asi q sera un    int(10)
  						- Ya q no acepta el signo

			





  - -- Ejecutar un archivo   `.sql`
    - Como estoy W con Docker:
      - Sin auth en MySQL:
        - Creo 1 volumen q mapee este dir con uno en el container
        - Entro al container
        - Ejecuto:
            `mysql -u root -p < /home/docs/sentencias.sql`
      - Auth en MySQL:
            `SOURCE /home/docs/sentencias.sql;`

      
  - Ejecutar sentencias SQL al inicar sesion con MySQL:
    - Todo tipo de sentencias
        `mysql -u root -p libreria_cf -e "SELECT * FROM authors"`




			




## Devel SQL
- -- Si reguieres un ID autoincrementa con una capacidad > 2^32 (IN UNSIGNED) puedes user el  `BIGINT`
  - El ID    `BIGINT`    es 1 Int de 64 bits con Signo (acepta negativos)
    - Con Signo:    Min: -2^63      Max: 2^63
    - UNSIGNED:     Min: 0          Max: 2^64 - 1
  - El    `BIGINT UNSIGNED AUTO_INCREMENT`   tiene el  shortcut    `SERIAL`

  - El problema q tiene los ID AutoIncrement es q se incrementan de 1 en 1
    - Existe un     Ataque de Enumeracion   , con el q puedes saber cuantas Rows hay en 1 Table
      - Para evitar eso puedes usar      `UUID`      como PK/ID
        - Codely recomienda q el Client envie ese   UUID   en la Insercion
          - Asi la Insercion se maneja con un  PUT, ganando idempotencia


  - -- La FK debe ser del Mismo Type del tipo de dato q es la PK a la q apunta
    - FOREING KEY (fk_en_esta_tabla) REFERENCES tabla_a_la_q_apunta(PK)
      - Si el Update y Delete son RESTRIC, NO se coloca nada
      - Si son CASCADE, si que se lo coloca

    - Al crear tasks nos aparece esto:
      - Key: MUL es de Multiple, es decir, q esa FK puede tener multiples ocurrencias en esta tabla
        - La relacion   OneToMany
        - En la DB solo puede hacer 1 o Multiples
          - Si NO fuerzas a q exista Max 1 Ocurrencia, x default la deja en MUL
            - Xq no hay mas posibilidades, o 1 o MUL ocurrencias

```sql
mysql> describe tasks;
+-------------+--------------+------+-----+---------+----------------+
| Field       | Type         | Null | Key | Default | Extra          |
+-------------+--------------+------+-----+---------+----------------+
| id          | int unsigned | NO   | PRI | NULL    | auto_increment |
| user_id     | int unsigned | NO   | MUL | NULL    |                |
| title       | varchar(255) | NO   |     | NULL    |                |
| description | varchar(512) | NO   |     | NULL    |                |
| completed   | tinyint      | NO   |     | NULL    |                |
| due_date    | datetime     | NO   |     | NULL    |                |
+-------------+--------------+------+-----+---------+----------------+
6 rows in set (0.00 sec)
```







### Funcionamiento del tipo de datos VARCHAR
- --- El VARCHAR existe para resolver los problemas del CAR

  - -- CHAR
    - El problema q tiene el CHAR es que si tu definies un   CHAR(255)
      - Y colomas un String   'Alex',  con char lo q hace es colocar SPACES a la Derecha hasta completar los 255 characters, o lo q le pongas por ahi
        - Si luego consultas el dato, SI elimina los spaces a la derecha para devolverte el String Original
      - Desperdicias espacio en Disco xq te rellena con white spaces

  - -- VARCHAR
    - Data Type q resuelve los problemas del CHAR
      - Si le colocas como max 255 bytes
        - Si no llega al maxio, SOLO ocupa lo q ocupa y NO te rellena
        - Como esto es variable, lo q hace MySQL es colocar un PREFIJO con el numero/quantity q ocupa ese value
        	- `VARCHAR(255)`:
          	- Si colocas una size max de 255 con 1 byte tiene suficiente para representar ese size. Necesitas 1byte de zise max para representar el size de la cadena. Una vez te pasas del 255 ya necesitas 2 bytes para representar ese size.
            	- Xq 1byte = 8bits  -- 8bits = 1111 1111 = 255 <- en binario es 255 = 2^8 - 1
              -  `4"Nate"`  <- 5bytes: 1byte del size (4) + 4bytes del string (asumiendo q c/char ocupa 1byte)
            - Si colocaas como max zise 265 ya necesitas 2 bytes para representar el ese numero/size
              - Para ahorrarse 1byte de size x Row lo q hace la gente es poner  `255`


    - VARCHAR(255): Para Cadenas de Caracteres cortas
      - Una vez pasas de 255 ya requieres 2 bytes para representar el size de la cadena
    - VARCHAR(512): Mas largas
      - Para el representar el size de la cadena requerimos  2bytes  + los bytes q ocupe la cadena de char en si











### Relaciones uno a uno con Tablas Intermedias (1:1)
- --- Relacion OneToOne (1:1) con Tabla Intermedia
  - La creacion de Tablas tb debe ser en Orden, asi como para eliminar tablas con Cascade
  - Una   `Tabla Intermedia`    NO se puede crear Antes q las Tablas principales a las q va a Apuntar con sus FK
    - La tabla de    vehicles    NO se puede crear antes de dirvers & vehicles
    - La tabla de     parking     NO se puede crear antes q la de vehicles xq tiene FK q apuntan a ella
  - Asi como eliminas en orden, Creas en Orden





### Relaciones ManyToMany (1:N) con Tabla Pivote
- Para tener una PK como combinacion de 2 attributes usamos una tupal de 2 valores:
  `PRIMARY KEY (user_id, role_id)`






### Tipos de datos precisos y constraints
- --- Jerarquia de Generalizacion
  - Pues es una tabla mas q tiene una FK, nada novedoso al respecto





### Foreign keys compuestas
- --- FK Compuestas - E5 puramente teorico
  - Ver el SQL :v
  - Mas engorrose
    - Se puede hacer si xq te lo permite el Algebra de datos q esta detras de eso
      - Pero a dia de hoy es puramente teorico, NADIE en la Vide Real hace eso


  - -- SQL
    - El Lenguajde SQL como tal NO requiere  ( ; )

  - -- Comandos del SGDB
    - Estos son comandos de MySQL en este caso, y esos necesitan el  ( ; )  al final de cada comando
      - SHOW DATABASES;   <--   Es 1 comando de la db
      - SOURCE      <--   NO es un comando de la DB, sino q es un comando del CLIENT de consola de MySQL





  - -- Lo DIFICIL es hacer el Disenio
    -  Una vez tienes el Disenio (Logico), tirar lineas de SQL es facil




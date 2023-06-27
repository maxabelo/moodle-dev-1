# Diseno de Bases de Datos Relacionales con MySQL


## Bases de datos desde el Backend

### Concepto de MIGRACIONES
- --- En la vida real de 1 backend NO vas a tirar lineas de SQL a pelo
  - Con la creacion y descruccion de db y demas xq ya partes con Datos en la DB




- --- Migraciones
  - Es 1 concepto muy importante para mantener 1 DB en 1 Estado en el q tiene todos los cambios que queremos q tenga
	- Una DB va a estar en continuo crecimiento/modificacion segun se agreguen requerimientos a la app
  	- Entonces, hay q mantener 1 Registro de todos los cambios q se aplican y ese es el comcepto de migraciones
    	- Creamos un dir    /migrations
      	- En donde camos a colocar todas las versiones de la DB en orden
        	- La Migracion 01 sera el disenio logico inicial de la DB
        	- La M02.sql sera la q contenga el 1er cambio q le metimos a la DB
						- En este caso cambiar el data type de description de VARCHAR(512) a VARCHAR(1024)
					- La M03.sql sera el index agregado
					- La M04.sql seria la de agregar la columna q permite el soft delete
        	- Y asi con todos los cambios
		- Este es el concepto de las Migraciones
  		- Pero esto ya lo Automatiza los Frameworks como Django/Laravel, etc
    		- Y lo hacen mejor, sin ficheros sql a pelo


  - -- Suponemos q ya tenemos 1 DB en Produccion con datos y demas
  	- Pero queremos hacer cambios en la estrcutura de la DB
  		- Cambiar las    description   a VARCHAR(1024) xq quiero descs mas largas
  			- Para modificarla usamos    `ALTER`
    			- `ALTER TABLE` nos permitira Modificar 1 tabla existente
      			- Asi q para actualizar el  DataType  a   VARCHAR(1024)   usamos   `MODIFY`
        			`ALTER TABLE tasks MODIFY COLUMN description VARCHAR(1024) NOT NULL;`

		- Ej:
        - La gente busca mucho por title, asi q quiere colocar 1 Index a esa property
          - Indexas el campo  title
				`			ALTER TABLE tasks ADD INDEX(title);`

    		- Ya no quieres eliminar las tareas, ahora quieres hacer 1 soft-delete
  				- Agregamos 1 Nueva Columnas a la Tabla
				`			ALTER TABLE tasks ADD is_deleted BOOLEAN NOT NULL DEFAULT FALSE;`
		

  		- Otros Ejemplos:A
        - Agregar 1 Columna
            `ALTER TABLE books ADD sales INT UNSIGNED NOT NULL;`
            `ALTER TABLE books ADD stock INT UNSIGNED NOT NULL DEFAULT 12;`
            `ALTER TABLE usuarios ADD email VARCHAR(50);`
        - Eliminar 1 columna
            `ALTER TABLE books DROP COLUMN stock;`
        - Modificar el Data Type de una Column
            `ALTER TABLE usuarios MODIFY telefono VARCHAR(50);`
        - Generar 1 PK a 1 tabla:
            `ALTER TABLE usuarios ADD id INT UNSIGNED NOT NULL AUTO_INCREMENT, ADD PRIMARY KEY (id);`
        - Agregar 1 FK a 1 tabla:
            `ALTER TABLE usuarios ADD FOREIGN KEY(grupo_id) REFERENCES grupos(grupo_id);`
        - Eliminar una FK de 1 tabla:
            `ALTER TABLE usuarios DROP FOREIGN KEY grupo_id;`
				- Actualizar / Cambiar el nombre de una Column
            `ALTER TABLE table_name RENAME COLUMN old_column_name TO new_column_name;`











### Schema Builder
- --- Ahora vemos como funciona en el Mundo Real con Librerias/Framerorks
  - No todos los devs van a estar conectados x consola a la BD tirando lieneas de SQL
  


- --- Sequelize
	- -- `Migraciones`
  	 - Con el      CLI      de Sequelize creamos migraciones y modelos
    	 - Este CLI solo funca con  CommonJS, da error cuando usas Module
    	 - Asi definimos las tablas de la DB con JS en este caso
      	 - Esto es para generar migraciones y tener registros de cambios de la db

  	- Deps: `pnpm add sequelize knex mysql2`  `pnpm add -D sequelize-cli`
    	- Command:	 	`npx sequelize-cli init`
	 		- Nos crea los /dir
  	 		- config	
    	 		- Configuramos los datos de Conexion a DB
  	 		- migrations
  	 		- models
  	 		- seeders
		
		- Creating the first Model (and Migration)
  		- Command:
    		- Como attributes colocamos la COLUMNS q tiene la DB
      		- Esto nos crea 2 ficheros: 
        		- 1 de migraciones
        		- 1 Model en  /models

	`				npx sequelize-cli model:generate --name User --attributes name:string,email:string,password:string`

      		- Gracias al CLI generamos de 1 el Schema del Model y la Migrations
        		- Pero SIII podemos modificar esto a volundat, de acuerdo al Disenio de la DB
        		- Una vez lo tenemos como queremos, ejecutamos las Migraciones
	`							npx sequelize-cli db:migrate`
          		- Al ejecutar las migraciones genera las tablas
            		- Crea la de    `SequelizeMeta`    y la q hayamos definido en las migraciones
        					- Si haces 1    `select * from SequelizeMeta;`
          					- Vas a ver el nombre del fichero.js de la migracion q ya se ha migrado
              		- Con esto mantenemos un registro de las migraciones
                		- Si creas otras, pues ya sabe cuales NO tiene q ejecutar y cuales si


    - -- Tabla de tasks: Esta ya tiene FK y demas
      - Generamos los ficheros de migrations y model
			`  npx sequelize-cli model:generate --name Task --attributes userId:integer,title:string,description:string,completed:boolean,due_date:date`

      - Establecemos en las Migratios la FK y ajustamos los Attributes
      - En cada   `Model`   establecemos las   Relaciones    en el    associate()
        - Aqui van las relaciones para luego poder hacer consultas complejas mas simple

			- Ahora insertamos esto en DB con el cli migrate
				`npx sequelize-cli db:migrate`
  			- Esto ya crea la Tabla en DB
    			- E inserta el nombre del fichero de la migracion en la tabla de SequelizeMeta







### 


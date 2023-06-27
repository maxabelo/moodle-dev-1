# Diseno de Bases de Datos Relacionales con MySQL

-- En el Mundo Real NO vas a tener estos enunciados bonitos para discernir el modelado
	- En el mundo real el CLiente te va a decir quier esto y ya
  	- Tu deberas investigar como funciona eso y perguntarle al cliente sobre el negocio
    	- He ir sacando toda la informacion necesaria para crear esto enunciados y modelar la DB




## Diseno Conceptual
-- Un Dis. Conceptual es una Descripcion a Alto Nivel de la Info q debe contener 1 DB.
	- Es Agnostico a la DB
	- Para esto usaremos los  	`Chem Diagram`
  	- Como un UML para la OOP
    	- Como un UML tb es  Agnostico al tipo de DB q se vaya a utilizar
	

	-- E1: TodoList
		- 1ro: Identificar las 		`Entity`   q hay en esa descripcion
			- Van en   RECTANGULOS
		- 2: Identificar las 			`Relaciones`	 en Tablas/Enities		<--  Rombo
			- Identificar los Verbos entre Tablas: indican relacion. Ej:
  			- 1 Cliente 		COMPRA		Products
  			- 1 Vendedro 		VENDE			Products
		- 3: Identificar los    	`Attributes`		de las Entities
  		- Van con 1 simple   Texto   unido con un Circle y Fleca
  		- Identificar 1  		IDENTIFICADOR UNICo			si NO tiene, se lo agregamos como nuevo att al ID
		- 4: Cardinalidad de las Relaciones entre DB
  		- Cantidad de Ocurrencias puede tener 1 Entidad en la otra entidad :v
    		- 1 User puede Crear MUCHAS tareas
					- 1:N			-  	OneToMany
  					- Como es dis conceptual requiere:		(min, max)	-   (0, n)
    		- MUCHAS Tarea le pueden Pertenecer a 1 User
      		- N:1			-		ManyToOne
        		- Como es Dis Conceptual:							(1, 1)



	-- E2: Taxista - Relaciones uno a uno y atributos compuestos
		1. Entity
			- Taxista y Vehiculo se tepiten un monton de veces, asi q son Entities
			- Parking para los Vehiculos
			- Address		<-  x la naturaleza de un Address es mejor tenerlo como Entity
  			- Pero en este ejemplo x didactica sera 1    `Atributo Compuesto`
		2. Relaciones:
			- Relaciones entre Taxista > Drive < Vehicle			Vehicle > park < Parking
			- La Image NOOOO es una Entity x lo tanto NOOO tiene relacion
			- Conducto Conduce 1 Vehiculo en 1 Periodo
  			- Este periodo o start/end_dat NOO es Propio Ni del Conductor ni del Vehiculo
    			- Es propio de la RELACION entre ambas Entities
      			- X lo tanto es un    `Atributo de Relacion`  , ya q no pueden estar separados
		3. Attributes of Entity
			- Vehicle
  			- La Matricula SI es Unique entre Vehicles, asi q me Sirve de Identificador
  			- Las Imgs con Attributes y NO entities
  			- Address para este ej x didactica va a ser 1 ATRIBUTO COMPUESTO	<- Ovalo
    			- Se puede romper/seccionar en diversas partes a la vez
      			- 1 Atributo Compuesto puede tener Cardinalidad
		4. Cardinalidad
			- Cada vehículo solo puede ser utilizado al mismo tiempo por un taxista
				- (0, 1) 	<-  Taxista
  				- 1 Vehiculo cuando se Registra en DB No tiene asignado 1 Conducto
    				- Por eso su Min en relacion con Vehicle puede ser 0
				- (0, 1) 	<-  Vehiculo
  				- 1 Taxista cuando se Registra en DB No tiene asignado 1 Vehiculo

				- (0, n) 	<-  Image (Vehicle)
  				- Aunque NOO es una Entity, nos dicen q puede tener unas cuantas imgs
    				- X lo tanto SI tiene Cardinalidad con esa Property
      				- Cardinalidad a Nivel de Atributo
        				- Si en	el dis Conceptual no colocas cardinalidad con el Att. se asume q es (1, 1)
          				- Es decir, que NO puede ser null, siempre debe existir
          				- (1, 1) en Cardinalidad de Attributes no es como la otra Cardinalidad
            				- Si tiene edad de un user, esta cardinalidad es 1, 1, ya que NO hace referencia al valor de su edad.

				- (1, 1) 	<-  Vehiculo
  				- 1 Vehiculo como Min puede ser Conducido x 1 Taxista
  				- 1 Vehiculo como Max puede ser Conducido x 1 Taxista
  			- (1, 1)	<-	Taxista
    			- Min 1 taxista conduce 1 vehiculo
    			- Max 1 taxista conduce 1 vehiculo

			- varios GARAJES/PARKINGS donde se Estacionarán los VEHÍCULOS
  			- La relacion es logica de 1:N
				 	- 1 Parking puede tener N vehiculos
				 	- 1 Vehiculo puede estar Parqueado en 1 soo Parking al mismo tiempo


				-- La Imagen NO es una Entity xq no es crucial para la App
					- Es un Attributo de Entity
  					- Lo normal es guardar el Path a la img y alojar la Img en un servicio de 3ros como `AWS S3`







	-- E3: Chat Rooms - Relaciones muchos a muchos (N:N)
		- 

		1. Entity: Para q sea Entity debe ser Muy Representativo de la Logica de Negocios
			- User, Salas
			- Role: Si se requiere q el User tenga +1 Role esta relacion es  N:N
  			- Si solo puede tener 1 role, es 1:N
		2. Relations: Pueden existir varias relaciones entre las mismas salas
   		- 1 User puede Crear Salas
   		- 1 User puede Unirse a Salas para chatear	<-- N:N
     		- (0, n): user -> rooms
       		- 1 User se puede Unir como Min a 0 Rooms
       		- 1 User se puede Unir como Max a N Rooms
     		- (0, n):	rooms -> user
       		- 1 Room puede Tener como Min 0 Users
       		- 1 Room puede Tener como Max n Users
   		- SEND Messages es una Relacion de N:N entre USER y ROOMS
     		- Los Atributos del Message son Attributos de Relacion xq le pertenecen a la relacion
			- INVITAR a salas, igual N:N
  			- (0, n):	user -> rooms
    			- 1 user puede ser Invitado como Min a 0 Rooms
    			- 1 user puede ser Invitado como Max a n Rooms
  			- (0, n):	rooms -> user
    			- 1 Room puede Invitar como Min a 0 Users
    			- 1 Room puede Invitar como Max a n Users
			- ROLES
  			- Role SI es su propia Entidad xq de lo contraria Tendriamos Informacion repetida x cada registro
    			- Si solo fuera una relacion entre user y role (SIN Entity para Role), se duplicaria info ya q los roles van a ser casi constantes
    			- NO x cada Role q se asigne va a haber 1 Nombre de Role distinto, x eso es su propia entity
						- La cardinalidad depende del enfoque:
  						- 1 User muchos roles:   	N:N
  						- 1 User 1 Role:					1:N
		3. Attributes of Entity
		4. Cardinalidad

			-- Message: X cada message q se envie vamos a CREAR DISTINTos values para las Properties, x eso es Relacion
			-- JOIN:		X cada Link q se envie vamos a CREAR DISTINTOs values, x eso es una relacion y no entity
			-- ROLE:		X cada user q se una a la sala NOO vamos a crear un distinto nombre de rol (limitado)








	-- E4: Seguros - Jerarquías de generalización
		- Las Jerarquías de generalización nos permite extender properties de una entity a otras que ocupan lo mismo
			- Como la       `Herencia`       en OOP
  			

		1. Entity
   		- Seguro, Client
     		- 
		2. Relations
   		- 
		3. Attributes
   		- Como nos dice q el Seguro es Anual
     		- Debemso colocar fecha de inicio y fin para la aquisicion del seguro
   		- Coste Anual
     		- Como es una Relacion de   1:1
       		- No vamos a tener problemas con relaciones ni nada, asi q es un attribute del Seguro
		4. Cardinalidad
   		- Siempre tenemso el problema de 0,n o 1,n xq depende de la logica de negocios y es algo q te lo debe decir el cliente
     		- Si va a permitir users sin seguros, o q para q sea client debe tener si o si 1 seguro adquirido, etc.

   		- (1, 1)		seguro > client
     		- 1 seguro como Min puede Pertenecer a 1 Client
     		- 1 seguro como Max puede Pertenecer a 1 Client

			- Cuando existe cardinalidad entre Properties, y esta es (0, 1), significa q es opciona, q puede ser null en DB

			- Cardinalidad entre  	`Jerarquias de Generalizacion` 	<-  Flecha con punta rellena
  			- Aqui los numeros cambian a la relacion entre ellas		(t, e)
    			- Si es Dependiente una de la General:		(t, e)		<-	Total, Cuantas Subentidades al mismo t puede ser
      			- Como Property esta Obligada a ser un tipo de Seguro es total (t)
      			- Como SOlo puede ser de 1 Tipo, o bien property o bien vehicle, es EXCLUSIVO (, e) (jerarquia exclusiva)
        			- 1 Seguro AL MISMO TIEMPO NO puede ser de property/vehicle
								- SI pudiera ser varios es una   (,s)  de Superpuesto
    			- Si NO son dependientes estrictamente:		(p)		<-  Parcial
      			- Es decir No todos los seguros deben ser de 1 u otro
    			- (t, e):
      			- Total xq Todas las Jerarquias estan obligadas a depender de la General	
        			- Si exite alguna jerarquia q NO dependa de la Genera puede ser parcial
      			- Exclusivo xq solo puede ser o Property/Vehicle
        			- Lo coum es que sea Exclusivo en lugar de superpuesto










	-- E5: Departamentos y empleados: Entidades débiles e identificadores compuestos
		- Estas Entidades Debiles a dia de hoy son Puramente Conceptuales
			- Ya  NOOOO  se aplican, ya q el espacio en disco es barato
			- Simpementen colocamos 1 ID y ya nos quitamos esta dificultad, x es puramente didactico
  			- Se pueden ver en DB muy antiguas
			- Tampoco es comun tener Identificadores compuestos en lugar de un ID
  			

		1. Entity
			- Edificio / Departamento / Empleado
  			- Empleado Trabaja en Edificio  	(verbos usualmente indican relacion)
			- Empleado es una      ```ENTIDAD DEBIL```
  			- Es debil xq NO se puede Identificar x si misma
    			- Sino q necesita de Otra Entidad para Identificarse
		2. Relations
   		- EMPLEADO q tiene empleados a su cargo
     		- Relacion      ```Entre la Misma Entity```
		3. Attributes
			- El numero del Edificio es un      ```IDENTIFICADOR COMPUESTO```		<- ver graph
				- Un Ident. Comp. es el identificador que se genera de combinar 2 atributos
  				- Su combinacion se utiliza para Identificar ya q es Unico
    				- Pero x separados NO son Unicos
  			- un número asociado, 1 es  único entre los EDIFICIOS de la misma "ciudad" but puede repetirse para EDIFICIOS de ciudades distintas
			- Si es un Atributo UNICO, puede ser usado como Identificador
		4. Cardinalidad
		 	- (1:1)	 Departament is_located Building
  		 	- Min 1 depa located en 1 Building
  		 	- Max 1 depa located en 1 Building
		 	- (1:N)	
				- 1 Departamento puede Pertenecer a Muchos Edificios
				- 1 Edificio puede Tener Muchos Departamentos







-- Ejercicios de repaso:
	-- E6: Red Social
		- Entidades: User | Profile | Post
		- Relaciones:
  		- User y Profile es la Relacion 		1:1
  		- Profile y Posts es								1:N
  		- Los Comentarios a Posts SON una Relacion, NOOO una Entity
    		- Se pued simplificar con una simple Relacion
		

	-- E7: App de Pagos
		- (p, e) entre Account y Corporate Account
			- Parcial xq NO obligamos a q todas las cuentas sean de Empresa
  			- Pero si lo es me voy a guardar name y tax_d
			- Exclusiva xq o es corporate account o no


	-- E8: Ecommerce
		- Relacion entre Product y Order
  		- Como es un Ecommerce, el precio y descuento varia segun el mes/semana/dia
    		- X eso, al generar la Orden de compra se almacena el Valor de Ese Dia de generacion
      		- Se almacena el Price y Discount del dia de la generacion de orden de compra






### Ejecutar archivos   .sql   en MySQl Docerizado
- Importante crear el Volumen q vincule el dir de project con el Container de MySQL
- Creamos los path en base a ese volumen dentro del container
		source /home/docs/inserts/users_todos.sql










#### REPO

		https://github.com/mastermindac/curso-bd



# Diseno de Bases de Datos Relacionales con MySQL

## Diseno Logico
- - El Dis. Logico se enfoca en disenia toda la info. de una manera logica, tal como lo va a utilizar el motor de DB q se va a utilizar
	- Si vas a tener una `DB Relacional (SQL)`, pues organizar la info en base a  `TABLAS`
		- Entonces el Dis. Logico para DB SQL consiste en Definir que Tablas se va a tener, las columnas y filas q dichas tablas van a contener.
		- Y estas Tablas son el Formato Logico de los datos en SQL
	- Si vas a usar `DB NO SQL` como MongoDB, la info debera ser organizada en `Documentos`
	- El Dis. Logico Depende del TIPO de DB, y no de una DB en concreto.
  	- Relacional, Documentos, Graphos, etc.


-- Entonces:
	- El 		`Dis. Conceptual`		NOO depende de nigun tipo de DB, es totalmente Agnostico a la DB
	- El 		`Dis. Logico`				SI depende del tipo de DB, solo del tipo, no del motor de DB a usar.






### Diseno Logico para DB Relacionales (SQL)
- ---- El formato Logico de este Tipo de DB son las   `TABLAS`
  - Vamos a Crear una   `TABLA`   x cada    `Entity`


	- --- Las 	`RELACIONES`	 entre TABLAS se Representan mediante un Sistema de representacion de relaciones entre tablas
		- -- `OneToMany (1:N)`
			1. Method:  Crear una Nueva   `COLUMN`   con el ID de la tabla con la q mantiene relacion
				- Estos Nuevos Valores se llaman     `FOREING KEY`		y permiten relacionar entre tablas
  				- Una columan q apunta a valores de Otra Column
			2. Usar una   TABLA INTERMEDIA   o   `TABLA PIVOTE`
				- Esta tabla pivote   `NOOO tiene ID`, pero SI guarda la Relacion entre tablas
  				- Mantiene los Identificadores de las tablas que mantiene relacion entre ellas
  				- Aqui se puede Ver de Mejor forma la Cardinalidad establecida en el  Dis. Conceptual
    				- Asi ya tiene Mayor Sentido la Cardinalidad entre Entidades/Tablas
      				- User (0, n)  -  (1, 1) Task
        				- User puede Aparecer 0 o n Veces en la tabla pivote
          				- No es obligatorio q la tabla pivote tenga una PK
        				- Task Solo puede Aparecer 1 vez en la tabla pivote
				- Este tipo de relacion no se usa para OneToMany, sino q para relaciones mas complejas
  				- Mientras mas JOIN menos eficiente




      -- Crear el Dis. Logico en  diagrams.net
        - Entity Relation		<--   usaremos sus componentes

          -- Reglas para la Actualizacion (`UPDATE`) de PK
            - Si se Actualiza el PK de la Tabla a la q se hace referencia con un FK tenemos 4 reglas a utilizar:
              - 1. `Cascade` (propagar): Si se actualiza la PK, en Auto la DB actualiza las FK y asi siempre mantendra los punteros al mismo sitio
                - Es muuuy raro actualizar un ID
              - 2. `Restrict`:	Si tenemos FK apuntando a la PK y se quiere Uptade a la PK, NOO nos va a dejar, xq va a tirar error.
								- Mantiene la Integridad Referencial a toda costa
								- Si quieres Update de la PK, 1ro debes Eliminar/Actualizar las filas de la tabla q Apunten a la PK
									- Es decir, eliminar las FK q apunten a la PK, luego ya Update a la PK.
              - 3. `Default Value`: Si se Update la PK, se asigna un DefaultValue Predefinido a las FK
              - 4. `Anular`: Si se Update la PK, cambiaa   `NULL`   todas las FK q apuntaban a la PK.
                - Pero esto NO siempre es posble, depende de las Reglas de Nulos q tenga la FK
                  - Si la FK  NO  Acepta NULL, pues esta regla de Update NO se puede aplicar

					-- Reglas de Eliminacion (`DELETE`) de PK
              1. `Cascade` (propagar): Si Delete a una PK, se Eliminan TODOS los Registros (FK) asociados
                 - Es decir, elimino la PK con todos los FK q apunten a ella
              2. `Restrict`: Procura la Integridad Referencial, con lo cual, si existen FK apuntando a la PK a eliminar tirara error.
									- 1ro debo ELIMINAR las FK para poder eliminar la PK, asi mantengo la integridad referencial.
              3. `Anular`: Si eliminas la PK, coloca todas las FK a NULL
									- Esto no siempre seraposible, ya q depende de la Regla de Null que posea esa FK
  									- Si la FK NO acepta Null, pues no se puede hacer esto.
              4. `Default Value`: Si se Delete la PK, coloca 1 DefaultValue Prestablecido a las FK
					
                 - El 95% de los casos vas a usar Cascade o Restrict
                   - En el Mundo Real se usa el      `SOFT DELETE`
                     - O borrado logico, q es marcar 1 user como Inactivo pero NO borramos sus datos
                       - Crear una nueva columna para el stado del user
                         - Si elimina su cuenta, pues esa columna marcara como eliminado, pero NO se elimina el registro de la DB
                       - Asi mantenemos la data.
                       - Esto conlleva acoplarse a Leyes del uso de datos
                         - Colocar un check para q acepte q sus datos NO se van a borrar cuando el user elimine la cuenta



			- -- 2do Method con la Tabla Pivote
  			- Debemos asegurarnos q cada task_id SOLO aparezca 1 vez en la tabla pivote
    			- Para lo cual podemos establcerla como PK o Unique (UQ)
				- Para   user_id   debo dejar claro q es una FK que NO es Compuesta, asi q damos numeracion
  				- FK2

				- Entre   user_id   y   users  seguimos teniendo la cardinalidad (1:N)
  			- Entre   task_id   y   tasks  tenemos una cardinalidad de  (1:1)
    			- Las reglas de  `UPDATE`  x lo general Siempre van a ser en CASCADE aunque NUNCA se actualice una PK
					- Para el    `DELETE`     al tener en CASCADE, SOLO se va a eliminar las FK de la tabla pivote, y NO las tasks asociadas
  					- Asi el backend debera escribir otra line de codigo para Eliminar Manualmente las tasks asociadas
  					- Amenos que en el   (1:1)   tb coloquemos   `CASCADE`   para q se eliminen las tareas que estan haciendo referencia a la PK

				-- Todas estas Reglas de 		UPDATE/DELETE 	existen para Mantener la Integridad Referencial
					- NO puede haber una FK haciendo referencia a un Value q NO existe.






### Crow's foot notation
	- -- Notacion para Indicar la Cardinalidad de la Relacion entre Tablas
  	- Este sistema en especifico es muy usado, incluso por Apps en las que Generas este Dis. Logico y en base a ello te dan el SQL
    	- Ver el PDF q hice en Edge (Drive)  :v








### Relaciones uno a uno (1:1)
- --- Relacion (1:1):
  - La Foreign Key (FK) SOLO se puede colocar en aquella Entity que participa con Cardinalidad Máxima 1.
  	- Si la relación es (1:1)
			- La cardinalidad máxima entre tablas va a ser 1, por lo tanto la FK se la podrá colocar en cualquier tabla/entity.
			- Los  `Attributes`  de la Relación se los puede colocar en donde quieras. 
  			- Para mayor semántica, colocar los    `Attributes`    en la `misma Entity` que contenga la    `FK`.



- -- Relglas de Update/Delete
  - Como estamos usando una      `Tabla Pivote`	     entre Driver y Vehicle
    - El DELETE CASCADE de Driver con la TP solo eliminar los registros q hagan referencia a la PK de driver, pero NO los autos
      - Para tb eliminar los Vehicles debemos usar otro DELETE CASCADE entre la TP y Vehicle

		- El NULL hay q saber Interpretarlo
			- Si  vehicles  tiene NULL en la FK con parkings, significa q NO esta aparcado
				- Q NO tiene parking asignado
			- Si el NULL   NO tiene Interpretacion NO aceptes nulls

		- Como  Image  es un Attributo q tiene Cardinalidad con Vehicle creamos su propia Tabla
  		- NO es una Entity, asi q NO tiene ID
  		- NO es una tabla pivote
  		- Simplemente tiene una   FK   q apunta a Vehicle

		- Generamos la Tabla Intermedia xq da mayor sentido y representastividad a la Relacion x el hecho de existir Attributes de Relacion
  		- En temas de rendimiento y escalabilidad el tener esta tabla intermedia para relaciones (1:1) no tiene mayor impacto en esta app
    		- Estos temas deben ser analizados cuidadosamente
      		- En esta app q es solo de taxis regionales, lo q vamos a tener como mucho son 3000 rows
        		- Eso no es nada, NO representara Depreciacion en el Rendimiento al hacer    `2 JOIN`    para traer la info
					- Pero en Apps como    Uber   ahi si que es importantisimo y NO se recominda esta tabla intermedia.











### Relaciones muchos a muchos (N:N)
- --- Las Relaciones     `ManyToMany`    se representan mediante una    `Tabla Pivote`
  - Así la relación de ManyToMany entre Entidades se reduce a 2 relaciones OneToMany entre las Entidades y la Tabla Pivote
    - Como es ManyToMany      `NO requerimos Unique (UQ) ni PK`    que Limiten las veces que pueden aparecer las FK.

  - 





















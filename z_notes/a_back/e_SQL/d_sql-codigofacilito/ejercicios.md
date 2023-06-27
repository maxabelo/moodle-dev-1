# Tipos de datos

En general, la mayoría de los servidores de base de datos nos permiten almacenar los mismo tipo de datos, como strings, fechas y número.

En este post, listamos los tipos de datos que más utilizarás en tu día a día.
Alfanuméricos

    CHAR
    VARCHAR

En ambos casos nosotros debemos de especificar la longitud máxima que podrá almacenar el campo. Opcionalmente podemos definir el charset que almacenará.

  `varchar(20) character set utf8`


Con MySQL nosotros podemos establecer el charset que usará la base de datos desde su creación 
    `create database nombre character set utf8;`


## Números enteros
  Tipo 	          Rango
  Tinyint 	      -128 a 127
  Smallint 	      -32,768 a 32,767
  Mediumint 	    −8,388,608 a 8,388,607
  Int 	          −2,147,483,648 a 2,147,483,647
  Bigint 	        −9,223,372,036,854,775,808 a 9,223,372,036,854,775,807



## Números flotantes

Para los flotantes encontraremos dos tipos

    Float
    Double

En ambos casos nosotros debemos de especificar la cantidad de dígitos que almacenará la columna antes y después del punto (p,s)

  `precio FLOAT(3, 2)`

  En este caso la columna podrá almacenar hasta tres dígitos como enteros y dos después del punto decimal. Ejemplo 999.99


## Tiempo
  Tipo 	        Formato default
  Date 	        YYYY-MM-DD
  Datetime 	    YYYY-MM-DD HH:MI:SS
  Timestamp 	  YYYY-MM-DD HH:MI:SS
  Time 	        HHH:MI:SS



















<!-- ================================================================================= -->
<!-- ================================================================================= -->
# Ejercicios

Aquí un listado de ejercicios con los cuales puedes practicar a partir de los datos que se encuentran en el archivo sentencias.sql
    Tu puedes agregar más datos (reales) si así tú lo deseas. Si aun no poses el archivo puedes descargarlo en el siguiente link


## Libros
    Obtener todos los libros escritos por autores que cuenten con un seudónimo.

    Obtener el título de todos los libros publicados en el año actual cuyos autores poseen un pseudónimo.

    Obtener todos los libros escritos por autores que cuenten con un seudónimo y que hayan nacido ante de 1965.

    Colocar el mensaje no disponible a la columna descripción, en todos los libros publicados antes del año 2000.

    Obtener la llave primaria de todos los libros cuya descripción sea diferente de no disponible.

    Obtener el título de los últimos 3 libros escritos por el autor con id 2.

    Obtener en un mismo resultado la cantidad de libros escritos por autores con seudónimo y sin seudónimo.


    Obtener la cantidad de libros publicados entre enero del año 2000 y enero del año 2005.

    Obtener el título y el número de ventas de los cinco libros más vendidos.
    Obtener el título y el número de ventas de los cinco libros más vendidos de la última década.
    Obtener la cantidad de libros vendidos por los autores con id 1, 2 y 3.


    Obtener el título del libro con más páginas.

    Obtener todos los libros cuyo título comience con la palabra “La”.

    Obtener todos los libros cuyo título comience con la palabra “La” y termine con la letra “a”.

    Establecer el stock en cero a todos los libros publicados antes del año de 1995

    Mostrar el mensaje Disponible si el libro con id 1 posee más de 5 ejemplares en stock, en caso contrario mostrar el mensaje No disponible.

    Obtener el título los libros ordenador por fecha de publicación del más reciente al más viejo.


## Autores
    Obtener el nombre de los autores cuya fecha de nacimiento sea posterior a 1950

    Obtener la el nombre completo y la edad de todos los autores.

    Obtener el nombre completo de todos los autores cuyo último libro publicado sea posterior al 2005

    Obtener el id de todos los escritores cuyas ventas en sus libros superen el promedio.

    Obtener el id de todos los escritores cuyas ventas en sus libros sean mayores a cien mil ejemplares.


## Funciones
Crear una función la cual nos permita saber si un libro es candidato a préstamo o no. Retornar “Disponible” si el libro posee por lo menos un ejemplar en stock, en caso contrario retornar “No disponible.”











<!-- ================================================================================= -->
<!-- ================================================================================= -->
# Ejercicios parte 2
Aquí un listado de ejercicios con los cuales puedes practicar a partir de los datos que se encuentran en el archivo sentencias.sql
    Obtener a todos los usuarios que han realizado un préstamo en los últimos diez días.

    Obtener a todos los usuarios que no ha realizado ningún préstamo.

    Listar de forma descendente a los cinco usuarios con más préstamos.

    Listar 5 títulos con más préstamos en los últimos 30 días.

    Obtener el título de todos los libros que no han sido prestados.

    Obtener la cantidad de libros prestados el día de hoy.

    Obtener la cantidad de libros prestados por el autor con id 1.

    Obtener el nombre completo de los cinco autores con más préstamos.

    Obtener el título del libro con más préstamos esta semana.














<!-- ================================================= -->
<!-- ================================================= -->
# Motores de almacenamiento en MySQL

Afortunadamente para nosotros, los administradores de base de datos, MySQL nos permite trabajar con diferentes motores de almacenamiento, entre los que destacan MyISAM e InnoDB.

¿Motor de almacenamiento?, ¿Qué es eso? 🤔, verás, un motor de almacenamiento se el encargado de almacenar, gestionar y recuperar toda la información de una tabla. Es por ello que es de suma importancia que nosotros conozcamos la existencia de estos motores, cuales son sus principales diferencias y en qué casos es bueno utilizar uno u otro, de esta forma que podamos garantizar un mejor performance en nuestras aplicaciones. 😉

Para que nosotros conozcamos que motor de almacenamiento podemos utilizar basta con ejecutar la siguiente sentencia en nuestra terminal.

SHOW ENGINES;

Obtendremos el siguiente listado.

    InnoDB
    MRG_MYISAM
    MEMORY
    BLACKHOLE
    MyISAM
    CSV
    ARCHIVE
    PERFORMANCE_SCHEMA
    FEDERATED

En esta ocasión nos centraremos en explicar los dos motores de almacenamiento más populares, me refiero a MyISAM e InnoDB.

MyISAM es el motor por default de MySQL. Una de las principales ventajas de este motor es la velocidad al momento de recuperar información. MyISAM es una excelente opción cuando las sentencias predominantes en nuestra aplicación sean de consultas. Esta es una de las razones por las cuales MyISAM es tan popular en aplicaciones web.

    Si tu aplicación necesita realizar búsquedas full-text MyISAM es un mejor opcion.

La principal desventajas de MyISAM recae en la ausencia de atomocidad, ya que no se comprueba la integridad referencial de los datos. Se gana tiempo en la inserción, sí, pero perdemos confiabilidad en los datos.

Por otro lado tenemos el motor de almacenamiento InnoDB. La principal ventaja de este motor recae en la seguridad de las operaciones. InnoDB permite la ejecución de transacciones, esto nos garantiza que los datos se persisten de forma correcta y si existe algún error podamos revertir todos los cambios realizados.

Algo interesante a mencionar sobre InnoDB es que este motor realiza un bloqueo total sobre un tabla cuando es ejecutada una se las siguientes sentencias.

    Select
    Insert
    Update
    Delete

Si deseamos trabajar con transacción y la integridad de los datos sea crucial nuestra mejor opción será InnoDB, por otro lado, sí lo que deseamos es una mayor rapidez al momento de obtener información será necesario utilizar MyISAM.
Gestión

Si nosotros así lo deseamos podemos cambiar el motor de almacenamiento. Existen dos formas de hacer esto. La primera, es modificar el archivo my.cnf.

[mysqld]
default-storage-engine = innodb

La segunda forma es hacerlo directamente desde nuestra sección, basta con ejecutar la siguiente sentencia.

SET storage_engine=INNODB;

En ambos casos modificamos el motor de almacenamiento de MyISAM a InnoDB.

Si nosotros deseamos conocer qué motor de almacenamiento utiliza una tabla en particular, podemos hacerlo ejecutando la siguiente sentencia.

SHOW TABLE STATUS WHERE `Name` = 'tabla' \G;

Si deseamos crear una tabla utilizando un motor en particular, debemos seguir la siguiente estructura.

CREATE TABLE tabla_innodb (id int, value int) ENGINE=INNODB;
CREATE TABLE tabla_myisam (id int, value int) ENGINE=MYISAM;
CREATE TABLE tabla_default (id int, value int);














<!-- ================================================= -->
<!-- ================================================= -->
# Eventos MySQL
A partir de la versión 5.1, MySQL añade el concepto de eventos. Un evento no es más que una tarea la cual se ejecuta de forma automática en un momento previamente programado. Si eres un usuarios Linux puedes ver a los eventos cómo los cron jobs . 








<!-- ================================================= -->
<!-- ================================================= -->
# Triggers Mysql
Un trigger, también conocido como disparador (Por su traducción al español) es un conjunto de sentencias SQL las cuales se ejecutan de forma automática cuando ocurre algún evento que modifique a una tabla. Pero no me refierón a una modificación de estructura, no, me refiero a una modificación en cuando a los datos almacenados, es decir, cuando se ejecute una sentencia INSERT, UPDATE o DELETE.

    A diferencia de una función o un store procedure, un trigger no puede existir sin una tabla asociada.


Lo interesante aquí es que podemos programar los triggers de tal manera que se ejecuten antes o después, de dichas sentencias; Dando como resultado seis combinaciones de eventos.

    BEFORE INSERT     Acciones a realizar antes de insertar uno más o registros en una tabla.

    AFTER INSERT      Acciones a realizar después de insertar uno más o registros en una tabla.

    BEFORE UPDATE     Acciones a realizar antes de actualizar uno más o registros en una tabla.

    AFTER UPDATE      Acciones a realizar después de actualizar uno más o registros en una tabla.

    BEFORE DELETE     Acciones a realizar antes de eliminar uno más o registros en una tabla.

    AFTER DELETE      Acciones a realizar después de eliminar uno más o registros en una tabla.



A partir de la versión 5.7.2 de MySQL podemos tener la n cantidad de triggers asociados a una tabla. Anteriormente estábamos limitados a tener un máximo de seis trigger por tabla (Uno por cada combinación evento).

    Podemos ver esto como una relación uno a muchos, una tabla puede poseer muchos triggers y un trigger le pertenece única y exclusivamente a una tabla.

    Algo importante a mencionar es que la sentencia TRUNCATE no ejecutará un trigger.



## Ventajas de Utilizar triggers

    Con los triggers seremos capaces validar todos aquellos valores los cuales no pudieron ser validados mediante un constraints, asegurando así la integreidad de los datos.
    Los triggers nos permitirán ejecutar reglas de negocios.
    Utilizando la combinación de eventos nosotros podemos realizar acciones sumamente complejas.
    Los trigger nos permitirán llevar un control de los cambios realizados en una tabla. Para esto nos debemos de apoyar de una segunda tabla (Comúnmente una tabla log).



## Desventajas de Utilizar triggers

    Los triggers al ejecutarse de forma automática puede dificultar llevar un control sobre qué sentencias SQL fueron ejecutadas.
    Los triggers incrementa la sobrecarga del servidor. Un mal uso de triggers puede tornarse en respuestas lentas por parte del servidor.









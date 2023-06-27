# Diseno de Bases de Datos Relacionales con MySQL


## Insercion y consulta de datos en MySQL

### CRUD con SQL
- -- SI es AuntoIncrement, este se va a incrementar aunq falle la insercino
  - Para evitar eso usar   COMMIT/ROLLBACK
    - Asi aseguramos las insercions/updates en DB

- -- UPDATE
  - Nunca hacer 1 UPDATE manual en la DB de Produccion
    - No te conectes x ssh y escrimas sentencias SQL manualmente q impacten la DB en produccion
      - Mucho riesgo
		

- -- DELETE
  - Siempre debe ir con un   WHERE
    - Sino te cargas DB y te caen a ostias :v



- -- Ejecutar archivos SQL en Docker   <--   Depende del Volume q se le asigne
    `SOURCE /home/docs/todos.sql`








### Funcionamiento del RESTRICT, CASCADE, SET NULL y SET DEFAULT en claves ajenas
- --- Comprobaremos q en efecto funciona el CASCADE, DELETE y SET DEFAULT
  - -- `CASCADE`: 
    - Si hago un    DELETE    de 1 user, TODOS sus tasks se van a eleiminar x el CASCADE
    - Si hago un    UPDATE    del ID de 1 user, TODAS las FK q apunten a ese PK se van a actualizar 
    


  - -- `RESTRICT`:
    - Al intentar hacer 1     DELETE    x el RESTRICT nos lanza 1 error q prioriza la preservacion de la Integridad Referencial
      - Solo podremos     DELETE      a 1 User q NO tenga Tasks asociadas o FK q apunten a esa PK
        - NO debe hacer FK apuntando al registro/PK q quiero eliminar/update

```bash
ERROR 1451 (23000): Cannot delete or update a parent row: a foreign key constraint fails (`todos`.`tasks`, CONSTRAINT `tasks_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE)
```



  - -- `SET NULL`: E2 Taxis
    - Al hacer 1 Update/Delete setea a NULL todas las FK que apunten a esa PK
      - Para esot la FK debe Aceptar NULL




  - -- Relaciones (1:1) y (1:N)
    - Hay mucho W q va en el Backen xq a la DB no le importa q tengas condiciones/restricciones
      - Ej. En el Dis. Logico tenemos q el Vehicle debe tener como Min 1 Image y Max N
        - Pero al hacer un select de las images, NO hemos ingresado nada y eso a la DB NO le importa
        - Todo esto debes controlarlo en el Backend
      - En la DB como mucho (de forma facil) solo puedes controlar q un Attribute sea
        - MUL:  Multiple (aparezca N veces)
          - Si en la Logica de Necogios dices q como Max. 1 Vehicle puede tener 10 imgs, eso NO le importa a la DB
            - Eso lo debemos controlar en el Backend
              - Todo tipo de restriccion de la Logica de Negocios debe ser controlada en el Backend
              - SI q lo puedes hacer en la DB, pero con cosas mas avanzadas como TRIGGERS, etc.
                - Lo normal es q vaya en el back
                  -  Es mas, asi tengas en DB esas restricciones con triggers, pues en el Back Tambien debes tenerlo
        - UNI:  Unique (aparezca solo 1 vez en la tabla)

    +--------------+--------------+------+-----+---------+----------------+
    | Field        | Type         | Null | Key | Default | Extra          |
    +--------------+--------------+------+-----+---------+----------------+
    | id           | int unsigned | NO   | PRI | NULL    | auto_increment |
    | parking_id   | int unsigned | YES  | MUL | NULL    |                |
    | plate_number | varchar(255) | NO   | UNI | NULL    |                |
    | brand        | varchar(255) | NO   |     | NULL    |                |
    | model        | varchar(255) | NO   |     | NULL    |                |
    +--------------+--------------+------+-----+---------+----------------+








### Consultas SQL básicas
- -- W con Fechas
  - Usamos   `EXTRACT()`  para extraer ya sea el year/month/day
  - Usamos Between para rangos de fechas



### JOINS
- --- JOINS
  - MySQL NO previene q se cumpla la logica de negocios
    - Eso es tarea del Backend
      - MySQL NO previene q en la tabla de `vehicles` se inserte una FK q apunte a un Seguro de Casas
        - Esta tarea la debe validar/controler/manejar el backend







### Transacciones y ACID
- --- TRANSACTION: Mecanismo q nos permite agrupar N cantidad de Sentencias SQL en 1 sola, de modo q todas o ningua de ellas tengan exito
  - O se ejecutan exitosamente TODAS o NADA altera la DB.
  - Existen 3 estdos de la transaccino
    - antes/durante/despues
      -  durante: los cambios son reversibles
  - SOLO se alterara la DB cuando TODAS las Sentencias hayan tenido Exito
    - `COMMIT;`   <- si todo OK finalizamos la transaccion y PERSISTIMOS  los cambios en DB
    - `ROLLBACK;` <- 1 error y finalizamos la transaccion SIN Persistir los cambios / afectar la db




- --- ACID
  - Las DB Relacionales son ADIC Compliant, es decir, q implementan 4 caracteristicas
    - Atomicidad / Atomicity
      - Permite q todas las     Transacciones     (q estan compuestas de multiples sentencias) sean tratadas como una UNIDAD
        - O bien Toda la unidad tiene exito
        - O falla x completo
      - Es similar a la Atomicidad en Programacion Paralela
    - Consistencia / Consistency
      - Se enfoca en al consistencia de los datos insertados en la DB
        - Tememos Constraints, cascade, triggers, Referential Integrity (PK <- FK) q ofrece cierta consistencia
        - Pero es tarea del backend mantener la consistencia de datos e inserciones en DB en base a la Logica de Negocio
    - Aislamiento / Isolation
      - Atender a cada Transaction en secuencia
        - Tenemos acciones concurrentes (muchas acciones al mismo tiempo a la db), pero la DB trata las transacciones en secuenca.
          - InnoDB es 1 tipo de Bloqueo q hace q todas las sentencias a DB generen 1 Bloqueo
    - Durabilidad / Durability
      - Le llegan la sentencias, y la DB tiene como 1 block de notas donde 1ro se apunta lo q tiene q hacer
        - Q se va la luz, no importa, ya lo tiene apuntado. Regresa la luz y ejecuta cada sentencia anotada
          - Asi esta medio cubierto ante este tipo de cosas q es muy raro q pasen xq si tienes servidores de DB, lo mas probable es q ya tengas cubierto todas estas cosas.


  - PostgreSQL, MySQL, Oracle, La de Microsoft son ACID Complaint
    - NO todos los tipos de DB son ACID Complaint xq algunas sacrifican algo para obtener otro beneficio
      - Existen distintas DB








### Como causar un Deadlock en MySQL
- --- Las Transacciones son muy utilies para realizar operaciones atomicas
  - Pero pueden traer consigo algunos problemas
    - Si se da 1 situacion Muy Pecualia, puede ocurrir 1    Deadlock
      

    
  - -- How to cause deadlock on MySQL
    - Nos conectamos desde 2 terminales a la db para tener 2 conecciones establecidas
      - Entonces la situacion es q Varias Servidores Back se comunican con la DB Simultaneamente
        - Con esto, para generar el    deadlock   debemos generar la peticion de transferencia de dinero al mismo tiempo en ambos servidores a las mismas cuentas


    - Vamos a suponer q la App de Pagos a Crecido mucho, tiene 2 millones de usuarios
      - Tienes q     Escalar Horizontalmente   , tienes    muchos Servidores de Back    para poder soportar toda la carga, pero de DB tienes Solo 1 Servidor
        - Xq los Servidores de la DB son mas Dificiles de Escalar Horizontalmente, y lo q se hace es     Escalarlas Verticalmente   , es decir, en vez de poner mas servidores, contratas 1 Servidor Mas Potente.




    - - Teoria:
      - Cada Row esta Aislada/Isolada, pro eso con c/peticion se pilla el Lock y lo bloquea
        - Si tienes trnsacciones, hasta que Hagas el Commit la Transaction NO suelta el el Lock
        - Por eso, si envias la misma transaccion y esta depende de q otra haga commit, pero esta 2 tb depende de la T1, pues ahi se genera el    deadlock. Porque es un loop infinito de bloqueo mutuo.







### Index / Indices
- --- Los Index en la practica sirven para q cierto tipo de Queries sean mucho mas rapidas de lo q serian sin indices a costa de ocupar mas Espacio
  - Para indexar 1 campo/attribute simplemente lo colocas un Index
    `INDEX(name)`
    - Las PK estan Indexadas, los Unique (UQ) tb estan indexadas.
      - Cuando colocas 1  UQ  a algo, la DB tiene que combrar Rapidamente q es UQ, x eso lo indexa
  - Para probar esto creamos 1 script en Python para q cree el SQL q inserte 100000 datos en users
    - Ese SQL lo usamos con el   `SOURCE`  para insertarlo en la tabla
      - Hacemos las queries y comparamos
  

  - -- El los    Index    funciona con algo llamado   `b tree`
    - Es una Estructura de datos muy compleja, y es lo q se utiliza para hacer Index en DB
    - Hacen q las consultas sean mas rapidas, pero ocupan espacio

    - Las Tablas tiene 2 ficheros
      - .idb: Almacena el INDEX y la Data
        - Es dificil calcular el size exacto total xq usan Paginacion en donde Bloques enlazan a otros Bloques
      - .frm: Almacena el formato de la Table, metadatos y demas

      - Si llegases a eliminar una barbaridad de datos y quiere optimzar el  .idb
        - X default el  .idb   sigue  ocupando el size mas alto, xq tiene almacenado esos bloques q ante nuevas inserciones los reutilizan.
        - Pero podemos forzar la reestructuracion de la estrcutura interna del   .idb
          - Con lo cual 
            `optimize table users;`











### Dumps
- --- Tiene usos muy importantes
  - Los   Dumps   puedes usarlos para traerte los datos de una DB q esta en Production a tu PC en Local
    - Sirve para hacer de forma rapida copias de seguridad
      - Duplicar DB en cualquier maquina
        - Clonar DB
    - En Empresas pequenas, SOLO si te autorizan, puedes haceru Dump para replicar los errores de producion en Local y corregirlos
      - En empresas Tochas NO te van a dejar x temas de privacidad y demas
      - Pero si te lo permite, es muy util para replicar bugs de produccion en local


  - Un   Dump  es basicamente un Fichero   .sql   q incluye:
    - Creacion de las Tables
    - Los Inserts para tener todos los datos q habian en la DB cuando hiciste en Dump




    - --- Crear 1   Dump
      - EN docker dentro del Container SI tiene el    `mysqldump`
        - Esto nos genera el SQL q contiene las tablas y los inserts q existen hasta ese momento
          `mysqldump -u root -h 127.0.0.1 -P 3306 -p insurances`

        - -- Como solo nos da el SQL, debemos redirigirlo a un fichero
          - Si usas docker, para poder tener acceso a ese fichero, debes crearlo en el volumen q compartes con el HOST
              `mysqldump -u root -h 127.0.0.1 -P 3306 -p insurances > ./home/docs/dump.sql`

          - Ya con este fichero, simplemente replicas la DB en cualquier otro lado q tenga mysql
            - Te conectas a MySQl x consola
              - Creas la DB q sera la copia
                `CREATE DATABASE insurances_copy;`
                `USE insurances_copy`
              - Hacemos el    SOURCE    de ese fichero dump creado
                `SOURCE /home/docs/dump.sql`
                - Y asi ya lo tenemos replicado
                  - Esta es 1 forma de recrear la DB




      - --- Otra forma de replicar la DB
        - Podemos conectarnos de una a 1 tabla (sin necesidad de hace el   use ...) colocando el name
            `mysql -u root -h 127.0.0.1 -P 3306 -p insurances_copy;`

        - Asi pues podemos de una redirigir a la inversa, el fichero  dump.sql  q generamos previamente a la coneccion a la tabla 
          - Como siempre, ojo el path del Volume con Docker
            - Si tenemos 1 db en prod q esta en un server externo:
              `mysql -u root -h 127.0.0.1 -P 3306 -p insurances_copy < /home/docs/dump.sql `
            - Solo en local no hace falta indicar -h ni -P
              `mysql -u root -p insurances_copy < /home/docs/dump.sql`







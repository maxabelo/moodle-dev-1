# Devstagram
- --- Init
  - `app/`: 
    - `Http` : Controllers: Es donde se van a coloar los      Controllers    q vayas generando
    - `Console`: Establecer comandos a ser ejecutados (posiblemente x 1 cronjob)
    - `Models`: Donde se crearan los Models (Entities)
  - bootstrap y config ya viene preseteado x laravel, es raro q toques ese codigo
	- El core de Laravel NOOO lo debes modificar
  - `database`: Donde manejaremos todos con respecto al W con DB
    - desde las factories, Migrations (), Seeders
  - lang: Instalar languages para tenerlos en tu app de laravel
  - `public`: Almacena los Archivos Estaticos ya procesados, es decir los transpilados x el runner q usa Laravel. Q actualmente es    vite     lo cual me sorprende :)
    - Va a contener los transpilados de JS, ademas de los CSS, imagenes y demas archivos estaticos
  - `resources`: Contiene los Archivos originales de JS, CSS y views
	- Estos archivos seran porcesados por    viete    para generar los compilados/trnaspilados
	- Views: Ahi van las    views    del     MVC     horroroso
  - `routes`: Es 1 pieza muy importante en laravel. Podemos tener rutas para API y para el MVC
    - api.php: Los endpoints http q retoran JSON para ser consumidos x vue.js, react, next, flutter, etc
    - web.php: Renderizar las view q creamos con    blade   q es el template engine de laravel
  - `storage`: Donde se van a almacenar los Archivos q los usuarios Suban a la app
    - Es donde se guardan en filesystem los archivos q usan los usuarios de la app
	- Si vas a almacenar una gran cantidad de archivos es mejor EXTERNALIZAR el storage a servicios como
  	  - S3 de AWS
  	  - Cloudflare - R2  |  q es mucho mas barato q AWS
  - vendor: contiene todas las dependencias del    composer   q laravel usa
    - Como el     node_modules    de js
    - Podemos agregar nuevos packages para nuevas funcionalidades

  - Luego tenemos solo archivos de configuracion y de EnvV
    - .env					para W con EnvV
    - docker-compose.yml	para levantar todo con conexiones a MySQL
    - phpunit.xlm 			W con unit testing










## Routing in Laravel
- --- En Laravel tenemos la class     `Route`     q tiene static methods para atender a cada verbo http
  - X defaul Laravel usa los    `closure`     q son como los callbacks d JS
  - Con esta glase y el method    view()    renderizamos vistas de laravel (blade)






## Creando un Layout Principal y utilizandolo
- --- Para evitar repetir codigo podemos crear     Layouts 
  - Blade tiene las denominadas    `directivas`    q son los q meten logica a la view
    - El    if, foreach, else, etc    pueden se utilizados en    blade, pero requieren 1 sintaxis especial.
    - Para usar 1 View princiapl usamos    `@extends('name')`
	  - A diferencia de php, aqui damos las rutas con   (   .   )  puntos y no con  (   /   )
		- Si en una view tenemos 1    @    es una directiva de blade
		  `@extends('layouts.app')`

  - W con Variables en el Blade, variables q se le pasan a la view
    - En la view usamos el    `@yield('title')`









## Install TailwindCSS with Vite
- ---  Como estamos corriendo laravel con Docker, debemos usar     `sail`     para interacturar con el container
  - Install tailwind:   `sail npm i -D tailwindcss postcss autoprefixer`
  - Creamos los archivos de configuracion
    - Como el comando con   sail   ya nos creo el    node_modules     desde el host anfitrion podemos podemos ejecutar npx normalmente
      - Crear los config failes de tailwind:    `npx tailwindcss init -p`
        - Esto creara el:   tailwind.config.js y postcss.config.js
		  - tailwind.config.js:	seteamos los archivos q van a usar estas clases de tailwind
			- Son todas las   views   .blame.php    de laravel
			- Establecemos los files a los q debe darle seguimiento para refrescar los cambios
		  - postcss.config.js:	
		  - app.css: Establecemos los los @tailwind q se requieren para w con tailwind


  - --- Init Layout template
    - En Laravel tenemos      `helpers fn`     q podemos usar
      - Como estamos con    blame    NO vamos a crear php tags en 1 view, sino q para Imprimir variables o calculos se usa      `{{}}`     y ahi dentor podemos usar los     helpers     de laravel
        - Para imprimir el   current year   tenemos    `now()`
          - Ej:    `{{now()->year}}`

              - URL:
                - Helpers:    https://laravel.com/docs/10.x/helpers











## Login and Sign Up
- --- Vamos a ver la logica para el Login y Sign Up de usuarios en Laravel con MVC
  - Como es MVC se va a W con Sessions
    - Laravel nos provee 2 packages de Auth, pero para aprender sobre Laravel vamos a w sin ellos. El resto de proyectos los haremos con esos packages



- --- Que es   `Artisan`
  - Artisan es el     CLI     q viene incluido en Laravel
    - Para crear archivos en Laravel con artisan tenemos la categoria de    `make`
      - Crear 1 controller:     `sail artisan make:controller RegisterController`
        - Le pasamos el nombre de la Class q va a crear
          - La crea en     app/Http/Controllers    y ahi crea la class q Extends de Controller
            - Implementa 1    namespace    por lo cual para usar archivos externos debemos usarlos con    use
          - Tb podemos especificar la ruta en la q queremos crear el controller
            - Es decir, si queremos q este en 1 dir dentro de controllers para separar el codigo
              - Ej:      `sail artisan make:controller Auth\\RegisterController`
    
    - Ya con La Controller Class creada con artisan
      - En el Router (web.php) lo llamamos
        - Pilas con la importacion xq es una una Class con Namespace
        

  - --- Register form
    - Laravel nos cubre con el funcionalidad de Repetir Password
      - Para usarla debemos colocar el    `_confirmation`    en el name q viaja al server
        - password_confirmation
    - Trabajar con   images   en 1 view de laravel
      - Se w con    `{{assets('')}}`    el path parte desde /public
        <img src="{{asset('img/register.jpg')}}" alt="Register image">



  - --- POST in MVC with Laravel
    - Como es MVC para enviar data al server desde la View usamos Formularios q como action tiene POST
      - Para recibir esta data y W debemos crear 1 nuevo method en nuestro Controller
        - En el   form    debemos especificar el    action y el method
          - action: url q tenemos en nuestro  Router
            - {{route('name')}}  <- lo hace dinamico, lo toma del route (web.php)
          - method: Verbo http
            <form action="{{route('register')}}" method="POST">

    - Importante: Como estamos usando MVC, DEBEMOS Protegernos de los ataques `CSRF`
      - Para esto se usan tokens q viajan en 1 `input hidden` en el form
        - Laravel nos ayuda con eso gracias al    `@csrf`    q colocamos dentro del form en la view




  - --- Controllers en Laravel y sus convenciones
    - Nos ayudan a tener los routers limpios y a organizar mejor el codigo
      - Separacion de la funcionalidad en nuestro code
    - Laravel tiene 1 convencion a la hora de nombrar los methods de los controllers conocida como `Resource Controllers`
      - Esta convencion ayuda a tener organizado el codigo
        - Tabla de convenciones para el MVC en Laravel
          - index: renderiza la view 
          - store: post q toma la data de la view
    - Route Name: 
      - Podemos darle el name a la route para q sea dinamico
        - Asi, si cambia la url, solo cambio en el route y los templates ni se enteran

    ```
      HTTP Verb   |   URI   |   Action    |   Route   |
      ------------|---------|-------------|-----------|
      GET           /clients    index       clients.index
      POST          /clients    store       clients.store
      DELETE        /c/{id}     destroy     clients.destroy

      # https://laravel.com/docs/10.x/controllers#actions-handled-by-resource-controller
    ```




  - --- Validacion de Forms
    - Lo 1ro ya lo hicimos, es protegernos del ataque CSRF
    - Validar los campos
      - Larabel nos cubre con la validacion de formularios
        - Seteamos las validaciones en el Controller
        - En la View podemos recuperar el    error message
          - Podemos Traducirlo al Spain con 1 libreria de terceros:
            - clonamos el repo en     `resources/lang/es`
                git clone https://github.com/MarcoGomesr/laravel-validation-en-espanol.git resources/lang
            - config la app a spain:  config del spain  <-  /config/app.php
              - En la linea 86 modificamos en x es
    - Mantener los valores del form tras el error:
      - Usamos la fn helper old:    `value="{{ old('name') }}"`
    
    - Las validaciones se establecen en el Controller
      - Laravel con ayuda con estas reglas de validacion:
              https://laravel.com/docs/10.x/validation
      
    - Colocar los mensajes de validacion de formulario en ES:
        https://github.com/MarcoGomesr/laravel-validation-en-espanol






  - --- Que son y como ejecutar MIGRACIONES
    - Las Migraciones son el control de versiones de la DB. Asi podemos crear la DB y compartir el disenio fisico con el equipo de W
    - Si deseas agregar nuevas tablas o columnas a 1 tabla existente, puedes hacerlo con 1 nueva migracion; si el resultado no fue el deseado, puedes reviertir esa migracion.
    - Artisan nos ayuda con la creacion de migraciones:
      - Ej:  `sail artisan migrate`
        - Step hace ref al # de migraciones con las q se quire hacer algo
          - Si algo salio mal, aplicamos 1     `rollback`  
            - Si queremos el rollback de las ultimas 5 migrations:  --step=5
              `sail artisan migrate:rollback --step=5`
      - Ej de crear 1 migration:    `sail artisan make:migration table_name`




    - -- Corriendo Migrations
      - Laravel nos da una serie de Default Migrations para la creacion de los users
        - Para correr estas default tables podemos correr el comando:
          `sail artisan migrate`
        - Para hacer rollback
          `sail artisan migrate:rollback`
          `sail artisan migrate:rollback --step=5`




    - -- CREAR Migrations
      - Como se dijo antes, las Migraciones son como el Control de Versiones de nuestras DB
        - Nos deben permitir hacer    rollback    de los nuevos cambios
        - Para modificar una tabla o db existente debemos crear migraciones, lo cual esta cubierto por Laravel con el cli (make:migration)
          - La forma de crearlas es en base al name, y a la convencion de Laravel
            - Como vamos a crear 1 nueva COLUMN a una TABLA existente, debemos especificar eso en el nombre de la Migration, y Laravel en auto identificara el nombre de la tabla y demas

        - -- Creamos la migration:
          - Con el cli:   `sail artisan make:migration add_username_to_users_table`
          - Se creara la migration y deberemos especificar lo q queremos
            - up():   lo q se hara al correr la migration
              - Aqui agregamos la column
            - down(): lo q se hara al correr el rollback de esta migration
              - Removemos la new column, para q el control de versiones/migrations tengan sentido
          - Corremos la migration:  `sail artisan migration`







### Eloquent ORM
- --- Eloquent es el ORM propio de Laravel
  - Cada Tabla tiene su propio Model q es una class
    - Para crear 1 model en laravel usamos el CLI. El nombre del Model es en Singular
      - Ej:   `sail artisan make:model Client` 

  - En este punto, laravel nos dio ya el modelo de User. A esta table le metimos 1 migration para agregar la columna username. Ahora, vamos a usar ese model para insertar 1 registro en esa tabla
    - Asi q para el username debemos validar y construir 1 slug
      - Esto ya nos ayuda laravel
        - Modificar la req solo cuando no haya de otra para validar el username q va a ser parte de la url

  - -- Insertar 1 registro en la DB
    - Como aplicamos 1 migration para agregar el    username, este cambio debemos reflejarlo manualmente en el User Model
      - Y ya solo llamamos al Model y usamos su static method:     `::create([''=>$value])`
        - La key en este arreglo asociativo en el nombre de la columna en la DB
    - Todo esto, en el Controller como siempre en MVC



- --- Redireccionar al user tras crear su cuenta
  - Para redireccionar tenemos:   `return redirect()->route('posts.index');`
    - Solo le pasamos el name de la route q establecemos con el    ->name('name');   en el router

  - Para AUTENTICAR al user usamos      `auth()->attempt($request->only('email', 'password'));`
    - el helper q nos da laravel lo usamos y ya




- --- Proteger rutas con Laravel
  - Podemos usar el middleware q nos provee laravel para porteger rutas
    - Este lo ejecutamos en el Constructor de la clase controller q contiene la logica, renderizaciones y demas q queremos proteger

  ```php
    public function __construct()
    {
      $this->middleware('auth');
    }
  ```

  - Asi es como protegemos todo el Controller









## Authentication
- --- Para la Authentication q es el login basicamente vamos a
  - -- Crear el   LoginController:   `sail artisan make:controller LoginController`
    - Lo seteamos en el Router e invocamos al method  init()  q es el q renderiza la view
    - Con el    init()   como siempre renderizamos la view

    - En auto Laravel, si NO esta `Auth` lo envia a /login
      - Esto xq protegimos el Controller q renderiza la view de   /muro


- --- Login
  - Necesitamos manejar el form de login, para eso necesitamos 1 POST y su    store()    en el controller
    - Igualmente usamos el    `auth()->attemp()`   para auth al user
      - Esto behind the scenes hara las consultas a la DB y demas. Super facil como nos lo pone Laravel
  - `with()`  <-  agregar cosas a la SESSION actual
    - Con esto podemos enviar mensajes de error hacia las Views y recuperarlas alla
      - Para el mensaje del Login Fallido x credenciales incorrectas
        - Lo bueno q es los errores de POST Laravel los maneja en auto para q al refrescar la pagina NO se vuelva a hacer la request invalida, sino 1 ya solo se refresca

  - Para diferenciar las view entre alguien Auth y un Guest laravel nos ayuda con:
    - `@auth`
    - `@guest`




- --- Log Out
  - Creamos el Controller:    `sail artisan make:controller LogoutController`
  - El logout lo manejamos x medio de 1 FORM para poder tener la Seguridad del  `CSRF`
    - Asi hacemos mas segura la app
      - Logout laravel:    `auth()->logout();`



- --- Mantener la Session Abierta
  - Laravel nos facilita esto. Simplemente creamos 1 CHECKBOX con el name `remember` y ese se lo pasamos al `auth` en el LoginController
    - Esto insertara 1 token en el la tabla user en la colum `remember_token` q sera comparado con la COOKIE q le mete laravel al user
      - Si hacen match, no necesitara hacer login y tendra la funcionalidad de mantener la session
          `if (!auth()->attempt($request->only('email', 'password'), $request->remember)){}`








## URLs unicas para el muro
- --- Vamos a crear el    route model binding
  - Con lo q directamente desde el route podemos traer data del model (db) para crear una URL dinamica
    - Laravel nos cubre con esto para no hacer la consulta en codigo, sino q la hace behind the scenes
      - Entre llaves (lo hace dinamico, como el  :id   de node)
        - El model q en este caso es User
          - Con esto, el method a ser llamado en auto espera el Modelo
            - Lo recepta y podemos hacer lo q queramos con el en el COntroller
        - Nuestro Login cambia puesto q debe redirigir a ese path con la username
        ```php
          <!-- router -->
          Route::get('/{user:username}', [PostController::class, 'init'])->name('posts.index');

          <!-- login -->
          return redirect()->route('posts.index', auth()->user()->username);
        ```
      - 









## Creando Post
- --- Con laravel tenemos convenciones para el nombre de los methods del controller
  - Para renderizar el formulario de Creacion de 1 recurso (GET) debemos llamarlo   `create`

          URL: https://laravel.com/docs/10.x/controllers#actions-handled-by-resource-controller




- --- Dropzone para el soltar archivos en el drop zone :v
  - Instalamos la dependencia con SAIL:   `sail npm i dropzone`
  - Como estamos usando vite con Laravel, debemos declarar los archivos a ser transpilados
    - En este caso tenemos:     `@vite('resources/js/app.js')`    en el   app.blade.php
  - Configuramos la libreria en el app.js
    - La W como form para q tenga proteccion   CSRF   y debemos establecer la RUTA q va a gestionar estos POST de archivos



- --- Subir archivos
  - Comunicamos el form de la view con el back de laravel a travez del form
    - Este form requiere el  CSRF  token para q funcione



- --- Los Eventos de Dropzone
  - Tenemos varios eventos para saber el estado de nuestro file en todo momento
    - sending, success, error, delete, etc
  - El evento de   `SUCCESS`   nos dara la respuesta q retorna el Server en el Endpoint al q se esta enviado la image
    - En este caso estamos enviando la request POST al /images
      - Lo q este controller responda lo atrapara dropzone en su evento success
  





- --- Intervention Image para porcesar images in PHP
  - Instalar librerias de COmposer con Laravel en Docker
    - Aqui con docker es facil xq ya tiene todo configurado
      - Usa el AUTODISCOVER de composer, q si hace falta algo, lo identifica y lo instala/genera
        `sail composer require intervention/image`

  - Requerimos configurar su integracion con Laravel:
    - Necesitamos tocal el    `/config/app.php`
      - Agregar lo q nos pide la doc: `providers/aliases`

        https://image.intervention.io/v2/introduction/installation



  - -- Procesar la Img con Intervention Image
    - La procesamos con los helpers 1 nos da este paquete
    - Almacenamos la imagen en plublic
      - Como levantamos con docker, algo de permisos siempre chirria 1 poco
        - Por eso, creamos manualmente la carpeta de destino de las images
          - En este caso    /public/uploads
        - Ahora si q subira sin dar error de escritura en ese path








## Migrations and Modles for Posts table
- --- Comenzamos creando el Model de nuestra tabla, y luego la migration
  - Creamos el model con artisan:   `sail artisan make:model Post`
    - Los models al igual q los controllers se crean en    /app
      - Pero estos en Models, en lugar de http/controller como los controllers
  - Creamos la Migration:         `sail artisan make:migration create_posts_table`


  - --- Esto lo podemos hacer en 1 solo comando:
    -  Como ya habiamos creado el Controller, no lo creamos aqui, but it could be done
      `sail artisan make:model --migration --factory Post`
        - El factory es usado para los tests en laravel ???



- --- Agregando Properties/Columns a la tabla/migration
  - Todo lo q se puede hacer esta en la doc de migrations in laravel
      https://laravel.com/docs/10.x/migrations#column-method-foreignId

  - Una vez definimos como va a quedar el Model de Posts porcedemos a correr la Migration
    - Para esto nos apoyamos de artisan como milpre
      `sail artisan migrate`




### Factories
- --- Las Factorias nos van a permitir hacer TESTING a las DB
  - Nos ayudan en la etapa de desarrollo para hacer testing de nuestras db

  - -- En el   return    podemos definir la fake data para porbar esta entity
    - Laravel ya trae la libreria     Faker    para poderla usar 
    - Simplemente lo definimos en base a esta libreria


  - -- Ejecutar y probar el Factory
    - Usamos    `tinker`    para interacturar con la app y la db en laravel
      - Abre 1 terminal iteractiva con:   `sail artisan tinker`
    - Usar este Factory solo en Devel, no en production
        ```bash
          # get user by id
          $user = User::find(7);

          # use factory to create records
          App\Models\Post::factory();

          ## To use aliases:
          exit
          sail composer dump-autoload
          sail artisan tinker
          Post::factory();

          ## create records
          Post::factory()->times(48)->create();
        ```

    - Si cometimos 1 error, debemos revertir la migration:
      ```bash
          # rollback to last migration
          sail artisan migrate:rollback --step 1

          # run migration
          sail artisan migrate

          # enter into tinker
          sail artisan tinker
          Post::factory()->times(48)->create();
      ```







## Validacion a las Publicaciones
- --- Validamos en el Controller como siempre
  - Para validar q venga 1 Image necesitamos crear 1    Input HIDDEN     q llenaremos con JS su value con el nombre de la imagen mediante el     success    event de dropzone
  

  - --- Mantenemos el imageName en el input hidden
    - Solo con el   old()   q ya estabamos utilizando
    - Toda la logia se vasa en el     Imput Hidden    y a como W con JS en base a los eventos de Dropzone





## Save Posts in DB
- --- Aqui lo unico nuevo es la   FK   q apunta al user
  - Como es quien esta autenticated, pues usamos   `auth()`
    ```php
      Post::create([
          'title' => $request->title,
          'description' => $request->description,
          'image' => $request->image,
          'user_id' => auth()->user()->id,    // <--   auth user
      ]);
    ```





## Relaciones con Eloquent
- --- Relaciones SQL con Eloquent ORM de Laravel
  - `OneToOne`: Relacion de 1:1
    - En 1 RRSS las entidades/tables  User y Profila van a ser de   1:1
      - 1 user solo puede tener 1 profile, y 1 profile solo puede pertenecerle a 1 user a la vez.
  - `OneToMany`: Relacione 1:n
    - 1 tabla puede tener multiples registros de otra tabla (su FK puede aparecer >1 en la tabla padre)
      - 1 User puede tener Muchos Posts
  - `BelongsTo`: 1 Mismo Post solo puede pertenecerle a 1 user a la vez
    - 1 user puede tener muchos posts, pero 1 MISMO post Solo puede pertenecerle a 1 user a la vez.

  - HasOneOfMany: Para traer el Ultimo Registro del modelo asociado ???
  - HasOneThought: Relacion 1:1, pero con otra cosa
    - Doctor has many patients, and each patient has 1 room
  - HasManyThrough: Relacion  ManyToMany
    - Crea la tabla Pibote



- --- Usar las relaciones definias en el codigo
  - Para traer la data de la otra tabla q relacionamos previamente usamos la Flecha
    - Ej:   `$user->posts;`     `$post->user;`
  - Cuando queremos traer data de la DB con Laravel, gracias a las Relations prestablecidas podemos hacerlo directamente SIN establecer el     where     
    - Asi sin mas, ya nos trae la data de las tablas asociadas




- --- Get posts by user_id
  - Gracias a las Colecciones/Relaciones NO necesitamos el where, pero igual aprendelo
    - Asi de simple con el where:  `$posts = Post::where('user_id', $user->id);`



- --- Route Model Binding para los Posts
  - Pilas en los   anchor   pasarle el id del post en la view
  - Este route model binding hace todo x nosotros, no necesitas hacer la peticion a la DB manualmente NI hacer la validaciones respectivas d si existe o no el ID
    - Todo nos lo hace laravel behind the scenes



- --- Disenio de la pagina del Post
  - Como estamos usando el     Route Model Binding    le pasamos en auto el Post a esa view
  - Establecemos el design
  - Gracias a    Carbon    Laravel nos ayuda con el formating de las fechas
    `{{ $post->created_at->diffForHumans() }}`
  
  - -- Proteger solo ciertos methods/url de nuestro controller
    - Con el mismo middleware podemos hacerlo con except
      `$this->middleware('auth')->except(['show', 'init']);`
    





## Model and Migrations for Comment Model
- --- Creamos el Model, Controller y las Migraciones con artisan
  - Comando:   `sail artisan make:model --migration --controller Comment`
  - Seteamos las properties/columns del Model en las Migrations
    - Luego en el Model mismo, lo q debe esperar
      - Sino da error

- --- Insertamos en DB el comentario
  - Pilas con el Paso del   User   a travez del controller
    - Del Post controller >> View (show.blade) >> Comment Controller >> View
      - Aqui el    `user_id`    q importa es el del   `Auth`   xq ese es el q esta enviando el comentario




- --- Mostrar los COmments con las    RELACIONES   entre entities
  - Aqui en el comment tenemos relaciones de    `1:n`   entre   Post::Comment
    - X eso usaremos el    `hasMany()`








## Delete comments
- --- Primero vamos a Verificar si el Authenticated User es quien CREO el Comment
  - Laravel nos permite escuchar    `.delete()`    con el    `Spoofing Mehtod`
    - Q agrega la firma del verbo http q el navegador no soporta nativamente, para q el router lo intercepte y maneje correctamente 
  - Proteger el btn de delete:
    - primero q sea auth para luego verificar q sea quien creo el post
      ```php
        @auth()
            @if ($post->user_id === auth()->user()->id)
                <form action="{{ route('posts.destroy', $post) }}" method="POST">
                    @method('DELETE')
                    @csrf

                    <input type="submit" value="Delete Post"
                        class="bg-red-500 hover:bg-red-600 p-2 rounded text-white font-bold mt-4 cursor-pointer">
                </form>
            @endif
        @endauth
      ```



- --- Proteger en el Back q solo el author pueda borrar el post con  `Policy`
  - Esto es util para bloquear acciones dependiendo el role o el user
    - Creamos la policy Asociandola a 1 Model con artisan:
      `sail artisan make:policy PostPolicy --model=Post`
    - Nos crea el archivo de la Policy y modificamos el method/action q nos interesa
      - Lo crea en     /app/policies/file
        - En este caso el     `delete`
        - Este lo usamos en el Controller para proteger la accion

  - Como tenemos relaciones, los    constrained    deben ser gestionados
    - En este caso se hace con 1    delete:cascade
      - Pero INVESTIGAR sobre el     `soft delete`


















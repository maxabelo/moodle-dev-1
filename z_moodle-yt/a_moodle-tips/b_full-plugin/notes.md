# Moodle developer tutorial - full plugin

## Intro
- --- Lo q se curbira
	- Creating db tables
	- building pages in moodle using templates
	- creating and handling forms to get user input
	- how to write custom SQL to query moodle
	- display dynamic notifications and callback fn

	- w con formularios
	- w con notificaciones
	- Se va a crear 1 plugin local



## create database tables
- --- Crearemos 1     local plugin
	- Al crear el    /message   y el       `version.php`       moodle ya nos solicita la instalacion
		- Q mas q nada es el upgrade de la moodle db
			- Esto se puede hacer desde el CLI:     `php admin/cli/upgrade.php`


	- -- Creamos el     `lib.php`
		- Moodle nos provee hooks o callbacks que podemos usar
			- Los      `output callback`    
			- Entonces en este    lib.php    se colocan callbacks
			- Para agregar Notificaciones podemos hacerlo aqui ya q desde ese lib podemos acceder al  _before_footer()
				- Este tipo de notificaciones son aquellas q No obedecen a las q normalmente se usan en la redireccion
					- Simplemente son notificaciones

		-- Creamos el      `local_message_before_footer`    q nos permitira usar ese hook para agregarlo antes del footer
			- Este hook se Ejecutara cada vez q Moodle Renderice la Pagina
  			- Para probarlo podemos crear 1    alert   y veremos q al hacer refresh, este aparece
  			- Y esto se ejecutara previo a renderizar la page

		-- Esto funciona xq este hook llama al     outputrenderers.php    y de ese file invoca al  footer()	
			- Y antes de renderizar el    footer    busca todos los     lib.php    de los plugins q contengan una function q termine con     before_footer
  			- Y cuando la encuentra, la llama
			



	- -- Ahora vamos a crear 1 FORM en donde el admin pueda crear notificaciones
		- Vamos a guardar esa notificacion en 1 nueva Table propia de nuestro plugin
			- Esta notificacion sera almacenada en 1 tabla
			- Y cuando el user la vea, almacenaremos ese visto en otra tablae in DB para no volversela a mostrar


		- -- El     `install.xml`     se pasa a inserta en Moodle cuando se instala el plugin, lo creamos en el    /db    del plugin
			- Como vamos a agregarlo luego de haberlo instalado, lo q deberemos hacer es volverlo a instalar luego d haber agregado el     install.xml
			- Este     install.xml     tiene la definicion de la(s) tabla(s) para este plugin en `XMLBD`
			
			- -- Para crear el      `install.xml`    nos basamos en otro existente, q ya tenga el xml basico
				- En este caso nos basamos en el   de   /mod/folder/db/install.xml   y a este lo modificamos
				- La modificamos a conveniencia
				- Una vez terminemos este archivo, Moodle no se entera de q debe crear estas tablas
  				- Asi q debemos indicarselo instalando el Plugin
    				- X eso es importante q si se va a W con tablas, se defina este     install.xml    antes de instalar el plugin

				- -- Dado q se creo mal el name de las tablas, debemos corregirlo	
					- Desisnstalando e instalando
  					- Linea de comandos:  	`php admin/cli/uninstall_plugins.php --plugins=local_message --run`
						 	- En mi instancia en    Docker    NOOOO funca, se va a la shit   >:V
  					- Interfaz grafica




		-- URL
			- local plugins:		https://moodledev.io/docs/apis/plugintypes/local
													https://docs.moodle.org/dev/Local_plugins
			- lib.php:					https://moodledev.io/docs/apis/commonfiles#libphp
			- callback:					https://docs.moodle.org/dev/Callbacks
				- OUTPUT callbacks:		https://docs.moodle.org/dev/Output_callbacks
					- before_footer:		https://docs.moodle.org/dev/Output_callbacks#before_footer
			- Notificaciones:			https://docs.moodle.org/dev/Notifications#Notifications
			- XMLDB:							https://docs.moodle.org/dev/Using_XMLDB#Create_install.xml

		https://moodledev.io/docs/apis/plugintypes/local#adding-site-wide-settings-for-your-local-plugin










	- -- Queremos crear 1 New Page, en donde podamos crear 1 nuevo message e insertarlo en DB, en las tablas q acabamos de crear con el     install.xml
  	- Vamos a crear 1 nueva pagina y la vamos a llamar    `manage.php`
    	- Se llama asi xq va a administrar los mensajes existentes, todas las Operaciones CRUD

		- -- Creamos el      `manage.php`      en el root del plugin q sera 1 PAGE
  		- Damos el boilderplay code, lo q siempre se repite: lo del    lib/version.php
    		- Se quiere crear 1 page a odne el use pueda navegar
      		- Como es  1 page a la q queremos navegar desde afuera, pues NOOO va con el 
					`		defined('MOODLE_INTERNAL') || die();`
			- Le damos acceso a los Objetos Globales a traves del    config.php
  			- Hacemos q lo   require_one
			- Seteamos la config de la   $PAGE



		- -- Vamos a mover todo lo construido a un Template para no harcodear html asi
  		- -- Para esto creamos el     `manage.mustache`    en   /templates
    		- Todos los templates de Moodle se manejan con     `Mustache`





		- -- Para tener data q monstrar, vamos a crear el   PAGE    del form para crear nuevos mensajes
  		- -- Creamos el      `edit.php`    en el root del plugin
    		- Q es en donde vamos a mostrar nuestro Form para crear los messages


			- -- Creamos el   `/classes`   xq nuestra definicion de FORM es una Class
  			- Extendera de   `moodleform`
    			- Para crear   FORMS   en moodle, usar la    Form API
      			- Esta api separa en 2 momentos el uso de forms
        			- 1. Class q Extends de    moodleform    q esta en 
									[path/to/plugin]/classes/form/myform.php
        			- 2. Usar ese Form en donde sea requerido
									https://moodledev.io/docs/apis/subsystems/form#usage

				- Una vez tenemos definida la     classes     q extends de   moodleform    procedemos a instanciarla
  				- En donde sea q la vayamos a usar, en este caso en el     edit.php    del root del plugin

				- -- Para permitirle elegir el    Tipo de Mensaje    al admin, vamos a hacer esto mas dinamico
  				- Asi q implementaremos 1    select    en el form
  				- Este lo implementamos igual en el    /classes/form/edit

				- -- Agregamos el btn de   submit:  `$this->add_action_buttons();`



		- -- 1 Context puede tener otros contextos y se pueden Asignar Roles a c/contexto
  		- EL concepto de Contex es importante en Moodle
    		- Ver la docs


				-- URL:
					- API Guides:			https://moodledev.io/docs/apis
					- Page API:				https://docs.moodle.org/dev/Page_API
					- Navigation			https://moodledev.io/docs/apis/core/navigation
					- Context:				https://docs.moodle.org/402/en/Context
					- Template:				https://moodledev.io/docs/guides/templates
					- Forms API:			https://moodledev.io/docs/apis/subsystems/forms






## Handle form submission #5
- --- Ahora que ya tenemos el form con el submit button, debemos manejar este submit para persistir en DB
  - Ahora vamos a implementar el    handle    de la Cancelacion del Sumbit
    - Esto lo hacemos en el    `edit.php`    del root del plugin
      - En base a la doc se ve como manejar el form
        - Luego, al recuperar esa info, la persistimos en db con     `$DB`

  - En el    template mustache    le podemos meter todo el html q queramos
    - X defecto Moodle usa Bootstrap, asi q podemos usar sus clases


		-- URL:
			- Form API: https://docs.moodle.org/dev/lib/formslib.php_Form_Definition#definition.28.29












## display dynamic notification #6
- --- Lo q teniemoas en el    lib.php    lo queremos hacer dinamico, para q tome de manera dinamica el mensaje y el tipo de notificacion
  -  Simplemente modificamos el      `lib.php`    xq queremos q se muestren con el hook
	- Como esto se carga antes de renderizar todo, aprovechamos aqui para llamar hooks y implementar funconalidad q queremos q cumpla esrte criterio, ejecutarse antes






## build SQL to mark a message as read #7
- --- Debemos guardar en DB q se ha visto 1 mensaje x
  - Agregamos esta funcionalidad en el     `lib.php`
    - Creamos 1    $sql    raw query para traernos lo q necesitamos
      - En este caso   SOLO   nos traemos la data si NO ha sido vista
        - Es decir, su los   messageId   NO estan en la tabla   read








## Tidying up our plugin's language strings #8
- --- Vamos a usar la    `API String`    de moodle para tener soporte a multiidioma
  - Simplemente creamos     `/lang`    y dentro cada    dir   del idioma instalado en Moodle






## Create dynamic form definition #1
- --- Vamos a crear 1 New Page para poder manejar ediciones masivas
  - Esto es del curso privado de   Udemy,    esperar a q baje  $10   :v

























- --- Project de la sig semana
	- -- Store videos en filesysten con node.js		<--  multer
		- Vanilla JS
		- Socket.io
			- Pensar como ver q estan copiando y en base a ello enviar 1 evento q lo desconecte
		- Sequalize ORM
		- Multer
			- Validar el tipo de archivo como tal, los binarios
		- Ver como transformar el video a una version mas libiana con Node.js
			-	Esto lo suelen hacer con Python
				- Podriamos exponer 1 api q haga esta reduccion de calidad en Python xq es + eficiente













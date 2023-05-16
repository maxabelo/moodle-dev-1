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
		- Moodle nos provee HOOKS o callbacks que podemos usar
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










	- -- Queremos crear 1 NEW PAGE, en donde podamos crear 1 nuevo message e insertarlo en DB, en las tablas q acabamos de crear con el     install.xml
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
  		- -- Creamos el      `edit.php`
    		- Q es en donde vamos a mostrar Nuestro Form para crear los messages


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















# Profundizando con el Curso de Udemy:
## Add Unit tests to local message plugin
- --- Debemos configurar el suit de test y lo q este necesita
  - Comenzamos por crear la DB para los tests, en donde se van a crear las tablas necesarias para eso
    - Creamos la DB en MySQL
    - Establecemos la configuracion de phpunit en el      	`config.php`       del root de moodle
      - Establecemos lo solicitado en la doc:
					https://moodledev.io/general/development/tools/phpunit#initialisation-of-test-environment
			- Ojo con los datos de la DB, su user y demas
  			- Este men crea otro user para la db
  - Ejecutamos:		`php admin\tool\phpunit\cli\init.php`
    - Esto tardara varios minutos, creara todas las tablas necesarias y demas
  - Ejecutamos los phpunit:		`vendor\bin\phpunit`
    - Esto ejecutara Todos los Suits de Test
	- Podemos ejecutar 1 suit en concreto solo especificando el path
  	- Para 1 plugin en concreto hacemos ref a testsuit del plugin
			`vendor\bin\phpunit --testsuite=local_message_testsuite`
	

- --- Ahora SI vamos a corregir el problema de al SQL Raw Query al trar los messages
  - Como lo tenemos todo en el lib en un hook, va a aser complicado hacer el  unit_tes, x eso se crea otra clase en    /classes   para estas funcionalidades, desacoplar el codigo y tener mayor control con nuestros tests


	- --- Creamos el     `manager.php`    en   /classes
  	- Como es una clase propia, va en   /classes   y debe implementar 1 namespace
  	- Creamos el    NAMESPACE    de esta clase
    	- Asi, en donde la vayamos a instanciar, deberemos    USE    de ese namespace
      	- Al   use   este namespace, ya podremos instanciar la class
			- Instanciamos esta class en el       edit.php      del root del plugin
		- Modificamos el      lib.php     para usar el      get_messages()    q creamos en el    manager.php
			- Para esto, igualmente usamos el namespace del manager.php
		

	- --- Creamos el      `manager_test.php`     q va a contener nuestrso uniTests
  	- Instanciamos el   manager   con su namespace
  	- Implementamos los    assert     respectivos
  	- Ejecutamos los   suit tests
    	- Iniciamos de nuevo el phpunit x si acaso
			`		php admin\tool\phpunit\cli\init.php`
    	- Ejecutamos los suittest  para este plugin en concreto
			`		vendor\bin\phpunit --testsuite=local_message_testsuite`






## Fixing the SQL for getting messages
- --- Creamo el method para el test de traer los messages de DB
  - Creamos el method     test_get_message()

  - -- En el      `manager.php`     ce /classes  creamos 1 method para insertar en DB los mensajes vistos x el user
    - Creasmo el method     `mark_message_read()`
      - Lo implementamos para q marke los messages as read in db
		- Modificamos el      lib.php     para q use este method en lugar de tener el code en su archivo

	
	- -- Implementamos los tests para esto
  	- Ejecutamos los tests:
			`vendor\bin\phpunit --testsuite=local_message_testsuite`





## Implementing namespaces in moodle
- --- Moodle tiene algo llamado autoloading
  - Que carga todo basado en el     namespace    q vayamos a usar
    - Con esto nos evitamos el    requiere_once   de cada file
      - Simplemente los traemos basado en el namespace
  
	- Los   namespace   encapsulan toda la clase, x tanto debemos hacer    use     de aquello q necesitemos en nuestros methods:   `use: stdClass`
  	- Esto es mejor q usar    /     q represente el root
    		new /stdClass();





## Updating messages - pre-filling form with existing message data
- --- Dado q  Moodle  trae x default bootstrap, podemos hacer uso de sus clases de css

  - --- Modificamos el template de      `manage.mustache`      para q implemente algunos estilos de bootstrap, ademas de q tenga 1 btn q nos lleve a a la page de     EDIT     pasamdole como       url param      el valor del ID del Message q se esta iterando en el template
    - Dado q el    `id`    es una property directa del       #message      q estamos iterando, mustache va a encontrar esta variable
      - Si NO fuera asi, en el render deberiamos pasarle esta variable a este template

		- -- Aqui la logica es pasarle el     id     x param para q en la Page del Form se aplique la logica respectiva
  		



	- -- Implementamos la logica para el    EDIT    en el    `edit.php`     del  root plugin
  	- Si viene el    url param    del id, cargar la data y tal propio del mvc
  	- Obtener cualquier param q viene x url: 		`optional_param()`
    	- Este method requiere el    'paramName`   <-  tal como viene x url
    	- default value, q si NO lo queremos es      null
    	- type: PARAM_INT
  	- Esto lo hacemos en este, xq aqui tenemos acceso a la data q viene del Form
		

		- -- Creamos el method    `get_message`    en el    `manager.php`
			- Este method traera el message from DB, y ya moodle se encarga de instanciarlo como objeto
  			- Asi ya lo tenemos como Obje, con lo cual podemos Setearlo a ese Input en el   	`edit.php` del root del plugin
					`$mform->set_data($message);`
		 		- moodle se encargara de setearlo en los inputs correspondientes
			
		
		- -- Procedemos al     `edit.php`    del    /classes/form
  		- Aqui, vamos a implementar la logica q nos permitira hacer CREATE/UPDATE en el edit.php del root 
  		- Como en MVC, necesitamos 1    input hidden    para pasar id al 'controller'
  			- Por esto aqui tb lo creamos, y le damos    'id'
    			- Xq Asi esta en DB, en esta tabla exclusiva pal plugin
    			- Como asi esta en DB, Moodle, en Auto lo llena
      			- Si le dieramos otro nombre como    'ids'    NO se llenaria en auto xq NO existe esa columna en DB

					```php
						$mform->addElement('hidden', 'id'); // to edit in mvc
						$mform->setType('id', PARAM_INT);
					```


	- -- Implementamos la logica en el     `edit.php`     del root, xq aqui es donde se maneja el submit del form, acuerdate papu
		- Ahora si, dado q el    form    nos esta pasando el    `id`     en el      input hidden
			- Podemos tomar ese id y aplicar la logica del     CREATE/UPDATE

		- -- Edit
  		- Verificamos con 1    ifazo    si el form nos envia el    'id'    
    		- Si viene el id, es xq el form lo encontro en DB, x tanto lo coloco en el input hidden, con lo cual, si lo encontro en DB, es xq ya existe ese registro, y como ya existe pues es q queremos Editar

				- -- Creamos el method     `update_message()`     en el     `manager.php`
  				- Q va a hacer el     `update_record`     para actualizar el registro
    				- Como usamos el    stdClass   para Construir el Object q se va a Persistir, pues al method    update_record   le pasamos todo el objeto y el ya toma el     id     y el resto del body para poderlo actualizar















# Delete Messages
## Intro
- --- Vamos a hacer el   Delete   de messages utilizando   JS
  - Vamos a hacer una peticion con fetch, para eliminar el mensaje a nuestro back con moodle



## Create delete message button
- --- En el template      `manage.mustache`      creamos el btn con las clases de bootstrap
  - Es man agrega 1 class con el ID del btn, para saber cual eliminar
    - Podriamos crear simplemente 1      data-attribute     para identificarlo
		- Asi luego lo recuperamos facil con js





## Create JS file
- --- We're going to inject some js in this page

	- -- En el     `manage.php`     del  root del plugin
  	- Vamos a llamar JS con el obj    $PAGE
    	- Simplemente damos el path al js:
			`$PAGE->requires->js_call_amd('local_message/confirm');`
  	

	- -- Los archivos JS generalmente van en el      `/amd/src`      del plugin
  	- Se usa 1 runner para crear los compilados
    	- Moodle utiliza    grunt:
      	- Para generarlos debemos estar en el plugin:
				`		grunt amd --force`
				`		grunt amd watch --force`


			-- URL:
				- JS Modules:			https://moodledev.io/docs/guides/javascript/modules






## Grunt y JS
- --- Se instala Grunt cli para solo ejecutar     `grunt amd --force`     en lugar de hacerlo con el npx de toda la vida
  - Debemos usar    `nvm`    para W con la version de Node q nos exige grunt
	- Los logs NO se W con el    console.log    de js, sino q usa un    `Y.log()`


	- Usa    JQuery    en nuestros archivos JS de moodle   (/amd/src)

			https://moodledev.io/docs/guides/javascript/jquery#as-a-dependency-of-a-module






## Creating a modal window to confirm defiting a message
- --- Moodle ya nos cubre con esto, podemos usar el    moodle/modal_factory    para crear modals en moodle
  - Usaremos esto y crearemos el modal para Confirmar el Delete del Message
  - El   `trigger`   aqui en los modals es el Disparador, quien va a disparar la Apertura del Modal. Hacemos a referencia a ese elemento en el HTML
    - Para esto usamos   JQuery   para acceder a ese elemento en el DOM
	- Ya con el trigger usamos el    `ModalFactory`    para crear el Modal
  	- `preShowCallback`     nos permite ejecutar acciones previas a mostrarse el modal
    	- En este caso lo ocupamos para obtener el ID del message q vamos a eliminar
    	- Ese men le hace mas complicado con una clase de CSS, pero yo mero le mete en un    data attribute     y asi solo acceder a este id de forma mas simple
      	- Si seleccionamos el elemento HTML con  JQuery, este va a ser de 1 tipo especial de jquery, x tanto NO puedo usar cosas de JS como si fuese 1 elemento normal accedido con JS.




			-- URL:
				- Modal			https://docs.moodle.org/dev/AMD_Modal






## Creating an external function
- --- En Moodle lo referente a llamadas     AJAX    es denominado     External Function
  - Estos      services      se crean en el dir    /db     en      services.php

  
	- -- Creamos el       `services.php`      en    /db
  	- Lo copiamos de la nueva doc y lo adaptamos a nuestras necesidades
    	- El nombre de la function debe tener como sufijo:    `_create_groups`
    	- classpath: Path del file q contiene la Class external
      	- No es necesario si se usan     Namespaces    auto-loading classes
    	- ajax: true		<- si es True, permitira las peticiones desde el JS de Moodle
      	- Si es     false     solo permite el acceso Externo


	- -- Creamos el      `externallib.php`      en el root del plugin
  	- Si usamos namespace, en el      services.php     NO colocamos el path
  	- Este     externallib.php       requiere 3 methods
    	- params q recibe
    	- lo q retorna
    	- la implementacion de esta    external fn
		- 

				https://moodledev.io/docs/apis/subsystems/external/writing-a-service#write-the-external-function-descriptions


		- _returns()
			https://moodledev.io/docs/apis/subsystems/external/writing-a-service#execute_returns

		- La fn en si
			https://moodledev.io/docs/apis/subsystems/external/writing-a-service#implement-the-external-function



			-- URL:
				- Adding a web service to a plugin
						https://moodledev.io/docs/apis/subsystems/external/writing-a-service
				- Web Services API Functions: Fn propias de Moodle
						https://docs.moodle.org/dev/Web_service_API_functions







## Use external functions in AJAX Call
- --- s



























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













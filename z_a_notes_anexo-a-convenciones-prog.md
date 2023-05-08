# Anexo A: convenciones de programación para Moodle

## Las sangrías y el manejo de las líneas muy largas en la codificación de Moodle
- --- Moodle tiene su propio estilo de codificacion
	- Se utilizara etiquetas php largas
		- No usar el tag de cierre de php
	- Para la    indentation   usar 4 SPACES el lugar del tab, espacioes como en python
	- Usar 1 IDE propio de PHP para programar con Moodle
	- Estas  guide lines   vienen tb del   `PSR-12`
	- Maximun Line Length: Apuntar a   132char   y nunca >180
	- Concatenar con el punto   .

	- -- Para condicionales con mucho code, moodle recomienda Crear Variables
		- No tener 1 ifazo larguisimo con muchos saltos de linea dentro del if()
		- Sino que crear variables independientes para estas condicionales y esas variables usarlas en el ifazo

```php
$iscourseorcategoryitem = ($element['object']->is_course_item() || $element['object']->is_category_item());
$usesscaleorvalue = in_array($element['object']->gradetype, [GRADE_TYPE_SCALE, GRADE_TYPE_VALUE]);

if ($iscourseorcategoryitem && $usesscaleorvalue) {
    // This makes the conditions easier to review and understand.
}
```

	- Identar las implementaciones/herencia de 1 clase si son muchas con 2ble identacion para q se distinga del body
	- Priorizar la legibilidad del codigo


		-- URL:
			- Coding Style:		https://moodledev.io/general/development/policies/codingstyle








## Convenciones de nomenclatur
- --- 
	- Nombrar files
		- english | lower case | separadas x underscores  _  |  lo mas corto posible
	- Classes
		- english | lower case | underscores
		- Instanciar clases con el  ()  incluso si el constructor No necesita params
	- Las inserciones en DB deben seguir el standar de PHP con el    stdClass()
		- X eso es q se debe construir tipo obje todo lo q se va a insertar en la tabla de interes
	- Fuciones y methods
		- Frankenstyle | english | Verbose (nombres claros aunq largos)
		- Params:
			- Si no esta determinaod el datatype, colocar null en lugar de false
			- Si es boolean, si usar false
	- Variables
		- No usar el   _   sino q nombrarlas junto en minus y sin _
			- Evitar usar terminos negativos para nombrar variables, asi la logica se facilita
			- Usar logica con variables positivas
	- Usar las variables globales:
		- $CFG, $SESSION, $USER, $COURSE, $SITE, $PAGE, $DB, $THEME
	- Las   constantes   deben seguir el     Frankenstyle    (underscores)


		-- URL
			- Naming conventions:		https://moodledev.io/general/development/policies/codingstyle#naming-conventions
			- Namespace:				https://moodledev.io/general/development/policies/codingstyle#namespaces
			- Automatic class loading:		https://docs.moodle.org/dev/Automatic_class_loading
			- Frankenstyle:				https://moodledev.io/general/development/policies/codingstyle/frankenstyle
			- Activity Modules:		https://moodledev.io/docs/apis/plugintypes/mod
			- Development Policies:	https://moodledev.io/general/development/policies





## Manejo de cadenas y cadenas de idioma
- --- Mejor es la legibilidad q hacer cosas complejas
	- Siempre usar cadenas simples ('')
		- Deshabilitar Variables Embebidas para Evitar Code Injection ????
	- Para SQL complejas usar  Doubel Quotes  ("")
	- Sustitucion de Variables
		- No la directa, sino con {} para poder evitar el code injection
	- Concatenacion de strings con el punto    (  .  )
	- Cadenas de Idiomas
		- Mayus solo en el la 1ra letra
		- Para multilenguaje usar el    get_string()   del String API


			-- URL:
				- Strigns:		https://moodledev.io/general/development/policies/codingstyle#strings





## Arrays
- --- 
	- Crear arrays con el   []   y no instanciarlo
	- Las classes propias deben ir en su propio dir    /classes
		- Con su respectivo   namespace
	- Cada archivo debe tener 1 sola  Class/Interface
	- PHPDoc para la documentacion







## Uso de funciones, métodos y sentencias de control
- --- 
	- Methods deben especificar su   Accesibilidad    public/private, etc
	- El   return   debe ser de 1 solo element
		- Si se requiere retornar mas cosas, hacerlo en 1 obj
	- No usar los methods propios del php q inician con doble underscore   __call()   y demas
	- ifazos con llaves, aunq sea solo 1 linea
		- espacion de los parentesis
	- Operador Ternario q sea entendible




- -- Todo archivo debe tener la Licencia del GNU y el PHPDoc
	- Todas las   Classes   deben tener su documentacion con el    PHPDoc
		- Las properties tb deben tener su PHPDoc con   @var
		- C/properti debe tener su bloque de doc

















# Anexo B: El uso de las APIs de programación
## Las variables globales
- --- Accedemos a ellas con    global
	- CFG (configuracion) | $SESSION | $USER | $SITE
	- Se define en el archivo    `lib/setup.php`
		- Moodle recomienda NO crear nuestras propias







## Módulo de curso o Course module
- --- Lo encontraremos como   `cm`    q representa c/actividad q tenemos dentro del curso
	- Contiene info sobre q course y section se muestras, la actividad/recursos, asi como detalles sobre la visibilidad, grupo y estado de finalizacion de la antivity
	- La data de este modulo esta en DB en la tabla    `mdl_course_modules`
		- Nos enlaza a otras tablas como el   `mdl_course`  q tendra info del course q se esta consultando





## El cmid (ID del módulo del curso)
- --- El cmid (Id del Modulo del curso) se usa para identificar 1 actividad/recurso especifico
	- Cuando se vincula 1 script de modulos view.php, se pasa como el parametro 'id'
	- Tb nos ayuda a traer el  Contexto  para el modulo
		- Usado para verificar las capacidades del usuario o vincular archivos a 1 actividad a traves de la llamana de la fn      `context_module::instancia($cmid)`
		
	- Usado junto con el    require_login()  y la configuracion del   $PAGE
	- 4 lineas siempre en todos los  	`mod`

			https://moodledev.io/docs/apis/plugintypes/mod
			https://docs.moodle.org/dev/Page_API



## La API Page
- --- Controla el aspecto de cada page de moodle
	- En las   view.php   usa 4 lineas con el   $cmid
	- Page se encarga de configurar la page

			- PAGE API:		https://docs.moodle.org/dev/Page_API





## OUTPU API
- --- Output se encarga de despelegar la pagina o imprimimos con un   echo   de php
	- Page nos sirve para configurar la page
	- Output nos sirve para la salida/imprimir






## API FILE
- --- To control de upload/store files with moodle
	- Todos los archivos se almacenan en una DB central y es accesible a traves de la  FILE API  de moodle, y cada archivo esta asociado a un   componente y area de archivo   en especial
		- Como un modulo en particular
		- Importante el    Area de Archivo
	- Hay 3 elementos de formulario relacionados con archivos para interactuar con los usuarios
		- filemanager: adjuntar 1 0 + archivos en conjunto
		- editor: Editor html para el manejo de imagenes y archivos
		- `filepicker`: Es el q mas se utiliza para w con archivos
	- Obtener el contenido del archivo iguaol con el    `$mform`
		- get_file_content
		- get_new_filename('userfile')    para traer el filename
		- Para    save    del file usamos el     moodledata    para almacenarlo
	- Podemos configurar los criterios de aceptacion del file
		- file type
		- size / maxbytes
		- files aceptados x su formato/tipo



				https://moodledev.io/docs/apis/subsystems/files









## Dire   /db
- --- Podemos agregar algunos archivos:
	- access.php: Definimos las capacidades q creara el plugin
		- Establecer permisos y demas
		- Si llegamos a modificar este file, o las capacidades para este plugin, debemos hacer la modificacion del numeor de version para q lo tenga en cuenta moodle.
	- events.php:	Son como los    listeners    de JS.
		- Los los observadores o listeners
	- install.xml:	Define las tablas de la DB asociada al plugin, y se utiliza en la instalacion del plugin
		- Es la definicion de las tablas con este formato XMLDB
	- upgrade.php:	Maneja la actualizacion del modulo para q coincida con la ultima version
		- Igual, debemos modificar la version para q moodle lo tome en cuenta
	- mobile.php:		Para algo en mobile







## Otras carpetas y archivos
- --- Otros files/dirs
	-- /lang:			guarda las strings para el multi idioma
	-- /pix:			para las imagenes dle plugin
	-- /lib.php:	Van Hooks de moodle, y overrides q queramos implementar
		-  __delete_instance:	para ejecutar procesos luego de desisntalar el plugin
	-- index.php:	moodle utiliza esta pagina cuando enumera todas las instancias de su modulo q estan en 1 curso en particular con la identificacion del curso q se pasa a este script
	-- view.php:	cuando 1 curso muestra el disenio de pagina y sus actividades, genera los enlaces para velros usando el script





## Las notificaciones en Moodle
- --- Notificaciones pertenecen a    Notification API de Module
	- Permite w con las notificaciones
	- redirect()		redirecciones en el front
		- Con esto se usan las notificaciones atachadas a 1 redirect, q es el uso principal en MVC
	- Funciones auxiliares son las q los invocan SIN el redirect()
	







## El API de eventos: Introducción
- --- Los eventos son utilziados en plugins mas complejos
	- Es muy utili para cuando se W con   Acitividades y Recursos
	- Moodle proporciona el   Events API   q se puede agregar a 1 plugin, x lo q podemos crear eventos personalizados dentro de 1 plugin, y 1 vez q se activa el evento, se generara 1 Notificacion

	- -- Flujo de eventos
		- Evento  --Event Object-->  Sistema de registro (logging system)  --EventObject--> Lister/Observer
		- Debemos   subscriber   al evento de interes

	- -- Los   Eventos   son piezas atomicas de informacion q describen algo q sucedio en moodle
		- Los eventos son principalmente los resultados de acciones del usuario
			- pero tb pueden ser el resultado de procesos del   CRON JOB   o acciones de admin realizadas a traves de la linea de comando  (CLI)
		- El    Sistema de Eventos   difunde/emite la info de ese evento a los Observadores Registrados a ese evento
		- Canal de comunicacion unidireccional en donde los observers suscritos solo pueden reaccionar al evento y NO modificarlos
		- Todos los eventos debe poder registrarse y todas las entradas de registro actuales deben activarse como eventos
		- El sistema de registro (loggin system) es 1 observador de eventos, escucha todos los eventos y los dirige a los complementos de almacenamiento de registro d manera controlable
			- Escucha todos los eventos, es el arbitro
		- Nos podemos subscribir a todos los eventos  (*), pero NO es ideal hacer eso
		- Todo va a buffer y va a estar cacheado, para q sea mas rapido
		- Hay prioridad de Observadores
		- Hay eventos anidados


				https://docs.moodle.org/dev/Events_API







## El API de eventos: Observadores y eventos
- --- Cada plugin define los eventos q puede informar (desencadenar) al extender 1 clase basa abstract x cada evento
	- Eventos dentro de la clase    event.php
		- Establecemos los eventos propios de nuestro plugin


				https://docs.moodle.org/dev/Events_API





## El API de eventos: Disparo de eventos
- --- Desencadenar/Disparar Eventos
	- Todas las definiciones de eventos con classes q amplian las clase  \core\event\base
	- Los eventos se activan creando 1 nueva instancia del evento de clase y ejecutando   $event->trigger()
	- El nombre de la clase de evento es 1 identificador unico de c/evento
		- El nombre de la clase del evento termina con 1 verbo q describe la accion q lo disparo
	- `$event->trigger()`: dispara/emite el evento
		- Entonces ya podran reaccionar los subscribers ante este evento

				https://docs.moodle.org/dev/Events_API







## El API de eventos: Uso de la carga automática de PHP
- --- Las classes van en el dir     /classes
	- La info contenida en Eventos
		- Aqui debemos cargar toda la info q queremos q contenga nuestro evento
		- Tiene operaciones CRUD
		- Level: nivel de acceso al evento





## El API de eventos: Métodos de los eventos
- --- 







## El API de eventos: Almacenamiento en caché de registros
- --- Las snapshots van a ser usadas por los observadores, no por las actividades y demas
	- Todo lo referencte al caching de estos eventos para q todo sea mas eficiente
	





## El API de eventos: Nomenclatura de eventos
- --- Los eventos estan con   frankenstyle
	- El verbo en pasado     _created      
	- Usar el  PHPDoc
		- @since: desde q version de moodle se incluyo el evento
	-





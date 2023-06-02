# Intro moodle

## Moodle overview 1/5  Explaining the different parts of a moodle installation
- --- Environment de Moodle
	- -- Server
		-- Moodle Source Code
			- From GitHub repo
		-- Moodle config.php file
			- Tells Moodle the DB username/password and other environment details
			- Esta en el   /root   d moodle
		-- Moodle Sitedata folder
			- where moodle can write files (cashing, user uploads, config)
		-- PHP and libraries
			- != classes and functions sitting in a separate forlder in the siteroot
		-- Apache/Nginx
			- Ambos pueden ser usados para procesar las request
			- Receives and processes web requests, part of a request may be reading/writing to db

	- -- DB
		- PostgreSQL/MySQL
			- Hold data in sql tables
		- DB user that can read/write
			-	A db user that has the correct permissions to make changes
				- Estas credenciales son las mismas q se guardan en el     `confing.php`

		-- URL del      config.php
				https://docs.moodle.org/all/es/config.php







## Moodle overview 2/5 - Explaining the overall folder and plugin structure
- --- Antes de ver code, vamos a realizar 1 overview del diorectory tree d moodle
	- Los plugins necesitan obligatorio el      version.php    y     	lang/
		- db/
			- Se configura a travez de 1     XML     q tiene info de las tablas, columnas, filas, etc
	- Los plugins siguen una estrcutura similar, tiene los    `common files`
	- De esta manera es como   moodle   modulariza todo

			-- URL
				- Commom files - Plugins
						https://moodledev.io/docs/apis/commonfiles


	- -- 1 de las cosas FUNDAMENTALES de Moodle es  `/lib`
		- Contiene todas las    moodle functions   q nos provee moodle y podran ser utilizadas desde cualquier parte del codigo

			-- URL lib: https://moodledev.io/docs/apis/commonfiles#libphp


	- -- `/admin/cli`
		- Contiene varios scripts del CLI q nos provee Moodle
			- Los podemos ejecutar desde la terminal tranquilamente
		- Podemos hacer cambios directamente en DB, pero como Moodle cachea todo, pues los cambios No se veran reflejados en el front amenos q se ejecute un      purgue cache   
			- NOO realizar cambios directamente desde la DB xq perderiamos mucho del comportamiento que maneja moodle al hacer un cambio desde la interfaz
				- X ejemplo, si se realiza 1 cambio desde la interfaz grafica, behind the scenes suceden muchas cosas q afectan a varias tablas

		-- Todo tipo de cambios deben ser mediante interaccion con el   front   para q se dispare todo el comportamiento q tiene x detras de escenas








## Moodle overview 4/5 - How to add a setting to the core moodle html block (and why you shouldn't)
- --- Simplemente nos basamos en lo ya establecido, usamos las clases y fn provistas x moodle
	- Estas setearan los  styles  porpios dle theme y demas

	- -- Modificamos el     '/home/adrian/adserver/www/campus/blocks/html/settings.php'
		- Agregandole el checkbox para 1       `settings.php`       adicional q agregamos
			- Este ya se crea como row en la     DB     establecida para ese plugin tipo Block en este caso
				- Q esta en la tabla    `mdl_config`   y como le dimos el name     "block_html_testsetting"     pues con ese name se guarda en la tabla

			```php
				<?php
						// // //  esto es el boilder plai, q se agrega a todo archivo: Licencia y PHPDocs
						// This file is part of Moodle - http://moodle.org/
						//
						// Moodle is free software: you can redistribute it and/or modify
						// it under the terms of the GNU General Public License as published by
						// the Free Software Foundation, either version 3 of the License, or
						// (at your option) any later version.
						//
						// Moodle is distributed in the hope that it will be useful,
						// but WITHOUT ANY WARRANTY; without even the implied warranty of
						// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
						// GNU General Public License for more details.
						//
						// You should have received a copy of the GNU General Public License
						// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

						/**
						* Settings for the HTML block
						*
						* @copyright 2012 Aaron Barnes
						* @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
						* @package   block_html
						*/

						defined('MOODLE_INTERNAL') || die;

						if ($ADMIN->fulltree) {
								$settings->add(new admin_setting_configcheckbox('block_html_allowcssclasses', get_string('allowadditionalcssclasses', 'block_html'),
																	get_string('configallowadditionalcssclasses', 'block_html'), 0));

								// Este es el q agregamos al plugin tipo Block de HTML q en la nueva version de Moodle se renombro el tag a Text, pero en filesystem sigue siendo   /blocks/html
								$settings->add(new admin_setting_configcheckbox('block_html_testsetting', 'Some subtitle',
										'Some description', 0));

						}
			```


	- -- Cabe recalcar q esto NOO se debe hacer xq estamos Modificando el     Core de Moodle
		- Al hacer esot, perdemos soporte a los update xq se van a generar conflictos de merge
		- Lo q se busca priorizar es   Extender  la funcionalidad de Moodle, pero NOOO modificar el core del mismo








## Moodle overview 5/5 - How to customise a lang string through the front end UI without changing 
- --- Como se establecio en las clases pasadas, NOO debemos modificar el core de Moodle, en cambio debemos extender las funcionalidades a travez de nuevos plugins o modificaciones directamente desde la interfaz del moodle, o el front.
	- Si es cambios de texto de algun plugin se puede hacer desde el front
		- En este ejemplo va a: Site Admin > Language > Language customisation > Edit language pack
			- Selecciona el idioma de interes y procede buscar x el identificador lo q quiere modificar
				- Una vez lo enconetra, procede con el cambio
					- De esta forma no cambia el codigo core de moodle, y se evita hacer push y generar conflictos al actualizar





















# Block plugins

## Moodle developer tutorial 1/5 - Creating a new moodle block plugin initial skeleton/boilerplate code 
- --- Ahora q tenemos > perspectiva, vamos a comenzar con 1 plugin tipo bloque
	- -- Si se va	a crear 1 plugin tipo bloque se lo crea en      `/block`
		- Como todo plugin en Moodle, necesita una cantidad minima de archivos para funcionar como plugin
			- Pero como es     block    necesita estos como requeridos:
				- version.php
				- block_name.php:		La main class del plugin q    EXTENDS    del     `block_base`
					- El propio q tiene el nomrbe del plugin
				- capabilities: 		Relacionado con los permisos. Capability 1 permiso, Role varios permisos
					- Lo creamos en     '/db'    del plugin


	- -- Hasta este punto NO le hemos dicho a Moodle sobre el plugin, asi q NO se ha agregado nada en DB
		- Si hacemos refresh de moodel, ahi nos indicara q tenemos 1 plugin a la espera de su instalacion a traves del front
			- Para q se instale debemos hacer click sobre    'Upgrade Moodle database now'
		
		- Al hacer click en ese boton moodle sabra q debera crear 1 nuevo     block    en DB
			- X tanto, modificara la tabla de blocks     `mdl_block`
				-	A 1ra instancia podemos ver q una instalacion limpia de mooodle presenta 43 bloques en la tabla    "mdl_block"
					- Tras presionar en     Upgrade Moodle db     para instalar el plugin tipo block q creamos, podremos ver como se actualiza esta tabala y agrega lo referente al plugin tipo bloque creado
						- Al instalarse correctamente, como es 1 tipo bloque podemos crearlo en el    "my/othersite"
						- Tras la instalacion, se modifica la tabla agregando 1    ROW    para este plugin tipo Bloque
							- Se agrego:    `testblock`    en la tabla      `mdl_block`
					- Tb agrega la row en la tabal     `testblock`



		-- URL
			- Block: 					https://moodledev.io/docs/apis/plugintypes/blocks
			- Capabilities:		https://moodledev.io/docs/apis/plugintypes/blocks#dbaccessphp
				- Access API:		https://moodledev.io/docs/apis/subsystems/access
				- Roles:				https://moodledev.io/docs/apis/subsystems/roles









## Moodle developer tutorial 2/5 - Explaining what the MOODLE_INTERNAL || die code is doing
- --- Esta funcionalidad nos permite controlar el acceso al file desde afuera
	- X ejemplo, si agregamos esta linea, NO nos permite acceder a ella a traves de 1 url
	- Ahora bien, paginas como el     index.php    q SI necesitan ser accedidas desde 1 url, NOOO van a tener esa linea de codigo ya q SI queremos que sean accesibles desde afuera
		- x ejemplo el     /my/index.php    q es publico para acceder x url 

		`defined('MOODLE_INTERNAL') || die();`









## Moodle developer tutorial 3/5 - How to create a test course automatically so we get dummy content 
- --- Podemos crear cursos x xdefecto desde Moodle para tener    dummy content
	- Vamos a     Site Admin > Development > Make Test Course > Seleccionamos el Size > Proveemos 1 name  y lo creamos
	- Como son acciones que estamos generando desde el Front, pues dado q usamos       Rsync     deberemos hacer el    sync    mediante terminal
		- Para esto solo exponemos el path
		- Ejecutamos       `rsync.adserver www/campus`
			- Es el     campus     xq estamso W sobre ese









## Moodle developer tutorial 4/5 - Fetch list of users from the database and display that in our block 
- --- Queremos hacer q el bloque sea dinamico y se traiga 1 lista de users, x ejemplo.
	- -- Fetch something from DB
		- Debemos usar la variable globar     `$DB`
			- Es la interfaz entre nuestro code con la db
		- Gracias a estos Objetos globales podemos acceder facilmente a db con Moodle







## Moodle developer tutorial 5/5 - adding a SETTING to our new block and use that in the code
- --- Traemos los     courses   de db

	- -- Creamos los    settings    q nos permitan hacer el switch entre courses/users en el block q creamos
		- -- Creamos el      `settings.php`      en el root del plugin
			- Cada vez q moodle hace load de cada page, carga los      settings.php      files
				- Load all plugins into the   admin tree
			- En este archivo 1ro verificamos si se esta haciendo el    display    del admin menu, xq solo si se muestra el admin menu quiero q se vea estos settings 


	- -- Debemos agregar 1 method en     `block_testblock .php`     para q moodle verifique si este plugin tiene las   settings   a ser configuradas, y eso se hace con el       `hasConfig()`
		- En este     hasConfig()    retornamos TRUE xq SI tenemos un    setting.php   para este plugin
		- Ahora sigamos adelante y verificquemos esa config en el    get_content()

		- De esta manera tenemos en el   Site Admin > Plugins > Blocks > Test Block Plugin Name
			- Aqui ya tenemos el checkbox de la config q establecimos para este plugoin de bloque


			-- URL:
				- settings.php:			https://docs.moodle.org/dev/Plugin_files#settings.php











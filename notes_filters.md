# Desarrollo de filtros

## Las carpetas y archivos basicos de 1 filtro
- --- Los   filters    son otro tipo de Plugin en Moodle q se los crea en     /filter
  - Sus archivos Obligatorios/Required son:   `filter.php, version.php, /lang`
	- El dir del filtro debe llevar el nombre recomendado x moodle, todo english, sin mayus


	- --- Para crear nuestro 1r    Filter    debemos crear su dir en   /filter    con sus required files
  	- Creamos los 2 archivos basicos:
    	- version.php
    	- /lang
		- Dejando el     filter.php     para el prox video


		-- URL:
			- Filter Plugins:			https://moodledev.io/docs/apis/plugintypes/filter
			- Output API:					https://moodledev.io/docs/apis/subsystems/output







## Filtro: el archivo filter.php
- --- Nos falta el 1    Required File    de este tipo de plugins, q es el filter.php
  - La Logica de Programacion principal de los filtros se encuentra en el archivo    filter.php
  - Debemos Crear 1    Class    con notacion Frankenstyle, extendido de la classe     moodle_text_filter
  - Despues de hacer la instalacion, debemos Activar el filtro


	- -- Creamos el     `filter.php`     en el root del plugin
  	- Esta classe extiende de    moodle_text_filter
  	- Tiene 1 method      filter()     q retorna el modified text


		-- URL:
			- FIlter Plugin:		https://moodledev.io/docs/apis/plugintypes/filter







## Filtro: parámetros generale
- --- Vamos a agregar 1 param genera a nuestro filtro, x eso usaremos el     setting.php
  - Esto como siempre, lo vamos a conseguir gracias al      `settings.php`
  - Como es 1 plugin tipo filter/block/theme estos tiene YA configurado el    $settings   y tiene acceso al    admin_tree, ademas q tb pueden tener Parametros Locales
    - Asi q NO tenemos q configurarlo manualmente como con los    local plugin

  - En este punto, ya tenemos este param/condig/setting para q pueda ser accedido desde el site admin
    - Como siempre, estos params se guardan en DB como 1 row q toma el valor del    $settings->add()    para asignarselo a esa row
      - Ese valor se almacena en esa nueva row en la tabla     `mdl_config`   

	- Como ya se almacena en DB este value del param del setting, pues podemos leerlo en donde queramos e implementar Logica con el







## Filtro: Usar el parámetro general
- --- Ahora q ya lo implementamos y esta en db, pues vamos a usarlo para implementar logica
  - Para acceder a este lo hacemos a traves del Obj   `$CFG`
  - Condicionamos la salida/output
	- Simplemente lo usamos en el    filter.php









## Filtro: parámetros locales
- --- A los filtros tb podemos agregarles parametros Locales, en los   Blocks   es muy caracteristico tener la opt para modificar estos local params
  - Con los filtros es raro usarlos, xq se w con Parametros Globales como acabamos de hacer
    - Pero si se require, tb se los puede crear en los filters
  - Podemos crear Parametros Locales creando el      filterlocalsettings.php      en la raiz de la carpeta del plugin
  - Debemos crear 1 clase con el nombre      mifiltro_filter_local_settings_form.php
  - La clase debe Extender de la clase       filter_local_settings_form
		- Dentro de esta clase debemos crear el methdos      definition_inner($msform)
		
	- -- Esto habilita el   settings   ese q configuramos para este plugin, ahora Localmente en el Course
  	- X eso, 1ro accedemos a 1 course > More > Filters
    	- Y ya vemos q podemos acceder a settings
			- Esto nos abre el    settings.php   q configuramos
			- Pero lo aplica Localmente a este curso
		- Basicamente lo de los   global parmas   pero localmente para 1 course en especifico


			-- URL
				- Filters:
  				- extends filter_local_settings_form:			https://docs.moodle.org/dev/Filters







## Filtro: leer parámetros locales
- --- Al leer los parametros locales vamos a tener 1 peque problem de estrcutura x moodle
  - Estos   Local Params    se leen en el obj     $this->localconfig
    - El problema es q aveces si los lee, y otras no. X eso no se W mucho con filtros y local params
  - No se recomienda los locales x este tipo de bug q tiene moodle


	- print_object(): de utils, para poder imprimir algo en el front - logger trucho


		-- URL:
			- Filter Plugins
  			- $this->localconfig:			https://docs.moodle.org/dev/Filters








## Filtro Marcas: archivos básicos
- --- Vamos a Reemplazar alguna palabra con 1 Icon propio de Moodle    /pix/t
  - Creamos el dir de    /marcas    
    - Creamos el    filter.php
      - Q por el momento solo va a ser copy/paste de la doc
		- Creamos el    version.php
		- Creamos el    /lang
  		- Y asi tenemos lso 3   file required    q requiere como min un filter plugin para poder ser instalado








## Filtro Marcas: parámetros globales
- --- Como siempre, para parametros globales vamos a usar el       `settings.php`
  - Creamos el     setting.php
  - Necesitamos mas language packs
  - Todo con languales se almacena en la cache, asi q hay q purgarlo para ver cmabios

	- De nuevo, x ser 1 Plugin de Filtro, SI tiene configurado el   $settings  x defecto, ademas del admin_tree
  	- Establecemos los checkbox del      settings.php

	-- En este punto, ya tenemos los settings/checkbox de los global params q se almacenaran en DB en la tabla   `mdl_config`  en rows con el name q le demos al   $settings->add()
		- En este punto ya las almacenamos en db, asi q lo q sigue es leer estas global variables y escribir logica con respecto a ellas








## Filtro Marcas: Reemplazar las cadenas con los iconos
- --- Vamos a Leer los Global Params para poder reemplazar x icons
	- Para leer estas  global params  usaremos el    `$CFG`
	- Reemplazamos con la logica de PHP en el      filter.php
  	- Simplemente como simpre el   ifazo   para validar q NO este empty la variable global
    	- Traemos el icono propio de Moodle con la    `moodle_url`
    	- Construimos el HTML como lo recomienda Moodle, con el     `html_writer::tag()`
    	- modificamos el  $text   con el   str_replace   de php









## Filtro Imágenes: Copiar los archivos de otro filtro
- --- Vamos a crear 1 Plugin Basandonos en otro q ya existe, esto es 1 practica muy comun
  - Vamos a hacer 1 copia de    /dir    y renombrarlo al nombre del nuevo plugin
  - cambiar el name en   version.php y settings.php
  - Cambiar el archivo de cadenas de idiomas y el nombre del filtro


	- -- Copiamos el de   marcas   y lo renombramos por    imagenes
  	- Las imagenes van dentro del plugin dir, y deben ir en el     `/pix`
			- pix es 1 estandar








## Filtro Imágenes: Crear los parámetros del nuevo filtro
- --- Modificamos lo copiado para implementar la funcionalidad
  - Necesitamos reutilizar el codigo copiado (refactoring o refactorizar)











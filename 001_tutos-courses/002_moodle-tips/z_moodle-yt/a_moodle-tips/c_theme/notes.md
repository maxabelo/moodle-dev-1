# Moodle theme tutoria

## Create a child theme based off boost
- --- Vamos a crear 1 child theme
	- A la altura de    /boost   creamos nuestro child theme
	

	- --- Creamos el    `/adrian`   dir de nuestro theme
  	- Creamos el    version.php,   /lang,    /pix
    	- /pix contendra el favicon y demas necesario para el theme, copie del  boot
  	- Creamos el    lib.php
  	- Creamos el    config.php
    	- Es uno de los mas importantes, con este file ya podmos probarlo
    	- Aqui es Importante especificar el      parent theme     del q extiende


	- --- Como 1 theme es otro tipo de plugin, simplemente se instala como siempre
  	- Instalamos el theme
  	- Cambiamos el theme para usar el nuestro:
    	- Site Admin > Apparence > Theme > Theme selector
  	- Con esto ya estamos usando nuesto theme

		- -- Asi hemos creamos el skeleton de nuestro child theme




		-- URL:
			- Creating a theme based on boost:		https://docs.moodle.org/dev/Creating_a_theme_based_on_boost






## Creating settings page and custom scss files
- --- Vamos a crear la pagina de     settings    para nuestro theme
  - Debemos crear nuestro      `settings.php`      para NO usar los settings del padre, ya q si lo hacemos, estos van a cambiar cuando cambien los del padre en 1 update y tal.
    - Solo copiamos y pegamos lo de la doc

				https://docs.moodle.org/dev/Creating_a_theme_based_on_boost#Duplicate_the_settings_from_Boost



  - Para agregar CSS adicional a nuestro theme agregamos el     `$THEME->scss`    al    `config.php`
    - tb modificar el    lib.php


	- -- Necesitamos modificar el     `lib.php`     ya q en el skeleton lo teniamos vacio
  	- Le metemos la config q requiere    `theme_adrian_get_main_scss_content`
  	- Ademas, dado q queremos q Incluya Nuestro CSS, pues agregamos  el    pre, post
  		- Q son los archivos en nuestro dir del plugin de CSS


	- -- En el    /lang     dado q estamos usando el    settings.php   propio de nuestro theme (Lo RECOMENDADO)
  	- Debemos crear las   strings   en el lang q faltan
    	- Solo copie y peque de la documentacion

				https://docs.moodle.org/dev/Creating_a_theme_based_on_boost#Duplicate_the_settings_from_Boost


	- -- Creamos el      `settings.php`      
  	- Este simplemente fue 1 copy/paste de la doc
  

	- -- Creamos los   CSS
  	- Van en el dir     `/scss`     en el root del plugin
    	- Los files deben tener el Name q especifiquemos en el     `lib.php`    en la parte q incluye a los css nuestros
    	- Creamos el    	`post.scss`      
      	- Es util para dar los estilos css
			- Creamos el       `pre.scss`
  			- Q es bueno para establecer variables de Sass



		-- URL:
			- Creating a theme based on boost:		https://docs.moodle.org/dev/Creating_a_theme_based_on_boost
			- SETTINGS thel child theme:			https://docs.moodle.org/dev/Creating_a_theme_based_on_boost#Duplicate_the_settings_from_Boost










##  How to override a template in Moodle
- --- Recordar q el   theme    es quien tiene la ultima palabra de como va a lucir 1 page
  - Antes de Sobrescribir la forma de 1 Output/Cuadro, debemos Entender q es un     TEMPLATE
    - El template es la forma en q Moodle genera el HTML sin tener q mezclarlo con php
    - NO modificar el core de moodle, sino q   @Overrige   /  Sobrescribirlo   con un template

	



- --- OVERRIDE DEL TEMPLATE
    - Debemos buscar el template a reemplazar/sobrescribir, lo buscamos en el navegador, luego guiandonos por clases o id especiales
    - En este caso quiero Override de 1 mustache de       `/lib`        x lo canto en nuestro theme creamos:
      - `/templates`     y dentro de esto lo q queremos sobrescribir
        - Como viene de          lib            en nuestro theme, dentro de     template     se va a llamar        `/core`
          - X lo tanto, quedaria asi:       `/templates/core/name.mustache`
            - Y aqui Solo         Copiamos y Pegamos        ese contendi
              - Y ya solo lo sobrecribimos, modificamos y demas 



	- Se busca intensamente cual puede ser el    template    q tiene la funcionalidad q queremos alterar, en este caso con la update, moodle dejo eso en el    lib, x lo cual NO me funca
  	- Si esta en blocks y se llama    myoverview
    	- Simplemente copiamos ese   template   en nuestro plugins en:
      	- /templates/nameblock_origin/file.mustache


		-- URL:
			- Template: 		https://moodledev.io/docs/guides/templates











## how to override a RENDERER
- --- Vamos a ver como hacer   @Override    de  1 Renderer
	- En lugar de sobrescribir la Plantilla o Template, podemos sobrescribir su        `Renderer`        q se encarga de los calculos y de hacer    display   del content

	- 1 Renderer es 1        Class       q contiene toda la logica para desplegar en html
  	- Sus methods retornan html as string
  	- Pilas con el nombre de la clase del    renderer    con la q vamos a sobrescribir


		-- URL:
			- Override al   renderer:     https://docs.moodle.org/dev/Overriding_a_renderer






	- --- Render contiene toda la logica y estrcutura html a ser renderizada. Retornan html as string o directamente Mustache
    	- Localizamos el     Renderer      q queremos Override, y creamos el Override en nuestro Theme

    	- -- Creamos el      `renderers.php`       en el root del theme
        	- Colocamos el name del      renderer     al q vamos a hacer Override
            	- Pilas con el name para q funcione:  `theme_adrian_core_course_renderer`
			- Simplemente copiamos el method q queremos hacer      @Override     y le hacemos las modificaciones pertinentes
			- Esto dentro del mismo     renderer.php







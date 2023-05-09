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

				https://docs.moodle.org/dev/Creating_a_theme_based_on_boost#Duplicate_the_settings_from_Boost


  - Para agregar CSS adicional a nuestro theme agregamos el     `$THEME->scss`    al    `config.php`


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
			- Settings thel child theme:			https://docs.moodle.org/dev/Creating_a_theme_based_on_boost#Duplicate_the_settings_from_Boost














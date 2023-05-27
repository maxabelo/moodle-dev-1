# Block Plugin

- --- Todo plugin tipo bloque requiere     `3`     archivos obligatorios para poder ser instalado
  - version.php                       <-  root
  - lang/en/block_pluginname.php      <-  lang/language
  - block_pluginname.php              <-  root



      -- URL:
        - Common files
            https://moodledev.io/docs/apis/commonfiles
        - Block Plugins
            https://moodledev.io/docs/apis/plugintypes/blocks#block_pluginnamephp







- ---  `settings.php`
  - Establecer      settings     al plugin
    - Para q podamos setear configs q seran persistidas en DB
  - Importante, los plugins tipo         `local`      NO tienen configurado x defecto el 
    - Por eso es necesario el    ifazo    para validar el     '$hassiteconfig' y el admin tree
      - $settings
      - $ADMIN->fulltree




- --- `styles.css`
  - Este archivo va en el     root     del plugin
  - Debe llamarse asi y ya esta, moodle lo reconoce de inmediato
  - Asi damos estilos css a nuestros Plugins









- --- Multiple Instance
  - X default Moodle NOO permite el       instance_multiple      , ya q Solo permite agregar el block plugin 1 sola vez  en el       applicable_formats      q hayamos permitido
  - Pero, si agregamos este method en el       blocktype_pluginname.php      q esta en el root del plugin, avilitaremos la multiple instanciacion del plugin, o lo q es lo mismo, permitiremos tener +1 vez el plugin en el       applicable_formats      q hayamos habilitado
      `instance_allow_multiple()`






- --- How to use JS, CSS and Ajax
  - Existen 2 maneras de W con JS en un custom plugin de Moodle
    1. JS Module, q requiere el     `/amd/src`     y       `grunt`      para transpilar el code
       - Usa el     `$PAGE->requires->js_call_amd('local_message/confirm');`
        - Para llamar al js q se requiera
    2. Usar 1 dir    `/js`     en el root del plugin y crear ahi los JS
       - Necesita usar el
          `$PAGE->requires->js('/blocks/mycourselist/js/main.js', true);`
         - Para llamar al archivo, y el     true     para poder usar JQuery
       - NOOOO necesita del    grunt     para los transpilados
         - Solo escribes el JS y ya esta


      -- URL:
        - JS Module: JS va dentro de    /amd/src
          - Usa     grunt     para los transpilados
              https://moodledev.io/docs/guides/javascript/modules#es-modules




  - -- W con CSS
    - Podemos crear custom css files y require con esto:
      - NO necesita purgar cache
        `$PAGE->requires->css('/blocks/mycourselist/css/somecss.css');`

    - Podemos W con SCSS, con el   pre/post.css
      - Esto es mas usado en    THEMES
  

  - -- Aqui W con Ajax de una forma fea
    - Creo el    ajax.php    q retornaba lo q este man queria
      - A esto lo consume con AJAX desde el JS
      - Y eso lo renderiza
        - X eso el ajax.php retorna html con 1    echo
        - NO me gusto nada
























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































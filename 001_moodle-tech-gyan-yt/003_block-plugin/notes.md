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
















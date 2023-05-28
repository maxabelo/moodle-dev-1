# Arco Linux

- --- Aqui usa     `paru`     para AUR, en lugar de    yay
  - Ya viene x default el    paru
        `paru -S brave-bin pcmanfm bat exa fish python-pip`

    - Descargamos los dotfiles de antonio
      - Checkout a la rama de   Arco
        `git checkout arco`

    - Reemplazamos todo el config x el de los dotfiles
      - 1ro creamos 1 copia de seguridad de    .config    origina y el     .bashrc
      - Reemplazamos el config y .bashrc

    - Descargamos el  git-prompt.sh
        `curl https://raw.githubusercontent.com/git/git/master/contrib/completion/git-prompt.sh -o .git-prompt.sh`
        - La terminal es Alacritty
        - El  shell  es bash, q es el interprete de comandos
        - El   promt    es el promt :v, donde sale el user y demas

    - Creamos el     `.xprofile`     para q se ejecuten los mismos programas al arrancar
      - Asi se comparten para cada gestor de ventanas: openbox y qtile
      - Nos vamos al  openbox  dentro del   .config   para mover el autostart
        `cd`
        `cp backups/arco/.config/openbox/autostart ~/.xprofile`
    


    - Instalamos VSCODE con paru
        `paru -S visual-studio-code-bin --needed --noconfirm`
      - Abrimos el xprofile y autostar en vscode
        `cd`
        `code .xprofile .config/openbox/autostart`

    - Instalamos   udiskie   para los USB
        `sudo pacman -S udiskie`
    
    - Rofi: Ya viene instalado x default, asi q lo configuramos
        `cd Downloads`
        `git clone https://github.com/davatorium/rofi-themes`
        `cd rofi-themes`
        `./install.sh` > a > instala todo

      - Podemos cambiar el theme con:   `rofi-theme-selector`


    - NerdFonts
      - Descargamos las fuentes
        - UbuntuMono es la Obligatoria
      - Las instalamos:
        `mkdir ~/.local/share/fonts`
        `cd Downloads`
        `mv *.zip ~/.local/share/fonts`
        `cd ~/.local/share/fonts`
        `for file in $(ls); do unzip $file; done`


    


# Instalar Qtile
- --- Vamos a instalar Qtile
  - Install
    `sudo pacman -S qtile`

  - s














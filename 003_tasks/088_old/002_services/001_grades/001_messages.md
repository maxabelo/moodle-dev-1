### Conexión Inalámbrica

loadkeys es
rfkill list
rfkill unblock wifi
rfkill unblock wlan
iwctl
device list
station NOMBRE_DISPOSITIVO scan  # El nombre sale del comando anterior
station NOMBRE_DISPOSITIVO get-networks
station NOMBRE_DISPOSITIVO connect NOMBRE_ROUTER
exit
ping archlinux.org



-------------------------------------------
timedatectl set-ntp true




### Crear y formatear particiones (comandos usados en mi caso)

lsblk
cfdisk
mkfs.ext4 /dev/sda#
mkfs.ext4 /dev/sda#
mkswap /dev/sda#
swapon /dev/sda#
mount /dev/sda# /mnt
mkdir /mnt/home
mount /dev/sda# /mnt/home
mkdir /mnt/boot     						||    mkdir -p /mnt/boot/efi 
mount /dev/sda# /mnt/boot   		||  	/mnt/boot/efi




### Instalar sistema

pacstrap /mnt base linux linux-firmware base-devel efibootmgr os-prober networkmanager grub gvfs nano netctl wpa_supplicant dialog xf86-input-synaptics udisks2 ntfs-3g bash-completion

genfstab -U /mnt >> /mnt/etc/fstab




### Configurar sistema

arch-chroot /mnt
ln -sf /usr/share/zoneinfo/America/Guayaquil /etc/localtime
hwclock --systohc --utc
nano /etc/locale.gen  			<---	Buscar //en_US.UTF-8 UTF-8
locale-gen
echo "LANG=en_US.UTF-8" > /etc/locale.conf
echo "KEYMAP=en" > /etc/vconsole.conf
echo "wolf" > /etc/hostname


sed -i '/#NTP=/d' /etc/systemd/timesyncd.conf

sed -i 's/#Fallback//' /etc/systemd/timesyncd.conf

echo \"FallbackNTP=0.pool.ntp.org 1.pool.ntp.org 0.fr.pool.ntp.org\" >> /etc/systemd/timesyncd.conf

systemctl enable systemd-timesyncd.service


nano /etc/hosts
	127.0.0.1		localhost
	::1		    	localhost
	127.0.1.1		wolf.localhost wolf 		<---	myhostname.localdomain	myhostname

passwd
systemctl enable NetworkManager
grub-install --efi-directory=/boot/efi --bootlaoder-id='Arch Linux' --target=x86_64-efi

- Para que reconozca a windows: Agregamos al final   <-  GRUB_DISABLE_OS_PROBER=false
nano /etc/default/grub
		GRUB_DISABLE_OS_PROBER=false

grub-mkconfig -o /boot/grub/grub.cfg
os-prober
grub-mkconfig -o /boot/grub/grub.cfg
useradd -m USER
passwd USER
usermod -aG wheel,audio,video,storage USER
pacman -S sudo

nano /etc/sudoers
	- Descomentamos el %wheel que este despues del utlimo root <- Buscamos con: Ctrl + W en nano

exit
umount -R /mnt
reboot
# Sacar USB y arrancar PC




### Instalar Entorno de escritorio    <-    Qtile
sudo systemctl start NetworkManager.service
sudo systemctl enable NetworkManager.service


# Antes configurar router a solo 2.4Ghz
nmcli d wifi list
sudo nmcli d wifi connect NOMBRE password CONTRASEÑA
ping archlinux.org


sudo pacman -Syu xorg-server xorg-xinit xorg-xinput xf86-video-nouveau mesa mesa-libgl libvdpau-va-gl xf86-input-libinput python3 python-pip qtile lightdm lightdm-gtk-greeter alacritty zip unzip curl unrar git firefox opera opera-ffmpeg-codecs rofi lsd bat wget

sudo systemctl enable lightdm.service

[Optional]   sudo pacman -S ttf-ubuntu-font-family  noto-fonts ttf-dejavu ttf-liberation ttf-bitstream-vera


sudo pacman -Scc

reboot





==============================================================================================================================
### Apps
# Brillo y Luz nocturna
sudo pacman -S brightnessctl redshift

# Picom
sudo pacman -S picom feh


## AUR
sudo git clone https://aur.archlinux.org/yay-git.git
sudo chown -R adrian:adrian ./yay-git/
cd yay-git/
makepkg -si

yay -S nerd-fonts-ubuntu-mono ttf-ms-fonts visual-studio-code-bin google-chrome

sudo pacman -S xorg-xprop wmctrl
*Install Glassit Linux <- Vscode 
  - config - Glass: 90
  - settings.json :

    "workbench.colorCustomizations": {
    "[One Dark Pro]":  {
      "editor.background": "#1f1f1d"
    }
    }

[Optional]  yay -S micro


## Exa &  ccat
sudo pacman -S exa
yay -S ccat

yay -S zram-generator			<---	 Al final de todo




### Cambiar inicio de lightdm
sudo pacman -S lightdm-webkit2-greeter
sudo nano /etc/lightdm/lightdm.conf
#Cambiar: 
    greeter-session=lightdm-webkit2-greeter


## Cambiar theme de webkit2
yay -S lightdm-webkit-theme-aether




### Cambiar tema rofi
rofi-theme-selector
	- alt + a		<-	seleccionar


git clone https://github.com/davatorium/rofi-themes
- colonar dotfiles de Antonio Sarosi

cd rofi-themes/User\ Themes

sudo cp slate.rasi /usr/share/rofi/themes

rofi-theme-selector

sudo pacman -S papirus-icon-theme

cp -r  dotfiles/.config/rofi .config
->

#Cambiar tema:
nano .config/rofi/config.rasi
	- Font: 'UbuntuMono Nerd Font'
	- Theme: Slate




### Audio
sudo pacman -S pipewire-pulse pavucontrol
pipewire-pulse &




### xsession
- LO creamos en /home y pegamos lo que tiene ese Men
chmod u+x .xsession




#### Alacritty
Creamos la carpeta y el archivo de configuracion .yml




#### Icono volume

sudo pacman -S volumeicon

    - Se lo mete en el autostart de qtile / En la carpeta de qtile se crea el archivo: autostart.sh

chmod u+x autostart.sh




### USB
# Para ver el icono del USB

sudo pacman -S udiskie

udiskie -t




### Pantallas
sudo pacman -S arandr
    rofi > arandr




### Programas varios:
##  IMV para ver imagenes desde terminal:
sudo pacman -S imv

## Para hacer captura de pantalla
sudo pacman -S flameshot

## Gestores de Archivos
#Grafico
sudo pacman -S pcmanfm




### Temas de gtk
-Descargar - Descomprimir con unzip: 

# Temas
https://www.gnome-look.org/p/1316887/
sudo mv Material-Black-Blueberry/ /usr/share/themes/

# Iconos
https://www.gnome-look.org/p/1333360/
sudo mv Material-Black-Blueberry-Suru/ /usr/share/icons/


## Cursor
sudo pacman -S xcb-util-cursor

https://www.gnome-look.org/p/999927/

tar -xf 165371-Breeze.tar.gz

sudo mv Breeze/ /usr/share/icons/


## Aplicar themes - Programa grafico
sudo pacman -S lxappearance
	rofi > lxappearance



### Iconos Wifi y bateria
sudo pacman -S network-manager-applet


###Icono de bateria
sudo pacman -S cbatticon




### Libreria de notificaciones
sudo pacman -S  notification-daemon

sudo nano /usr/share/dbus-1/services/org.freedesktop.Notifications.service
####################   #############################   #####################
[D-BUS Service]
Name=org.freedesktop.Notifications
Exec=/usr/lib/notification-daemon-1.0/notification-daemon
####################   #############################   #####################

#
sudo pacman -S libnotify

notify-send Hello




### Despues de clonar
sudo pacman -S gcc
pip install psutil
pip install pipenv




### Zsh
https://www.youtube.com/watch?v=su0h5StEZ6A

sudo pacman -S zsh zsh-completions

sh -c "$(curl -fsSL https://raw.githubusercontent.com/robbyrussell/oh-my-zsh/master/tools/install.sh)"

git clone https://github.com/romkatv/powerlevel10k.git $ZSH_CUSTOM/themes/powerlevel10k


git clone https://github.com/zsh-users/zsh-autosuggestions.git $ZSH_CUSTOM/plugins/zsh-autosuggestions
git clone https://github.com/zsh-users/zsh-syntax-highlighting.git $ZSH_CUSTOM/plugins/zsh-syntax-highlighting


nano .zshrc
####################   #############################   #####################

ZSH_THEME="powerlevel10k/powerlevel10k"

--------------------------
#ENABLE_CORRECTION="true"
//to this
ENABLE_CORRECTION="true"
-------------------------

plugins=(git zsh-autosuggestions zsh-syntax-highlighting)



alias grep=' grep --color=auto '
alias cat=' ccat -G Plaintext="blink" -G Keyword="purple" -G String="darkgreen" -G Punctuation="brown" -G Comment="faint" '
alias ls=' exa --group-directories-first '
alias tree=' exa -T '
####################   #############################   #####################




### Establecer por defecto una sesion: SI usas vairas 
-> qtile / spectrum / dwm  ,etc

sudo micro /etc/lightdm/lightdm.conf




### Others
sudo pacman -Sy keepass nodejs npm vlc smplayer --needed --noconfirm

## WPS Office 
yay -S wps-office ttf-wps-fonts --noeditmenu --noconfirm --needed

unzip wps-español.zip

sudo cp -r interfaz/es_ES/  /usr/lib/office6/mui/

cp -r diccionario/es_ES/   ~/.local/share/Kingsoft/office6/dicts/


## Spotify Adblock
https://t.me/c/1340062268/172


yay -S microsoft-edge-stable
	- Packages to CleanBuild = A (for ALL)
	- Diff to show = N



## Postman:
yay -Sy postman-bin 
	- Font: 			agave Nerd Font Mono
	- Font Size:	18




## Docker & Docker Compose: Si no se activa, Reiniciar PC |  ∀  sudo
sudo pacman -S docker
sudo systemctl start docker
sudo systemctl enable docker
sudo systemctl status docker
sudo docker run hello-world

	https://www.linuxtechi.com/install-use-docker-on-arch-linux/


sudo pacman -Sy docker-compose




## lsd & bat
sudo pacman -Sy lsd bat
	- Configurar  lsd  en  .zshrc




## Plugins Zsh:

### sudo  -  esc esc para sudo
cd /usr/share/
sudo mkdir zsh-sudo
sudo chown adrian:adrian zsh-sudo
cd !$
wget https://raw.githubusercontent.com/ohmyzsh/ohmyzsh/master/plugins/sudo/sudo.plugin.zsh

	- Agregar el    source   de este path en el   .zshrc





## MongoDB & MongoDB Compass:
yay -S mongodb-bin
sudo systemctl start --now mongodb

mongo
	show dbs
	exit

yay -Sy mongodb-compass

	https://awan.com.np/how-to-install-mongodb-on-arch-linux-working/






## PC Potente  -  Limitar los trheads para ahorrar consumo energetico
yay -Syy cpupower-gui --needed --noconfirm
	- Desmarcamos los threads q no vamos a utilizar








### Instalar DWM:     sudo make clean install
	- Ver github de Antonio Sarosi
	- Reemplazar su dotfile de dwm por el mio.



### Instalar nvim
	- GitHub Antonio Sarosi











































# uui user
070be625-a8ad-0c33-8e8c-c7825fbf2c1f


095be615-a8ad-4c33-8e9c-c7613fbf5c9f||CDS008-vEA









```
=======================================================================================
// // // approved
message_id		d28647a3-dea5-4928-8f02-b0858d2efff6
type					academic-teaching.evaluation-system.subject_graded
content_type	application/json


{
	"uuid":"10b36575-779b-4977-9846-f42c97665517",
	"fired_at":"2023-06-06T15:58:00Z",
	"institution":{
		 "name":"UNIC",
		 "uuid":"095be615-a8ad-4c33-8e9c-c7613fbf5c9f"
	},
	"grade":{
		 "uuid":"10b36575-779b-4977-9846-f42c97665517",
		 "value":9,
		 "status":"approved",
		 "student":{
				"name":"Estudiante",
				"uuid":"070be625-a8ad-0c33-8e8c-c7825fbf2c1f",
				"login":"SNDODP4006400",
				"last_name":"Prueba 12"
		 },
		 "subject":{
				"name":"Curso verificación estado finalizacion v3",
				"uuid":"095be615-a8ad-4c33-8e9c-c7613fbf5c9f",
				"version":"CDS008-vEA",
				"abbreviation":"DD003"
		 },
		 "change_date":"2023-06-06T15:58:00Z",
		 "creation_date":"2023-06-06T15:58:00Z",
		 "grades":[
				{
					 "uuid":"10b36575-779b-4977-9846-f42c97665517",
					 "value":4.3,
					 "grades":[
							{
								 "uuid":"10b36575-779b-4977-9846-f42c97665517",
								 "value":4.3,
								 "grades":[
										{
											 "uuid":"10b36575-779b-4977-9846-f42c97665517",
											 "value":4.3,
											 "status":"failed",
											 "notatki":{
													"reference":"10b36575-779b-4977-9846-f42c97665517",
													"campus_reference":"095be615-a8ad-4c33-8e9c-c7613fbf5c9f"
											 },
											 "activity":{
													"name":"Actividad de Foro",
													"type":"_FORO",
													"abbreviation":"DD055_Esp_p01E0_Af"
											 },
											 "change_date":"2023-06-06T15:58:00Z",
											 "creation_date":"2023-06-06T15:58:00Z"
										},
										{
											 "uuid":"10b36575-779b-4977-9846-f42c97665517",
											 "value":4.3,
											 "status":"failed",
											 "notatki":{
													"reference":"10b36575-779b-4977-9846-f42c97665517",
													"campus_reference":"095be615-a8ad-4c33-8e9c-c7613fbf5c9f"
											 },
											 "activity":{
													"name":"Actividad de Practica",
													"type":"_PRACTICA",
													"abbreviation":"DD055_Esp_p01E0_APr"
											 },
											 "change_date":"2023-06-06T15:58:00Z",
											 "creation_date":"2023-06-06T15:58:00Z"
										},
										{
											 "uuid":"10b36575-779b-4977-9846-f42c97665517",
											 "value":4.3,
											 "status":"failed",
											 "notatki":null,
											 "activity":{
													"name":"Examen",
													"type":"_Examen",
													"abbreviation":"DD055_Esp_p01E0_AE"
											 },
											 "change_date":"2023-06-06T15:58:00Z",
											 "creation_date":"2023-06-06T15:58:00Z"
										}
								 ],
								 "status":"failed",
								 "activity":{
										"name":"Convocatoria Ordinaria",
										"type":"_TEST_PRIMARIO",
										"abbreviation":"DD055-E1"
								 },
								 "change_date":"2023-06-06T15:58:00Z",
								 "creation_date":"2023-06-06T15:58:00Z"
							}
					 ],
					 "status":"failed",
					 "activity":{
							"name":"Sistema de Convocatoria",
							"type":"_EXAMEN",
							"abbreviation":null
					 },
					 "change_date":"2023-06-06T15:58:00Z",
					 "creation_date":"2023-06-06T15:58:00Z"
				}
		 ]
	}
}




// // // // reproved
message_id					d28647a3-dea5-4928-8f02-b0858d2efff6
type								academic-teaching.evaluation-system.subject_graded
content_type				application/json


{
	"uuid":"d28647a3-dea5-4928-8f02-b0858d2efff6",
	"fired_at":"2023-06-06T15:58:00Z",
	"institution":{
		 "name":"UNIC",
		 "uuid":"095be615-a8ad-4c33-8e9c-c7613fbf5c9f"
	},
	"grade":{
		 "uuid":"d28647a3-dea5-4928-8f02-b0858d2efff6",
		 "value":2,
		 "status":"failed",
		 "student":{
				"name":"Estudiante",
				"uuid":"070be625-a8ad-0c33-8e8c-c7825fbf2c1f",
				"login":"SNDODP4006400",
				"last_name":"Prueba 12"
		 },
		 "subject":{
				"name":"Curso verificación estado finalizacion v3",
				"uuid":"095be615-a8ad-4c33-8e9c-c7613fbf5c9f",
				"version":"CDS008-vEA",
				"abbreviation":"DD003"
		 },
		 "change_date":"2023-06-06T15:58:00Z",
		 "creation_date":"2023-06-06T15:58:00Z",
		 "grades":[
				{
					 "uuid":"d28647a3-dea5-4928-8f02-b0858d2efff6",
					 "value":4.3,
					 "grades":[
							{
								 "uuid":"d28647a3-dea5-4928-8f02-b0858d2efff6",
								 "value":4.3,
								 "grades":[
										{
											 "uuid":"d28647a3-dea5-4928-8f02-b0858d2efff6",
											 "value":4.3,
											 "status":"failed",
											 "notatki":{
													"reference":"d28647a3-dea5-4928-8f02-b0858d2efff6",
													"campus_reference":"095be615-a8ad-4c33-8e9c-c7613fbf5c9f"
											 },
											 "activity":{
													"name":"Actividad de Foro",
													"type":"_FORO",
													"abbreviation":"DD055_Esp_p01E0_Af"
											 },
											 "change_date":"2023-06-06T15:58:00Z",
											 "creation_date":"2023-06-06T15:58:00Z"
										},
										{
											 "uuid":"d28647a3-dea5-4928-8f02-b0858d2efff6",
											 "value":4.3,
											 "status":"failed",
											 "notatki":{
													"reference":"d28647a3-dea5-4928-8f02-b0858d2efff6",
													"campus_reference":"095be615-a8ad-4c33-8e9c-c7613fbf5c9f"
											 },
											 "activity":{
													"name":"Actividad de Practica",
													"type":"_PRACTICA",
													"abbreviation":"DD055_Esp_p01E0_APr"
											 },
											 "change_date":"2023-06-06T15:58:00Z",
											 "creation_date":"2023-06-06T15:58:00Z"
										},
										{
											 "uuid":"d28647a3-dea5-4928-8f02-b0858d2efff6",
											 "value":4.3,
											 "status":"failed",
											 "notatki":null,
											 "activity":{
													"name":"Examen",
													"type":"_Examen",
													"abbreviation":"DD055_Esp_p01E0_AE"
											 },
											 "change_date":"2023-06-06T15:58:00Z",
											 "creation_date":"2023-06-06T15:58:00Z"
										}
								 ],
								 "status":"failed",
								 "activity":{
										"name":"Convocatoria Ordinaria",
										"type":"_TEST_PRIMARIO",
										"abbreviation":"DD055-E1"
								 },
								 "change_date":"2023-06-06T15:58:00Z",
								 "creation_date":"2023-06-06T15:58:00Z"
							}
					 ],
					 "status":"failed",
					 "activity":{
							"name":"Sistema de Convocatoria",
							"type":"_EXAMEN",
							"abbreviation":null
					 },
					 "change_date":"2023-06-06T15:58:00Z",
					 "creation_date":"2023-06-06T15:58:00Z"
				}
		 ]
	}
}





```


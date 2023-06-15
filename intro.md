# Moodle - Plugin Locales y Filtros

## Intro
- -- Objetivos
  - Aprender a Crear y Modificar Plugin Locales y Filtros
    - Moodle tiene al rededor de 35 Tipos diferentes de Plugins
      - Los Plugins Locales son aquellos q No caven en niguna de las clasificaciones como:
        - Themes, Bloques, Cursos, Preguntas, Filtros, ect.
        - Filtros en los Contenidos: EN los Encabezados podemos procesar esa Info y hacer cosas como Eliminar Palabras, Completar frases, substituirla, etc.

	- Moodle internamente usa la OOP con PHP
  	- Necesitas conocimientos de HTML, CSS y JS
  	- Dirigido a Desarroladores Web q conozcan Moodle y q deseen desarrollar plugin locales y filtros para esa plataforma
  	- Debes saner Administrar Moodle



	- -- Temario:
  	-- S1: Intro al Desarrollo en Moodle
			- Intro a la Arq. de Moodle
			- Frankenstyle
			- Standar de Documentacion PHPDoc
			- Modo de Disenio de Temas, modo de Desarrollo y Purgar los Caches.
			- Clase HTML Write

		-- S2: Crear los Plugin local
			- Las carpetas y archivos basicos de 1 plugin local
			- Crear 1 nueva option en el Menu de Administracion del cursos
			- Agregar 1 Opt en el Menu de admin del curso
			- Crearemos 1 page a desplegar
			- Crear != versiones de idiomas
			- Quitar la pagina principal o 'home'
			- Agregar 1 param global al plugin
			- Sustituir 1 method de 1 API
			- Parametros para el Plugin Bilingue
			- Activar y desactivar el plugin biliguen

		-- S2: Desarrollo de Filtros
			- Las carpetas y archivos basicos de 1 filtro
			- Filtro: el arvhivo filter.php
			- Filtro: 
			
		-- Anexo A: Estilos de Programacion para Moodle
			- Las sangrias y el manejo de las lineas my alargadas en la codificacion de Moodle
			- Convenciones de nomenclatura
			- Manejo de cadenas y cadenas de idioma
			- Manejo de Arrays y declaracion de clases
			- Uso de funciones, methods y sentencias de control
			- Manejo de los comentarios

		-- Anexo B: Los APIs de programacion
			- Las variables globales
			- Modulo de curso o Coruse module
			- el cmid (ID del modulo del curso)
			- La API page
			- La API Output
			- Uso de la API de archivos en formularios
			- La carpeta db
			- Otras carpetas y archivos
			- Las notificaciones en Moodle

		













<!-- course overvie/summary pack -->
git clone https://gitlab.fbr.group/teaching-action/plugins-development/novelties-schema/collect_novelties_information.git ./local/collect_novelties_information


git clone https://gitlab.fbr.group/teaching-action/plugins-development/novelties-schema/block-recent-novelties.git ./blocks/recent_novelties


git clone https://gitlab.fbr.group/teaching-action/plugins-development/block-course-view.git ./blocks/course_view





<!-- pdf & theme -->
git clone https://gitlab.fbr.group/teaching-action/plugins-development/theme-vle.git ./theme/vle

git clone https://gitlab.fbr.group/teaching-action/plugins-development/mod-protected-pdf.git ./mod/protectedpdf




<!-- additional web service -->
git clone https://gitlab.fbr.group/teaching-action/plugins-development/local-additional-web-service.git ./local/additional_web_service



<!-- message broker -->
git clone https://gitlab.fbr.group/teaching-action/plugins-development/local-message-broker.git ./local/message_broker





<!-- teachers block -->
git clone https://gitlab.fbr.group/teaching-action/ficha-de-docente/ficha-docente.git ./blocks/resume

git clone https://gitlab.fbr.group/teaching-action/ficha-de-docente/mod_resume.git ./mod/resume

git clone https://gitlab.fbr.group/teaching-action/ficha-de-docente/local_resume.git ./local/resume





f19c2349
bfd654cc





<!-- novelties - ojito -->
git clone https://gitlab.fbr.group/teaching-action/plugins-development/novelties-schema/block-novelties-and-notices.git ./blocks/novelties_and_notices

git clone https://gitlab.fbr.group/teaching-action/plugins-development/announcements-schema/local-global-notifications.git ./local/alerts_front

git clone https://gitlab.fbr.group/teaching-action/plugins-development/local-socket-io.git ./local/socketio






http://35.222.192.45:15672/#/queues/beta/teaching-action.subject-approval-service














<footer id="page-footer" class="footer-popover bg-white





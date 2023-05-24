# Crear un servicio web y un token con el API del LMS Moodle

## Crear un Web Serivce y token
- --- Debemos seguir los pasos del     `Overview`      q tenemos en  WebServices
  - Nos vamos a:   Site admin >> Web services >> Overview
    - Seguimos todos los pasas hasta obtener el token
      - Es importante CREAR 1 USER especifico, con las Capabilities y el ROLE especifico para este Web Servie en concreto
        - AL hacerlo asi, solo le damos las Capabilities necesarias asl Role especifico y se lo asignamos al nuevo user y ya.
	- Lo consumimos con POSTMAN	
  	- El como construir las peticiones queda para otro video



	- -- Seguimos lo del     Overview
  	- Creamos el New User
		- Creamos el New Role
  		- Le damos las Capabilities necesarias
		- Le asignamos este new role al new user
		- Volvemos al    Overview    para crear el     web service
  		- Creamos el  External Service 
    		- Add functions
      		- Seleccionamos las q queremos exponer
			- Creamos el token
  			- Este token es el q deberemos enviar desde el softare 3ro a la API de moodle para q permita las trnasacciones de info/data
    			- Esto va en el   `wstoken`    , ahi le metemos el token q acabamos de generar
      			- Este token es unico para c/instancia de Moodle
					- Con el    `wsfunction`     la fn q hayamos habilitado en la creacion de este webservice


		- Se Hace la peticion a:
  		- Para obtener cursos x id
  		- Algo del api criteria me da error con el de la doc, pero con este Options ya va bien
				http://localhost/webservice/rest/server.php?wstoken=9d051dd4d3847e8e3547913d11e0454c&wsfunction=core_course_get_courses&moodlewsrestformat=json&options[ids][0]=1

		- Para el resto de peticiones, simplemente vemos la Api Doc en Server de Moodle
  		- Ahi nos dicen como llamar a estos web services
    		- Los params q necesitan y demas


			-- URL: 	
				- A donde debemos hacer la llamada http:
						https://docs.moodle.org/dev/Creating_a_web_service_client











# How to Create Web Services in Moodle #moodle #webservices #api

- --- En este tuto explican el inicio comun para todos
  - Pero en estos videos, todos usan el user admin q ya tiene el role y Capabilities de todo
  - Sin embargo, en otros videos RECOMIENDAN crear 1 user especifico para este web service con el ROLE especifo para el web service


	- -- Sigue el Overview
  	- Paso a paso



- --- Creamos 1 plugin local para testear
  - Creamso los archivos basicos de todo plugin: version/lang, etc

	- -- Creamos el      `services.php`      q contendra
  	- Definira nuestra external function o web service
  	- Declaramos todas las   webservice  fn en este file q podran ser llamadas desde afuera x api rest



			-- URL:
				- service.php
					https://moodledev.io/docs/apis/subsystems/external/writing-a-service#declare-the-web-service-function
























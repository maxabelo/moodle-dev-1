# Merge Request - GitLab



# Traer las ramas del gitlab remote a local
git fetch origin -p
git fetch origin develop:develop

git checkout -b feature/name-name
git add .
git commit (formato correcto)

git push origin hotfix/start-button

merge request en Gitlab a la rama q corresponda
	-- Proviene de Master
		- Merge request a master
			- no eliminar rama tras el merge
		- Merge request a develop
	-- sale de develop
		- merge request a develop 

	- resolver los conflictos q vayan a suceder
		- pull de la rama de confilcto en mi rama del fix/feature
		- rsync
		- resolvermos confictos con phpstorm
		- git commit, sin mas para q haga el commit del merge
		- git push a mi rama de hotfix/feature
			- se va directo al merge request


ahora SI vamos a cambiar el    state     en     Asana 
	- cambiasmo de haciendo a revision QC
	- Agregamos las subtareas con    (horas)   q tomo esas subtareas para completar la tarea
	- 

	- -- Flujo:
`				x hacer -> haciendo -> QC => resuelta => hecha`






# Prevenir cache de JS en moodle
-- Evitar q requiera el purgue cache moodle en el   `config.php`
	- Importante QUITARLO antes de subir a prod:		`$CFG->cachejs = false;`






# rsync
- Crear el dir    /bin     en el home y crear el archivo   `rsync.adserver`     en ese /bin
	- Export path:	PATH="$HOME/bin:$PATH"
	- Sync:					rsync.adserver www/campus







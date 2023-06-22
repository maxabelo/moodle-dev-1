# Intro a Kubernetes - K8s
  -- Intro a Kubernates o K8
    - Es 1 administrador de 1 gran conjunto de Containers
      - Orquestado/Orquestacion de containers
      

    -- Kubernetes
      - Es 1 plataforma para automatizar el despliegue, escala y manejo de contenedores
      - Algunos problemas q resuelve
        - Un servicio 24/7 de nuestra app desplegada
        - Los de IT esperan hacer muchos despliegues en 1 dia Sin Detener el servicio q esta correindo
        - Las companias esperan > eficiencia de los recursos en la nube
        - Un sistema Tolerante a fallas en el momento q algo salga mal
        - Escalar hacia arriba o abajo segun demanda

      -- Orquestacion: 
        - Manejo automatico de apps en Containers
        - Alta disponibilidad
        - Practicamente NO hay 'downtimes' en reemplazos de versiones
        - Facil manejo de replicas




    -- Componentes de  Kubernetes (K8S)
      - Los components son: Pod, Service, Ingress, ConfigMap, Secret, Volume, Deployment, StatefulSet

      - POD
        - Son los Objs implementables mas pequenos y basicos de K8s.
          - Es 1 carpeta abstracta sobre 1 o mas Containers
          - Esto permite reemplazarlos facilmente
        - Los Containers en nuestro POD tienen IP unica asignada, q al construirse cambia
          - Estas IP cambian c/levanta y baja los containers o se los destruyen
      
      - SERVICE
        - Tienen 1 unica IP asiganda, y en todo momento sabe cual es la direccion IP de esos contenedores en el POD.
          - Asi permite una conmunicacion facil entre Containers sin importar q la direccion IP cambie
        - La IP del Service es Permanente.
          - El ciclo de vida del POD y el Service son Independientes
        - Tenemos Services Internos y Externos:  Internal Service and External
      
      - INGRESS
        - X default el cluster (conjunto de pods, services, demas) se mantiene hermetico. No permite interaccion con el mundo exterior.
          - Pero, a traves de los Ingress, podemos Exponer 1 entrada o Ingress a nuestro cluster
        - Ej.: Una nueva solicitud a nuestra web entra primero x el Ingress y este a los respectivos servicios.

      - CONFIG MAP
        - Podemos verlo como las EnvV ya q es 1 obj q esta a la vista, lo podemos ver
        - Nos sirve para tener un  key-value, en donde apuntamos a la key y obtenemso el value

      - SECRET
        - Podemos verlo como las EnvV pero Seguras. K8s NO encripta nada x default.
          - Los secrets requieren q lo q se vaya a almacenar este encriptado, sino NO lo acepta.
        - Ej: Credenciales, Secret del JWT, Tokens y demas cosas secretas.

      - VOLUME
        - Almacenamiento en 1 maquina local, o lugar remoto fuera del Custer K8s. K8s NO maneja la persistencia de la data
          - Parecido a los Volumes a los q estamso acostumbrados en docker
          - Son como discos duros q se acoplan al cluster

      - DEPLOYMENT
        - Es el plano o "Blueprint" para crear todo el POD y la cantidad de Replicas. Aqui es donde pude escalar arriba o abajo la replicas.
          - Replicas q entraran x si algun servicio falla

      - STATEFULSET
        - Es el plano similar a los Deployments, pero para DB.
          - No podemos replicar la DB



    -- Cluster
      - Es 1 grupo de Nodos q corren apps en contenedores de 1 forma Eficiente, automatizada, distribuida y escalable.



    -- Review:
      - Pod: Capa q se construye sobre los Containers
      - Service: Permite comunicacion con direcciones IP fijas
      - Ingress: Trafico externo q viaja para adentro del Cluster
      - ConfigMap: Configuraciones como EnvV
      - Secret: Similar al ConfigMap pero Secretos
      - Volume: Mantener la data persistente
      - Deployment: Planos o 'BluePrints' de la construccion de 1 POD
      - StatefulSet: Similar al Deployment, pero para uso de DB




  -- Instalacion y Config de  MiniKube
    - Crea 1 contenedor q ya viene pre-config con Kubernetes para q administremos el Cluster
    - Ayuda a quien esta iniciando con Kubernetes
      - La forma oficial de W esto es con el    `KubeCTL`   q es el CLI de Kubernetes
          https://minikube.sigs.k8s.io/docs/


    -- Instalamos MiniKube:
      - En linux:    https://minikube.sigs.k8s.io/docs/start/
      
  ```bash
      curl -LO https://storage.googleapis.com/minikube/releases/latest/minikube-linux-amd64
      sudo install minikube-linux-amd64 /usr/local/bin/minikube

    # Start your cluster
      minikube start
  ```
      
      - Con Minukube, el puerto externo del Cluster sera a traves del container q corre Minikube


      


  -- Construccion
    - Creamos el ConfigMap q es 1 yml
    - Creamos el Secret q tiene la data encriptada o en base64
        https://kubernetes.io/es/docs/concepts/

    - Pod, Service y Deployments
      - Es igual 1 yml

    - Desplegar la DB en el cluster


  -- Instalamos   kubeclt  <-  kubernetes
        https://kubernetes.io/docs/tasks/tools/install-kubectl-linux/

  ```bash

  ```


    - Desplegar DB
      - Comando en el path donde estan los yml:
            
  ```bash
      kubectl apply -f postgres-config.yml
      kubectl apply -f postgres-secret.yml
      kubectl apply -f postgres.yml
  ```

      - Ver si ya se levanto
            kubectl get all

      - Ver los logs de algun POD
  `kubectl logs pod/postgres-deployment-fd46c5fd-tt27t`



    -- Agregar PgAdmin al Cluster 
      - Creamos los  Secrets y el Deployment + Service

      -- Desplegar PgAdmin al Cluster
        - Se despliega en orden como el de postgres, esto xq tiene dependencias
        - Nos vamos al    path/   donde estan los  yml
        
  ```bash
      kubectl apply -f pg-admin-secrets.yml
      kubectl apply -f pg-admin.yml

      kubectl get all
      kubectl logs pod/pg-admin-deployment-6c66cb99f6-rw4j6
  ```

      - Ahora, esto esta expuesto al mundo exterior, pero dentro del Container de  Minikube
        - Debemos hacerlo exterior al Host o nuestra pc
          - Ejecutamos con respecto al Service q queremos:
                minikube service pg-admin-service
          - Datos de connection:
            - Host: postgres-service    <--  postgres-config.yml
            - Port: 5432                <--  postgres.yml <- service
            - username: postgres        <--  postgres-secrets.yml
            - pass: somePasswordPapuss  <--  postgres-secrets.yml  




      -- Backend:
        - Crear los   Secrets y el Depolyment + Service
        - Nos vamos al path de los yml

  ```bash
    kubectl apply -f backend-secrets.yml
    kubectl apply -f backend.yml

    kubectl get all

    # ver el describe del Deplyment
    kubectl describe deployment.apps/backend-deployment

    # ver los Logs del PLOD
    kubectl logs pod/backend-deployment-64664b7d66-hz957

  ```        

        - Cambiar un Secret
          - Cambiamos en el  seret.yml
          - Volver a hacer el   apply  del secret
          - Restart al Deployment q afecta ese cambio
            - Solo hace ref al name sin el deplotment.app/  del   kubeclt get all

  `kubectl rollout restart deployment backend-deployment`
  kubectl logs pod/backend-deployment-7c98688bd5-5kzpc

          - Aqui hacemos el Rollout manualmente xq modificams el Secret
            - Es Rollout xq no tiene   downtimes
          - Si se modifica el  Deployment yml, esto se hace en auto



  -- Probar el Back y limpieza
    - Provamos el service, sin la palabra service q nos da el   kubectl get all
      - Esto lanza el navegador
        - Se cancela con  Ctrl+C
  `minikube service backend-service`

      - Nos conectamos al PgAdmin lanzando ese servicio
        - Los datos de la DB son los del secret de postgres


    -- Limpieza en  minikube
      - Esto limpia todo y ya no ha pasado Nada
  `minikube delete --all`



        https://github.com/Klerith/k8s-teslo
        https://github.com/Klerith/docker-ejercicios


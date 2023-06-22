# Kubernetes

## Comparacion de Docker con Kubernetes
- --- Docker conteneriza apps. 
  - Docker compose nos ayuda a gestionar los contenedores
  - Docker Compose No nos ayuda facilmente con el AUTOescalamiento y con cosas mas complicadas
  



- --- Kubernetes
  - La unidad Minima son los Pods, estos empiezan a ser descartables ya q los podemos reemplazar.
  - Permite        ORQUESTAR       contenedores
    - Es 1 orquestador:		Site Realiability Engineering


  - -- Kubernetes es Declarativo
    - Yo creo 1 manifiesto tipo    `deployment`    q indica los     `pod`     a levantar, las    `replicas` y los   `containers`   que va a contener cada    'pod'
    - Kubernetes va a tratar de cumplir lo q le pedi en el manifiesto    `deployment.yml`
      - Si establezco q se requieren 3 	`containers` los va a distribuir en los  `workerrs`
        - Estos workers son manejados x el servicio de Kubernetes    `scheduler`   q se encarga de mover los container de 1 lugar a otro
          - Los       Servicios de Cluster de Kubernetes        se conectan a los Workers a traves de 1 agente q corre en c/worker que se llama `kubelet`
            - Un    `kubelet`    es como 1 servicio de Kubernetes q permite conectar todos los workers y todos los servicios de Kubernetes entre si
              - Kubernetes sabe cuando uno de esos Workers se Cae, por lo cual en Automatico va a tratar de mover ese container a otro worker y va a tratar de mantener lo q se establecio en el Manifiesto (deployment), las replicas y demas
                - Si falla algo, kubernetes en auto va a tratar de solventarlo




## Kubernetes Components
- --- El     CLUSTER de kubernetes    consta del
  - `Control Plane`: Son los servidores de kubernetes, los q se encargan de hacer las cosas a nivel orquestador
  - `Nodos` o instancias: En donde dentro de c/u de estos nodes va a correr el      `kubelet`      q es el agente de kubernetes
    - `kubelet`: quien permite conectar todos los workers y todos los servicios de kubernetes entre si
    - `k-proxy`: Se encarga de Recibir el Trafico y enviarselo a los    `pods`    q corresponda
      - Si le mando trafico a 1 instancia y queria ir a otra, k-proxy se va a encarger de redirigirlo al pod correspondiente.
	- Todo esto se conecta a la API de Kubernetes q esta dentro del Control Plane
  	  - Luego tenemos varios commponentes dentro del Control Plane como el:
  	    - Scheduler
  	    - Cloud Controller Manager (c-c-m):
  	      - Se conecta a la API de tu Proveedor de Cloud    <--   importante
  			- Esto es lo q lo diferencia de Docker Compose
  			- Kubernetes tiene la capacidad de conectarse a la API de 1 proveedor de Cloud y hacer cosas como crear 1 Load Balancer, Crear mas Instancias, Destruir instancias, etc.
  	    - Controller Manager
  	    - Etcd: qes como 1 DB basada en K-value q permite guardar el state del kluster de kubernetes


- --- Para poder Conectarnos a nuestro Cluster de Kubernetes debemos descargar     `kubectl`    q es el Client de Kubernetes
  - Es el Client q se conecta a 1 Cluster de Kubernetes 








## Init con Kubernates - Kubectl
- --- Instalamos kubeclt y minikube
  - Tal como lo hace FH



- --- Manifiestos / Recursos de Kubernetes
  - `namespace`: Es 1 division logica del Cluster de Kubernetes. Separa la carga en el cluster, y dentro de cada namespace vamos a tener pods.
    - Va a dividir nuestro cluster x namespaces para tener solo lo q queremos en el namespace q queremos. Es decir, tener     `pods`    de inteneres en 1 mismo namespace
      - Ver los namespaces:     `kubectl get ns`
	- Un     `pod`     es 1 set de Containers, ese set de containers puede estar basado en 1 o + containers.
  	  - Aunq se pueden correr varios Container en 1 mismo Pod, generalmente vas a correr 1 solo container/app en cada pod.
  	    - En ciertos casos puedes querer correr varios porcesos en 1 container, pero NO es lo ideal puesto q queremos q kubernetes maneje cosas en auto.
  	  - Ver los pods:			`kubeclt -n kube-system`   <- kube-syste es 1 namespace
	- El     `deployment`     genera pods
	  - 
  - 








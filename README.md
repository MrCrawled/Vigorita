

## **Vigorita - Sistema eCommerce de venta en linea.**

Stack
		
 - PHP 7.4
 - MYSQL: 5.7
 - Wordpress 5.7
 - Nginx

**Instalación y configuración de Docker y Docker Compose en Windows**

 - Descargar Docker desde el siguiente link: https://www.docker.com/products/docker-desktop
 - Clonar el repositorio. Renombrar el archivo .env-sample a .env y si se desea modificar las credenciales, editar el archivo para cambiar la contraseña de Mysql, nombre de la base de datos de Wordpress.
 - Dirigirse a la carpeta C:\Windows\System32\drivers\etc y modficar el archivo hosts

									127.0.0.1 yourdomain.local

	Ej: 127.0.0.1 vigorita.local

**Instalación y configuración del proyecto.**

 - Abrir una terminal e ir a la carpeta donde se clono el proyecto y ejectuar el siguiente comando:

  

								docker-compose up -d

  
  

Lo que realiza este comando es inicializar los contenedores que componen el stack, y el flag -d (Detached mode) indica que los inicializa en modo daemon,  es decir en segundo plano. Cuando finalice, ejecutar el siguiente comando para verificar que todos los servicios estén levantados

									 docker ps

  
Si algunos de ellos no se esta ejecutando o se reinicia, se deben revisar las configuraciones de docker-compose.

 - Realizar la copia de la base de datos, dentro del contenedor, para poder inicializar el proyecto, ejecutando el siguiente comando:

  

*docker exec -i Id del contenedor mysql -uusuario_mysql -ppassword_mysql nombre_bd_local < ruta_fichero_importación.sql*

  

Ej: docker exec -i d172e693dc19 mysql -uvigorita -proot vigorita < c:\vigorit8_vigorita.sql

 - Ir al browser e ingresar a la URL especificada: Ej: http://vigorita.local:8080. Si aparece la home page,se ha finalizado con la configuración del entorno local.

**Comandos útiles a saber.**

 - docker-compose up: inicializa los contenedores.
 - docker-compose stop:  detiene los contenedores.
 - docker-compose down: detiene y elimina todos los contenedores.
```

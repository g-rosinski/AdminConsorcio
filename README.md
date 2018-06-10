# AdminitradorConsorcio

## Requerimientos previos.

* Node.
* @Angular/Cli instalado de manera global.
* xammp

## Instalar el entorno
1) Descargar node version 8.11.2 (la version 10 no!), aca esta el link: https://nodejs.org/es/
2) Instalar node. Siguiente siguiente siguiente. Para comprobar que se instalo bien abren CMD y ejecutan: 
    a) node -v
    b) npm --v
   Si la instalacion fue correcta les deveria devolver una version diferente en cada comando.
4) Tenemos que instalar el cli de angular de manera global, para eso en la misma ventana CMD hacemos (sin las comillas). "npm install -g @angular/cli", esto puede tardar un ratito, pero cuando terminan, verifican la instalacion haciendo "ng -v" y este deberia devolver la version del cli que instalaron.

## Levantar la aplicacion.
1) Clonan el proyecto, y abren la ubicacion del proyecto en CMD. 
2) Una vez ubicados en CMD, escriben "npm install" (Este si puede llevar a tardar 5 minutos o mas, aca esta instalando todas las dependencias del proyecto).
3) Una vez que termina de instalar podemos escribir "npm start" y abren en el navegador http://localhost:4200 y deberian tener la app andando (Pero sin el lado de php).
4) Para usar el lado de PHP tienen que hacer lo siguiente: Ejecutar "ng build", esto una vez terminado genera una carpeta llamada "dist" que adentro deberia tener otra carpeta llamada "adminitrador-consorcio". Lo que tienen que hacer es copiar todos los archivos que hay dentro de "./dist/administrador-consorcio" dentro de la carpeta htdocs de su xammp, asi de esta manera puede jugar con php. Yo recomiento modificar la configuracion de xammp y cambiar de la carpeta de inicio, osea que en lugar de htdocs sea "./dist/administrador-consorcio"

## Aclaraciones.
- Todo lo que sea PHP se encuentra dentro de "./src/server" ahi adentro van todos nuestros archivos PHP.
- Si tienen que modificar un archivo PHP, lo tienen que hacer dentro de "./src/server" y ejecutar "ng build" (Ver paso 4), todo lo que modifiquen dentro de la carpeta "dist" no es tenido en cuenta por GIT.
- Cualquier cosa me preguntan 
- BYE :D
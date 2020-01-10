# binaryTree
BinaryTree es una aplicación que permite el registro de arboles binarios con sus respectivos nodos. Dado un árbol binario y dos nodos se retorna el ancestro común más cercano. Esta aplicación ha sido desarrollada en PHP 7.x. / Mysql 5.X, haciendo uso de programación orientada a objetos y servicios con APIRest. Los servicios expuestos son:
* Consulta de un arbol dado su Id de Referencia
* Consulta de nodos dado el id de Referencia del Arbol
* Consulta de el ancestro común más cercano dado el árbol y 2 nodos.

## Instalación
Puede clonar el repositorio así:
```bash
git clone https://github.com/jmsg78/binaryTree.git
```
también podrá descargar el archivo zip y descomprimirlo en la ruta de tu virtual host en linux o windows

Ubique el archivo de la base de datos aquí
```bash
model/db/db.sql
```
Realice la restauración correspondiente de la base de datos utilizando el gestor de base de datos Mysql que disponga o realiza el restore por consola Linux o Windows. 

Ajustes las credenciales de la base de datos en el archivo de configuración
```bash
model/db/db.class.sql
$host = 'localhost';
$db =   'binarytree';
$user = 'root';
$pwd =  '';
```
Para hacer uso de la API REST podrá levantar el servicio desde la consola así:
```bash
php -S localhost:8002 app/router.php
```
Esto permitirá exponer los servicios comentados arriba, se recomienda hacer uso de POSTMAN para la interacción correspondiente.
* Para conocer los arboles existentes, acceder al recurso con el verbo GET trees así:
```bash
http://localhost:8002/trees
```
Este servicio te permitirá obtener todos los arboles existentes en la bd.

* Para conocer los nodos existentes en un arbol, podrá acceder al servicio vía GET así:
```bash
http://localhost:8002/trees/1
```
Este servicio le mostrará todos los nodos definidos para el árbol identificado con el id de recurso 1.

* Para adicionar un Nodo a un arbol existente, podrá acceder al recurso vía POST, así: importante enviar en el header el Content-Type application/json (POSTMAN)
```bash
http://localhost:8002/trees/1 (trees refiere a la colección y 1 al Id del Arbol).
```
- El Modelo del Json para crear un nodo en el arbol 1
```json
{
    "userid": 1,
    "valuenode": 90
}
```
* Para conocer el ancestro común más cercano dado un arbol binario y dos nodos, podrá acceder al recurso vía POST, así:
```bash
http://localhost:8002/trees/1 (trees refiere a la colección y 1 al Id del Arbol).
```
- El Modelo del Json para consultar el Ancestro deberia ser así. Vía JSON, importante enviar en el header el Content-Type application/json (POSTMAN)
```json
{
    "node1": 29,
    "node2": 44
}
```
## Aplicación
Se creó una aplicación con login básico para registrar los arboles por usuarios y así tener una interfaz más amigable y sencilla.
Podrá acceder a ella a través de el archivo index.php que se encuentra en la raiz de la aplicación. Puede crear una cuenta y comenzar a crear tus arboles con nodos, eliminarlos y consultar el ancestro común más cercano si lo desea.

### Views
En la carpeta Views se encuentras las interfaces web para el registro de arbol, nodos, busqueda via web.
### Controllers
En la carpeta API podrá conocer los servicios expuestos.
### Data
Se construyó una clase para acceder a la BD


## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[GPL]

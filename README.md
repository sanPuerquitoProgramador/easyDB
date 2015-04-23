# easyDB
Libreria de funciones en PHP que permiten un acceso sencillo a bases de datos MySQLi. Se contemplan las 4 funciones básicas:
- SELECT
- INSERT
- UPDATE
- DELETE

##Incluir la libreria en tu proyecto

```php
include_once(easyVAR.php)
include_once(easyDB.php)
```
### Variables en easyVAR

```php
$easy_db_name = ''; //Usuario de la base de datos
$easy_db_pwd = ''; //Contraseña de la base de datos
$easy_db_host = ''; //Servidor donde está alojada la base (tipicamente localhost)
$easy_db_db = ''; //nombre de la base de datos
```
##USO de easyDB
###Función SELECT
```php
function ConsultaTabla($tabla, 
          $campo, 
          $condicion=NULL, 
          $operadorIncluido = NULL, 
          $ordenado=NULL, 
          $debug = NULL)
```
####Parametros Requeridos

- `$tabla` : Tabla que será consultada
- `$campo` : Array de campos que serán consultados

####Parametros Opcionales

- `$condicion` : Array de campo => valor que serán consultados
 
```php
array('nombre'=>'"Jon Snow"')
```

>Por defecto se agrega el operador "=" a la condicion. Puede modificarse este comportamiento agregando el operador deseado al array.

```php
array('nombre != '=>'"Jon Snow"')
```
>**IMPORTANTE** en caso de que se modifique el operador por defecto, se debe especificar **$operadorIncluido = 1**

- `$operadorIncluido` : Variable booleana (null / 1) que indica si el operador de la varibale condicion está incluido o no en el array

- `$ordenado` : Parametro para agregar la sentencia final "order by "

- `$debug` : Variable booleana. Si está en 1, la sentencia SQL construida NO se ejecutará y en su lugar devolverá a pantalla la sentencia SQL construida

**Ejemplo de uso con más de un operador simple de condicion**

```php
$resultado = ConsultaTabla('usuario',
            array('nombre','direccion'), 
            array('correo'=>'"jonsnow@thenightwatch.com"', 'password'=>'"ygritte"'));
```
>SELECT nombre, direccion FROM usuario WHERE correo = "jonsnow@thenightwatch.com" AND password = "ygritte"

**Ejemplo de uso con modificador de operador en condicion**
```php
$resultado = ConsultaTabla('usuario', 
            array('nombre','direccion'),
            array('nombre like '=>'"%snow%"'),
            1)
```
>SELECT nombre, direccion FROM usuario WHERE nombre LIKE "%snow%"

Los resultados de la consulta se deveuelven en un array con la siguiente estructura
```php
$resultado =  [totalItems] //total de filas devueltas
              [items][...] //filas consultadas
                [nombre]
                [direccion]
                [...]
              [debug] //sentencia SQL contruida y ejecutada
```
###Función UPDATE
```php
function ActualizaTabla($tabla, 
          $campoValor, 
          $condicionValor, 
          $debug = NULL)
```
####Parametros Requeridos

- `$tabla` : Tabla que será actualizada
- `$campoValor` : Array de campo => valor que serán actualizados
- `$condicionValor` : Array de campo => valor que será usado como filtro para el update

>Todos los parametros de `$condicionValor` se contruyen con el operador "=" y no es posible modicarlo

####Parametros Opcionales
- `$debug` : Variable booleana. Si está en 1, la sentencia SQL construida NO se ejecutará y en su lugar devolverá a pantalla la sentencia SQL construida
 
**Ejemplo de uso**
```php
$resultado = ActualizaTabla('usuario', 
            array('work'=>'"The wall"', 'color'=>'"black"'),
            array('nombre'=>'"Jon Snow"'));
```
>UPDATE usuario SET work = "The wall", color = "black" WHERE nombre = "Jon Snow"


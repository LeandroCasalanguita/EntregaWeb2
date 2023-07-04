# <center>Trabajo Web 2 Api Rest</center>

# Integrantes:
1. Casalanguita Leandro
2. Casalanguita Luciano

# Obtencion del token: GET '/api/user'

Header: "username: password"
El username y la password han de ser codificados en base64.
#### Code 200: 
#### Ejemplo:
token = eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c2VyIjoicGF0cmkifQ.Zdw4Qb6Q97uYhBoBpZYQ4oMJD0pHHkuFttWtsqNMU94
#### Code 401: username o password invalido 

# <center>Tabla Travels</center>
| Método | Endpoint | Descripcion | Respuestas|
| - | - | - | - |
| GET    | api/travel               | Obtiene una lista de todos los viajes y detalles de cada uno. | 200: Trajo correctamente los viajes / 404: No existe respuesta  |
| GET    | api/travel/:{id}          | Obtiene los detalles de un unico viaje. | 200: Trajo correctamente el viaje / 400: Id no es valido / 404: Id es valido pero no se ha encontrado|
| POST   | api/travel         | Crea un nuevo viaje. | 201: Viaje creado exitosamente / 404: Viaje no ha sido creado / 400: Datos invalidos / 401: Usuario no autorizado|
| PUT    | api/travel/:{id}          | Actualiza los datos de un viaje existente. | 200: Viaje editado exitosamente / 404: Viaje no ha sido editado / 400: Datos invalidos / 401: Usuario no autorizado |
| DELETE | api/travel/:{id}          | Elimina un viaje. | 200: Elimino correctamente el viaje / 400: Id no es valido / 404: Id es valido pero no se ha encontrado |

# GET 'api/travel':
Muesta todos los viajes en pantalla en formato JSON.
## Posibles Respuestas:
### Code 200:
```json
{
	"id_travel":"int",
	"id_load":"int",
	"kilometer":"int",
	"amount_fuel":"int",
	"truck":"string",
	"driver":"string"
}
```
### Code 404: No existe respuesta.
# GET 'api/travel/:{id}':
Muestra un viaje con el id ingresado por el usuario es muy similar al 'api/travel', este es mostrado por pantalla en formato JSON.
200: Trajo correctamente el viaje 
## Posibles respuestas:
### Code 200:
```json
{
	"id_travel":"int",
	"id_load":"int",
	"kilometer":"int",
	"amount_fuel":"int",
	"truck":"string",
	"driver":"string"
}
```
### Code 400: Id no es valido.
### Code 404: Id es valido pero no se ha encontrado.
# POST 'api/travel':
El usuario debe hacer la peticion con su token, los datos deben ser enviados por body request, luego lo guarda en la tabla travel y finalmente lo muestra en formato JSON.

Requiere header: "bearer {token}". Un ejemplo del body request: 
```json
{
    "id_load": 2,
    "kilometer": 710,
    "amount_fuel": 3500,
    "truck": "Mercedes",
    "driver": "Marcelo"
}
```
## Posibles respuestas:
### Code 201:
```json
{
    "id_load": 2,
    "kilometer": 710,
    "amount_fuel": 3500,
    "truck": "Mercedes",
    "driver": "Marcelo"
}
```
### Code 400: Valores no validos.
### Code 401: Sin token.
### Code 404: Error.
# PUT 'api/travel/{id}':
El usuario debe hacer la peticion con su token. Modifica un viaje con el id ingresado por el usuario, el id ingresado debe existir para ser realizado con exito. En el caso de que el id exista recibe por body request los datos a modificar asegurandose de que todos esten correctamente ingresados. 

Requiere header: "bearer {token}", un ejemplo del body request: 
```json
{
    "id_load": 2,
    "kilometer": 710,
    "amount_fuel": 3500,
    "truck": "Mercedes",
    "driver": "Marcelo"
}
```
## Posibles Respuestas:

#### Code 200:
```json
{
	"id_travel":"int",
	"id_load":"int",
	"kilometer":"int",
	"amount_fuel":"int",
	"truck":"string",
	"driver":"string"
}
```
#### Code 400: Valores no validos.
#### Code 401: Sin token.
#### Code 404: Error.
# DELETE 'api/travel/{id}':
El id ingresado debe existir para ser borrado con exito. Elimina un viaje con el id ingresado por el usuario.
## Posibles respuestas:
#### Code 200: Exitoso.
#### Code 400: Paramenetro no valido.
#### Code 404: Error.
# Query params del endpoint api/travel
| Primer Parámetro | Segundo Parámetro | Descripción | Ejemplo | Respuestas |
|-|-|-|-|-|
| pag='int'| amount='int' | Muestra por pagina la cantidad deseada de viajes| `/api/travel?pag=2&amount=5`| 200: Trajo correctamente los viajes / 400: Datos invalidos / 404: Cantidad de viajes no disponibles o no hay mas viajes|
| id_travel='char'| a='int' | Muestra de manera filtrada por un rango, mayor o menor a un numero deseado los viajes | `/api/travel?id_travel=>&a=20` | 200: Muestra correctamente / 400: Datos invalidos / 404: No encontrado|
| atributo='string'| order='string' | Campo por el que se ordenarán los viajes de manera ascendente o descendente | `/api/travel?atributo=id_travel&order=asc` | 200: Ordena correctamente / 400: Datos invalidos / 404: Sin elementos |

# GET '/api/travel?pag='int'&amount='int'':
Ambos parametros han de ser ingresados.
## Posibles respuestas:
#### Code 200:
```json
{
	"id_travel":"int",
	"id_load":"int",
	"kilometer":"int",
	"amount_fuel":"int",
	"truck":"string",
	"driver":"string"
}
```
#### Code 400: Parametros no validos.
#### Code 404: Cantidad es mayor al total de viajes.

# GET '/api/travel?id_travel='char'&a='int''
Muestra viajes mayores, iguales o menores a un numero

id_travel: opciones "<", ">" o "="
#### Code 200:
```json
{
	"id_travel":"int",
	"id_load":"int",
	"kilometer":"int",
	"amount_fuel":"int",
	"truck":"string",
	"driver":"string"
}
```
#### Code 400: Parametros no validos.
#### Code 404: Sin elementos.

# GET	'/api/travel?atributo='string'&order='string''
Ordena los viajes ascendete o descendente 

Opciones para atributo: "id_travel", "kilometer", "amount_fuel", "truck","driver", "id_load" 

Opciones para order: "asc", "desc"
## Posibles respuestas:
#### Code 200:
```json
{
	"id_travel":"int",
	"id_load":"int",
	"kilometer":"int",
	"amount_fuel":"int",
	"truck":"string",
	"driver":"string"
}
```
#### Code 400: Parametros no validos.
#### Code 404: No encontrado.


# <center>Tabla truck_load</center>
| Método | Endpoint | Descripcion | Respuestas|
| - | - | - | - |
| GET | api/truck_load | Obtiene una lista de todos los tipos de carga y detalles de cada uno. | 200: Trajo correctamente los tipos de carga / 404: No existe respuesta  |
| GET | api/truck_load/:{id} | Obtiene los detalles de un unico tipo de carga. | 200: Trajo correctamente el tipo de carga / 400: Id no es valido / 404: Id es valido pero no se ha encontrado|
| POST | api/truck_load | Crea un nuevo tipo de carga. | 201: Tipo de carga creado exitosamente / 404: Tipo de carga no ha sido creado / 400: Datos invalidos / 401: Usuario no autorizado |
| PUT  | api/truck_load/:{id} | Actualiza los datos de un tipo de carga existente. | 200: Tipo de carga editado exitosamente / 404: Tipo de carga no ha sido editado / 400: Datos invalidos / 401: Usuario no autorizado |
| DELETE | api/truck_load/:{id} | Elimina un tipo de carga. | 200: Elimino correctamente el tipo de carga / 400: Id no es valido / 404: Id es valido pero no se ha encontrado |

# GET 'api/truck_load':
Muesta todos los tipos de carga en pantalla en formato JSON.
## Posibles Respuestas:
### Code 200:
```json
{
	"id_load":"int",
	"type_load":"string",
	"value":"int"
}
```
### Code 404: No existe respuesta.
# GET 'api/truck_load/:{id}':
Muestra un tipo de carga con el id ingresado por el usuario es muy similar al 'api/truck_load', este es mostrado por pantalla en formato JSON.
## Posibles respuestas:
### Code 200:
```json
{
	"id_load":"int",
	"type_load":"string",
	"value":"int"
}
```
### Code 400: Id no es valido.
### Code 404: Id es valido pero no se ha encontrado.
# POST 'api/truck_load':
El usuario debe hacer la peticion con su token, los datos deben ser enviados por body request, luego lo guarda en la tabla truck_load y finalmente lo muestra en formato JSON.

Requiere header: "bearer {token}". un ejemplo del body request: 
```json
{
	"type_load":"Maiz",
	"value":700
}
```
## Posibles respuestas:
### Code 201:
```json
{
	"id_load":"int",
	"type_load":"string",
	"value":"int"
}
```
### Code 400: Valores no validos.
### Code 401: Sin token.
### Code 404: Error.
# PUT 'api/truck_load/{id}':
El usuario debe hacer la peticion con su token. Modifica un tipo de carga con el id ingresado por el usuario, el id ingresado debe existir para ser realizado con exito. En el caso de que el id exista recibe por body request los datos a modificar.

Requiere header: "bearer {token}". un ejemplo del body request: 
```json
{
	"type_load":"Maiz",
	"value":700
}
```
## Posibles Respuestas:

#### Code 200:
```json
{
	"id_load":"int",
	"type_load":"string",
	"value":"int"
}
```
#### Code 400: Valores no validos.
#### Code 401: Sin token.
#### Code 404: Error.
# DELETE 'api/truck_load/{id}':
El id ingresado debe existir para ser borrado con exito. Elimina un tipo de carga con el id ingresado por el usuario.
## Posibles respuestas:
#### Code 200: Exitoso.
#### Code 400: Parametro no valido.
#### Code 404: Error.
# Query params del endpoint api/truck_load
| Primer Parámetro | Segundo Parámetro | Descripción | Ejemplo | Respuestas |
|-|-|-|-|-|
| pag='int'| amount='int' | Muestra por pagina la cantidad deseada de tipo de cargas| `/api/truck_load?pag=2&amount=5`| 200: Trajo correctamente los tipo de cargas / 400: Datos invalidos / 404: Cantidad de tipos de cargas no disponibles o no hay mas tipos de cargas|
| value='char'| a='int' | Muestra de manera filtrada por un rango, mayor o menor a un numero deseado los tipos de cargas | `/api/truck_load?value=>&a=20` | 200: Muestra correctamente / 400: Datos invalidos / 404: No se han encontrado cargas|
| atributo='string'| order='string' | Campo por el que se ordenarán los viajes de manera ascendente o descendente | `/api/truck_load?atributo=value&order=asc` | 200: Ordena correctamente / 400: Datos invalidos / 404: Sin elementos |

# GET '/api/truck_load?pag='int'&amount='int'':
Ambos parametros han de ser ingresados.
## Posibles respuestas:
#### Code 200:
```json
{
	"id_load":"int",
	"type_load":"string",
	"value":"int"
}
```
#### Code 400: Parametros no validos.
#### Code 404: Cantidad es mayor al total de viajes.

# GET '/api/truck_load?value='char'&a='int''
Muestra tipos de cargas mayores, iguales o menores a un numero

Opciones value: "<", ">" o "=".
#### Code 200:
```json
{
	"id_load":"int",
	"type_load":"string",
	"value":"int"
}
```
#### Code 400: Parametros no validos.
#### Code 404: Sin elementos.

# GET	'/api/truck_load?atributo='string'&order='string''
Ordena los tipos de carga de manera ascendete o descendente 

Opciones para atributo: "id_load", "type_load", "value"

Opciones para order: "asc", "desc"
## Posibles respuestas:
#### Code 200:
```json
{
	"id_load":"int",
	"type_load":"string",
	"value":"int"
}
```
#### Code 400: Parametros no validos.
#### Code 404: No encontrado.
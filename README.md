# Instrucciónes de la prueba:

Evaluación {Práctica} web developer
Objetivo:
- Validar las habilidades de programación.
- Validar conocimientos y habilidad en HTML y CSS.
- Validar habilidades en diseño.
- Usabilidad.
 
Parte 1:
Realizar un Demo de carrito de compras responsivo en el cual se pueda hacer lo siguiente:
Formulario con tres pruductos, con sus respectivos campos de cantidades y botón de agregar y eliminar:
 
 tabla

- Agregar objetos a una lista para compra con un solo click y mostrar mensaje de éxito.
- Eliminar objetos de la lista de compras con un click y mostrar mensaje de warning.
- Mostrar lo que hay en el carrito en un modal con dos imágenes(abajo se indica el formato del modal propuesto, puede variar un poco en la forma de acuerdo a lo que considere el desarrollador).
- No es necesario que se guarde en base de datos.

tabla 

Nota: Es importante que se realice la prueba en conjunto con javascript, ajax,html y css, puede utilizar el framework que desee.También puede agregar objetos que considere para la mejor experiencia del usuario.



# INSTALACIÓN DEL PROYECTO Y ARCHIVOS NECESARIOS:

Versiónes
Laravel v11.18.1 
PHP v8.2.18

Es necesario tener habilitadas las extensiones para sqlite (pdo_sqlite, sqlite3).

El proyecto se puede clonar desde github:
- git clone https://github.com/5onn1/acr-prueba-2.git

El archivo .env.example ya incluye la información necesaria para el proyecto.

ejecutar los comandos para instalar:
- composer install
- npm install
- php artisan key:generate
- php artisan migrate

ejecutar los comandos para iniciar el proyecto:
- php artisan serve
- npm run dev

Librerias utilizadas:
- Tailwindcss
- SweetAlert2 (https://sweetalert2.github.io/)
- Toastify (https://apvarun.github.io/toastify-js/)

Crear un archivo json llamado products.json en storage/app/public/products.json y copiar y pegar el siguiente json o mover a ese directorio el archivo compartido:

{
  "products": [
    {
      "id": "1",
      "name": "Uno",
      "price": 5,
      "image": "red-shoes"
    },
    {
      "id": "2",
      "name": "Dos",
      "price": 10,
      "image": "black-shoes"
    },
    {
      "id": "3",
      "name": "Tres",
      "price": 15,
      "image": "white-shoes"
    }
  ]
}


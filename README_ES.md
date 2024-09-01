# Panel de ayuda para World of Warcraft

Este Dashboard de Ayuda para Inscripción en World of Warcraft está diseñado para ayudar a los jugadores a maximizar sus ganancias identificando los glifos más rentables para crear, las tintas necesarias y las hierbas más económicas para comprar. Los elementos se crean a partir de listas de compras de Auctionator, y la información de los ítems se obtiene de Wowhead utilizando un analizador HTML DOM.

## Características

- **Tablas de datos y tablas laterales con información relevante**:
- **Página de elementos con información detallada, vista en árbol de componentes y gráficos**:
- **Registro de ventas/compras**:
- **Scripts para leer y cargar datos de exportación diarios desde auctionator export.csv**:
- **Raspado de elementos y componentes de Wowhead**:
- **Addon Lua para WoW que registra todas las ventas/compras en la AH leyendo el buzón**:

## Cómo Funciona

### Flujo de Trabajo

1. **Comparación de precios**:
   - Usa el addon Auctionator para crear una lista de compras.
   - Busca todos los elementos en la lista de compras.
   - Exporta los datos y guárdalos como `assets/export.csv`.
   - Ejecuta el script `scripts/insertExport.php` para insertar los datos en la base de datos.

2. **Datos de Ventas/Compras**:
   - Instala el addon desde la subcarpeta wowMailLedger o desde su repositorio: [Repositorio de Github](https://github.com/Aperezortega/wowMailLedger).
   - Copia el siguiente archivo: `C:\Program Files (x86)\World of Warcraft\_classic_\WTF\Account\**TU CUENTA**\SavedVariables\AipoxMailLedger.lua` (hay un archivo bat en assets para automatizar esto).
   - Ejecuta 'scripts/insertTransactions.php' para insertar los datos de las transacciones en la base de datos.

### Scripts

1. **insertExport.php**:
   - **Propósito**: Leer datos de un archivo CSV e insertarlos en la base de datos.
   - **Funcionalidad**:
     - Abre y lee el archivo `assets/export.csv`.
     - Analiza los datos y selecciona las columnas relevantes (Precio, Nombre, Disponible).
     - Inserta los datos en la tabla `scrap` de la base de datos.
     - **Si un elemento no se encuentra en la tabla `items`, crea una nueva entrada para el elemento y lo busca en Wowhead para encontrar sus componentes, e introduce estos también en la base de datos**.

2. **insertTransactions.php**:
   - **Propósito**: Leer datos de transacciones de un archivo Lua e insertarlos en la base de datos.
   - **Funcionalidad**:
     - Abre y lee el archivo `AipoxMailLedger.lua`.
     - Usa expresiones regulares para extraer los datos de las transacciones.
     - Analiza los datos y los almacena en un array.
     - Inserta los datos de las transacciones en la base de datos.

3. **copia.bat**:
   - **Propósito**: Automatizar el proceso de copiar el archivo Lua y ejecutar el script PHP para insertar datos en la base de datos.
   - **Funcionalidad**:
     - Copia el archivo `AipoxMailLedger.lua` desde el directorio de World of Warcraft al directorio del repositorio de GitHub.
     - Elimina el archivo Lua original y su respaldo si la copia es exitosa.
     - Abre un navegador web para ejecutar el script `insertTransactions.php`, que inserta los datos en la base de datos.

## Instrucciones de Configuración

### Requisitos Previos

- Un gestor de bases de datos (por ejemplo, [HeidiSQL](https://www.heidisql.com/download.php)).
- Un servidor local capaz de ejecutar PHP (por ejemplo, [XAMPP](https://www.apachefriends.org/es/index.html)).
- El addon Auctionator para crear listas de compras en World of Warcraft. Puedes descargarlo desde [CurseForge](https://www.curseforge.com/wow/addons/auctionator).
- El addon wowMailLedger (que he creado) para registrar todas las ventas/compras en la casa de subastas leyendo el buzón. Puedes descargarlo desde su repositorio: [wowMailLedger](https://github.com/Aperezortega/wowMailLedger).

### Instalación

1. **Descargar e Instalar Requisitos Previos**:
   - Descarga e instala HeidiSQL.
   - Descarga e instala XAMPP.

### Estructura del Código

- **index.php**: El punto de entrada principal para el dashboard. Inicializa la aplicación y carga la interfaz principal.
- **items.php**: Contiene la lógica para la página de elementos, mostrando datos mínimos, máximos, promedio, y actuales, un árbol recursivo de componentes, y un gráfico de evolución de precios.
- **salespurchases.php**: Contiene la lógica para la página de ventas y compras, incluyendo una tabla mensual con todas las transacciones y una tabla de datos generales de ventas.
- **db.php**: Gestiona la conexión e interacciones con la base de datos.
- **controller.php**: Actúa como el controlador para manejar solicitudes y coordinar entre la vista y el modelo.
- **functions.php**: Contiene varias funciones auxiliares utilizadas en toda la aplicación.
- **scripts/**: Contiene varios scripts PHP para procesamiento de datos e interacciones con la base de datos:
  - **insertExport.php**: Lee datos de un archivo CSV e inserta la información en la base de datos.
  - **insertTransactions.php**: Lee datos de transacciones de un archivo Lua e inserta la información en la base de datos.
  - **copia.bat**: Automatiza el proceso de copiar el archivo Lua y ejecutar el script PHP para insertar los datos en la base de datos.
- **htmldomparser/**: Contiene la librería HTML DOM parser utilizada para analizar contenido HTML.
- **wowMailLedger/**: Contiene el submódulo para manejar los datos del registro de correo.
- **assets/**: Contiene activos estáticos como el archivo `export.csv` utilizado para importar datos de precios y `copia.bat` para copiar y eliminar archivos del addon en la carpeta del repositorio.

### Personalización

- **Uso del Addon**: El addon puede ser utilizado para cualquier profesión, no solo Inscripción. Los elementos insertados en la base de datos son aquellos añadidos a la lista de compras de Auctionator, lo que permite flexibilidad en el seguimiento y la gestión de ítems en diferentes profesiones.

### Aviso Legal

Esta herramienta está destinada únicamente para fines educativos. Por favor, respeta los términos de servicio de World of Warcraft.

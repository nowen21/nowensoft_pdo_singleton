<?php

require_once('app/config/app.php'); // Incluir el archivo de configuración de la aplicación
require_once('app/database/DBConnection.php'); // Incluir el archivo de conexión a la base de datos
require_once('app/models/Model.php'); // Incluir el archivo de la clase Model

Model::setTableName('usuario'); // Establecer el nombre de la tabla en el modelo 'usuario'
Model::getAll(); // Obtener todos los registros de la tabla 'usuario' utilizando el modelo

Model::setTableName('users'); // Establecer el nombre de la tabla en el modelo 'users'
Model::connetion('nowengd')->getAll(); // Obtener todos los registros de la tabla 'users' utilizando el modelo y la conexión 'nowengd'




<?php
$dotenvData = file_get_contents('.env'); // Leer el contenido del archivo .env

$dotenvLines = explode("\n", $dotenvData); // Dividir el contenido en líneas individuales
$envVariables = []; // Array para almacenar las variables de entorno

foreach ($dotenvLines as $line) {
    $line = trim($line); // Eliminar espacios en blanco al inicio y final de la línea
    if ($line && strpos($line, '=') !== false) { // Verificar que la línea no esté vacía y contenga el símbolo '='
        [$name, $value] = explode('=', $line, 2); // Dividir la línea en nombre y valor de la variable
        $envVariables[$name] = $value; // Almacenar la variable en el array $envVariables
    }
}

/**
 * La función permite obtener el valor de una variable de entorno a partir de su nombre. Se accede al array $envVariables que contiene las variables de entorno y se devuelve el valor asociado al nombre proporcionado.
 */
function get_env($clavexxx, $valorxxx)
{
    global $envVariables; // Acceder al array $envVariables en el ámbito global
    return $envVariables[$clavexxx]; // Obtener el valor de la variable de entorno correspondiente al nombre proporcionado
}

define('APP_URL', get_env('APP_URL', '')); // Definir constante 'APP_URL' con el valor de la variable de entorno 'APP_URL' o una cadena vacía si no está definida
define('SERVER_NAME', $_SERVER['SERVER_NAME']); // Definir constante 'SERVER_NAME' con el valor de la variable superglobal $_SERVER['SERVER_NAME']
define('SERVER_PORT', $_SERVER['SERVER_PORT']); // Definir constante 'SERVER_PORT' con el valor de la variable superglobal $_SERVER['SERVER_PORT']
define('DOCUMENT_ROOT', $_SERVER['DOCUMENT_ROOT']); // Definir constante 'DOCUMENT_ROOT' con el valor de la variable superglobal $_SERVER['DOCUMENT_ROOT']
define('REMOTE_ADDR', $_SERVER['REMOTE_ADDR']); // Definir constante 'REMOTE_ADDR' con el valor de la variable superglobal $_SERVER['REMOTE_ADDR']

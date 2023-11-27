<?php 

use mysqli;

/**Conexion a la base de datos
 * se utiliza exit para que en caso de la conexion tenga error
 */

function conectaDB() : mysqli {
    
    /**
     * Conexion a la base de datos con POO
     * */
    $db = new mysqli(
        $_ENV['DB_HOST'],
        $_ENV['DB_USER'],
        $_ENV['DB_PASS'],
        $_ENV['DB_NAME']
    );


    // debuguear($_ENV);

    mysqli_set_charset($db, "utf8");

    if(!$db) {
        echo 'conexion incorrecta';
        exit;
    }

    return $db;


    /**
     * Conexion a la base de datos utilizando programación funcional
     * */

    // $host = 'localhost';
    // $usr = 'root';
    // $psw = 'root';
    // $db_name = 'uptask_mvc';
    // $db = mysqli_connect($host, $usr, $psw, $db_name);
    // $db->set_charset('utf8');

    // if (!$db) {
    //     echo "Error: No se pudo conectar a MySQL.";
    //     echo "errno de depuración: " . mysqli_connect_errno();
    //     echo "error de depuración: " . mysqli_connect_error();
    //     exit;
    // }
    
};

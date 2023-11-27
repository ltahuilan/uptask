<?php

use Model\ActiveRecord;

require __DIR__.'/../vendor/autoload.php';
// require '../vendor/autoload.php';

//libreria phpdotenv
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/config/');

//metodo sefaload() en caso de que no este presente el archivo no emita error
$dotenv->safeLoad();

require 'funciones.php';
require 'config/database.php';

//obtener la conexion a la base de datos --disponible en cualquier archivo al utilizar app.php
$db = conectaDB();

ActiveRecord::setDB($db);
<?php
require_once("config.php");
date_default_timezone_set('America/Cuiaba');

try {
    $pdo = new PDO("mysql:dbname=$banco; host=$servidor", "$usuario", "$senha");
} catch (\Throwable $th) {
    echo "erro ao se conectar com banco " . $th->getMessage();
}
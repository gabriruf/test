<?php
    define('ROOT_PATH', dirname(__DIR__, 1));

    $envfile = parse_ini_file(ROOT_PATH . '/.env');
    $servername = $envfile["SERVER_NAME"]; 
    $dbusername = $envfile["DB_USERNAME"];
    $dbpassword = $envfile["DB_PASSWD"];
    $dbname = $envfile["DB_NAME"];
    $dsn = "mysql:host=$servername;charset=utf8mb4";

    try {
        $conn = new PDO($dsn, $dbusername, $dbpassword, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);

        $conn -> query("CREATE DATABASE IF NOT EXISTS $dbname");
        $conn -> query("use $dbname");
    } catch(PDOException $e) {
        die("Could not connect. " . $e->getMessage());
    }

<?php
    try {
        $tables = $conn->prepare("SHOW TABLES LIKE 'Users'");
        $tables->execute();
        if ($tables->rowCount() < 1) {
            $conn->prepare(
                "CREATE TABLE doafacil.Users (
                    id_user           SERIAL PRIMARY KEY,
                    nome_user         VARCHAR(50) NOT NULL,
                    email_user        VARCHAR(70) NOT NULL UNIQUE,
                    endereco_user     VARCHAR(70),
                    num_endereco_user NUMERIC(3,0) CHECK (num_endereco_user >= 1 AND num_endereco_user <= 255),
                    cel_user          VARCHAR(14),
                    cep_user          VARCHAR(9),
                    tipo_user         VARCHAR(9) NOT NULL,
                    pass_user         VARCHAR(255) NOT NULL
                );"
            )->execute();
        }
    } catch(PDOException $e) {
        $sql = $conn->errorInfo();
        echo "Erro ao criar tabela: $sql <br>" . $e->getMessage();
    }
<?php
// databas koppling
class Database {
    private $pdo;

    public function __construct($config, $user = "root", $passw = "") {
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ];
        $dsn = http_build_query($config, "", ";");

        $pdo = new PDO("mysql:" . $dsn, $user, $passw, $options);
        $this->pdo = $pdo;
    }

    public function query($sql, $parameters = []) {
        try {
            $statement = $this->pdo->prepare($sql);
            $statement->execute($parameters);
            return $statement;
        } catch (PDOException $e) {
            echo "SQL error: ". $e->getMessage();
        }
    }

    public function fetchAll($statement) {
        return $statement->fetchAll();
    }

    public function fetchOne($statement) {
        return $statement->fetch();
    }
}
<?php

class DbConnection {

    private $dsn;
    private $username;
    private $password;
    private $connection;

    public function __construct(string $dsn, string $username, string $password) {
        $this->dsn = $dsn;
        $this->username = $username;
        $this->password = $password;
    }

    public function connect() {
        try {
            $this->connection = new PDO($this->dsn, $this->username, $this->password);
        } catch (Exception $e) {
            print $e->getMessage();
            error_log($e->getMessage());
            error_log($e->getTraceAsString());
            $this->connection = false;
        } catch (PDOException $p) {
            print $p->getMessage();
            error_log($p->getMessage());
            error_log($p->getTraceAsString());
            $this->connection = false;
        }

        return $this->connection;
    }

}

<?php
namespace src;
use \PDO;

class DbConnection {

    private $dsn;
    private $username;
    private $password;
    
    // Notice that PDO variable is made public. That's because we will need to 
    // access the full PDO functionality through this variable.
    // https://phpdelusions.net/pdo/common_mistakes
    
    public $connection;
    
    /**
     * function __construct
     * Parameters match the arguments needed to create a PDO object.
     * @param string $dsn
     * @param string $username
     * @param string $password
     */
    public function __construct(string $dsn, string $username, string $password) {
        $this->dsn = $dsn;
        $this->username = $username;
        $this->password = $password;
    }

    /**
     * function connect
     * The Exception and PDO Exception must be caught with a backslash
     * because they're outside the src namespace defined in this project.
     * @return boolean
     */
    public function connect() {
        try {
            $this->connection = new PDO($this->dsn, $this->username, $this->password);
        } catch (\Exception $e) {
            print $e->getMessage();
            error_log($e->getMessage());
            error_log($e->getTraceAsString());
            return false;
        } catch (\PDOException $p) {
            print $p->getMessage();
            error_log($p->getMessage());
            error_log($p->getTraceAsString());
            return false;
        }
        return true;
    }
}

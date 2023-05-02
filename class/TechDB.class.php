<?php

final class TechDB {

    private $db = null;

    public function __destruct() {
        $this->db = null;
    }

    /**
     * @param string $sql
     * @return bool|mysqli_result
     * @throws Exception
     */
    public function query($sql) {
        $res = $this->getDB()->query($sql);
        if ($this->getDB()->error) {
            try {
                throw new Exception("MySQLi error " . $this->db->error . " <br> Query:<br>" . $sql, $this->db->errno);
            } catch (Exception $ex) {
                echo "Error No: " . $ex->getCode() . " - " . $ex->getMessage() . "<br >";
                echo nl2br($ex->getTraceAsString());
            }
        }
        return $res;
    }

    /**
     * @return mysqli|null
     * @throws Exception
     */
    private function getDB() {
        if ($this->db !== null) {
            return $this->db;
        }
        $config = Config::getConfig("db");
        try {
            $this->db = new mysqli($config['hostname'], $config['username'], $config['password'], $config['database']);
        } catch (Exception $ex) {
            throw new Exception('DB connection error: ' . $ex->getMessage());
        }
        mysqli_set_charset($this->db, $config['charset']);
        return $this->db;
    }

}

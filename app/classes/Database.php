<?php

class Database extends PDO  {

    private $stm;
    private $result;

    public function __construct() {
        try {
            parent::__construct(DB_TYPE . ':host='. DB_HOST . ';dbname=' . DB_NAME, DB_USER, DB_PASS);
            $this->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->exec("SET NAMES 'utf8';");
        } catch (PDOException $e) {
            echo '<p class="echoError">Error Connection, code : ' . $e->getCode() . '<br/>' . $e->getMessage(). '</p>';
        }
    }

    protected function executeParams($fields) {
        if (!empty($fields)) {
            foreach($fields as $key => $val){
                $this->stm->bindValue(":$key", $val);
            }
        }
        $this->stm->execute();
        return $this->stm;
    }

    public function insert($table, $fields){
        $fieldNames = implode('`, `', array_keys($fields));
        $fieldValues = ':' . implode(', :', array_keys($fields));
        $this->stm = $this->prepare("INSERT INTO $table (`$fieldNames`) VALUES ($fieldValues)");
        $this->executeParams($fields);
        return $this->lastInsertId();
    }

    public function delete($table, $fields, $where, $limit = 1) {
        $this->stm = $this->prepare("DELETE FROM $table WHERE $where LIMIT $limit");
        return $this->executeParams($fields)->rowCount();
    }

    public function update($table, $fields, $where){
        $fieldDetails = array();
        foreach ($fields as $key => $val) {
            $fieldDetails[] = "`$key` = :$key";
        }
        $fieldDetail = implode(', ', $fieldDetails);
        $this->stm = $this->prepare("UPDATE $table SET $fieldDetail WHERE $where");
        return $this->executeParams($fields)->rowCount();
    }

    public function deleteById($table, $id) {
        return $this->delete($table, array('id' => $id), 'id = :id');
    }

    public function updateById($table, $id, $params) {
        $params['id'] = $id;
        return $this->update($table, $params, 'id = :id');
    }

    public function query($sql, $params = array()) {
        $this->stm = $this->prepare($sql);
        if (!empty($params)) {
            foreach($params as $key => $val){
                $this->stm->bindValue(":$key", $val);
            }
        }
        $this->stm->execute();
        return $this;
    }

    public function all($fetchMode = PDO::FETCH_OBJ) {
        return $this->stm->fetchAll($fetchMode);
    }

    public function one($fetchMode = PDO::FETCH_OBJ) {
        return $this->stm->fetch($fetchMode);
    }

    public function selectOneObject($table, $id) {
        return $this->query("SELECT * FROM $table WHERE id = :id", array('id' => $id))->one();
    }

    public function selectAllObject($table) {
        return $this->query("SELECT * FROM $table")->all();
    }
}

?>

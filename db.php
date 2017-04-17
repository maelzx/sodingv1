<?php

//reference: https://www.if-not-true-then-false.com/2012/php-pdo-sqlite3-example

Class Db {

    private $db;

    function __construct()
    {
        $this->db = new PDO('sqlite:todo.sqlite3');
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    function insert_todo($name, $due_date)
    {
        $sql = "INSERT INTO todo (id, name, due_date) values(:id, :name, :due_date)";
        $query = $this->db->prepare($sql);

        $id = $this->get_todo_latest_id()['id'] + 1;

        $query->bindParam(':name', $name);
        $query->bindParam(':due_date', $due_date);
        $query->bindParam(':id', $id);

        $query->execute();
    }

    function get_all_todo()
    {
        $sql = "SELECT * FROM todo ORDER BY id DESC";
        $query = $this->db->prepare($sql);
        $query->execute();

        $rows = $query->fetchAll(PDO::FETCH_ASSOC);
        return $rows;
    }

    function get_todo($id)
    {
        $sql = "SELECT * FROM todo WHERE id = :id";
        $query = $this->db->prepare($sql);

        $query->bindParam(':id', $id);

        $query->execute();

        $row = $query->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    function get_todo_latest_id()
    {
        $sql = "SELECT id FROM todo ORDER BY id DESC LIMIT 1";
        $query = $this->db->prepare($sql);

        $query->execute();

        $row = $query->fetch(PDO::FETCH_ASSOC);
        return $row;
    }

    function update_todo($id, $name, $due_date)
    {
        $sql = "UPDATE todo SET name = :name, due_date = :due_date WHERE id = :id";
        $query = $this->db->prepare($sql);

        $query->bindParam(':id', $id);
        $query->bindParam(':name', $name);
        $query->bindParam(':due_date', $due_date);

        return $query->execute();
    }

    function delete_todo($id)
    {
        $sql = "DELETE FROM todo WHERE id = :id";
        $query = $this->db->prepare($sql);

        $query->bindParam(':id', $id);

        return $query->execute();
    }


}

?>

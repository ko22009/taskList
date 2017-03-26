<?php

class modelList extends Model
{
    function __construct()
    {
        parent::__construct();
    }
    function read($id)
    {
        $query = "SELECT * FROM lists WHERE id_user=:id";
        $stmt = $this->connection->prepare($query);
        if ($stmt->execute([':id' => $id])) {
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
            if (count($rows) > 0)
            {
                return $rows;
            }
        }
        return [];
    }
}
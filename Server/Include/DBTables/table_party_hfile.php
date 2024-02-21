<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/Server/Include/connect.php';
    function GetLastPartyId()
    {
        global $db;
        $sql = "SELECT * FROM table_party
                ORDER BY party_id DESC LIMIT 1;";

        $statement = $db->prepare($sql);
        $statement->execute();

        $last_party_row = $statement->fetch();
        $result = $last_party_row['party_id'];
        return $result;
    }

    function GetPartyStatusFromId($param_party_id)
    {
        global $db;
        $sql = "SELECT * FROM table_party
                WHERE party_id = :party_id;";

        $statement = $db->prepare($sql);
        $statement->bindParam(":party_id", $param_party_id);
        $statement->execute();

        $local_party_row = $statement->fetch();
        $result = $local_party_row['party_status'];
        return $result;
    }

    function GetPartyGridFromId($param_party_id)
    {
        global $db;
        $sql = "SELECT * FROM table_party
                WHERE party_id = :party_id;";

        $statement = $db->prepare($sql);
        $statement->bindParam(":party_id", $param_party_id);
        $statement->execute();

        $local_party_row = $statement->fetch();
        $result = $local_party_row['party_grid'];
        return $result;
    }

    function CreateNewPartyRow($param_party_status, $param_party_grid, $param_queue_id)
    {
        global $db;
        $sql = "INSERT INTO table_party (party_status, party_grid, queue_id)
            VALUES (:party_status, :party_grid, :queue_id);";

        $statement = $db->prepare($sql);
        $statement->bindParam(":party_status", $param_party_status);
        $statement->bindParam(":party_grid", $param_party_grid);
        $statement->bindParam(":queue_id", $param_queue_id);
        $statement->execute();
    }

    function UpdatePartyStatus($param_party_id, $param_party_status)
    {
        global $db;
        $sql = "UPDATE table_party SET party_status = :party_status
                WHERE party_id = :party_id;";

        $statement = $db->prepare($sql);
        $statement->bindParam(":party_status", $param_party_status);
        $statement->bindParam(":party_id", $param_party_id);
        $statement->execute();
    }

    function UpdatePartyGrid($param_party_id, $param_player_cell, $param_player_color)
    {
        $local_party_grid = GetPartyGridFromId($param_party_id);
        $local_party_grid = json_decode($local_party_grid, true)['party_grid'];

        if ($local_party_grid[$param_player_cell['y_cell']][$param_player_cell['x_cell']] != eGridColors::EMPTY)
        {
            return false;
        }
        
        $local_party_grid[$param_player_cell['y_cell']][$param_player_cell['x_cell']] = $param_player_color;
        $local_party_grid = json_encode(["party_grid" => $local_party_grid]);        

        global $db;
        $sql = "UPDATE table_party SET party_grid = :party_grid
                WHERE party_id = :party_id;";

        $statement = $db->prepare($sql);
        $statement->bindParam(":party_grid", $local_party_grid);
        $statement->bindParam(":party_id", $param_party_id);
        $statement->execute();
        return true;
    }
?>
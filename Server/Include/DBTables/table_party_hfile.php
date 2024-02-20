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

    function UpdatePartyGrid($param_party_id, $param_player_grid, $param_player_color)
    {
        global $EMPTY_PARTY_GRID;
        $param_player_grid = json_decode($param_player_grid, true)['party_grid'];

        if (count($param_player_grid) != count($EMPTY_PARTY_GRID))
        {
            return false;
        }

        foreach ($param_player_grid as $each_grid_line)
        {
            if (count($each_grid_line) != count($EMPTY_PARTY_GRID[0]))
            {
                return false;
            }
        }

        $local_party_grid = GetPartyGridFromId($param_party_id);
        $local_party_grid = json_decode($local_party_grid, true)['party_grid'];
        $differences_count = 0;

        foreach ($param_player_grid as $player_grid_rowindex => $each_grid_line)
        {
            foreach ($each_grid_line as $player_grid_colindex => $each_cellstatus)
            {
                if ($each_cellstatus != $local_party_grid[$player_grid_rowindex][$player_grid_colindex])
                {
                    if ($differences_count > 0)
                    {
                        return false;
                    }

                    if ($param_player_grid[$player_grid_rowindex][$player_grid_colindex] != $param_player_color)
                    {
                        return false;
                    }

                    $differences_count += 1;
                }
            }
        }

        if ($differences_count == 0)
        {
            return false;
        }

        $param_player_grid = json_encode(["party_grid" => $param_player_grid]);

        global $db;
        $sql = "UPDATE table_party SET party_grid = :party_grid
                WHERE party_id = :party_id;";

        $statement = $db->prepare($sql);
        $statement->bindParam(":party_grid", $param_player_grid);
        $statement->bindParam(":party_id", $param_party_id);
        $statement->execute();
        return true;
    }
?>
<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/Server/Include/connect.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/Server/Include/globals.php';

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

    function SetQueuePlayersInParty($param_queue_id)
    {
        global $db;
        $sql = "SELECT * FROM table_player
                WHERE queue_id = :queue_id;";

        $statement = $db->prepare($sql);
        $statement->bindParam(":queue_id", $param_queue_id);
        $statement->execute();

        $players_in_party = $statement->fetchAll();
        $param_party_id = GetLastPartyId();

        foreach ($players_in_party as $each_player)
        {
            $each_player_id = $each_player['player_id'];
            $sql = "UPDATE table_player SET party_id = :party_id
                    WHERE player_id = :player_id;";

            $statement = $db->prepare($sql);
            $statement->bindParam(":party_id", $param_party_id);
            $statement->bindParam(":player_id", $each_player_id);
            $statement->execute();
        }
    }

    function IsPlayerAlreadyInParty($param_player_id)
    {
        global $db;
        $sql = "SELECT * FROM table_player
                WHERE player_id = :player_id;";

        $statement = $db->prepare($sql);
        $statement->bindParam(":player_id", $param_player_id);
        $statement->execute();

        $player_row = $statement->fetch();
        if (!$player_row)
        {
            return false;
        }

        $local_party_id = $player_row['party_id'];
        if (!$local_party_id)
        {
            return false;
        }

        return true;
    }

    function GetPlayerGridInRequest()
    {
        $result = "";
        if (!isset($_GET['player_grid']))
        {
            return $result;
        }

        $result = $_GET['player_grid'];
        return $result;
    }

    function GetPlayerGiveUpInRequest()
    {
        $result = false;
        if (!isset($_GET['player_give_up']))
        {
            return $result;
        }

        $result = $_GET['player_give_up'];
        return $result;
    }

    function GetPartyIdFromPlayerId($param_player_id)
    {
        global $db;
        $sql = "SELECT * FROM table_player
                WHERE player_id = :player_id;";

        $statement = $db->prepare($sql);
        $statement->bindParam(":player_id", $param_player_id);
        $statement->execute();

        $local_player_row = $statement->fetch();
        $result = $local_player_row['party_id'];
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

    function GetPlayerColorFromId($param_player_id)
    {
        global $db;
        $sql = "SELECT * FROM table_player
                WHERE player_id = :player_id;";

        $statement = $db->prepare($sql);
        $statement->bindParam(":player_id", $param_player_id);
        $statement->execute();

        $local_player_row = $statement->fetch();
        $result = $local_player_row['player_color'];
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

    /* We verify the grid lines
     * We verify the grid columns
     * We verify the diagonals
     * We verify the reversed diagonals
     * We return the player number if party is finished
     * We return the empty color if party continues
     */
    function IsGridPartyFinished($param_party_id)
    {
        $local_party_grid = GetPartyGridFromId($param_party_id);
        $local_party_grid = json_decode($local_party_grid, true)['party_grid'];

        for ($rowindex = 0; $rowindex < count($local_party_grid); $rowindex++)
        {
            for ($colindex = 0; $colindex < count($local_party_grid[0]) - 3; $colindex++)
            {
                if ($local_party_grid[$rowindex][$colindex] == $local_party_grid[$rowindex][$colindex + 1] &&
                    $local_party_grid[$rowindex][$colindex] == $local_party_grid[$rowindex][$colindex + 2] &&
                    $local_party_grid[$rowindex][$colindex] == $local_party_grid[$rowindex][$colindex + 3] &&
                    $local_party_grid[$rowindex][$colindex] != 0) {
                    return $local_party_grid[$rowindex][$colindex];
                }
            }
        }

        for ($colindex = 0; $colindex < count($local_party_grid[0]); $colindex++)
        {
            for ($rowindex = 0; $rowindex < count($local_party_grid) - 3; $rowindex++)
            {
                if ($local_party_grid[$rowindex][$colindex] == $local_party_grid[$rowindex + 1][$colindex] &&
                    $local_party_grid[$rowindex][$colindex] == $local_party_grid[$rowindex + 2][$colindex] &&
                    $local_party_grid[$rowindex][$colindex] == $local_party_grid[$rowindex + 3][$colindex] &&
                    $local_party_grid[$rowindex][$colindex] != 0) {
                    return $local_party_grid[$rowindex][$colindex];
                }
            }
        }

        for ($rowindex = 0; $rowindex < count($local_party_grid) - 3; $rowindex++)
        {
            for ($colindex = 0; $colindex < count($local_party_grid[0]) - 3; $colindex++)
            {
                if ($local_party_grid[$rowindex][$colindex] == $local_party_grid[$rowindex + 1][$colindex + 1] &&
                    $local_party_grid[$rowindex][$colindex] == $local_party_grid[$rowindex + 2][$colindex + 2] &&
                    $local_party_grid[$rowindex][$colindex] == $local_party_grid[$rowindex + 3][$colindex + 3] &&
                    $local_party_grid[$rowindex][$colindex] != 0) {
                    return $local_party_grid[$rowindex][$colindex];
                }
            }
        }

        for ($rowindex = 0; $rowindex < count($local_party_grid) - 3; $rowindex++)
        {
            for ($colindex = 3; $colindex < count($local_party_grid[0]); $colindex++)
            {
                if ($local_party_grid[$rowindex][$colindex] == $local_party_grid[$rowindex + 1][$colindex - 1] &&
                    $local_party_grid[$rowindex][$colindex] == $local_party_grid[$rowindex + 2][$colindex - 2] &&
                    $local_party_grid[$rowindex][$colindex] == $local_party_grid[$rowindex + 3][$colindex - 3] &&
                    $local_party_grid[$rowindex][$colindex] != 0) {
                    return $local_party_grid[$rowindex][$colindex];
                }
            }
        }

        return eGridColors::EMPTY;
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
?>
<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/Common/globals.php';

    require_once $_SERVER['DOCUMENT_ROOT'].'/Server/Include/DBTables/table_party_hfile.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/Server/Include/DBTables/table_player_party_hfile.php';

    if (!isset($_COOKIE['player_id']) || !isset($_COOKIE['player_name']))
    {
        header('location: http://powerplay4/Client/Errors/player_play_party_missing_cookies.php');
        die(eCookiesErrors::MISSING_COOKIES_FOR_PARTY);
    }

    $player_id = $_COOKIE['player_id'];
    $player_name = $_COOKIE['player_name'];

    $party_id = GetPartyIdFromPlayerId($player_id);
    $party_status = GetPartyStatusFromId($party_id);

    if ($party_status == ePartyStatus::WINNER_PLAYER_1 || $party_status == ePartyStatus::WINNER_PLAYER_2)
    {
        header('location: http://powerplay4/Client/party_finished.php?party_id='.$party_id);
        die(ePlayerPlayPartyErrors::ERROR_PARTY_ALREADY_FINISHED);
    }

    $player_turn_name = "";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="player_play_party.css">
    <link rel="stylesheet" href="global-styles.css">
    <title>PowerPlay4</title>
</head>
<body>
    <div class="container center-items">
        <div class="w-50 flex-column align-items-center justify-content-center">
            <h1 class="text-primary text-center">Waiting for player: <?=$player_turn_name?> action!</h1>
            <br>
            <table class="table table-bordered">
                <tbody>
                    <tr>
                        <td class="td-childrens"><div class="div-square empty-color"></div></td>
                        <td class="td-childrens"><div class="div-square empty-color"></div></td>
                        <td class="td-childrens"><div class="div-square empty-color"></div></td>
                        <td class="td-childrens"><div class="div-square empty-color"></div></td>
                        <td class="td-childrens"><div class="div-square empty-color"></div></td>
                        <td class="td-childrens"><div class="div-square empty-color"></div></td>
                        <td class="td-childrens"><div class="div-square empty-color"></div></td>
                    </tr>
                        <td class="td-childrens"><div class="div-square empty-color"></div></td>
                        <td class="td-childrens"><div class="div-square empty-color"></div></td>
                        <td class="td-childrens"><div class="div-square empty-color"></div></td>
                        <td class="td-childrens"><div class="div-square empty-color"></div></td>
                        <td class="td-childrens"><div class="div-square empty-color"></div></td>
                        <td class="td-childrens"><div class="div-square empty-color"></div></td>
                        <td class="td-childrens"><div class="div-square empty-color"></div></td>
                    </tr>
                    <tr>
                        <td class="td-childrens"><div class="div-square empty-color"></div></td>
                        <td class="td-childrens"><div class="div-square empty-color"></div></td>
                        <td class="td-childrens"><div class="div-square empty-color"></div></td>
                        <td class="td-childrens"><div class="div-square empty-color"></div></td>
                        <td class="td-childrens"><div class="div-square empty-color"></div></td>
                        <td class="td-childrens"><div class="div-square empty-color"></div></td>
                        <td class="td-childrens"><div class="div-square empty-color"></div></td>
                    </tr>
                    <tr>
                        <td class="td-childrens"><div class="div-square empty-color"></div></td>
                        <td class="td-childrens"><div class="div-square empty-color"></div></td>
                        <td class="td-childrens"><div class="div-square empty-color"></div></td>
                        <td class="td-childrens"><div class="div-square empty-color"></div></td>
                        <td class="td-childrens"><div class="div-square empty-color"></div></td>
                        <td class="td-childrens"><div class="div-square empty-color"></div></td>
                        <td class="td-childrens"><div class="div-square empty-color"></div></td>
                    </tr>
                    <tr>
                        <td class="td-childrens"><div class="div-square empty-color"></div></td>
                        <td class="td-childrens"><div class="div-square empty-color"></div></td>
                        <td class="td-childrens"><div class="div-square empty-color"></div></td>
                        <td class="td-childrens"><div class="div-square empty-color"></div></td>
                        <td class="td-childrens"><div class="div-square empty-color"></div></td>
                        <td class="td-childrens"><div class="div-square empty-color"></div></td>
                        <td class="td-childrens"><div class="div-square empty-color"></div></td>
                    </tr>
                    <tr>
                        <td class="td-childrens"><div class="div-square empty-color"></div></td>
                        <td class="td-childrens"><div class="div-square empty-color"></div></td>
                        <td class="td-childrens"><div class="div-square empty-color"></div></td>
                        <td class="td-childrens"><div class="div-square empty-color"></div></td>
                        <td class="td-childrens"><div class="div-square empty-color"></div></td>
                        <td class="td-childrens"><div class="div-square empty-color"></div></td>
                        <td class="td-childrens"><div class="div-square empty-color"></div></td>
                    </tr>
                </tbody>
            </table>            
            <br>
            <a class="btn btn-danger w-100" href="http://powerplay4/Server/player_play_party.php?player_give_up=true" role="button">Do you want to give up ?!</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
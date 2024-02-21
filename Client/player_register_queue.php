<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/powerplay4'.'/Common/globals.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/powerplay4'.'/Server/Fetch/get_party_id_from_player_id.php';
    
    $player_id = 0;
    if (isset($_COOKIE['player_id']))
        $player_id = $_COOKIE['player_id'];

    $player_name = "";
    if (isset($_COOKIE['player_name']))
        $player_name = $_COOKIE['player_name'];

    $unregister_request = "";
    if (isset($_COOKIE['player_name']))
    {
        $unregister_request = "?player_name=".$_COOKIE['player_name']."&player_unregister=true";
    }

    // We redirect to party if it has been started
    $party_id = get_party_id_from_player_id($player_id);
    if ($party_id != 0)
    {
        header($HEADER_RELOCATION_START.'/Client/player_play_party.php');
        die(eRegisterQueueSuccess::SUCCESSFULLY_WENT_TO_PARTY);
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">
    <link rel="stylesheet" href="global-styles.css">
    <title>PowerPlay4</title>
</head>
<body>
    <div class="container center-items">
        <div class="w-50 flex-column align-items-center justify-content-center">
            <h1 class="text-primary text-center">Waiting for another player!</h1>
            <h2 class="text-info text-center">Your player name is: <?=$player_name;?></h1>
            <h3 class="text-info text-center">Your player id is: <?=$player_id;?></h1>
            <br>
            <a class="btn btn-primary w-100" href="<?=$GLOBAL_RELOCATION_START?>/Server/player_register_queue.php<?=$unregister_request;?>" role="button">Unregister from queue!</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
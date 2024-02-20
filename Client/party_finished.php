<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/Common/globals.php';
    require_once $_SERVER['DOCUMENT_ROOT'].'/Server/Fetch/get_winner_name_from_party_id.php';

    if (!(isset($_GET['party_id']) && $_GET['party_id'] > 0))
    {
        die(eFetchWinnerNameErrors::ERROR_PARTY_ID_IS_NOT_SET);
    }

    $party_id = $_GET['party_id'];
    $winner_name = get_winner_name_from_party_id($party_id);
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
        <div class="alert alert-info" role="alert">This party is finished! Winner is: <?=$winner_name?>
            <br>
            <a class="btn btn-primary w-100" href="http://powerplay4/Client/index.php" role="button">Play another party!</a>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
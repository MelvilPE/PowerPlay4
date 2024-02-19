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
            <h1 class="text-primary text-center">Hello world!</h1>
            <h2 class="text-info text-center">Play PowerPlay4 with your friends on same network!</h2>
            <br>
            <form action="http://powerplay4/Server/player_register_queue.php" method="GET">
                <div class="form-group">
                    <input type="text" class="form-control text-center" id="player_name" name="player_name" placeholder="Set your player name here">
                    <input class="btn btn-primary w-100" type="submit" value="Register in queue!">
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
</body>
</html>
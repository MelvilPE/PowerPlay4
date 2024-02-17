<?php
    class eRegisterQueueErrors {
        const MISSING_PLAYER_NAME_IN_REQUEST = "MISSING_PLAYER_NAME_IN_REQUEST";
        const PLAYER_NAME_CANT_BE_EMPTY = "PLAYER_NAME_CANT_BE_EMPTY";
        const FAILED_FETCHING_QUEUE_STATUS = "FAILED_FETCHING_QUEUE_STATUS";
        const FAILED_FETCHING_LAST_PLAYER = "FAILED_FETCHING_LAST_PLAYER";
        const FAILED_UNREGISTERING_PLAYER = "FAILED_UNREGISTERING_PLAYER";
        const PLAYER_ALREADY_IN_PARTY = "PLAYER_ALREADY_IN_PARTY";
    }

    class eRegisterQueueSuccess {
        const SUCCESSFULLY_REGISTERED_PLAYER = "SUCCESSFULLY_REGISTERED_PLAYER";
        const SUCCESSFULLY_UNREGISTERED_PLAYER = "SUCCESSFULLY_UNREGISTERED_PLAYER";
    }

    class eQueueStatus {
        const NO_PLAYERS_IN_QUEUE = 0;
        const ONE_PLAYER_IN_QUEUE = 1;
        const QUEUE_READY = 2;
    }

    class ePlayerColors {
        const YELLOW = 0;
        const RED = 1;
    }

    class eCreatePartyErrors {
        const QUEUE_NOT_READY = "QUEUE_NOT_READY";
        const FAILED_TO_GET_PLAYERS_FROM_QUEUE = "FAILED_TO_GET_PLAYERS_FROM_QUEUE";
    }

    class ePartyStatus {
        const TURN_PLAYER_1 = 0;
        const TURN_PLAYER_2 = 1;
        const WINNER_PLAYER_1 = "WINNER_PLAYER_1";
        const WINNER_PLAYER_2 = "WINNER_PLAYER_2";
    }

    $EMPTY_PARTY_GRID = [
        [0, 0, 0, 0, 0, 0, 0],
        [0, 0, 0, 0, 0, 0, 0],
        [0, 0, 0, 0, 0, 0, 0],
        [0, 0, 0, 0, 0, 0, 0],
        [0, 0, 0, 0, 0, 0, 0],
        [0, 0, 0, 0, 0, 0, 0]
    ];
    $EMPTY_PARTY_GRID_JSON = json_encode(["party_grid" => $EMPTY_PARTY_GRID]);
?>
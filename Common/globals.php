<?php
    $VIRTUAL_HOST_FOLDER_NAME = 'powerplay4';
    $GLOBAL_RELOCATION_START = 'http://'.$_SERVER['SERVER_ADDR'].'/'.$VIRTUAL_HOST_FOLDER_NAME;
    $HEADER_RELOCATION_START = 'Location: '.$GLOBAL_RELOCATION_START;
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
        const SUCCESSFULLY_WENT_TO_PARTY = "SUCCESSFULLY_WENT_TO_PARTY";
    }

    class eQueueStatus {
        const NO_PLAYERS_IN_QUEUE = 0;
        const ONE_PLAYER_IN_QUEUE = 1;
        const QUEUE_READY = 2;
    }

    class eGridColors {
        const EMPTY = 0;
        const PLAYER_1 = 1;
        const PLAYER_2 = 2;
    }

    class eCreatePartyErrors {
        const QUEUE_NOT_READY = "QUEUE_NOT_READY";
        const FAILED_TO_GET_PLAYERS_FROM_QUEUE = "FAILED_TO_GET_PLAYERS_FROM_QUEUE";
    }

    class eCreatePartySuccess {
        const SUCCESSFULLY_CREATED_PARTY = "SUCCESSFULLY_CREATED_PARTY";
    }

    class ePartyStatus {
        const TURN_PLAYER_1 = eGridColors::PLAYER_1;
        const TURN_PLAYER_2 = eGridColors::PLAYER_2;
        const WINNER_PLAYER_1 = 3;
        const WINNER_PLAYER_2 = 4;
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

    class ePlayerPlayPartyErrors {
        const ERROR_PLAYER_ID_IS_NOT_SET = "ERROR_PLAYER_ID_IS_NOT_SET";
        const ERROR_PLAYER_CELL_IS_NOT_SET = "ERROR_PLAYER_CELL_IS_NOT_SET";
        const ERROR_PLAYER_NOT_PARTY = "ERROR_PLAYER_NOT_PARTY";
        const ERROR_PARTY_ALREADY_FINISHED = "ERROR_PARTY_ALREADY_FINISHED";
        const ERROR_WRONG_PLAYER_TURN = "ERROR_WRONG_PLAYER_TURN";
        const ERROR_WRONG_PLAYER_CELL = "ERROR_WRONG_PLAYER_CELL";
    }

    class ePlayerPlayPartySuccess {
        const SUCCESSFULLY_UPDATED_GRID = "SUCCESSFULLY_UPDATED_GRID";
        const WINNER_PLAYER_1 = "WINNER_PLAYER_1";
        const WINNER_PLAYER_2 = "WINNER_PLAYER_2";
    }

    class eFetchWinnerNameErrors {
        const ERROR_PARTY_ID_IS_NOT_SET = "ERROR_PARTY_ID_IS_NOT_SET";
    }

    class eCookiesErrors {
        const MISSING_COOKIES_FOR_PARTY = "MISSING_COOKIES_FOR_PARTY";
    }
?>
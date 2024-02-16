<?php
    class eRegisterQueueErrors {
        const MISSING_PLAYER_NAME_IN_REQUEST = "MISSING_PLAYER_NAME_IN_REQUEST";
        const PLAYER_NAME_CANT_BE_EMPTY = "PLAYER_NAME_CANT_BE_EMPTY";
        const FAILED_FETCHING_QUEUE_STATUS = "FAILED_FETCHING_QUEUE_STATUS";
        const FAILED_FETCHING_LAST_PLAYER = "FAILED_FETCHING_LAST_PLAYER";
        const FAILED_UNREGISTERING_PLAYER = "FAILED_UNREGISTERING_PLAYER";
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
?>
<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/Server/Include/connect.php';

	require_once $_SERVER['DOCUMENT_ROOT'].'/Server/player_play_party_hfile.php';

	if (!isset($_COOKIE['player_id']))
    {
        header('location: http://powerplay4/Client/Errors/player_play_party_missing_cookies.php');
		die(ePlayerPlayPartyErrors::ERROR_PLAYER_ID_IS_NOT_SET);
    }
	$player_id = $_COOKIE['player_id'];

	$party_id = GetPartyIdFromPlayerId($player_id);
	if ($party_id == 0)
	{
		die(ePlayerPlayPartyErrors::ERROR_PLAYER_NOT_PARTY);
	}

	$party_status = GetPartyStatusFromId($party_id);
	if ($party_status == ePartyStatus::WINNER_PLAYER_1 || $party_status == ePartyStatus::WINNER_PLAYER_2)
	{
		die(ePlayerPlayPartyErrors::ERROR_PARTY_ALREADY_FINISHED);
	}

	$player_color = GetPlayerColorFromId($player_id);

	$player_give_up = GetPlayerGiveUpInRequest();
	if ($player_give_up)
	{
		$message;
		if ($player_color == eGridColors::PLAYER_2)
		{
			$party_status = ePartyStatus::WINNER_PLAYER_1;
			$message = ePlayerPlayPartySuccess::WINNER_PLAYER_1;
		}
		else
		{
			$party_status = ePartyStatus::WINNER_PLAYER_2;
			$message = ePlayerPlayPartySuccess::WINNER_PLAYER_2;
		}

		UpdatePartyStatus($party_id, $party_status);
		header('location: http://powerplay4/Client/player_play_party.php');
		die($message);
	}

	if ($player_color != $party_status)
	{
		die(ePlayerPlayPartyErrors::ERROR_WRONG_PLAYER_TURN);
	}

	$player_grid = GetPlayerGridInRequest();
	if ($player_grid == "")
	{
		die(ePlayerPlayPartyErrors::ERROR_PLAYER_GRID_IS_NOT_SET);
	}

	if (!UpdatePartyGrid($party_id, $player_grid, $player_color))
	{
		die(ePlayerPlayPartyErrors::ERROR_WRONG_PLAYER_GRID);
	}

	$player_finished = IsGridPartyFinished($party_id);
	if (!$player_finished)
	{
		if ($party_status == eGridColors::PLAYER_1)
		{
			$party_status = eGridColors::PLAYER_2;
		}
		else
		{
			$party_status = eGridColors::PLAYER_1;
		}
	}
	else
	{
		if ($player_finished == eGridColors::PLAYER_1)
		{
			$party_status = ePartyStatus::WINNER_PLAYER_1;
		}
		else
		{
			$party_status = ePartyStatus::WINNER_PLAYER_2;
		}
	}

	UpdatePartyStatus($party_id, $party_status);
	if ($player_finished)
	{
		if ($player_finished == eGridColors::PLAYER_1)
		{
			die(ePlayerPlayPartySuccess::WINNER_PLAYER_1);
		}
		else
		{
			die(ePlayerPlayPartySuccess::WINNER_PLAYER_2);
		}
	}

	die(ePlayerPlayPartySuccess::SUCCESSFULLY_UPDATED_GRID);
?>
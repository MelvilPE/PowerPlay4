<?php
    require_once $_SERVER['DOCUMENT_ROOT'].'/Server/Include/connect.php';

	require_once $_SERVER['DOCUMENT_ROOT'].'/Server/player_play_party_hfile.php';

	$player_id = GetPlayerIdInRequest();
	if ($player_id == 0)
	{
		die(ePlayerPlayPartyErrors::ERROR_PLAYER_ID_IS_NOT_SET);
	}

	$player_grid = GetPlayerGridInRequest();
	if ($player_grid == "")
	{
		die(ePlayerPlayPartyErrors::ERROR_PLAYER_GRID_IS_NOT_SET);
	}

	$party_id = GetPlayerPartyIdFromPlayerId($player_id);
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
	if ($player_color != $party_status)
	{
		die(ePlayerPlayPartyErrors::ERROR_WRONG_PLAYER_TURN);
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
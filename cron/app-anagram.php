<?php
	require_once( dirname(__DIR__).'/autoload.php');
	$pdo = new pdodb();
	$go = new utility();
	$pdo->query("SELECT count(*) as F_GRAM FROM cfc_games WHERE F_GRAM = 0");
	$row = $pdo->row();
	if(isset($row['F_GRAM']) && $row['F_GRAM'] > 1) {
		$go->DoAnagram();
	} else {
		$pdo->query("UPDATE cfc_games SET F_GRAM='0' WHERE F_ID > 0");
		$pdo->execute();
		$go->DoAnagram();
	}

<?php

defined('ABSPATH') or die("No Script Kiddies allowed!");


function getOppenentUnit()
{
    $oppenentUnit = ["cavalry", "archers", "pikemen"];
    return $oppenentUnit[array_rand($oppenentUnit)];
}


function getWinner($user, $computer)
{
    switch ($user) {
        case 'cavalry':
            if ($computer == 'archers') {
                return [0 => true, 1 => false];
            } else if ($computer == 'pikemen') {
                return [0 => false, 1 => true];
            } else {
                return [0 => false, 1 => false];
            }
            break;

        case 'archers':
            if ($computer == 'pikemen') {
                return [0 => true, 1 => false];
            } else if ($computer == 'cavalry') {
                return [0 => false, 1 => true];
            } else {
                return [0 => false, 1 => false];
            }
            break;

        case 'pikemen':
            if ($computer == 'cavalry') {
                return [0 => true, 1 => false];
            } else if ($computer == 'archers') {
                return [0 => false, 1 => true];
            } else {
                return [0 => false, 1 => false];
            }
            break;
    }
}

function createUser($user, $auth)
{
    global $wpdb;
    $tableName = $wpdb->prefix . NNC_TBL;
    return $wpdb->insert($tableName, [
        'username' => $user,
        'auth_token' => $auth,
        'game_rounds' => ''
    ]);
}


function save_round($winner)
{
    global $wpdb;
    $tableName = $wpdb->prefix . NNC_TBL;
    $authToken = sanitize_text_field($_COOKIE['nn_game_user_id']);
    $rounds = get_rounds();
    if (count($rounds) < 20) {
        $rounds[] = $winner;
    }
    $Rounds = serialize($rounds);
    return $wpdb->update($tableName, ['game_rounds' => $Rounds], ['auth_token' => $authToken]);
}


function get_rounds()
{
    global $wpdb;
    $tableName = $wpdb->prefix . NNC_TBL;
    $authToken = sanitize_text_field($_COOKIE['nn_game_user_id']);
    $row = $wpdb->get_row("SELECT * FROM $tableName WHERE auth_token='$authToken'");
    if (empty($row->game_rounds)) {
        return [];
    }
    return (array) unserialize($row->game_rounds);
}


function nn_get_user_name(){
    global $wpdb;
    $tableName = $wpdb->prefix . NNC_TBL;
    $authToken = sanitize_text_field($_COOKIE['nn_game_user_id']);
    $row = $wpdb->get_row("SELECT * FROM $tableName WHERE auth_token='$authToken'");
    return $row->username;   
}
<?php
defined('ABSPATH') or die("No Script Kiddies allowed!");

register_activation_hook(NN_CHALLENGE_FILE, function () {
    global $wpdb;
    $tableName = $wpdb->prefix . NNC_TBL;
    $charset_collate = $wpdb->get_charset_collate();
    $createTable = "CREATE TABLE IF NOT EXISTS `$tableName` (
        `id` int(11) NOT NULL AUTO_INCREMENT,
        `username` varchar(255) NOT NULL,
        `auth_token` varchar(255) NOT NULL,
        `game_rounds` text NOT NULL,
        `created_at` datetime NOT NULL DEFAULT current_timestamp(),
        PRIMARY KEY (`id`)
    ) $charset_collate";
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($createTable);
});

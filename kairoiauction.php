<?php
/**
*Plugin Name: Kairoi Auction Bidding and Voting Plugin
*Description: To execute the process flow of bidding for time slots and voting for already existing bids.
*Version: 1.0.0
*Author: Ebaad Ansari
*License: Open Source
**/
if ( ! defined( 'ABSPATH' ) ) {
	die( 'Invalid request.' );
}
if (! defined( 'kairoiauction_dir_path' ) ) {
	define('kairoiauction_dir_path',plugin_dir_path(__FILE__));
}
if (! defined( 'kairoiauction_url' ) ) {
	define('kairoiauction_url',plugins_url().'/kairoiauction');
}

/**
*Logic to be executed on plugin initialization
*/

function on_activate()
{
    global $wpdb;
    $charset_collate = $wpdb->get_charset_collate();
	$table_name = $wpdb->prefix . 'kairoi_auction_master';
	
	//checking and making table that stores the total time and the time consumed in the auction

	if (count($wpdb->get_results("SHOW TABLES LIKE '$table_name'"))==0){
		$table = "CREATE TABLE $table_name (
                        sno INT NOT NULL AUTO_INCREMENT,
                        total_time INT NOT NULL,
                        time_consumed INT NOT NULL,
						time_in_auction INT NOT NULL,
                        PRIMARY KEY  (sno)
        )$charset_collate;";
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php'); //to call dbDelta
        dbDelta($table); //dbDelta function is located at upgrade.php
	}
	
	//checking and making table for storing information about all users who bid

    if (count($wpdb->get_results("SHOW TABLES LIKE 'wp_kairoi_bidding_users'"))==0){
        $table = "CREATE TABLE wp_kairoi_bidding_users (
                        user_sno INT NOT NULL AUTO_INCREMENT,
                        email VARCHAR(30),
						nickname VARCHAR (40),
                        voted_bids VARCHAR (1000) NOT NULL,
                        PRIMARY KEY  (user_sno)
		)$charset_collate;";
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php'); //to call dbDelta
		dbDelta($table); //dbDelta function is located at upgrade.php
	}
	
	//checking and making table to store the seven slot times

	if (count($wpdb->get_results("SHOW TABLES LIKE 'wp_kairoi_slot_time'"))==0){
		$table = "CREATE TABLE wp_kairoi_slot_time (
						slot_time_sno INT NOT NULL AUTO_INCREMENT,
						time INT NOT NULL,
                        max_no INT NOT NULL,
						PRIMARY KEY  (slot_time_sno)
		) $charset_collate;";
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php'); //to call dbDelta
		dbDelta($table); //dbDelta function is located at upgrade.php
	}

	//checking and then making table for storing all the slots 

	if (count($wpdb->get_results("SHOW TABLES LIKE 'wp_kairoi_slots'"))==0){
		$table = "CREATE TABLE wp_kairoi_slots (
						slot_sno INT NOT NULL AUTO_INCREMENT,
						slot_time_sno INT NOT NULL,
						created_on DATETIME NOT NULL,
						no_of_bids INT NOT NULL,
						is_slot_open_for_voting BOOLEAN DEFAULT 0,
						opened_for_voting_on DATETIME,
						voted_ips VARCHAR(4000) NOT NULL,
						PRIMARY KEY  (slot_sno),
                        FOREIGN KEY (slot_time_sno) REFERENCES wp_kairoi_slot_time(slot_time_sno)
		) $charset_collate;";
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php'); //to call dbDelta
		dbDelta($table); //dbDelta function is located at upgrade.php
	}
	
	// checking and then making table for storing all bids

    if (count($wpdb->get_results("SHOW TABLES LIKE 'wp_kairoi_bids'"))==0){
		$table = "CREATE TABLE wp_kairoi_bids (
						bid_sno INT NOT NULL AUTO_INCREMENT,
						slot_sno INT NOT NULL,
						user_sno INT NOT NULL,
						description VARCHAR(250) NOT NULL,
						ip VARCHAR(100) NOT NULL,
						votes INT NOT NULL,
						is_winner BOOLEAN DEFAULT 0,
						bidded_on DATETIME NOT NULL,
						PRIMARY KEY  (bid_sno),
                        FOREIGN KEY (slot_sno) REFERENCES wp_kairoi_slots(slot_sno),
                        FOREIGN KEY (user_sno) REFERENCES wp_kairoi_bidding_users(user_sno)
		) $charset_collate;";
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php'); //to call dbDelta
		dbDelta($table); //dbDelta function is located at upgrade.php
	}

	// checking and then making table for storing all entries from the contact form

	if (count($wpdb->get_results("SHOW TABLES LIKE 'wp_kairoi_contacts'"))==0){
		$table = "CREATE TABLE wp_kairoi_contacts (
						contact_sno INT NOT NULL AUTO_INCREMENT,
						name VARCHAR(40) NOT NULL,
						email VARCHAR(40) NOT NULL,
						comment VARCHAR(100) NOT NULL,
						posted_on DATETIME NOT NULL,
						PRIMARY KEY  (contact_sno)
		) $charset_collate;";
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php'); //to call dbDelta
		dbDelta($table); //dbDelta function is located at upgrade.php
	}

	// checking and then making table for storing all winners (manual entry for starters, form to be developed later)

	if (count($wpdb->get_results("SHOW TABLES LIKE 'wp_kairoi_winners'"))==0){
		$table = "CREATE TABLE wp_kairoi_winners (
						winner_sno INT NOT NULL AUTO_INCREMENT,
						nickname VARCHAR(40) NOT NULL,
						slot_time INT NOT NULL,
						description VARCHAR(100) NOT NULL,
						PRIMARY KEY  (winner_sno)
		) $charset_collate;";
		require_once( ABSPATH . 'wp-admin/includes/upgrade.php'); //to call dbDelta
		dbDelta($table); //dbDelta function is located at upgrade.php
	}
}
register_activation_hook( __FILE__ , 'on_activate' );

/**
*Logic to be executed on plugin uninstallation
*/

function on_uninstall()
{
	global $wpdb;
	$table_name = $wpdb->prefix . 'wp_kairoi_auction_master';
	$wpdb->query('DROP TABLE IF EXISTS $table_name ;');
}
register_uninstall_hook( __FILE__ , 'on_uninstall' );

/**
*Enqueue styles for the plugin
*/

function kairoi_auction_styles() 
{
    wp_enqueue_style( 'styles', plugins_url( '/assets/styles.css', __FILE__ ) );
}
add_action( 'wp_enqueue_scripts', 'kairoi_auction_styles' );

/**
*Register shortcode to import plugin functionality anywhere in the website
*Any page that uses the shortcode will call the function kairoi_auction_main
*This function is defined in kairoiauctionmain.php file
*/

require_once( ABSPATH . 'wp-content/plugins/kairoiauction/kairoiauctionmain.php'); 
add_shortcode( 'kairoi-auction', 'kairoi_auction_main' );

/**
*To redirect URLs to other php files stored in the views folder
*/
function custom_rewrite_basic() {
	add_rewrite_rule('^minute-(.)+/slot-(.)+/([A-Za-z0-9-]+)/thank-you', 'wp-content/plugins/kairoiauction/views/thankyou.php', 'top');
	add_rewrite_rule('^minute-(.)+/vote/slot-(.)+/thank-you', 'wp-content/plugins/kairoiauction/views/thankyou.php', 'top');
    add_rewrite_rule('^minute-(.)+/slot-(.)+/([A-Za-z0-9-]+)/([A-Za-z0-9-]+)', 'wp-content/plugins/kairoiauction/views/error.php', 'top');

    add_rewrite_rule('^minute-(.)+/slot-(.)+/bid', 'wp-content/plugins/kairoiauction/views/bid.php', 'top');
	
	add_rewrite_rule('^minute-(.)+/vote/slot-(.)+', 'wp-content/plugins/kairoiauction/views/vote.php', 'top');

	add_rewrite_rule('^minute-(.)+/vote', 'wp-content/plugins/kairoiauction/views/vote-show-slots.php', 'top');

    //add_rewrite_rule('^minute-(.)+/slot-(.)+', 'wp-content/plugins/kairoiauction/views/slot.php', 'top');
    
	add_rewrite_rule('^minute-(.)+', 'wp-content/plugins/kairoiauction/views/minute.php', 'top');
	
	add_rewrite_rule('^about', 'wp-content/plugins/kairoiauction/views/about.php', 'top');
	add_rewrite_rule('^instructions', 'wp-content/plugins/kairoiauction/views/instructions.php', 'top');
	add_rewrite_rule('^rules', 'wp-content/plugins/kairoiauction/views/rules.php', 'top');
	add_rewrite_rule('^contact', 'wp-content/plugins/kairoiauction/views/contact.php', 'top');
	add_rewrite_rule('^winners', 'wp-content/plugins/kairoiauction/views/winners.php', 'top');
}
add_action('init', 'custom_rewrite_basic');
?>
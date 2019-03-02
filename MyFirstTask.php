<?php
/*
* Plugin Name: Form Plugin Task
* Description: WordPress Plugin For a Form With a List Of Entries Below It.  
* Version:     1.0
* Author:      Mohd Hassaan Raza
* Author URI:  https://www.linkedin.com/in/hassaan-raza-844453149
*/


/****** Plugin Activation ******/

// Register Activation Hook
register_activation_hook(__FILE__,"DB_tb_create");

// function to Create a Table in the Database
function DB_tb_create() {

    global $wpdb;

    /* Create Table Name with Prefix */
    $DB_tb_name = $wpdb -> prefix ."form_details"; 

    /* Write Query */
    $DB_query = "CREATE TABLE $DB_tb_name(
        id int(10) NOT NULL AUTO_INCREMENT,
        username varchar(100) DEFAULT '',
        email varchar(100) DEFAULT '',
        PRIMARY KEY(id)
    )";

    /* Execute Query */
    require_once(ABSPATH ."wp-admin/includes/upgrade.php");
    dbDelta($DB_query);

}



/****** Plugin Deactivation ******/

// Register Deactivation Hook
register_deactivation_hook(__FILE__,"DB_tb_delete");

// Delete the Table from Database
function DB_tb_delete() {

    global $wpdb;

    /* Table Name with Prefix */
    $DB_tb_name = $wpdb -> prefix ."form_details"; 

    /* Write Query */
    $DB_query = $wpdb -> query("DROP TABLE $DB_tb_name");

    /* Execute Query */
    require_once(ABSPATH ."wp-admin/includes/upgrade.php");
    dbDelta($DB_query);
}



// Add the Form function
function add_form() {

    // Include form 
    include_once("MyFirstTask_form.php");  
}



/****** Admin Panel ******/

// Define absolute path to avoid direct access
if(!defined('ABSPATH')) {
    define('ABSPATH', dirname(__FILE__) . '/');
}

define('MFT_dir',dirname(__FILE__));
define('MFT_url',plugins_url('',__FILE__));

// Add Menu
add_action('admin_menu', 'MFT_add_menu_function');
// Add CSS
add_action('admin_enqueue_scripts', 'MFT__admin_styles');


// Add Menu function
function MFT_add_menu_function() {
    add_menu_page(
        'My_First_Task Plugin', // Page Title
        'My_First_Task', // Menu Title
        'manage_options',  // Capability
        'MFT_plugin_page', // Menu Slug
        'add_form', // Callable function
        //MFT_url.'' // Icon Url
    );
}

// Add CSS 
function MFT__admin_styles() {
    if($_GET['page']=='MFT_plugin_page') {
        wp_enqueue_style('MFT_styles', MFT_url. '/css/style.css');
    }
}

?>
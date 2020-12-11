<?php
/*
   Plugin Name: Sub Site Syndication
   Plugin URI: https://emberlydigital.com/
   description: Extended functionality to create post syndication (push and pull) for WIN Intelligence websites.
   Version: 1.2
   Author: Emberly Digital
   Author URI: https://emberlydigital.com/
   License: GPL2
   */
   


if ( ! defined( 'ABSPATH' ) ) {
    die; // Die if accessed directly
}

/* MAGMA syndication */
include( plugin_dir_path( __FILE__ ) . 'initiatives/magma.php');

/* MI Apprenticeship syndication */
include( plugin_dir_path( __FILE__ ) . 'initiatives/mi_apprenticeship.php');

/* MI Bright Future syndication */
include( plugin_dir_path( __FILE__ ) . 'initiatives/mi_bright_future.php');

/* Opportunity Detroit Tech syndication */
include( plugin_dir_path( __FILE__ ) . 'initiatives/opportunity_detroit_tech.php');

/* Advance MI Manufacturing syndication */
include( plugin_dir_path( __FILE__ ) . 'initiatives/advance_mi_manufacturing.php');

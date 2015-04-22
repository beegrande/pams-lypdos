<?php

/**
 * Plugin Name: Table Sorter
 * Plugin URI: http://tablesorter.oregasoft.com
 * Description: This plugin makes your standard HTML tables sortable. For more details, visit plugin's setting page
 * Version: 1.0
 * Author: Farhan Noor
 * Author URI: http://linkedin.com/in/thenoors
 * License: Commercial
 */

wp_register_script( 'table-sorter', plugins_url( 'pams-lypdos/pams-tablesorter/jquery.tablesorter.min.js' ), array( 'jquery' ) );
wp_enqueue_script( 'pams-tablesorter-metadata', plugins_url( 'pams-lypdos/pams-tablesorter/jquery.metadata.js' ), array( 'table-sorter' ) );
//

wp_enqueue_script( 'pams-tablesorter-custom-js', plugins_url( 'pams-lypdos/pams-tablesorter/wp-script.js', 'table-sorter' ) );
wp_enqueue_style( 'pams-tablesorter-custom', plugins_url( 'pams-lypdos/pams-tablesorter/tblsort.css' ) );


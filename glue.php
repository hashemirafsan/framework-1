<?php defined('ABSPATH') or die;

/**
 * @package Glue
 */

/*
Plugin Name: Glue
Description: Simple WordPress Plugin.
Version: 1.0.0
Author: Sheikh Heera
Author URI: https://heera.it
License: GPLv2 or later
Text Domain: glue
*/



include "app/Foundation/Bootstrap.php";

\Glue\App\Foundation\Bootstrap::boot(__FILE__);

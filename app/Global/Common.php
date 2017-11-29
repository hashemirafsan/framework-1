<?php

/**
 * Declare common (backend|frontend) global functions here
 * but try not to use any global functions unless you need.
 */

if (! function_exists('dd')) {
	function dd() {
        echo "<pre>";
        foreach (func_get_args() as $value) {
            print_r($value);
            echo "<br>";
        }
		die;
	}
}
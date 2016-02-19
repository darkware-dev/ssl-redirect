<?php
/*******************************************************************************
 * ssl-redirect: A WordPress plugin to do simple HTTP-to-HTTPS redirection.
 * Copyright (c) 2016  jeff@darkware.org and contributors
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 ******************************************************************************/

/**
Plugin Name: SSL Redirect
Plugin URI: http://darkware.org/ssl-redirect/
Description: Redirect HTTP connections to use HTTPS.
Version: 0.1
Author: Jeff Sharpe
Author URI: http://darkware.org/
License: GPLv3 or later
*/

include 'ssl-redirect-options.php';

/* Add the hook for doing the actual redirect */
add_action('template_redirect', 'ssl_redirect_redirect_check');

/* Set up the admin menu and settings panel */
function ssl_redirect_plugin_menu()
{
    add_options_page( 'SSL Redirect', 'SSL Redirect', 'manage_options', 'ssl_redirect_opt', 'ssl_redirect_options' );
}
add_action('admin_menu', 'ssl_redirect_plugin_menu');

/* Set up options handling */
function register_ssl_redirect_settings()
{
    register_setting('ssl_redirect_opts', 'global_enable');
    register_setting('ssl_redirect_opts', 'ssl_redirect_domains', 'ssl_redirect_domain_normalize');
}
add_action('admin_init', 'register_ssl_redirect_settings');

function ssl_redirect_domain_normalize($input)
{
    $normalized = array();
    $domains = preg_split("/\\s+/", trim($input));

    foreach ($domains as $domain)
    {
        $domain = trim($domain);
        $normalized[] = $domain;
    }

    return implode("\n", $normalized);
}

function ssl_redirect_redirect_check()
{
    // Check for the HTTPS flag
    if (array_key_exists('HTTPS', $_SERVER)
        && $_SERVER['HTTPS'] == "on") return;

    // Check for a pretty-standard X-Forwarded-Proto header
    if (array_key_exists('HTTP_X_FORWARDED_PROTO', $_SERVER)
        && $_SERVER['HTTP_X_FORWARDED_PROTO'] == "https") return;

    $host = $_SERVER["HTTP_HOST"];
    // Check to see if the host is in the enabled list
    $domains = preg_split("/\\s+/", trim(get_option('ssl_redirect_domains')));

    if (in_array($host, $domains))
    {
        $ssl_url = "https://" . $host . $_SERVER["REQUEST_URI"];
        wp_redirect($ssl_url, 301);
        exit();
    }
}

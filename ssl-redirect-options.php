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

function ssl_redirect_options()
{
    if (!current_user_can('manage_options'))
    {
        wp_die( __('You do not have permission to access this page.'));
    }

    // Page header
    print('<div class="wrap">');
    print('<h2>SSL Redirection</h2>');

    // Form Setup
    print('<form method="post" action="options.php">');
    settings_fields('ssl_redirect_opts');
    do_settings_sections('ssl_redirect_opts');

    print('<table class="form-table">');
    print('<tbody>');

    print('<tr>');
    print('<th scope="row">SSL Domain Names</th>');
    print('<td><textarea name="ssl_redirect_domains" rows="8", cols="60">');
    print(esc_html(get_option('ssl_redirect_domains')));
    print('</textarea>');
    print('<p class="description">(Enter each domain to require HTTPS connections. One per line.)</p>');
    print('</td>');

    print('</tr>');

    print('</tbody>');
    print('</table>');

    // And a button would be nice...
    submit_button();

    // All Done
    print('</form>');
    print('</div>');


}

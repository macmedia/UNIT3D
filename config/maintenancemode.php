<?php
/**
 * NOTICE OF LICENSE
 *
 * UNIT3D is open-sourced software licensed under the GNU General Public License v3.0
 * The details is bundled with this project in the file LICENSE.txt.
 *
 * @project    UNIT3D
 * @license    https://www.gnu.org/licenses/agpl-3.0.en.html/ GNU Affero General Public License v3.0
 * @author     HDVinnie
 */

return [

    /**
     * The view to show to users when maintenance mode is currently enabled
     *
     * @var string
     */
    'view' => 'maintenance.app-down',

    /**
     * Include CSS styles with the optional notification view
     *
     * @var boolean
     */
    'notification-styles' => true,

    /**
     * Configuration values for injecting variables into the views
     *
     * Variables available:
     * [prefix]Enabled - If maintenance mode is currently enabled
     * [prefix]Timestamp - The timestamp of when maintenance mode was enabled
     * [prefix]Message - The message passed in with the command, if applicable
     *
     * @var array
     */
    'inject' => [

        /**
         * Make variables accessible in all views
         *
         * If set to false, only the maintenance page will have access to these variables
         *
         * @var boolean
         */
        'global' => true,

        /**
         * Prefix the variables to prevent name collisions
         *
         * @var string
         */
        'prefix' => 'MaintenanceMode',
    ],

    /**
     * The path to the language file to use
     *
     * @var string
     */
    'language-path' => 'maintenance',

    /**
     * An array of IP address that will never see the maintenance page
     *
     * To be used in conjunction with the IPWhitelist exemption class
     *
     * @var array
     */
    'exempt-ips' => ['127.0.0.1'],

    /**
     * Use proxies to get the user's IP address
     *
     * See: http://symfony.com/doc/current/components/http_foundation/trusting_proxies.html
     *
     * @var boolean
     */
    'exempt-ips-proxy' => false,

    /**
     * An array of environments that will never show the maintenance page
     *
     * To be used in conjunction with the EnvironmentWhitelist exemption class
     *
     * @var array
     */
    'exempt-environments' => ['local'],

    /**
     * A list of exemption classes to execute
     *
     * Each of these classes should extend
     * \App\Exemptions\MaintenanceModeExemption
     * and contain an "isExempt" method that returns a boolean value on
     * if the user should or should not see the maintenance page.
     *
     * @var array
     */
    'exemptions' => [

        /*
         * IPWhitelist exempts users with the IPs matched in the "exempt-ips" config
         */
        App\Exemptions\IPWhitelist::class,

        /*
         * EnvironmentWhitelist exempts installations with environments matched in the "exempt-environments" config
         */
        App\Exemptions\EnvironmentWhitelist::class,
    ],
];

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

namespace App\Exemptions;

/**
 * Class EnvironmentWhitelist
 *
 * Checks to see if the Laravel environment matches any of the whitelisted environments in the configuration
 *
 */
class EnvironmentWhitelist extends MaintenanceModeExemption
{
    /**
     * Execute the exemption check
     *
     * @return bool
     */
    public function isExempt()
    {
        $ignoreEnvs = config('maintenancemode.exempt-environments', []);

        if(is_array($ignoreEnvs) && in_array($this->app->environment(), $ignoreEnvs))
        {
            return true;
        }

        // We did not have a match
        return false;
    }
}

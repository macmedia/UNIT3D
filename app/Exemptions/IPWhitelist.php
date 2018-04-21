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

use Illuminate\Http\Request;

/**
 * Class IPWhitelist
 *
 * Checks to see if the user's IP matches any of the IPs whitelisted in the configuration
 *
 */
class IPWhitelist extends MaintenanceModeExemption
{
    /**
     * Execute the exemption check
     *
     * @return bool
     */
    public function isExempt(Request $request)
    {
        $authorizedIPs = config('maintenancemode.exempt-ips', []);
        $useProxy = config('maintenancemode.exempt-ips-proxy', false);
        $userIP = $request->getClientIp($useProxy);

        if(is_array($authorizedIPs) && in_array($userIP, $authorizedIPs))
        {
            return true;
        }

        // We did not have a match
        return false;
    }
}

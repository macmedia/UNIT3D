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

namespace App\Listeners;

use App\Events\MaintenanceModeEnabled;

class LogMaintenanceStarted
{
    /**
     * Log when maintenance mode starts and the message shown (if applicable)
     *
     * @param \App\Events\MaintenanceModeEnabled $maintenanceMode
     */
    public function handle(MaintenanceModeEnabled $maintenanceMode)
    {
        $logMessage = "Maintenance Mode Enabled";
        if(!is_null($maintenanceMode->message) && $maintenanceMode->message !== "")
        {
            $logMessage .= " with a custom message: \"" . $maintenanceMode->message . "\"";
        }
        notice($logMessage);
    }
}

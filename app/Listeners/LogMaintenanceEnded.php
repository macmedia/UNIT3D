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

use App\Events\MaintenanceModeDisabled;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class LogMaintenanceEnded
{
    /**
     * Log when maintenance mode ends, and for how long it was down
     *
     * @param \App\Events\MaintenanceModeDisabled $maintenanceMode
     */
    public function handle(MaintenanceModeDisabled $maintenanceMode)
    {
        $startingTime = $maintenanceMode->time;
        Log::notice("Maintenance Mode Disabled, total downtime was " . Carbon::now()->diffForHumans($startingTime, true, true, 6));
    }
}

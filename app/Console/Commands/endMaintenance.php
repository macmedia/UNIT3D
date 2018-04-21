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

namespace App\Console\Commands;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Console\UpCommand;
use App\Events\MaintenanceModeDisabled;
use Carbon\Carbon;

/**
 * Class endMaintenance
 *
 *
 */
class endMaintenance extends UpCommand
{
    /**
     * Execute the maintenance mode command
     *
     * @return mixed
     */
    public function handle()
    {
        // Verify we're actually down!
        if(!file_exists($this->laravel->storagePath().'/framework/down'))
        {
            $this->info('Application is already live.');
            return false;
        }

        // Grab the data
        $data = @json_decode(file_get_contents($this->laravel->storagePath().'/framework/down'), true);
        if(!isset($data) || !is_array($data))
        {
            $data = [];
        }
        $data = array_merge(["time" => null, "message" => null, "view" => null, "retry" => null], $data);

        // Remove the down file
        @unlink(storage_path('framework/down'));

        // Show how long the application was down for
        $startingTime = Carbon::createFromTimestamp($data['time']);
        $this->info("The application is now live! Total downtime: " . Carbon::now()->diffForHumans($startingTime, true, true, 6));

        // Fire the event
        Event::fire(new MaintenanceModeDisabled($data['time'], $data['message'], $data['view'], $data['retry']));
    }
}

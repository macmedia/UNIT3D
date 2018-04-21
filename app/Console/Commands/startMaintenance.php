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

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Console\DownCommand;
use App\Events\MaintenanceModeEnabled;

/**
 * Class startMaintenance
 *
 *
 */
class startMaintenance extends DownCommand
{
    /**
     * Flag to abort the command (e.g. bad view selected)
     *
     * @var bool
     */
    protected $abort = false;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'down {--message= : The message for the maintenance mode. }
            {--retry= : The number of seconds after which the request may be retried.}
            {--view= : The view to use for this instance of maintenance mode.}';

    /**
     * Execute the maintenance mode command
     *
     * @return bool|void
     */
    public function handle()
    {
        if($this->abort)
        {
            return false;
        }

        // Call the original method, writing to the down file & console output
        parent::handle();

        // Fire an event
        $payload = $this->getDownFilePayload();
        Event::fire(new MaintenanceModeEnabled($payload['time'], $payload['message'], $payload['view'], $payload['retry']));
    }

    /**
     * Get the payload to be placed in the "down" file.
     *
     * @return array
     */
    protected function getDownFilePayload()
    {
        // Get the Laravel file data & add ours (selected view)
        $data = parent::getDownFilePayload();
        $data['view'] = $this->getSelectedView();
        return $data;
    }

    /**
     * Get the selected view, if one exists
     *
     * @return string
     */
    protected function getSelectedView()
    {
        $view = $this->option('view');

        // Verify the user passed us a correct view
        if($view && !$this->laravel->view->exists($view))
        {
            $this->error("The view \"{$view}\" does not exist.");
            if(!$this->confirm('Do you wish to continue? [y|N]'))
            {
                $this->abort = true;
            }
            else
            {
                $this->info('OK, falling back to the view defined in the config file.');
            }
        }

        return $view;
    }
}

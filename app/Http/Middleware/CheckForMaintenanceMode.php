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

namespace App\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\CheckForMaintenanceMode as LaravelMaintenanceMode;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\App;
use App\Exceptions\MaintenanceModeException;
use App\Exceptions\InvalidExemption;
use App\Exceptions\ExemptionDoesNotExist;
use Carbon\Carbon;

/**
 * Class CheckForMaintenanceMode
 *
 *
 */
class CheckForMaintenanceMode extends LaravelMaintenanceMode
{

    /**
     * The language path
     *
     * @var string
     */
    protected $language;

    /**
     * The prefix for the view variables
     *
     * @var string
     */
    protected $prefix;

    /**
     * If the information should be injected into all the views
     *
     * @var bool
     */
    protected $inject = false;

    /**
     * Handle the request
     *
     * @param \Illuminate\Http\Request $request
     * @param  \Closure                $next
     * @return Response
     * @throws ExemptionDoesNotExist
     * @throws InvalidExemption
     */
    public function handle($request, Closure $next)
    {
        // Grab our configs
        $this->inject = config('maintenancemode.inject.globally', true);
        $this->prefix = config('maintenancemode.inject.prefix', 'MaintenanceMode');
        $this->language = config('maintenancemode.language-path', 'maintenance');

        // Setup value array
        $info = [
            'Enabled'     => false,
            'Timestamp'   => time(),
            'Message'     => $this->language . '.message',
            'View'        => null,
            'Retry'       => 60,
        ];

        // Are we down?
        if($this->app->isDownForMaintenance())
        {
            // Yes. :(
            Carbon::setLocale(App::getLocale());

            $info['Enabled'] = true;

            $data = json_decode(file_get_contents($this->app->storagePath().'/framework/down'), true);

            // Update the array with data from down file
            $info['Timestamp'] = Carbon::createFromTimestamp($data['time']);

            if(isset($data['message']) && $data['message'])
            {
                $info['Message'] = $data['message'];
            }
            if(isset($data['view']) && $data['view'])
            {
                $info['View'] = $data['view'];
            }
            if(isset($data['retry']) && intval($data['retry'], 10) !== 0)
            {
                $info['Retry'] = intval($data['retry'], 10);
            }

            // Inject the information into the views before the exception
            $this->injectIntoViews($info);

            if(!$this->isExempt())
            {
                // The user isn't exempt, so show them the error page
                throw new MaintenanceModeException($data['time'], $data['retry'], $data['message'],  $data['view']);
            }
        }
        else
        {
            // Inject the default information into the views
            $this->injectIntoViews($info);
        }

        return $next($request);
    }

    /**
     * Inject the prefixed data into the views
     *
     * @param $info
     * @return null
     */
    protected function injectIntoViews($info)
    {
        if($this->inject)
        {
            // Inject the information globally (to prevent the need of isset)
            foreach($info as $key => $value)
            {
                $this->app['view']->share($this->prefix . $key, $value);
            }
        }
    }

    /**
     * Check if a user is exempt from the maintenance mode page
     *
     * @return bool
     * @throws ExemptionDoesNotExist
     * @throws InvalidExemption
     */
    protected function isExempt()
    {
        // Grab all of the exemption classes to create/execute against
        $exemptions = config('maintenancemode.exemptions', []);
        foreach($exemptions as $className)
        {
            if(class_exists($className))
            {
                $exemption = new $className($this->app);
                if($exemption instanceof MaintenanceModeExemption)
                {
                    // Run the exemption check
                    if($exemption->isExempt())
                    {
                        return true;
                    }
                }
                else
                {
                    // Class doesn't match what we're looking for
                    throw new InvalidExemption($this->language . '.exceptions.invalid', ['class' => $className]);
                }
            }
            else
            {
                // Where's Waldo?
                throw new ExemptionDoesNotExist($this->language . '.exceptions.missing', ['class' => $className]);
            }
        }
        return false;
    }
}

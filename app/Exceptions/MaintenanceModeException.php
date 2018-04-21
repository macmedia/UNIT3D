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

namespace App\Exceptions;

use Illuminate\Contracts\Support\Responsable;

class MaintenanceModeException extends \Illuminate\Foundation\Http\Exceptions\MaintenanceModeException implements Responsable
{

    /**
     * View name to show
     *
     * @var string
     */
    public $view;

    /**
     * Create a new exception instance.
     *
     * @param                 $time
     * @param null            $retryAfter
     * @param null            $message
     * @param null            $view
     * @param \Exception|null $previous
     * @param int             $code
     */
    public function __construct($time, $retryAfter = null, $message = null, $view = null, \Exception $previous = null, $code = 0)
    {
        parent::__construct($time, $retryAfter, $message, $previous, $code);

        $this->view = $view;
    }

    /**
     * Build a response for Laravel to show
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function toResponse($request)
    {
        $headers = array();
        if ($this->retryAfter) {
            $headers = array('Retry-After' => $this->retryAfter);
        }

        // Figure out what view to show them
        $view = view()->first([$this->view, config("maintenancemode.view"), "errors/503", "maintenancemode::app-down"], []);

        return response($view, 503)->withHeaders($headers);
    }
}

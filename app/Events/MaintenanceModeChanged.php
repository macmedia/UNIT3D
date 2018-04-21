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

namespace App\Events;

use Carbon\Carbon;

abstract class MaintenanceModeChanged
{

    /**
     * The timestamp the application went down
     *
     * @var Carbon|null
     */
    public $time;

    /**
     * The custom message shown to the end users
     *
     * @var string|null
     */
    public $message;

    /**
     * The view name to use
     *
     * @var string|null
     */
    public $view;

    /**
     * The number of seconds to send in the Retry-After header
     *
     * @var int|null
     */
    public $retry;

    /**
     * Build a new event when Maintenance Mode is disabled
     *
     * @param int|null $time
     * @param string|null $message
     * @param string|null $view
     * @param int|null $retry
     */
    public function __construct($time = null, $message = null, $view = null, $retry = null)
    {
        $this->time = Carbon::createFromTimestamp($time);
        $this->message = $message;
        $this->view = $view;
        $this->retry = $retry;
    }
}

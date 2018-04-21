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

use Illuminate\Contracts\Foundation\Application;

/**
 * Class MaintenanceModeExemption
 *
 *
 */
abstract class MaintenanceModeExemption
{
    /**
     * @var Application
     */
    protected $app;

    /**
     * @param Application $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Check to see if the user is exempt from the maintenance page
     *
     * @return bool     True is the user should not see the exemption page
     */
    abstract public function isExempt();
}

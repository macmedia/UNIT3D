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

use Illuminate\Database\Seeder;

class TicketCategoriesTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {


        \DB::table('ticket_categories')->delete();

        \DB::table('ticket_categories')->insert([
            0 =>
                [
                    'id' => 1,
                    'name' => 'Account',

                ],
                1 =>
                [
                    'id' => 2,
                    'name' => 'Bug',
                ],
                2 =>
                [
                    'id' => 3,
                    'name' => 'Client',
                ],
        ]);
    }
}

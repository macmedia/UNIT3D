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

namespace App\Http\Controllers\Staff;

use App\TicketCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TicketCategoryController extends Controller
{
    public function show()
    {
        $categories = TicketCategory::all();

        return view('Staff.tickets.categories', ['categories' => $categories]);
    }

    public function add(Request $request)
    {
        $this->validate($request, [
        'name' => 'required|unique:categories,name',
    ]);
        TicketCategory::create([
        'name' => $request->name,
    ]);

        return redirect()->back();
    }

    public function delete($category_id)
    {
        $category = TicketCategory::findOrFail($category_id);
        foreach ($category->tickets as $ticket) {
            $ticket->delete();
        }
        $category->delete();

        return redirect()->back();
    }
}

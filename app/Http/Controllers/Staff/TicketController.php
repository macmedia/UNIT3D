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
use App\Mail\StatusChanged;
use App\Ticket;
use App\User;
use Illuminate\Support\Facades\Mail;

class TicketController extends Controller
{
    public function index($indicator_period = 2)
    {
    $tickets_count = Ticket::count();
    $open_tickets_count = Ticket::where('status', 'Open')->count();
    $closed_tickets_count = Ticket::where('status', 'Closed')->count();
    // Per Category pagination
    $categories = TicketCategory::paginate(10, ['*'], 'cat_page');
    // Total tickets counter per category for google pie chart
    $categories_all = TicketCategory::all();
    $categories_share = [];
    foreach ($categories_all as $cat) {
        $categories_share[$cat->name] = $cat->tickets->count();
    }
    // Per User
    $users = User::paginate(10);
    if (request()->has('cat_page')) {
        $active_tab = 'cat';
    } elseif (request()->has('agents_page')) {
        $active_tab = 'agents';
    } elseif (request()->has('users_page')) {
        $active_tab = 'users';
    } else {
        $active_tab = 'cat';
    }

    return view(
        'Staff.tickets.index',
        compact(
            'open_tickets_count',
            'closed_tickets_count',
            'tickets_count',
            'categories',
            'users',
            'categories_share',
            'active_tab'
        ));
    }

    public function tickets($status = null)
    {
        if ($status == 'open') {
            $tickets = Ticket::where('status', 'Open')->paginate(10);
        } elseif ($status == 'closed') {
            $tickets = Ticket::where('status', 'Closed')->paginate(10);
        } else {
            $tickets = Ticket::paginate(10);
        }
        $categories = TicketCategory::all();

        return view('tickets.index', ['tickets' => $tickets, 'categories' => $categories]);
    }

    public function changeStatus($ticket_id)
    {
        $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();
        if ($ticket->status == 'Open') {
            $ticket->status = 'Closed';
        } elseif ($ticket->status == 'Closed') {
            $ticket->status = 'Open';
        }

        $ticket->save();

        Mail::to($ticket->user->email)->send(new StatusChanged($ticket->user, $ticket));

        if ($ticket->status == 'Open') {
            return redirect()->back()->with(Toastr::success('Ticket Sucessfully Reopened', 'Yay!', ['options']));
        } elseif ($ticket->status == 'Closed') {
            return redirect()->back()->with(Toastr::success('Ticket Sucessfully Closed', 'Yay!', ['options']));
        }
    }
}

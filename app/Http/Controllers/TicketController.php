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

namespace App\Http\Controllers;

use App\TicketCategory;
use App\Mail\TicketCreated;
use App\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class TicketController extends Controller
{
    public function create()
    {
        $categories = TicketCategory::all();

        return view('tickets.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'title'     => 'required',
            'category'  => 'required',
            'priority'  => 'required',
            'message'   => 'required',
        ]);
        $ticket = new Ticket([
            'title'        => $request->input('title'),
            'user_id'      => auth()->user()->id,
            'ticket_id'    => strtoupper(str_random(10)),
            'category_id'  => $request->input('category'),
            'priority'     => $request->input('priority'),
            'message'      => $request->input('message'),
        ]);

        $ticket->save();

        Mail::to(auth()->user()->email)->send(new TicketCreated(auth()->user(), $ticket));

        return redirect()->to('tickets/'.$ticket->ticket_id)->with(Toastr::success("A ticket with ID: #$ticket->ticket_id has been opened.", 'Yay!', ['options']));
    }

    public function userTickets()
    {
        $tickets = Ticket::where('user_id', auth()->user()->id)->paginate(10);
        $categories = TicketCategory::all();

        return view('tickets.user_tickets', compact('tickets', 'categories'));
    }

    public function show($ticket_id)
    {
        $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();

        $comments = $ticket->comments;

        $category = $ticket->category;

        return view('tickets.show', compact('ticket', 'category', 'comments'));
    }
}

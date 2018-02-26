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

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $fillable = [
    'user_id', 'category_id', 'ticket_id', 'title', 'priority', 'message', 'status',
  ];

    public function category()
    {
        return $this->belongsTo(\App\TicketCategory::class);
    }

    public function comments()
    {
        return $this->hasMany(\App\Comment::class);
    }

    public function user()
    {
        return $this->belongsTo(\App\User::class);
    }
}

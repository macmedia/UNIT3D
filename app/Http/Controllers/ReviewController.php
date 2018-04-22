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

use App\Review;
use Illuminate\Http\Request;

use App\Http\Requests;

class ReviewController extends Controller
{
  /**
   * Holds the validation array for storing and updating
   *
   * @var array $rules
   */
   private $rules = [
      'user_id' => 'required',
      'imdb' => 'required',
      'title' => 'required',
      'comment' => 'required',
      'rating' => 'required',
  ];

  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
      //
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create()
  {
      return view('review.add_review');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
      $this->validate($request, $this->rules);

      $review = new Review;
      $review->user_id = auth()->user()->id;
      $review->imdb = $request->imdb;
      $review->title = $request->title;
      $review->comment = $request->comment;
      $review->rating = $request->rating;
      $review->save();

      return redirect()->back()->with(Toastr::success('Your Review Was Successfully Saved!', 'Yay!', ['options']));
  }

  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id)
  {
      $review = Review::findOrFail($id);

      return view('review.edit_review', ['review' => $review]);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(Request $request, $id)
  {
      $this->validate($request, $rules);

      $review = Review::findOrFail($id);

      $review->user_id = $review->user_id;
      $review->imdb = $request->imdb;
      $review->title = $request->title;
      $review->comment = $request->comment;
      $review->rating = $request->rating;
      $review->save();

      return redirect()->back();
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
      $review = Review::findOrFail($id);
      $review->delete();

      return redirect()->route('home');
  }
}

@extends('layout.default')

@section('title')
<title> </title>
@endsection

@section('breadcrumb')
<li>
    <a href="{{ url('add_review') }}" itemprop="url" class="l-breadcrumb-item-link">
        <span itemprop="title" class="l-breadcrumb-item-link-title">{{ trans('review.add-review') }}</span>
    </a>
</li>
@endsection

@section('content')
<div class="container">
  <div class="block">
    <h1>New Review</h1>
    <hr>
    <form action="{{ route('storeReview') }}" method="POST">
      {{ csrf_field() }}

      <div class="form-group">
        <label for="name">{{ trans('request.title') }}</label>
        <input type="text" name="title" class="form-control" required>
      </div>

      <div class="form-group">
        <label for="name">IMDB ID ({{ trans('request.required') }})</label>
        <input type="number" name="imdb" value="0" class="form-control" required>
      </div>

      <div class="form-group">
        <label for="description">{{ trans('request.description') }}</label>
        <textarea id="comment" name="comment" cols="30" rows="10" class="form-control"></textarea>
      </div>

      <div class="form-group">
        <label for="name">Rating</label>
        <div class="star-rating"></div>
      </div>

      <button type="submit" class="btn btn-primary">{{ trans('common.submit') }}</button>
    </form>
  </div>
</div>
@endsection

@section('javascripts')
<script type="text/javascript" src="{{ url('files/wysibb/jquery.wysibb.js') }}"></script>
<script>
$(document).ready(function() {
    var wbbOpt = { }
    $("#request-form-description").wysibb(wbbOpt);
});
</script>
<script type="text/javascript" src="{{ url('js/vendor/raty-master/jquery.raty.js?v=1') }}"></script>
<script>
  $('.star-rating').raty({
    path: '{{ url("js/vendor/raty-master/images/") }}',
    scoreName: 'rating'
  });
</script>
@endsection

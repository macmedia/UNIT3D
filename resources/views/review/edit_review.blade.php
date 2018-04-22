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
    <form action="{{ route('movie.review.store', [$movie]) }}" method="POST">
    {{ csrf_field() }}
    <div class="star-rating"></div>
    <label for="comment">Comment</label>
    <textarea type="text" name="comment" id="comment">{{ old('comment') }}</textarea>
    <button type="submit">Submit</button>
  </form>

  <script>
    $('.star-rating').raty({
      path: '{{ url("includes/raty-master/images/") }}',
      scoreName: 'rating'
    });
  </script>
@endsection

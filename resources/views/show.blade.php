@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Movies for {{ $language }}:</h1>
    <ul class="list-group">
      @foreach($movies as $movie)
    <li class="list-group-item">
        {{ $movie['title'] }} 
        
        @if (isset($ratings[$movie['id']]))
            Grade: {{ $ratings[$movie['id']] }}
            <form action="{{ route('ratings.destroy', $movie['id']) }}" method="POST" style="display: inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm">Remove rating</button>
            </form>
            <form action="{{ route('ratings.update', $movie['id']) }}" method="POST" style="display: inline;">
                @csrf
                @method('PUT')
                <div class="form-group">
                    <label for="rating">Grade (1-5):</label>
                    <input type="number" class="form-control" id="rating" name="rating" min="1" max="5">
                    <input type="hidden" name="movie_id" value="{{ $movie['id'] }}">
                </div>
                <button type="submit" class="btn btn-primary btn-sm">Change rating</button>
            </form>
        @else
            No ratings yet
            <form class="mt-3" action="{{ route('ratings.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="rating">Grade (1-5):</label>
                    <input type="number" class="form-control" id="rating" name="rating" min="1" max="5">
                    <input type="hidden" name="movie_id" value="{{ $movie['id'] }}">
                </div>
                <button type="submit" class="btn btn-primary btn-sm">Add a rating</button>
            </form>
        @endif
    </li>
@endforeach



    </ul>
</div>

@endsection

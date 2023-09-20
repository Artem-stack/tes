@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Choose the country:</h1>
    <select class="form-control" id="countrySelect">
        @foreach($languages as $language)
            <option value="{{ route('show', $language) }}">{{ $language }}</option>
        @endforeach
    </select>
    <button class="btn btn-primary mt-3" id="selectCountryButton">Select country</button>
</div>

<script>
    
    $(document).ready(function () {
        $("#selectCountryButton").click(function () {
            var selectedLanguage = $("#countrySelect").val();
            window.location.href = selectedLanguage; 
        });
    });
</script>
@endsection

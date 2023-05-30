@extends('layouts.app')

@section('title', 'TradeStat Form')

@section('content')
<div class="form-container">
    <h1>TradeStat</h1>
    <form method="POST" id="stock-form" action="/get-historical-data">
        @csrf
        <div class="form-group">
            <label for="company_symbol">Company Symbol:</label>
            <input type="text" id="company_symbol" name="company_symbol" />
            @error('company_symbol')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="start_date">Start Date:</label>
            <input type="text" id="start_date" name="start_date" />
            @error('start_date')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="end_date">End Date:</label>
            <input type="text" id="end_date" name="end_date" />
            @error('end_date')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="text" id="email" name="email" />
            @error('email')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <div class="error-container">
            @include('partials.errors')
        </div>
        <div class="form-group">
            <button type="submit">Get Historical Data</button>
        </div>
    </form>
</div>
@endsection

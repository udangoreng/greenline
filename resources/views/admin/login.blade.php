@extends('layout')
@section('c')
    <h1>
        Login Admin</h1>
    <form method="post" action="/admin/login" style="max-width:320px">@csrf
        <input type="password" name="password" placeholder="Password admin">
        @error('password')
            <p class="err">{{ $message }}</p>
        @enderror
        <button>Masuk</button>
    </form>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    @if(session()->get('message'))
                        {{ session()->get('message') }}
                    @endif
                    @if(auth()->check())
                    <div class="card-header">
                        <form action="/catch" method="POST">
                            @csrf

                            <input name="character_id" type="hidden" value="{{ $character->id }}">
                            <button type="submit" class="btn btn-danger">Yakala!</button>
                        </form>
                    </div>
                    @endif
                    <div class="card-body">
                        <p>{{ $character->name }}</p>
                        <p><strong>Deneyim Puanı</strong> {{ $character->experience }}</p>
                    </div>
                    <ul>
                        @foreach($character->users as $user)
                            <li>{{ $user->name }}</li>
                        @endforeach
                    </ul>
                    <div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
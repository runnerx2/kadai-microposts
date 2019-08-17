@extends('layouts.app')

@section('content')
    <div class="row">
        <aside class="col-sm-4">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">{{ $user->name }}</h3>
                </div>
                <div class="card-body">
                    <img class="rounded img-fluid" src="{{ Gravatar::src($user->email, 500) }}" alt="">
                </div>
            </div>
            @include('user_follow.follow_button', ['user' => $user])
        </aside>
        <div class="col-sm-8">
            @include('users.navtabs', ['user' => $user])

            <ul class="media-list">
                @foreach ($favorites as $favorite)
                    <li class="media mb-3">
                        <img class="mr-2 rounded" src="{{ Gravatar::src($favorite->user->email, 50) }}" alt="">
                        <div class="media-body">
                            <div>
                                {!! link_to_route('users.show', $favorite->user->name, ['id' => $favorite->user->id]) !!} <span class="text-muted">posted at {{ $favorite->created_at }}</span>
                            </div>
                            <div>
                                <p class="mb-0">{!! nl2br(e($favorite->content)) !!}</p>
                            </div>
                            @include('microposts.favorite_button', ['micropost' => $favorite])
                            <div>
                                @if (Auth::id() == $favorite->user_id)
                                    {!! Form::open(['route' => ['microposts.destroy', $favorite->id], 'method' => 'delete']) !!}
                                        {!! Form::submit('Delete', ['class' => 'btn btn-danger btn-sm']) !!}
                                    {!! Form::close() !!}
                                @endif
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
            {{ $favorites->render('pagination::bootstrap-4') }}


        </div>
    </div>
@endsection
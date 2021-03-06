@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                @include('threads._list')

                {{ $threads->render() }}
            </div>

            <div class="col-md-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Search
                    </div>

                    <div class="panel-body">
                        <form action="/threads/search" method="GET">
                            <div class="form-group">
                                <input type="text" name="q" placeholder="Search for something..." class="form-control">
                            </div>

                            <div class="form-group">
                                <button class="btn btn-default" type="submit">Search</button>
                            </div>
                        </form>
                    </div>
                </div>

                @if(count($trending))
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Trending threads
                        </div>

                        <div class="panel-body">
                            @foreach($trending as $thread)
                                <li class="list-group-item">
                                    <a href="{{ url($thread->path) }}">{{ $thread->title }}</a>
                                </li>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <ais-index
                    app-id="{{ config('scout.algolia.id') }}"
                    api-key="{{ config('scout.algolia.key') }}"
                    index-name="threads"
                    query="{{ request('q') }}"
            >
                <div class="col-md-8">
                    <ais-results>
                        <template slot-scope="{ result }">
                            <li>
                                <a :href="result.path">
                                    <ais-highlight :result="result" attribute-name="title"></ais-highlight>
                                </a>
                            </li>
                        </template>
                    </ais-results>
                </div>

                <div class="col-md-4">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Search
                        </div>

                        <div class="panel-body">
                            <ais-search-box>
                                <ais-input class="form-control" placeholder="Find a thread..." :autofocus="true"></ais-input>
                            </ais-search-box>
                        </div>
                    </div>

                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Filter by Channel
                        </div>

                        <div class="panel-body">
                            <ais-refinement-list attribute-name="channel.name"></ais-refinement-list>
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
            </ais-index>
        </div>
    </div>
@endsection

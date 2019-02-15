<div class="row mt-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-body">
                <div class="card-title">
                    <h2>{{$answersCount.' '.str_plural('Answer',$answersCount)}}</h2>
                </div>
                <hr>
                @include('layouts.messages')
                @foreach($answers as $answer)
                    <div class="media">
                        <div class="d-flex flex-column vote-controls">
                            <a title="This question is useful" class="vote-up">
                                <i class="fas fa-caret-up fa-3x"></i>
                            </a>
                            <span class="votes-count">1230</span>
                            <a title="This question is not useful"  class="vote-down off">
                                <i class="fas fa-caret-down fa-3x"></i>
                            </a>
                            @can('accept',$answer)
                            <a title="Click this answer to best answer.(Click again to undo)"
                               class="{{$answer->status}} mt-2"
                               onclick="event.preventDefault(); document.getElementById('accept-answer-{{$answer->id}}').submit();">
                                <i class="fas fa-check fa-2x"></i>

                            </a>
                            <form action="{{route('answers.accept',$answer->id)}}" id="accept-answer-{{$answer->id}}"
                            style="display: none;" method="post">
                                @csrf
                            </form>
                                @else
                                    @if($answer->is_best)
                                    <a class="{{$answer->status}} mt-2" title="The owner marked this question as best"
                                       onclick="event.preventDefault(); document.getElementById('accept-answer-{{$answer->id}}').submit();">
                                        <i class="fas fa-check fa-2x"></i>

                                    </a>
                                        @endif
                            @endcan
                            <span class="favorites_count">133</span>

                        </div>

                        <div class="media-body">
                            {!! $answer->body_html !!}
                            <div class="row">
                                <div class="col-4">
                                    @can('update-answer',$answer)
                                        <a href="{{route('questions.answers.edit',[$question->id,$answer->id])}}" class="btn btn-outline-info">Edit</a>
                                    @endcan
                                    @can('delete-answer',$answer)
                                        <form action="{{route('questions.answers.destroy',[$question->id,$answer->id])}}" method="post" class="form-delete">
                                            @method('DELETE')
                                            @csrf
                                            <button class="btn btn-outline-danger"
                                                    onclick="return confirm('Are you sure?')">Delete</button>
                                        </form>
                                    @endcan
                                </div>
                            </div>
                            <div class="float-right">
                                <span class="text-muted">Answered {{$answer->created_date}}</span>
                                <div class="media mt-2">
                                    <a href="{{$answer->user->url}}">
                                        <img src="{{$answer->user->avatar}}" alt="">
                                    </a>
                                    <div class="media-body">
                                        <a href="{{$answer->user->url}}">{{$answer->user->name}}</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr>
                @endforeach
            </div>
        </div>
    </div>
</div>
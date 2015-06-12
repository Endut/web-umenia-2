@extends('layouts.master')

@section('title')
@parent
| články
@stop

@section('content')

<section class="articles light-grey content-section">
    <div class="articles-body">
        <div class="container">
            <div class="row">
            	@foreach ($articles as $article)
	                <div class="col-sm-6 col-xs-12 bottom-space">
	                	<a href="{{ $article->getUrl() }}" class="featured-article">
	                		<img src="{{ $article->getThumbnailImage() }}" class="img-responsive" alt="{{ $article->title }}">
	                	</a>
                        <a href="{{ $article->getUrl() }}"><h4 class="title">
                            @if ($article->category)
                                {{ $article->category->name }}:
                            @endif
                            {{ $article->title }}
                        </h4></a>
                        <p class="attributes">{{ $article->getShortTextAttribute($article->summary, 250) }}
                        (<a href="{{ $article->getUrl() }}">viac</a>)
                        </p>
                        <p class="meta">{{$article->published_date}} / {{$article->author}}</p>
	                    
	                </div>	
            	@endforeach
            </div>
        </div>
    </div>
</section>

@stop

@section('javascript')

<script type="text/javascript">

</script>
@stop
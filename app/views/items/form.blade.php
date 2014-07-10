@extends('layouts.admin')

@section('content')

<div class="col-md-12">
	@if(isset($item))
	    {{ Form::model($item, ['route' => ['item.update', $item->id], 'method' => 'patch', 'files'=>true]) }}
	@else
	    {{ Form::open(['route' => 'item.store', 'files'=>true]) }}
	@endif

	@if (Session::has('message'))
	    <div class="alert alert-info alert-dismissable"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>{{ Session::get('message') }}</div>
	@endif


	@if($errors->any())
		<div class="alert alert-danger">
			<a href="#" class="close" data-dismiss="alert">&times;</a>
			{{ implode('', $errors->all('<li class="error">:message</li>')) }}
		</div>
	@endif

</div>
@if(isset($new_id))    	
<div class="col-md-12">
	<div class="form-group">
	{{ Form::label('id', 'Identifikátor') }}
    {{ Form::text('id', $new_id, array('class' => 'form-control', 'readonly')) }}
	</div>
</div>
@endif
<div class="col-md-12">
	<div class="form-group">
	{{ Form::label('title', 'Názov') }}
	{{ Form::text('title', Input::old('title'), array('class' => 'form-control')) }}
	</div>
</div>
<div class="col-md-12">
	<div class="form-group">
	{{ Form::label('author', 'Autor') }}
	{{ Form::text('author', Input::old('author'), array('class' => 'form-control')) }}
	</div>
</div>
<div class="col-md-12">
	<div class="form-group">
	{{ Form::label('description', 'Popis') }}
	{{ Form::textarea('description', Input::old('description'), array('class' => 'form-control wysiwyg')) }}	
	</div>
</div>
<div class="col-md-12">
	<div class="form-group">
	{{ Form::label('work_type', 'výtvarný druh') }}
	{{ Form::text('work_type', Input::old('work_type'), array('class' => 'form-control')) }}
	</div>
</div>
<div class="col-md-12">
	<div class="form-group">
	{{ Form::label('work_level', 'stupeň spracovania') }}
	{{ Form::text('work_level', Input::old('work_level'), array('class' => 'form-control')) }}
	</div>
</div>
<div class="col-md-12">
	<div class="form-group">
	{{ Form::label('topic', 'žáner') }}
	{{ Form::text('topic', Input::old('topic'), array('class' => 'form-control')) }}
	</div>
</div>
<div class="col-md-12">
	<div class="form-group">
	{{ Form::label('subject', 'tagy') }}
	{{ Form::text('subject', Input::old('subject'), array('class' => 'form-control')) }}
	</div>
</div>
<div class="col-md-12">
	<div class="form-group">
	{{ Form::label('measurement', 'miery') }}
	{{ Form::text('measurement', Input::old('measurement'), array('class' => 'form-control')) }}
	</div>
</div>
<div class="col-md-12">
	<div class="form-group">
	{{ Form::label('dating', 'datovanie') }}
	{{ Form::text('dating', Input::old('dating'), array('class' => 'form-control')) }}
	</div>
</div>
<div class="col-md-12">
	<div class="form-group">
	{{ Form::label('date_earliest', 'datovanie najskôr') }}
	{{ Form::text('date_earliest', Input::old('date_earliest'), array('class' => 'form-control')) }}
	</div>
</div>
<div class="col-md-12">
	<div class="form-group">
	{{ Form::label('date_latest', 'datovanie najneskôr') }}
	{{ Form::text('date_latest', Input::old('date_latest'), array('class' => 'form-control')) }}
	</div>
</div>
<div class="col-md-12">
	<div class="form-group">
	{{ Form::label('medium', 'materiál') }}
	{{ Form::text('medium', Input::old('medium'), array('class' => 'form-control')) }}
	</div>
</div>
<div class="col-md-12">
	<div class="form-group">
	{{ Form::label('technique', 'technika') }}
	{{ Form::text('technique', Input::old('technique'), array('class' => 'form-control')) }}
	</div>
</div>
<div class="col-md-12">
	<div class="form-group">
	{{ Form::label('inscription', 'značenie') }}
	{{ Form::text('inscription', Input::old('inscription'), array('class' => 'form-control')) }}
	</div>
</div>
<div class="col-md-12">
	<div class="form-group">
	{{ Form::label('place', 'geografická oblasť') }}
	{{ Form::text('place', Input::old('place'), array('class' => 'form-control')) }}
	</div>
</div>
<div class="col-md-6">
	<div class="form-group">
	{{ Form::label('lat', 'latitúda') }}
	{{ Form::text('lat', Input::old('lat'), array('class' => 'form-control')) }}
	</div>
</div>
<div class="col-md-6">
	<div class="form-group">
	{{ Form::label('lng', 'longitúda') }}
	{{ Form::text('lng', Input::old('lng'), array('class' => 'form-control')) }}
	</div>
</div>
<div class="col-md-12">
	<div class="form-group">
	{{ Form::label('state_edition', 'stupeň spracovania') }}
	{{ Form::text('state_edition', Input::old('state_edition'), array('class' => 'form-control')) }}
	</div>
</div>
<div class="col-md-12">
	<div class="form-group">
	{{ Form::label('integrity', 'stupeň integrity') }}
	{{ Form::text('integrity', Input::old('integrity'), array('class' => 'form-control')) }}
	</div>
</div>
<div class="col-md-12">
	<div class="form-group">
	{{ Form::label('integrity_work', 'integrita s dielami') }}
	{{ Form::text('integrity_work', Input::old('integrity_work'), array('class' => 'form-control')) }}
	</div>
</div>
<div class="col-md-12">
	<div class="form-group">
	{{ Form::label('gallery', 'galéria') }}
	{{ Form::text('gallery', Input::old('gallery'), array('class' => 'form-control')) }}
	</div>
</div>
<div class="col-md-12">
	<div class="form-group">
	{{ Form::label('iipimg_url', 'IIPImage url') }}
	{{ Form::text('iipimg_url', Input::old('iipimg_url'), array('class' => 'form-control')) }}
	</div>
</div>
<div class="col-md-12">
	@if(isset($item))
	<div class="primary-image">
		aktuálny:<br>
		<img src="{{ $item->getImagePath() }}" alt="">
	</div>
	@endif
	<div class="form-group">
	{{ Form::label('primary_image', 'obrázok') }}
	{{ Form::file('primary_image') }}
	</div>
</div>

<div class="col-md-12 text-center">
	{{ Form::submit('Uložiť', array('class' => 'btn btn-default')) }} &nbsp; 
	{{ link_to_route('item.index', 'Zrušiť', null, array('class' => 'btn btn-default')) }}
	{{Form::close() }}
</div>

<div class="clear">&nbsp;</div>
@stop
@section('main')

	<h2>Projects</h2>

	@if (count($models))
	
	<ul>
		@foreach($models as $model)
		<li>
			{{ $model->title }} {{ $model->start_date }}
			{{ link_to_route($lang.'.projects.categories.slug', trans('public.More'), array($model->category->slug, $model->slug)) }}
		</li>
		@endforeach
	</ul>

	@endif

@stop
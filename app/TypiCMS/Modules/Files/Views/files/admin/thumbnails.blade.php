@section('js')
    {{ HTML::script(asset('js/admin/list.js')) }}
@stop

@section('main')

    <h1>
        <a id="uploaderAddButtonContainer" href="{{ route('admin.files.create') }}"><i id="uploaderAddButton" class="fa fa-plus-circle"></i><span class="sr-only">{{ ucfirst(trans('files::global.New')) }}</span></a>
        <span id="nb_elements">{{ $models->getTotal() }}</span> @choice('files::global.files', $models->getTotal())
    </h1>

    <div class="list-form" lang="{{ Config::get('app.locale') }}">

        @include('admin._buttons-list')

        {{ Form::open(array('route' => 'admin.files.store', 'files' => true, 'class' => 'dropzone', 'id' => 'dropzone')) }}

            {{ BootForm::hidden('gallery_id', Input::get('gallery_id', 0)) }}
            @foreach (Config::get('app.locales') as $locale)
                {{ BootForm::hidden($locale.'[description]') }}
                {{ BootForm::hidden($locale.'[alt_attribute]', '') }}
                {{ BootForm::hidden($locale.'[keywords]') }}
            @endforeach

            <div class="dropzone-previews clearfix sortable sortable-thumbnails">
            @foreach ($models as $key => $model)
                <a class="thumbnail" id="item_{{ $model->id }}" href="{{ route('admin.files.edit', $model->id) }}">
                    {{ $model->present()->checkbox }}
                    {{ $model->present()->thumb }}
                    <div class="caption">
                        <small>{{ $model->filename }}</small>
                        <div>{{ $model->alt_attribute }}</div>
                    </div>
                </a>
            @endforeach
            </div>
            <div class="dz-message">@lang('files::global.Drop files to upload')</div>

        {{ Form::close() }}

    </div>

    {{ $models->appends(Input::except('page'))->links() }}

@stop

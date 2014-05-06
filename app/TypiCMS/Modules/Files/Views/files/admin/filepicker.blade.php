@section('js')
    {{ HTML::script(asset('js/list.js')) }}
    <script>
        function selectAndClose(image) {
            var TinyMCEWindow = top.tinymce.activeEditor.windowManager;
            TinyMCEWindow.getParams().oninsert(image);
            TinyMCEWindow.close();
        }
    </script>
@stop

@section('bodyClass')
no-padding-top
@stop

@section('navbar')
@stop

@section('breadcrumbs')
@stop

@section('h1')
    <span id="nb_elements">{{ $models->getTotal() }}</span> @choice('files::global.files', $models->getTotal())
@stop

@section('addButton')
    <a id="uploaderAddButtonContainer" href="{{ route('admin.files.create') }}"><i id="uploaderAddButton" class="fa fa-plus-circle"></i><span class="sr-only">{{ ucfirst(trans('files::global.New')) }}</span></a>
@stop

@section('main')

    <div class="list-form" lang="{{ Config::get('app.locale') }}">

        @section('btn-locales')
        @stop

        @include('admin._buttons-list')

        {{ Form::open(array('route' => 'admin.files.store', 'files' => true, 'class' => 'dropzone', 'id' => 'dropzone')) }}

            @foreach (Config::get('app.locales') as $locale)
                {{ Form::hidden($locale.'[status]', 1) }}
                {{ Form::hidden($locale.'[description]') }}
                {{ Form::hidden($locale.'[alt_attribute]', '') }}
                {{ Form::hidden($locale.'[keywords]') }}
            @endforeach

            <div class="dropzone-previews clearfix sortable sortable-thumbnails">
            @if (count($models))
                @foreach ($models as $key => $model)
                    <div class="thumbnail" id="item_{{ $model->id }}">
                        {{ $model->present()->checkbox }}
                        {{ $model->present()->thumb }}
                        <div class="caption">
                            <a href="#" class="btn btn-default btn-xs btn-block btn-insert" onclick="selectAndClose('/{{ $model->path }}{{ $model->filename }}')">@lang('files::global.Insert')</a>
                            <small>{{ $model->filename }}</small>
                        </div>
                    </div>
                @endforeach
            @else
                <p class="text-muted">@lang('global.No file')</p>
            @endif
            </div>
            <div class="dz-message">@lang('files::global.Drop files to upload')</div>

        {{ Form::close() }}

    </div>

    {{ $models->appends(Input::except('page'))->links() }}

@stop
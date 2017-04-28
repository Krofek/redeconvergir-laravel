@extends('backpack::layout')

@section('header')
    <section class="content-header">
        <h1>
            {{ trans('backpack::crud.add') }} <span class="text-lowercase">{{ $crud->entity_name }}</span>
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{ url(config('backpack.base.route_prefix'), 'dashboard') }}">{{ trans('backpack::crud.admin') }}</a></li>
            <li><a href="{{ url($crud->route) }}" class="text-capitalize">{{ $crud->entity_name_plural }}</a></li>
            <li class="active">{{ trans('backpack::crud.add') }}</li>
        </ol>
    </section>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <!-- Default box -->
            @if ($crud->hasAccess('list'))
                <a href="{{ url($crud->route) }}"><i class="fa fa-angle-double-left"></i> {{ trans('backpack::crud.back_to_all') }} <span class="text-lowercase">{{ $crud->entity_name_plural }}</span></a><br><br>
            @endif

            {!! Form::open(array('url' => $crud->route, 'method' => 'post')) !!}
            <div class="box">

                <div class="box-header with-border">
                    <h3 class="box-title">{{ trans('backpack::crud.add_a_new') }} {{ $crud->entity_name }}</h3>
                </div>
                <div class="box-body row">
                    <!-- load the view from the application if it exists, otherwise load the one in the package -->
                    @if(view()->exists('vendor.backpack.crud.form_content'))
                        @include('vendor.backpack.crud.form_content', ['fields' => $crud->getFields('create')])
                    @else
                        @include('crud::form_content', ['fields' => $crud->getFields('create')])
                    @endif
                </div><!-- /.box-body -->
                <input type="hidden" name="redirect_after_save" value="{{ $crud->route }}">
                <div class="box-footer">
                    <button type="submit" class="btn btn-success ladda-button" data-style="zoom-in"><span class="ladda-label"><i class="fa fa-save"></i> {{ trans('backpack::crud.add') }}</span></button>
                    <a href="{{ url($crud->route) }}" class="btn btn-default ladda-button" data-style="zoom-in"><span class="ladda-label">{{ trans('backpack::crud.cancel') }}</span></a>
                </div><!-- /.box-footer-->

            </div><!-- /.box -->
            {!! Form::close() !!}
        </div>
    </div>

@endsection

@extends('layouts.app')

@section('map')
    {{--    {!! Mapper::render(0) !!}--}}
    <initiative-map ref="initiative-map" :init="{{ $init }}"></initiative-map>
@endsection()

@section('content')

@endsection

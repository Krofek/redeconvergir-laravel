@extends('layouts.app')

@section('map')
    {{--    {!! Mapper::render(0) !!}--}}
    <initiative-map :init="{{ $init }}" :initiatives="{{ $initiatives }}"></initiative-map>
@endsection()

@section('content')

@endsection

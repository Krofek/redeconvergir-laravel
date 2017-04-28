@extends('layouts.app')

@section('map')
    <initiative-map ref="initiative-map" :init="{{ $init }}"></initiative-map>
@endsection()

@section('content')
    <div class="initiative-details">
        <router-view></router-view>
    </div>
@endsection()

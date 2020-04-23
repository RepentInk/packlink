@extends('layout.pageLayout')

@section('title', 'Dashboard')

@section('section')

      <dashboard-component userinfo="{{ Auth::user() }}"></dashboard-component>

@stop

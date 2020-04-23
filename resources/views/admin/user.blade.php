@extends('layout.adminLayout')

@section('title', 'User')

@section('content')

     <admin-user-component user_id="{{ Auth::id() }}"></admin-user-component>

@stop

@extends('layouts.errors')

@section('title', __('503'))
@section('message', __($exception->getMessage() ?: 'Service Unavailable'))
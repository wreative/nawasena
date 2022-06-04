@extends('layouts.errors')

@section('title', __('403'))
@section('message', __($exception->getMessage() ?: 'Forbidden'))
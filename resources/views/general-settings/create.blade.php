@extends('layouts.app')

@section('title', __('general-settings::messages.general_settings_create_title'))

@section('content')
<div class="container mt-4">
    <div class="card shadow-sm">
        <div class="card-body">
            <h1 class="h2 font-weight-bold mb-4">{{ __('general-settings::messages.general_settings_create_title') }}</h1>
            @include('general-settings.partials.errors')
            <form class="row g-3" action="{{ route('admin.general-settings.store') }}" method="POST">
                @csrf
                @include('general-settings.partials.form')
            </form>
        </div>
    </div>
</div>
@endsection

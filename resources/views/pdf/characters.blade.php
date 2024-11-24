@extends('layouts.pdf')

@section('content')
    @foreach ($characters as $character)
        <div class="clearfix character">
            <div class="character__image">
                <img src="{{ $character->image }}" class="img-thumbnail">
            </div>
            <div class="character__info">
                <p class="character__name">{{ $character->name }}</p>
            </div>
        </div>

        @if (! $loop->last)
            <div class="page-break"></div>
        @endif
    @endforeach
@endsection

@push('styles')
    <style>
        .character {
            margin-bottom: 50px;
        }

        .character__image {
            margin-right: 20px;
            float: left;
        }

        .character__name {
            font-size: 24px;
        }
    </style>
@endpush

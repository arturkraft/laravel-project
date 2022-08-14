@extends('layout')

@section('content')
@include('partials/._hero')
@include('partials._search')

        <div class="columns-2 xl:grid-cols-3 xl:grid gap-4 space-y-4 md:space-y-0 mx-4">
        @unless (count($listings) == 0)
        
        @foreach ($listings as $listing)
            <x-listing-card :listing="$listing" />
        @endforeach

        @else 
        <p> no lisitngs found </p>
        @endunless
        </div>

        <div class="mt-6 p-4">
           {{$listings->links()}}
        </div>
@endsection

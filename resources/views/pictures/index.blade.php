@extends('layouts.simple')

@section('content')
    <div class="container">
        <h1 class="h4">Галерея изображений</h1>
        <div class="pictures-gallery">
            @if($pictures->count())
                <div class="row">
                    @foreach($pictures as $picture)
                        <div class="col-4 mt-3">
                            <div class="card" style="width: 18rem;">
                                <img class="card-img-top" src="{{ $picture->url }}" alt="">
                                <div class="card-body">
                                    <p class="card-text text-right">{{ $picture->created_at->format('Y-m-d H:i:s') }}</p>
                                    <p class="text-center">
                                        <a href="{{ route('pictures.view', $picture->hash) }}" class="btn btn-primary">Просмотр</a>
                                    </p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                Нет загруженных изображений
            @endif

        </div>
    </div>
@endsection
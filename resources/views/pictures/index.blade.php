@extends('layouts.simple')

@section('content')
    <div class="container">
        <h1 class="h4">Галерея изображений</h1>
        <div class="pictures-gallery">
            @if($pictures->count())
                <div class="row">
                    @foreach($pictures as $picture)
                        <div class="col-12 col-md-4 mt-3">
                            <div class="card">
                                @if($picture->is_completed)
                                    <img class="card-img-top" src="{{ $picture->thumbnail_url }}" alt="">
                                @else
                                    <div class="card-img-top">
                                        <div class="mt-4 text-center font-weight-bold">
                                            В обработке
                                        </div>

                                    </div>
                                @endif
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
                <div class="row">
                    <div class="col-12">
                        {{ $pictures->links() }}
                    </div>
                </div>
            @else
                Нет загруженных изображений
            @endif

        </div>
    </div>
@endsection
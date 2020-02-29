@extends('layouts.simple')

@section('content')
    <div class="container">
        <h1 class="h4">Просмотр изображения</h1>
        <div class="pictures-gallery">
            <div class="row">
                <div class="col-12 mt-3">
                    <div class="card">
                        @if($picture->is_completed)
                            <img class="card-img-top" src="{{ $picture->lossy_url }}" alt="">
                        @else
                            <div class="card-img-top">
                                <div class="mt-4 text-center font-weight-bold">
                                    В обработке
                                </div>

                            </div>
                        @endif
                        <div class="card-body">
                            <p class="card-text text-right">{{ $picture->created_at->format('Y-m-d H:i:s') }}</p>
                            <p class="text-right">
                                <a href="{{ route('pictures.download', $picture->hash) }}?compress=lossy" class="btn btn-primary">Скачать</a>
                                <a href="{{ route('pictures.download', $picture->hash) }}?compress=original" class="btn btn-primary">Скачать оригинал</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
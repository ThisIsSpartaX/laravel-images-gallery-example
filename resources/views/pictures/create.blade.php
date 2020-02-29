@extends('layouts.simple')

@section('content')
    <div class="mt-5 container">
        <div class="ml-auto mr-auto" style="max-width: 600px;">
            <h1 class="h4 text-center">Добавить изображение</h1>
            <div class="row mt-4">
                <div class="col-12">
                    <p>Для загрузки изображения выберите файл с компьютера:</p>
                </div>
            </div>
            <form action="{{ route('pictures.store') }}" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-12">
                        <div class="input-group mb-3">
                            <input id="pictureFile" class="form-control" type="file" name="picture" accept="image/x-png,image/jpeg">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">Отправить</button>
                            </div>
                            <div class="input-group-append">
                                <button class="btn btn-light" type="reset">Сбросить</button>
                            </div>
                        </div>
                    </div>
                </div>
                {!! csrf_field() !!}
            </form>
            <form action="{{ route('pictures.store-by-url') }}" method="post" enctype="multipart/form-data">
                <div class="row">
                    <div class="col-12">
                        <p>или укажите URL:</p>
                    </div>
                    <div class="col-12">
                        <div class="input-group mb-3">
                            <input class="form-control" type="text" name="url" placeholder="URL"/>
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">Отправить</button>
                            </div>
                            <div class="input-group-append">
                                <button class="btn btn-light" type="reset">Сбросить</button>
                            </div>
                        </div>
                    </div>
                </div>
                {!! csrf_field() !!}
            </form>
        </div>
    </div>
@endsection
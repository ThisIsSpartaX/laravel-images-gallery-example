@extends('layouts.simple')

@section('content')
<div class="container">
    <h4>Ошибка:</h4>
    <h5 style="color: #000;">
        {{ $code }} - {{ $message }}
    </h5>
</div>
@endsection
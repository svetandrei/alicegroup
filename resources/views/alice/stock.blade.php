@extends(env('THEME').'.layouts.site')
@section('class_bg', $class_bg)
@section('header')
    {!! $header !!}
@endsection

@section('cover')
    @if($cover)
    {!! $heading !!}
    @endif
@endsection

@section('navigation')
    {!! $navigation !!}
@endsection

@section('content')
    {!! $content !!}
@endsection

@section('footer')
    {!! $footer !!}
@endsection
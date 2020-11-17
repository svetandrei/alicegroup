@extends(env('THEME').'.layouts.site')
@section('header')
    {!! $header !!}
@endsection

@section('side')
    {!! $side !!}
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
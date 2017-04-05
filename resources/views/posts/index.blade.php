@extends('layouts.app')

@section('content')

    <h1>
        {{ $category->exists ? 'Posts de ' . $category->name : 'Posts' }}
    </h1>

    <div class="col-md-2">
          {!! Menu::make($categoryItems, 'nav categories') !!}
    </div>

    <div class="col-md-10">
        {!! Form::open(['method' => 'get', 'class' => 'form form-inline']) !!}
          {!! Form::select(
              'orden',
              trans('options.posts-order'),
              request()->get('orden'),
              ['class' => 'form-control']
          ) !!}
          <button type="submit" class="btn btn-default">Ordenar</button>

        {!! Form::close() !!}

        @each('posts.item', $posts, 'post')

        {{ $posts->render() }}
    </div>
@endsection

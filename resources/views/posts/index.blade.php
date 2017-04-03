@extends('layouts.app')

@section('content')
  <h1>
      {{ $category->exists ? 'Posts de ' . $category->name : 'Posts' }}
  </h1>

  @each('posts.item', $posts, 'post')

  {{ $posts->render() }}
  {!! Menu::make($categoryItems, 'nav categories') !!}
@endsection

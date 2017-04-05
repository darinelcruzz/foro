<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Post;
use App\Category;

class ListPostController extends Controller
{
  public function __invoke(Category $category = null, Request $request)
  {
    $routeName = $request->route()->getName();

    list($orderColumn, $orderDirection) = $this->getListOrder($request->get('orden'));

    $posts = Post::orderBy('created_at', 'DESC')
            ->scopes($this->getListScopes($category, $request))
            ->orderBy($orderColumn, $orderDirection)
            ->paginate();

    $posts->appends(request()->intersect(['orden']));

    $categoryItems = $this->getCategoryItems();

    return view('posts.index', compact('posts', 'category', 'categoryItems'));
  }

  protected function getCategoryItems()
  {
      return Category::orderBy('name')->get()->map(function ($category) {
          return [
              'title' => $category->name,
              'full_url' => route('posts.index', $category)
          ];
      })->toArray();
  }

  protected function getListScopes(Category $category, Request $request)
  {
      $scopes = [];

      if ($category->exists) {
          $scopes['category'] = [$category];
      }
      $routeName = $request->route()->getName();

      if ($routeName == 'posts.pending') {
          $scopes[] = 'pending';
      }

      if ($routeName == 'posts.completed') {
          $scopes[] = 'completed';
      }

      return $scopes;
  }

  protected function getListOrder($order)
  {
      if ($order == 'recientes') {
          return ['created_at', 'desc'];
      }

      if ($order == 'antiguos') {
          return ['created_at', 'asc'];
      }

      return ['created_at', 'asc'];
  }
}

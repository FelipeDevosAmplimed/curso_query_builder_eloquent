<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;
use App\Models\Article;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ArticleController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->authorizeResource(Article::class, 'article');
    }

    public function index(): View
    {
        $articles = Article::with(['user', 'tags'])->latest()->simplePaginate();

        return view('articles.index', compact('articles'));
    }

    public function show(Article $article): View
    {
        return view('articles.show', compact('artcile'));
    }

    public function create(): View
    {
        return view('articles.create', $this->getFormData());
    }

    public function store(StoreArticleRequest $request): RedirectResponse
    {
        $article = Article::create([
            'slug' => Str::slug($request->title),
            'user_id' => auth()->id(),
            'status' => $request->status === "on"
        ] + $request->validated());

        $article->tags()->attach($request->tags);

        return redirect(route('articles.index'))
            ->with('message', 'Artigo criado com sucesso.');
    }

    public function edit(Article $article): View
    {
        return view('articles.edit', array_merge(compact('article'), $this->getFormData()));
    }

    public function update(UpdateArticleRequest $request, Article $article): RedirectResponse
    {
        $article->update($request->validated() + [
            'slug' => Str::slug($request->title)]);

        $article->tags()->sync($request->tags);

        return redirect(route('dashboard'))->with('message', 'Artigo atualizado com sucesso');
    }

    public function destroy(Article $article): RedirectResponse
    {
        $article->delete();

        return redirect(route('dashboard'))->with('message', 'Artigo removido com sucesso.');
    }

    private function getFormData(): array
    {
        $categories = Category::pluck('name', 'id');
        $tags = Tag::pluck('name', 'id');

        return compact('categories', 'tags');
    }
}

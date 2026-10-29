<?php

namespace App\Http\Controllers;
use App\Models\Tour;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    
    public function index(Request $request)
{
    $search = $request->query('q');
    $sort = $request->query('sort', 'created_at');

    $query = Tour::with('country');

    if ($search) {
        $query->where('title', 'like', '%' . $search . '%');
    }

    if (in_array($sort, ['title', 'start_date', 'price', 'created_at'])) {
        $direction = $sort === 'created_at' ? 'desc' : 'asc';
        $query->orderBy($sort, $direction);
    } else {
        $sort = 'created_at';
        $query->orderBy('created_at', 'desc');
    }

    $tours = $query->paginate(5)->withQueryString();

    return view('catalog.index', [
        'title' => 'Каталог туров',
        'tours' => $tours,
        'search' => $search,
        'sort' => $sort,
    ]);
}

    public function show(int $id)
{
    $tour = Tour::with('country')->findOrFail($id);

    return view('catalog.show', [
        'title' => $tour->title,
        'tour' => $tour,
    ]);
}

    public function byCode(string $code)
    {
        $tour = collect($this->tours())->firstWhere('code', $code);
        abort_if(! $tour, 404);

        return view('catalog.show', ['title' => $tour['title'], 'tour' => $tour]);
    }

public function byCountry(?string $country = null)
{
    $query = Tour::with('country');

    if ($country) {
        $query->whereHas('country', function ($q) use ($country) {
            $q->where('name', $country);
        });
    }

    $tours = $query->orderBy('title')->paginate(5);

    return view('catalog.index', [
        'title' => $country ? "Туры: {$country}" : 'Все страны',
        'tours' => $tours,
        'search' => null,
        'sort' => 'title',
    ]);
}
}

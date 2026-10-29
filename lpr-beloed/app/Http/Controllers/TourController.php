<?php

namespace App\Http\Controllers;

use App\Http\Requests\TourRequest;
use App\Models\Country;
use App\Models\Tour;
use Illuminate\Http\Request;

class TourController extends Controller
{
    // GET /tours?q=...
    public function index(Request $request)
    {
        $query = Tour::with('country'); // жадная загрузка связи

        if ($search = $request->query('q')) {
            $query->where('title', 'like', "%{$search}%");
        }

        $tours = $query->latest()                    // SORT = сначала новые
            ->paginate(5)                            // PER_PAGE = 5
            ->withQueryString();

        return view('tours.index', ['title' => 'Управление турами', 'tours' => $tours]);
    }

    // GET /tours/create
    public function create()
    {
        return view('tours.form', [
            'title'     => 'Добавить тур',
            'tour'      => new Tour(),
            'countries' => Country::orderBy('name')->get(),
        ]);
    }

    // POST /tours
    public function store(TourRequest $request)
    {
        $tour = Tour::create($request->validated()); // только проверенные поля

        return redirect()
            ->route('tours.show', $tour)
            ->with('success', "Добавлено: {$tour->title} (id {$tour->id})");
    }

    // GET /tours/{tour}
    public function show(Tour $tour)
    {
        $tour->load(['country', 'extras']);

        return view('tours.show', ['title' => $tour->title, 'tour' => $tour]);
    }

    // GET /tours/{tour}/edit
    public function edit(Tour $tour)
    {
        return view('tours.form', [
            'title'     => 'Редактировать тур',
            'tour'      => $tour,
            'countries' => Country::orderBy('name')->get(),
        ]);
    }

    // PUT /tours/{tour}
    public function update(TourRequest $request, Tour $tour)
    {
        $tour->update($request->validated());

        return redirect()
            ->route('tours.show', $tour)
            ->with('success', 'Изменения сохранены.');
    }

    // DELETE /tours/{tour}
    public function destroy(Tour $tour)
    {
        $tour->extras()->detach();
        $tour->delete();

        return redirect()
            ->route('tours.index')
            ->with('success', "Удалено: {$tour->title}");
    }
}

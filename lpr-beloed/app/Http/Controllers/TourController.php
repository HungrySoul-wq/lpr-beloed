<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\Tour;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TourController extends Controller
{
    public function index()
    {
        $tours = Tour::with('country')
            ->orderBy('created_at', 'desc')
            ->paginate(5);

        return view('tours.index', compact('tours'));
    }

    public function create()
    {
        $countries = Country::orderBy('name')->get();

        return view('tours.create', compact('countries'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'country_id' => ['required', 'integer', 'exists:countries,id'],
            'title' => ['required', 'string', 'min:2', 'max:150'],
            'start_date' => ['required', 'date'],
            'days' => ['required', 'integer', 'min:1', 'max:365'],
            'price' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
            'is_hot' => ['nullable', 'boolean'],
        ]);

        $validated['is_hot'] = $request->boolean('is_hot');

        $tour = Tour::create($validated);

        return redirect()
            ->route('tours.show', $tour)
            ->with('success', 'Тур успешно создан.');
    }

    public function show(Tour $tour)
    {
        $tour->load(['country', 'extras']);

        return view('tours.show', compact('tour'));
    }

    public function edit(Tour $tour)
    {
        $countries = Country::orderBy('name')->get();

        return view('tours.edit', compact('tour', 'countries'));
    }

    public function update(Request $request, Tour $tour)
    {
        $validated = $request->validate([
            'country_id' => ['required', 'integer', 'exists:countries,id'],
            'title' => ['required', 'string', 'min:2', 'max:150'],
            'start_date' => ['required', 'date'],
            'days' => ['required', 'integer', 'min:1', 'max:365'],
            'price' => ['required', 'numeric', 'min:0', 'max:99999999.99'],
            'is_hot' => ['nullable', 'boolean'],
        ]);

        $validated['is_hot'] = $request->boolean('is_hot');

        $tour->update($validated);

        return redirect()
            ->route('tours.show', $tour)
            ->with('success', 'Тур успешно обновлён.');
    }

    public function destroy(Tour $tour)
    {
        $tour->extras()->detach();
        $tour->delete();

        return redirect()
            ->route('tours.index')
            ->with('success', 'Тур удалён.');
    }
}
<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\TourApiRequest;
use App\Http\Resources\TourResource;
use App\Models\Tour;
use App\Support\ApiFormat;
use Illuminate\Http\Request;
use App\Models\Country;

class TourController extends Controller
{
    // GET /api/tours?q=&sort=-price&per_page=5
    public function index(Request $request)
    {
        $request->validate([
            'sort'     => ['sometimes', 'in:title,-title,price,-price'], // белый список полей сортировки
            'per_page' => ['sometimes', 'integer', 'between:1,50'],
        ]);

        $query = Tour::with('country');

        if ($request->filled('q')) {
            $query->where('title', 'like', '%' . $request->query('q') . '%');
        }

        $sort = $request->query('sort'); // "-" в начале - по убыванию
        if ($sort) {
            $query->orderBy(ltrim($sort, '-'), str_starts_with($sort, '-') ? 'desc' : 'asc');
        } else {
            $query->latest(); // SORT = сначала новые
        }

        $tours = $query->paginate($request->integer('per_page', 5)); // PER_PAGE = 5

        return ApiFormat::success(TourResource::collection($tours), 200, [
            'page' => [
                'number'      => $tours->currentPage(),
                'size'        => $tours->perPage(),
                'total_items' => $tours->total(),
                'total_pages' => $tours->lastPage(),
            ],
        ]);
    }

    // POST /api/tours
    public function store(TourApiRequest $request)
    {
        $tour = Tour::create($request->validated())->load('country');

        return ApiFormat::success(new TourResource($tour), 201)
            ->header('Location', route('api.tours.show', $tour));
    }

    // GET /api/tours/{tour}
    public function show(Tour $tour)
    {
        return ApiFormat::success(new TourResource($tour->load('country')));
    }

    // PUT/PATCH /api/tours/{tour}
    public function update(TourApiRequest $request, Tour $tour)
    {
        $tour->update($request->validated());

        return ApiFormat::success(new TourResource($tour->load('country')));
    }

    // DELETE /api/tours/{tour}
    public function destroy(Tour $tour)
    {
        $tour->extras()->detach();
        $tour->delete();

        return response()->noContent(); // 204
    }
    public function stats()
    {
    $countries = Country::withCount('tours')->withMin('tours', 'price')->orderBy('name')->get();

    return ApiFormat::success([
        'total_tours' => Tour::count(),
        'min_price'   => (float) Tour::min('price'),
        'by_country'  => $countries->map(fn ($c) => [
            'country_id'  => $c->id,
            'country'     => $c->name,
            'tours_count' => $c->tours_count,
            'min_price'   => $c->tours_min_price !== null ? (float) $c->tours_min_price : null,
        ])->all(),
    ]);
    }    
}

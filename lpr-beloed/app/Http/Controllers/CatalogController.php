<?php

namespace App\Http\Controllers;
use App\Models\Tour;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    // Временное хранилище: в ЛПР № 9 его заменит база данных
    private function tours(): array
    {
        return [
            ['id' => 1, 'code' => 'TR-0101', 'title' => 'Отдых в Анталии', 'country' => 'Турция',
             'start_date' => '2026-12-10', 'days' => 7, 'price' => 54900.00, 'is_hot' => true],
            ['id' => 2, 'code' => 'EG-0102', 'title' => 'Шарм-эль-Шейх всё включено', 'country' => 'Египет',
             'start_date' => '2026-11-20', 'days' => 10, 'price' => 62500.50, 'is_hot' => false],
            ['id' => 3, 'code' => 'TR-0103', 'title' => 'Стамбул: выходные', 'country' => 'Турция',
             'start_date' => '2026-11-05', 'days' => 4, 'price' => 38000.00, 'is_hot' => false],
            ['id' => 4, 'code' => 'IT-0104', 'title' => 'Рим и Флоренция', 'country' => 'Италия',
             'start_date' => '2027-01-15', 'days' => 8, 'price' => 89900.00, 'is_hot' => false],
            ['id' => 5, 'code' => 'EG-0105', 'title' => 'Хургада: дайвинг', 'country' => 'Египет',
             'start_date' => '2026-12-25', 'days' => 9, 'price' => 71000.00, 'is_hot' => true],
             ['id' => 6, 'code' => 'RU-0106', 'title' => 'На море в Сочи', 'country' => 'Россия',
             'start_date' => '2026-12-01', 'days' => 7, 'price' => 90000.00, 'is_hot' => true],
             ['id' => 7, 'code' => 'RU-0107', 'title' => 'Отдых в Иркутске', 'country' => 'Россия',
             'start_date' => '2026-12-21', 'days' => 3, 'price' => 38000.00, 'is_hot' => false],
        ];
    }

    // GET /catalog?q=...&sort=...
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

    // GET /catalog/3
    public function show(int $id)
{
    $tour = Tour::with('country')->findOrFail($id);

    return view('catalog.show', [
        'title' => $tour->title,
        'tour' => $tour,
    ]);
}

    // GET /catalog/code/EG-0102
    public function byCode(string $code)
    {
        $tour = collect($this->tours())->firstWhere('code', $code);
        abort_if(! $tour, 404);

        return view('catalog.show', ['title' => $tour['title'], 'tour' => $tour]);
    }

    // GET /catalog/country/Турция  или  /catalog/country
    public function byCountry(?string $country = null)
    {
        $tours = collect($this->tours());
        if ($country) {
            $tours = $tours->where('country', $country);
        }

        return view('catalog.index', [
            'title'  => $country ? "Туры: {$country}" : 'Все страны',
            'tours'  => $tours,
            'search' => null,
            'sort'   => 'title',
        ]);
    }
}

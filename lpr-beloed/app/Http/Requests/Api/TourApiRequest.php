<?php

namespace App\Http\Requests\Api;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TourApiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $tour = $this->route('tour'); // при создании - null

        // sometimes - проверять, только если поле прислано (для PATCH)
        $required = $this->isMethod('PATCH') ? 'sometimes' : 'required';

        // для PATCH без country_id берём страну из самой записи
        $countryId = $this->input('country_id', $tour?->country_id);

        return [
            'country_id'  => [$required, 'integer', 'exists:countries,id'],
            'title'       => [$required, 'string', 'min:2', 'max:118',          // MIN_LEN = 2, STR_LEN = 118
                              Rule::unique('tours')->where('country_id', $countryId)->ignore($tour?->id)],
            'description' => ['nullable', 'string', 'max:2000'],
            'start_date'  => [$required, 'date', 'after_or_equal:2020-01-01'],
            'days'        => [$required, 'integer', 'between:1,90'],
            'price'       => [$required, 'numeric', 'min:0', 'regex:/^\d{1,8}(\.\d{1,2})?$/'],
            'is_hot'      => ['sometimes', 'boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'required'       => 'Поле «:attribute» обязательно.',
            'title.min'      => 'Название - не менее :min символов.',
            'title.max'      => 'Название - не более :max символов.',
            'title.unique'   => 'В этой стране уже есть тур с таким названием.',
            'between'        => 'Поле «:attribute» - от :min до :max.',
            'price.regex'    => 'Цена - число не более чем с двумя знаками после точки.',
            'exists'         => 'Выбранная страна не существует.',
            'integer'        => 'Поле «:attribute» должно быть целым числом.',
            'numeric'        => 'Поле «:attribute» должно быть числом.',
            'date'           => 'Поле «:attribute» должно быть датой.',
            'after_or_equal' => 'Поле «:attribute» - не ранее :date.',
            'boolean'        => 'Поле «:attribute» должно быть true или false.',
        ];
    }

    public function attributes(): array
    {
        return [
            'country_id'  => 'Страна',
            'title'       => 'Название',
            'description' => 'Описание',
            'start_date'  => 'Дата начала',
            'days'        => 'Дней',
            'price'       => 'Цена',
            'is_hot'      => 'Горящий тур',
        ];
    }
}

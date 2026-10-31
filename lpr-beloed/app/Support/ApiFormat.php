<?php

namespace App\Support;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Единый формат ответов API (FORMAT = C):
 * успех:  { code, payload, timestamp, sign [, page] }
 * ошибка: { code, payload: null, error [, invalid], timestamp, sign }
 */
class ApiFormat
{
    public static function success(mixed $data, int $status = 200, array $extra = []): JsonResponse
    {
        $body = array_merge([
            'code'      => $status,
            'payload'   => self::normalize($data),
            'timestamp' => now()->toIso8601String(),
            'sign'      => self::sign(),
        ], $extra);

        return response()->json($body, $status, [], JSON_UNESCAPED_UNICODE);
    }

    public static function error(string $message, int $status, array $invalid = []): JsonResponse
    {
        $body = [
            'code'    => $status,
            'payload' => null,
            'error'   => $message,
        ];

        // ключ с ошибками полей - только для 422
        if ($invalid) {
            $body['invalid'] = $invalid;
        }

        $body['timestamp'] = now()->toIso8601String();
        $body['sign']      = self::sign();

        return response()->json($body, $status, [], JSON_UNESCAPED_UNICODE);
    }

    private static function sign(): string
    {
        return config('lab.slug') . '/' . config('lab.code');
    }

    private static function normalize(mixed $data): mixed
    {
        return $data instanceof JsonResource ? $data->resolve(request()) : $data;
    }
}

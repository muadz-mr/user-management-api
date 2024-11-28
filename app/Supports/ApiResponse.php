<?php

namespace App\Supports;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;

class ApiResponse
{
    public function success($data = [], $statusCode = 200): JsonResponse
    {
        $responseInfo = ['errCode' => 0, 'errMsg' => ''];

        return response()->json(
            count($data) > 0 ? array_merge($responseInfo, ['data' => $data]) : $responseInfo,
            $statusCode
        );
    }

    public function error(int $statusCode, int $errorCode, string $errorMesage, ?array $data = []): JsonResponse
    {
        return response()->json([
            'errCode' => $errorCode,
            'errMsg' => $errorMesage,
            ...$data,
        ], $statusCode);
    }

    public function collection($collection)
    {
        if ($collection instanceof LengthAwarePaginator || $collection instanceof AnonymousResourceCollection) {
            return $this->success([
                'items' => $collection->items(),
                'meta' => [
                    'current_page' => $collection->currentPage(),
                    'last_page' => $collection->lastPage(),
                    'per_page' => $collection->perPage(),
                    'total' => $collection->total(),
                    'has_more_pages' => $collection->hasMorePages(),
                ],
            ]);
        }

        return $this->success($collection);
    }
}

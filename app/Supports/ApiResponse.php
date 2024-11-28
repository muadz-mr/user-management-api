<?php

namespace App\Supports;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Pagination\LengthAwarePaginator;

class ApiResponse
{
    /**
     * @param array<string, mixed> $data
     * @param int $statusCode
     */
    public function success(array $data = [], int $statusCode = 200): JsonResponse
    {
        $responseInfo = ['errCode' => 0, 'errMsg' => ''];

        return response()->json(
            count($data) > 0 ? array_merge($responseInfo, ['data' => $data]) : $responseInfo,
            $statusCode
        );
    }

    /**
     * @param int $statusCode
     * @param int $errorCode
     * @param string $errorMessage
     * @param array<string, mixed>|null $data
     */
    public function error(int $statusCode, int $errorCode, string $errorMessage, ?array $data = []): JsonResponse
    {
        return response()->json([
            'errCode' => $errorCode,
            'errMsg' => $errorMessage,
            ...$data,
        ], $statusCode);
    }

    public function collection(mixed $collection): JsonResponse
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

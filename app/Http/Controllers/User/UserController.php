<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class UserController extends Controller
{
    public function store(StoreUserRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $user = User::query()->create($validated);

        if ($user == null) {
            throw new BadRequestHttpException(__('message.error.1001', ['resource' => 'user']), null, 1001);
        }

        return $this->apiResponse->success();
    }
}

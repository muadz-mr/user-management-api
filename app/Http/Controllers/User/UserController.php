<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\DeleteUserRequest;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class UserController extends Controller
{
    public function store(StoreUserRequest $request): JsonResponse
    {
        $user = User::create($request->validated());

        if ($user == null) {
            $this->throwException(1001);
        }

        return $this->apiResponse->success();
    }

    public function update(UpdateUserRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $user = User::find($validated['id']);
        $user->update($validated);

        if (! $user) {
            $this->throwException(1002);
        }

        return $this->apiResponse->success();
    }

    public function destroy(DeleteUserRequest $request): JsonResponse
    {
        $validated = $request->validated();
        $user = User::find($validated['id']);
        $user->delete();

        if (! $user) {
            $this->throwException(1003);
        }

        return $this->apiResponse->success();
    }

    private function throwException(int $errorCode): void
    {
        $errorMessage = __("message.error.$errorCode", ['resource' => 'user']);
        throw new BadRequestHttpException($errorMessage, null, $errorCode);
    }
}

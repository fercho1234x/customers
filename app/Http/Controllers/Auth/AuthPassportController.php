<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Psr\Http\Message\ServerRequestInterface;

class AuthPassportController extends AccessTokenController
{
    /**
     * @param ServerRequestInterface $request
     * @return Collection|JsonResponse
     */
    public function token(ServerRequestInterface $request): Collection|JsonResponse
    {
        try {
            $token = collect(
                json_decode(
                    parent::issueToken($request)->getContent(),
                    true
                )
            );
            $user = User::whereEmail(request('username'))
                ->with('commune:id,name,description')
                ->first();
            return $token->merge(['user' => $user]);
        } catch (Exception $exception) {
            return response()->json(['error' => 'failed_authentication'], 401);
        }
    }

    /**
     * @return JsonResponse
     */
    public function logout(): JsonResponse
    {
        request()->user()->currentAccessToken()->revoke();
        return response()->json(['message' => 'ok']);
    }
}

<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Traits\ApiResponser;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;
use Laravel\Passport\Http\Controllers\AccessTokenController;
use Psr\Http\Message\ServerRequestInterface;

class AuthPassportController extends AccessTokenController
{
    use ApiResponser;

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
                ->with([
                    'commune:id,name,description',
                    'region:id,name,description',
                    'roles:id,name'
                ])
                ->first();
            return $this->successResponse($token->merge(['user' => $user]));
        } catch (Exception $e) {
            return $this->errorResponse('failed_authentication', 401);
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

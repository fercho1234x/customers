<?php

namespace App\Http\Controllers\User;

use App\Actions\User\CreateUserAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\SearchRequest;
use App\Http\Requests\User\UserIndexRequest;
use App\Http\Requests\User\UserRequest;
use App\Models\User;
use App\Traits\ApiResponser;
use Exception;
use Illuminate\Http\JsonResponse;

class UserController extends Controller
{
    /**
     *
     */
    public function __construct()
    {
        $this->middleware('can:users.index')->only('index');
        $this->middleware('can:users.store')->only('store');
        $this->middleware('can:users.show')->only('show');
        $this->middleware('can:users.searchByEmailOrDNI')->only('searchByEmailOrDNI');
        $this->middleware('can:users.update')->only('update');
        $this->middleware('can:users.destroy')->only('destroy');
        $this->middleware('can:users.greet')->only('greet');
    }

    use ApiResponser;

    /**
     * Display a listing of the resource.
     * @param UserIndexRequest $request
     * @return JsonResponse
     */
    public function index(UserIndexRequest $request): JsonResponse
    {
        try {
            $status = $request->get('status');
            $perPage = $request->get('per_page');
            $role = $request->get('role');

            $users = User::with([
                'region:id,name,description,status',
                'commune:id,name,description,status',
                'roles:id,name'
            ])->filterByStatus($status)
                ->filterByRole($role)
                ->paginate($perPage);

            return $this->successResponse($users);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param UserRequest $request
     * @param CreateUserAction $action
     * @return JsonResponse
     */
    public function store(UserRequest $request, CreateUserAction $action): JsonResponse
    {
        try {
            $user = $action->execute(
                collect($request->validated())
                    ->except('role')
                    ->toArray()
            );

            $user->assignRole($request->role);

            return $this->successResponse($user);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * Display the specified resource.
     * @param User $user
     * @return JsonResponse
     */
    public function show(User $user): JsonResponse
    {
        try {
            return $this->successResponse(
                $user->load([
                    'region:id,name,description,status',
                    'commune:id,name,description,status',
                    'roles:id,name'
                ])
            );
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * @param SearchRequest $request
     * @return JsonResponse
     */
    public function searchByEmailOrDNI(SearchRequest $request): JsonResponse
    {
        try {
            $users = User::filterByEmailOrDNI($request->get('word'))
                        ->get();
            return $this->successResponse($users);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * Update the specified resource in storage.
     * @param UserRequest $request
     * @param User $user
     * @return JsonResponse
     */
    public function update(UserRequest $request, User $user): JsonResponse
    {
        try {
            $user->update(
                collect($request->validated())
                    ->except('role')
                    ->toArray()
            );

            $user->syncRoles($request->get('role'));

            return $this->successResponse($user);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param User $user
     * @return JsonResponse
     */
    public function destroy(User $user): JsonResponse
    {
        try {
            $user->delete();
            return $this->successResponse($user);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }

    /**
     * Greet.
     * @return JsonResponse
     */
    public function greet(): JsonResponse
    {
        try {
            return $this->successResponse('Hi ' . auth()->user()->name);
        } catch (Exception $e) {
            return $this->errorResponse($e);
        }
    }
}

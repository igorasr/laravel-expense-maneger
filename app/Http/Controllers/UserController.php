<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Services\UserService;

class UserController extends Controller
{

    private $userService;

    function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function index()
    {
        return response()->json(User::all());
    }

    /**
     * @OA\Post(
     *   path="/login/register",
     *   tags={"Auth"},
     *   summary="Registrar um novo usuário",
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="name",
     *           type="string",
     *           example="Igor",
     *           description="O nome do usuário"
     *         ),
     *         @OA\Property(
     *           property="email",
     *           type="string",
     *           format="email",
     *           example="teste@teste.com.br",
     *           description="O e-mail do usuário"
     *         ),
     *         @OA\Property(
     *           property="password",
     *           type="string",
     *           format="password",
     *           example="12345678",
     *           description="A senha do usuário"
     *         )
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response="200",
     *     description="Usuário registrado com sucesso"
     *   )
     * )
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'min:5'],
            'email' => ['required', 'email:rfc,dns'],
            'password' => ['required', 'min:8']
        ]);

        if ($validator->fails())
            return response()->json(array('errors' => $validator->errors()), 400);


        $userData = $request->only('email', 'name', 'password');

        $response = $this->userService->create($userData);
        
        if($response['error']) return $this->clientFail($response);

        return $this->created($response);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{

    /**
     * @OA\Post(
     *   path="/login",
     *   tags={"Auth"},
     *   summary="Login de usuário",
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
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
     *     description="Usuário autenticado com sucesso"
     *   ),
     *   @OA\Response(
     *     response="401",
     *     description="Credenciais inválidas"
     *   )
     * )
     */

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!auth()->attempt($credentials))
            return $this->clientFail('Invalid Credentials');

        $token = $request->user()->createToken('auth_token');

        return $this->success(array('token' => $token));
    }
}

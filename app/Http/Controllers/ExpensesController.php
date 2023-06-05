<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Services\ExpenseService;


class ExpensesController extends Controller
{
    protected $expenseService;

    function __construct(ExpenseService $expenseService)
    {
        $this->expenseService = $expenseService;
    }

    /**
     * @OA\Get(
     *   path="/expenses",
     *   tags={"Expenses"},
     *   summary="Listar despesas",
     *   security={{"bearerAuth": {}}},
     *   @OA\Response(
     *     response="200",
     *     description="Lista de despesas retornada com sucesso",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="id",
     *         type="integer",
     *         example="18",
     *         description="ID da despesa"
     *       ),
     *       @OA\Property(
     *         property="description",
     *         type="string",
     *         example="Testando",
     *         description="Descrição da despesa"
     *       ),
     *       @OA\Property(
     *         property="amount",
     *         type="numeric",
     *         example="30",
     *         description="Valor da despesa"
     *       ),
     *       @OA\Property(
     *         property="user_id",
     *         type="integer",
     *         example="7",
     *         description="ID do usuário associado à despesa"
     *       ),
     *       @OA\Property(
     *         property="date",
     *         type="string",
     *         format="date-time",
     *         example="2023-06-04 15:51:00",
     *         description="Data da despesa"
     *       ),
     *       @OA\Property(
     *         property="created_at",
     *         type="string",
     *         format="date-time",
     *         example="2023-06-04T19:47:59.000000Z",
     *         description="Data de criação da despesa"
     *       ),
     *       @OA\Property(
     *         property="updated_at",
     *         type="string",
     *         format="date-time",
     *         example="2023-06-04T19:47:59.000000Z",
     *         description="Data de atualização da despesa"
     *       )
     *     )
     *   )
     * )
     */

    public function index()
    {
        return response()->json($this->expenseService->getAll(), 200);
    }

    /**
     * @OA\Get(
     *   path="/expenses/{id}",
     *   tags={"Expenses"},
     *   summary="Obter despesa por ID",
     *   security={{"bearerAuth": {}}},   
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     description="ID da despesa",
     *     @OA\Schema(
     *       type="integer",
     *       format="int64",
     *       example="18"
     *     )
     *   ),
     *   @OA\Response(
     *     response="200",
     *     description="Despesa retornada com sucesso",
     *     @OA\JsonContent(
     *       @OA\Property(
     *         property="id",
     *         type="integer",
     *         example="18",
     *         description="ID da despesa"
     *       ),
     *       @OA\Property(
     *         property="description",
     *         type="string",
     *         example="Testando",
     *         description="Descrição da despesa"
     *       ),
     *       @OA\Property(
     *         property="amount",
     *         type="numeric",
     *         example="30",
     *         description="Valor da despesa"
     *       ),
     *       @OA\Property(
     *         property="user_id",
     *         type="integer",
     *         example="7",
     *         description="ID do usuário associado à despesa"
     *       ),
     *       @OA\Property(
     *         property="date",
     *         type="string",
     *         format="date-time",
     *         example="2023-06-04 15:51:00",
     *         description="Data da despesa"
     *       ),
     *       @OA\Property(
     *         property="created_at",
     *         type="string",
     *         format="date-time",
     *         example="2023-06-04T19:47:59.000000Z",
     *         description="Data de criação da despesa"
     *       ),
     *       @OA\Property(
     *         property="updated_at",
     *         type="string",
     *         format="date-time",
     *         example="2023-06-04T19:47:59.000000Z",
     *         description="Data de atualização da despesa"
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response="404",
     *     description="Despesa não encontrada"
     *   )
     * )
     */

    public function getById($id)
    {
        return response()->json($this->expenseService->getById($id), 200);
    }

    /**
     * @OA\Post(
     *   path="/expenses",
     *   tags={"Expenses"},
     *   summary="Criar despesa",
     *   security={{"bearerAuth": {}}},
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="description",
     *           type="string",
     *           example="Testando",
     *           description="Descrição da despesa"
     *         ),
     *         @OA\Property(
     *           property="amount",
     *           type="integer",
     *           example="30",
     *           description="Valor da despesa"
     *         ),
     *         @OA\Property(
     *           property="user_id",
     *           type="integer",
     *           example="7",
     *           description="ID do usuário associado à despesa"
     *         ),
     *         @OA\Property(
     *           property="date",
     *           type="string",
     *           format="date-time",
     *           example="2023-06-04 15:51:00",
     *           description="Data da despesa"
     *         )
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response="201",
     *     description="Despesa criada com sucesso"
     *   )
     * )
     */
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'description' => ['required', 'string'],
            'amount'    => ['required', 'numeric'],
            'date'      => ['required', 'date'],
            'user_id'   => ['required', 'unique:Users']
        ]);

        if ($validator->fails())
            return response()->json(array('errors' => $validator->errors()), 400);

        $expenseData = $request->only('description', 'amount', 'date', 'user_id');

        $Expense = $this->expenseService->create($expenseData);

        return response()->json($Expense, 200);
    }
    /**
     * @OA\Patch(
     *   path="/expenses/{id}",
     *   tags={"Expenses"},
     *   summary="Atualizar despesa",
     * security={{"bearerAuth": {}}},
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     description="ID da despesa a ser atualizada",
     *     @OA\Schema(
     *       type="integer",
     *       format="int64",
     *       example="18"
     *     )
     *   ),
     *   @OA\RequestBody(
     *     @OA\MediaType(
     *       mediaType="application/json",
     *       @OA\Schema(
     *         @OA\Property(
     *           property="description",
     *           type="string",
     *           example="Testando",
     *           description="Nova descrição da despesa"
     *         ),
     *         @OA\Property(
     *           property="amount",
     *           type="integer",
     *           example="30",
     *           description="Novo valor da despesa"
     *         ),
     *         @OA\Property(
     *           property="user_id",
     *           type="integer",
     *           example="7",
     *           description="Novo ID do usuário associado à despesa"
     *         ),
     *         @OA\Property(
     *           property="date",
     *           type="string",
     *           format="date-time",
     *           example="2023-06-04 15:51:00",
     *           description="Nova data da despesa"
     *         )
     *       )
     *     )
     *   ),
     *   @OA\Response(
     *     response="200",
     *     description="Despesa atualizada com sucesso"
     *   ),
     *   @OA\Response(
     *     response="404",
     *     description="Despesa não encontrada"
     *   )
     * )
     */
    public function save(Request $request)
    {
        $expenseData = $request->only('id', 'description', 'amount', 'date', 'user_id');

        $expenseData['id'] = $request->id;

        $Expense = $this->expenseService->save($expenseData);

        return response()->json($Expense, 200);
    }

    /**
     * @OA\Delete(
     *   path="/expenses/{id}",
     *   tags={"Expenses"},
     *   summary="Excluir despesa",
     *   security={{"bearerAuth": {}}},
     *   @OA\Parameter(
     *     name="id",
     *     in="path",
     *     required=true,
     *     description="ID da despesa a ser excluída",
     *     @OA\Schema(
     *       type="integer",
     *       format="int64",
     *       example="18"
     *     )
     *   ),
     *   @OA\Response(
     *     response="204",
     *     description="Despesa excluída com sucesso"
     *   ),
     *   @OA\Response(
     *     response="404",
     *     description="Despesa não encontrada"
     *   )
     * )
     */

    public function delete($id)
    {
        $Expense = $this->expenseService->delete($id);

        return response()->json($Expense, 200);
    }
}

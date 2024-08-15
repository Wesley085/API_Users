<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Models\User;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index() : JsonResponse
    {
        // Recupera os users do BD, ordenados pelo ID em ordem decrescente, paginados
        $users = User::orderBy('id', 'DESC')->paginate(1);

        // Retorna os users recuperados como uma resposta JSON
        return response()->json([
            'status' => true,
            'users' => $users,
        ],200);
    }

    public function show(User $user)
    {
        // Retorna os detalhes do user em formato de JSON
        return response()->json([
            'status' => true,
            'users' => $user,
        ],200);
    }

/**
 * Cria novo usuário com os dados fornecidos na requisição
 *
 * @param \App\Http\Requests\UserRequest $request $request O objeto de requisição contendo os dados do usuário a ser criado.
 * @return \Illuminate\Http\JsonResponse
 */

    public function store(UserRequest $request) : JsonResponse
    {
        // Iniciar a transação
        DB::beginTransaction();

        try {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
            ]);

            // Deu bom
            DB::commit();

            // Retorna os dados do user criado e uma mensagem de sucessp cpm status 201
            return response()->json([
                'status' => true,
                'user' => $user,
                'message' => "Usuário cadastrado com sucesso!"
            ],201);

        } catch (Exception $e) {

            // Operação não concluida
            DB::rollBack();

            // Retorna uma mensagem de erro com status 400
            return response()->json([
                'status' => false,
                'message' => "Usuário não cadastrado",
            ],400);
        }

    }

    /**
     * Tualizar os dados de um user existente com base nos dados fornecidos na requisição
     *
     *  @param \App\Http\Requests\UserRequest  $request O objeto de requisição contendo os dados do usuário a ser atualizado.
     *  @param \App\Models\User $user o usuário a ser atualizado.
     *  @return \Illuminate\Http\JsonResponse
     *
     */

    public function update(UserRequest $request, User $user): JsonResponse
    {

        // Iniciar a transação
        DB::beginTransaction();

        try {

            // Editar o registro no BD
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
            ]);

            // Deu bom
            DB::commit();

            // Retorna os dados do user editado e uma mensagem de sucesso com status 200
            return response()->json([
                'status' => true,
                'user' => $user,
                'message' => "Usuário editado com sucesso!"
            ],200);

        } catch (Exception $e) {
            // Operação não concluida
            DB::rollBack();

            // Retorna uma mensagem de erro com status 400
            return response()->json([
                'status' => false,
                'message' => "Usuário não editado",
            ],400);
        }

    }

    /**
     * Método de destruição para depuração
     * @return never
     */
    public function destroy(User $user) : JsonResponse
    {
        try {

            // Apaga o registro no BD
            $user->delete();

            // Retorna os dados do user apagado e uma mensagem de sucesso com status 200
            return response()->json([
                'status' => true,
                'user' => $user,
                'message' => "Usuário apagado com sucesso!"
            ],200);

        } catch (Exception $e) {

            // Operação não concluida
            DB::rollBack();

            // Retorna uma mensagem de erro com status 400
            return response()->json([
                'status' => false,
                'message' => "Usuário não apagado",
            ],400);
        }
    }
}


<?php

namespace App\Http\Controllers;

use JWTAuth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Pessoa;
use App\Models\User;
use Tymon\JWTAuth\Exceptions\JWTException;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{
    // Funções relevantes ao login e logou de usuários
    public function register(Request $request)
    {
    	//Validate data
        $data = $request->only('name', 'email', 'password');
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|max:50'
        ]);

        //Retorna resposta de falha quando o request não é válido
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        //Request é válido, gerar novo usuário
        $user = User::create([
        	'name' => $request->name,
        	'email' => $request->email,
        	'password' => bcrypt($request->password)
        ]);

        //Usuário criado, retorna respota de sucesso.
        return response()->json([
            'success' => true,
            'message' => 'Usuário criado com sucesso.',
            'data' => $user
        ], Response::HTTP_OK);
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->only('email', 'password');

        //valid credential
        $validator = Validator::make($credentials, [
            'email' => 'required|email',
            'password' => 'required|string|min:6|max:50'
        ]);

        //Retorna resposta de falha quando o request não é válido
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        //Request é válido
        //Gera o token
        try {
            if (! $token = \JWTAuth::attempt($credentials)) {
                return response()->json([
                	'success' => false,
                	'message' => 'Credênciais de login estão incoretas.',
                ], 400);
            }
        } catch (JWTException $e) {
    	return $credentials;
            return response()->json([
                	'success' => false,
                	'message' => 'Não foi possícel gera o Token.',
                ], 500);
        }

        //Token criado, retorna com sucesso e responde com o Token jwt
        return response()->json([
            'success' => true,
            'token' => $token,
        ]);

    }

    public function logout(Request $request)
    {
        //Válida a credencial
        $validator = Validator::make($request->only('token'), [
            'token' => 'required'
        ]);

        //Retorna resposta de falha quando o request não é válido
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

		//Request é validado, efetua o logout        
        try {
            JWTAuth::invalidate($request->token);
 
            return response()->json([
                'success' => true,
                'message' => 'Usuário efetuou o Logout.'
            ]);
        } catch (JWTException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Desculpa, o usuário não pode efetuar o Logout'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }

    }

    // Funções relevantes a manipulação do recursos Pessoas
    public function getPessoas() {
        // Lógica para carregar todos os registros de pessoas vai aqui
        // Efetuando o caregamento apenas de pessoas com status 'A'
        $pessoasLista = Pessoa::where('status', 'A')->paginate(15);
        return response()->json($pessoasLista, 200);

    }

    public function getPessoa($id) {
        // Lógica para carregar o registro de uma pessoa vai aqui
        if (Pessoa::where('id', $id)->exists()) {
            $pessoas = Pessoa::where('id', $id)->get()->toJson(JSON_PRETTY_PRINT);
            return response($pessoas, 200);
        } else {
            return response()->json([
              "message" => "Pessoa não encontrada."
            ], 404);
        }
    }

    public function createPessoa(Request $request) {
        // Lógica para registrar uma pessoa vai aqui

        $statusQuery = DB::insert('insert into pessoas (pessoa_nome, status, data_criacao, data_atualizacao) 
                                    values (?, ?, ?, ?)', ["$request->nome", "A", date("Y-m-d H:i:s"), date("Y-m-d H:i:s")]);

        if($statusQuery){

            return response()->json([
                "message" => "Registro de pessoa criado com sucesso!"
            ], 201);
        }else{

            return response()->json([
                "message" => "Ocorreu um erro ao registrar a pessoa, favor verificar os dados enviados!"
            ], 400);
        }

    }

    public function updatePessoa(Request $request, $id) {
        // Lógica para atualizar uma pessoa vai aqui
        if (Pessoa::where('id', $id)->exists()) {

            $statusQuery = DB::update('update pessoas set pessoa_nome = ?, status = ?, data_atualizacao = ?
                                        where id = ?',[$request->nome, $request->status, date("Y-m-d H:i:s"), $id]);

            if($statusQuery){
                return response()->json([
                    "message" => "Registro da pessoa foi atualizado com sucesso!"
                ], 200);
            } else {
                return response()->json([
                    "message" => "Não foi possível atualizar o registro da pessoa nesse momento!"
                ], 400);
            }
        }else{
            return response()->json([
                "message" => "Pessoa não encontrada!"
            ], 404);
        }
    }

    public function deletePessoa ($id) {
        // logic to delete a student record goes here
        if(Pessoa::where('id', $id)->exists()) {

            $statusQuery = DB::update('update pessoas set status = ?, data_atualizacao = ?
                                        where id = ?',[ 'I', date("Y-m-d H:i:s"), $id]);

            return response()->json([
            "message" => "Registro da pessoa foi desativado."
            ], 202);
        } else {
            return response()->json([
            "message" => "Registro da pessoa não foi encontrado."
            ], 404);
        }
    }
}

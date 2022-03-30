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
    /*
     Funções relevantes ao login e logou de usuários
     */
    public function register(Request $request)
    {
    	//Validate data
        $data = $request->only('name', 'email', 'password', 'confirmPassword');
        $validator = Validator::make($data, [
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6|max:50',
            'confirmPassword' =>'required|string|same:password|min:6|max:50'
        ]);

        //Retorna resposta de falha quando o request não é válido
        if ($validator->fails()) {
            return response()->json(['message' => 'Os dados estão invalidos','error' => $validator->messages()], 422);
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
        ], 201);
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
            return response()->json(['message' => 'Os dados estao invalidos', 'error' => $validator->messages()], 422);
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
            return response()->json(['message' => 'Os dados estão invalidos', 'error' => $validator->messages()], 200);
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

    /*
         Funções relevantes a manipulação do recursos Pessoas
     */

    public function getPessoas() {
        // Lógica para carregar todos os registros de pessoas vai aqui
        // Efetuando o caregamento apenas de pessoas com status 'A'
        $pessoasLista = Pessoa::where('status', 'A')->paginate(15);
        return response()->json($pessoasLista, 200);

    }

    public function getPessoa($id) {
        // Lógica para carregar o registro de uma pessoa vai aqui

        if(!is_numeric($id)){
            return response()->json([
                "message" => "Parametro incoreto para esta chamada."
            ], 400);
        }

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

        //Efetua a validação dos dados da pessoa, verificando se já não existe no banco
        $data = $request->only('pessoa_nome');
        $validator = Validator::make($data, [
            'pessoa_nome' => 'required|string|unique:pessoas'
        ]);

        //Retorna resposta de falha quando o request não é válido
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 422);
        }

        $pessoa = Pessoa::create([
        	'pessoa_nome' => $request->pessoa_nome,
        	'status' => 'A'
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Recurso pessoa criado com sucesso.',
            'data' => $pessoa
        ], 200);

    }

    public function updatePessoa(Request $request, $id) {
        // Lógica para atualizar uma pessoa vai aqui

        //Efetua a validação dos dados da pessoa, verificando se já não existe no banco

        if(!is_numeric($id)){
            return response()->json([
                "message" => "Parametro incoreto para esta chamada."
            ], 400);
        }

        $data = $request->only('pessoa_nome');
        $validator = Validator::make($data, [
            'pessoa_nome' => 'required|string|unique:pessoas'
        ]);

        //Retorna resposta de falha quando o request não é válido
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }

        if (Pessoa::where('id', $id)->exists()) {

            $pessoa = Pessoa::find($id);
            $pessoa->pessoa_nome = $request->pessoa_nome;
            $pessoa->save();

            return response()->json([
                'success' => true,
                'message' => 'Recurso pessoa criado com sucesso.',
                'data' => $pessoa
            ], Response::HTTP_OK);

        }else{
            return response()->json([
                "message" => "Pessoa não encontrada!"
            ], 404);
        }
    }

    public function deletePessoa ($id) {
        // logic to delete a student record goes here

        //Efetua a validação dos dados da pessoa, verificando se já não existe no banco

        if(!is_numeric($id)){
            return response()->json([
                "message" => "Parametro incoreto para esta chamada."
            ], 400);
        }

        if(Pessoa::where('id', $id)->exists()) {

            $pessoa = Pessoa::find($id);
            $pessoa->status = 'I';
            $pessoa->save();

            return response()->json([
                'success' => true,
                'message' => 'Recurso pessoa removido com sucesso.',
                'data' => $pessoa
            ], Response::HTTP_OK);

        } else {
            return response()->json([
            "message" => "Registro da pessoa não foi encontrado."
            ], 404);
        }
    }
}

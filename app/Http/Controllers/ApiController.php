<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pessoa;
use Illuminate\Support\Facades\DB;

class ApiController extends Controller
{
    //
    public function getPessoas() {
        // Lógica para carregar todos os registros de pessoas vai aqui
        $pessoas = Pessoa::where('status', 'A')->get()->toJson(JSON_PRETTY_PRINT);
        return response($pessoas, 200);

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

        var_dump($statusQuery);
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

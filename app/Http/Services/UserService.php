<?php

namespace App\Http\Services;
use Illuminate\Validation\Rules\Password;
use App\Models\User;
use Validator;

class UserService
{
    public function validate($data) {
        $validator = Validator::make($data, [
            'name' => ['bail' ,'required'],
            'userName' => ['bail', 'required'],
            'zipCode' => ['bail', 'required'],
            'email' => ['bail', 'required'],
            'password' => ['bail', 'required', Password::min(8)->letters()->numbers()]
        ]);
        if($validator->fails()) {
            return [
                'status' => false,
                'message' => 'validate_fail',
                'errors' => $validator->errors()
            ];
        } else {
            return [
                'status' => true,
                'message' => 'validate_success'
            ];
        }
    }

    public function index($data) {
        if(!$data->isEmpty()) {
            return [
                'status' => true,
                'message' => 'Usuários listados com sucesso!',
                'data' => $data
            ];
        } else {
            return [
                'status' => false,
                'message' => 'Lista de usuários vazia!'
            ];
        }
    }

    public function store($data) {
        $data['password'] = bcrypt($data['password']);
        $user = User::create($data);
        if($user) {
            return [
                'status' => true,
                'message' => 'Usuário cadastrado com sucesso!',
                'data' => $user
            ];
        } else {
            return [
                'status' => false,
                'type' => 'create_fail'
            ];
        }
    }

    public function show($id) {
        $user = User::find($id);
        if($user) {
            return [
                'status' => true,
                'message' => 'Usuário encontrado.',
                'data' => $user
            ];
        } else {
            return [
                'status' => false,
                'message' => 'Usuário não encontrado.'
            ];
        }
    }

    public function put($data, $id) {
        $user = User::find($id);
        $data['password'] = bcrypt($data['password']);
        $user->fill($data)->save();
        if($user) {
            return [
                'status' => true,
                'message' => 'Usuário atualizado com sucesso!',
                'data' => $user
            ];
        } else {
            return [
                'status' => false,
                'message' => 'Erro ao atualizar o usuário'
            ];
        }
    }

    public function patch($data, $id) {
        $user = User::find($id);
        if(!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        }
        $user->fill($data)->save();
        if($user) {
            return [
                'status' => true,
                'message' => 'Usuário atualizado com sucesso!',
                'data' => $user
            ];
        } else {
            return [
                'status' => false,
                'message' => 'Erro ao atualizar o usuário'
            ];
        }
    }

    public function destroy($id) {
        $user = User::find($id);
        if($user) {
            $user->delete();
            return [
                'status' => true,
                'message' => 'Usuário deletado com sucesso',
                'data' => $user
            ];
        } else {
            return [
                'status' => false,
                'message' => 'Usuário não encontrado.'
            ];
        }
    }
}
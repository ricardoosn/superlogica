<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request; 
use App\Http\Services\UserService;
use App\Models\User;
use Response;


class UserController extends Controller
{
    public function __construct(UserService $user_service, User $user, Response $response) {
        $this->user_service = $user_service;
        $this->user = $user;
        $this->response = $response;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = $this->user->all();
        $index = $this->user_service->index($users);
        
        if($index['status'] === true) {
            return response()->json($index, 200);
        } else {
            return response()->json($index, 204);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $validator = $this->user_service->validate($data);

        if($validator['status'] === true) {
            $created = $this->user_service->store($data);
            if($created['status'] === true) {
                return response()->json($created, 200);
            } else {
                return response()->json($created, 500);
            }
        } else {
            return response()->json($validator, 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = $this->user_service->show($id);
        if($user['status'] === true) {
            return response()->json($user, 200);
        } else {
            return response()->json($user, 404);
        }
        
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->all();

        if($request->isMethod('put')) {
            $validator = $this->user_service->validate($data);
            if($validator['status'] === true) {
                $put = $this->user_service->put($data, $id);
                if($put['status'] === true) {
                    return response()->json($put, 200);
                } else {
                    return response()->json($put, 500);
                }
            } else {
                return response()->json($validator, 500);
            }
        } else if($request->isMethod('patch')) {
            $patch = $this->user_service->patch($data, $id);
            if($patch['status'] === true) {
                return response()->json($patch, 200);
            } else {
                return response()->json($patch, 500);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $destroy = $this->user_service->destroy($id);
        if($destroy['status'] === true) {
            return response()->json($destroy, 200);
        } else{
            return response()->json($destroy, 404);
        }
    }
}

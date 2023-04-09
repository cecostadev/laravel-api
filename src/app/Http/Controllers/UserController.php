<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use App\Services\UserService;
use App\Models\User;

use App\Http\Middleware\CheckPermission;

class UserController extends Controller
{   

    private $userService;

    public function __construct(UserService $service)
    {
        $this->userService =  $service;

        $this->middleware('check.permission:get_all_users')->only(['index']);
        $this->middleware('check.permission:get_unique_user')->only(['show']);
        $this->middleware('check.permission:insert_user')->only(['store']);
        $this->middleware('check.permission:delete_user')->only(['destroy']);
    }

    public function index()
    {
        $users = $this->userService->getAll();
        if($users) {
            return response()->json(['users' => $users]);
        }
    }

    public function show($id)
    {
        $user = $this->userService->getUserById($id);
        if($user) {
            return response()->json(['user' => $user]);
        }

        return response()->json(['error' => 'User not found!', 404]); 
    }

    public function store(Request $request)
    {

        $validate = $request->validate([
            'name'=> 'required|max:255',
            'email'=> 'required|email|unique:users,email',
            'password'=> 'required|min:4'
        ]);

        if(!$validate) {
            return response()->json(['error'=> 'Dados Inválidos'], 422);
        }

        $user = $this->userService->register($request->all());

        if($user->save()) {
            return response()->json($user, 201);
        }

        return response()->json(['error'=> 'Houve algum problema ao salvar o usuário'], 404);
    }

    public function update(Request $request, $id)
    {   

        $validate = $request->validate([
            'name'=>  'max:255',
            'email'=> 'email|unique:users,email',
            'password'=> 'min:8'
        ]);

        $user = User::find($id);
        $user->name  = $request->input('name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        
        if($user->save()) {
            return response()->json($user);
        }

        return response()->json([]);
    }

    public function destroy($id)
    {
        $user = $this->userService->getUserById($id);

        if(!$user) {
            return response()->json(['error' => 'User not found', 404]);
        }

        $this->userService->delete($id);

        return response()->json(['message'=>'User deleted successfully!']);
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
    
        $users = User::where('name', 'LIKE', "%$query%")
                     ->orWhere('email', 'LIKE', "%$query%")
                     ->get();
    
        return response()->json(['data' => $users]);
    }
}

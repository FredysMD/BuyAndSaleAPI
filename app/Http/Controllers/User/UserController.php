<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\APIController;
use Illuminate\Http\Request;

use App\Models\User;

class UserController extends APIController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $users = User::all();

        return $this->showAll($users);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $rules =[
          'name' => 'required',
          'email' => 'required|email|unique:users',
          'password' => 'required|min:6|confirmed' 
        ];

        $this->validate($request, $rules);

        $fields = $request->all();
        $fields['password'] = bcrypt($request->password);
        $fields['verified'] = User::NOT_VERIFIED_USER;
        $fields['verification_token'] = User::generateVerificactionToken();
        $fields['admin'] = User::NOT_ADMIN_USER;

        $user = User::create($fields);

        return $this->showOne($user,201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $user = User::findOrFail($id);

        return $this->showOne($user);

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
        //dd($request);
        $user = User::findOrFail($id);

        $rules =[
          'email' => 'email|unique:users,email,'.$user->id,
          'password' => 'min:6|confirmed',
          'admin' => 'in:'.User::NOT_ADMIN_USER.','.User::ADMIN_USER,
        ];

        $this->validate($request, $rules);

        if ($request->name) {
            $user->name = $request->name;
        }

        if($request->email && $user->email != $request->email){

            $user->verified = User::NOT_VERIFIED_USER;
            $user->verification_token = User::generateVerificactionToken();
            $user->email = $request->email;
        }

        if ($request->password) {
            $user->password = bcrypt($request->password);
        }

        if ($request->admin){
            
            if (!$user->isVerified()) {
                return $this->errorResponse('No se encuentra verificado el usuario', 409);
            }
        }

        if (!$user->isDirty()) {
            return $this->errorResponse('Se debe especificar al menos un dato a actualizar', 402);
        }

        $user->save();

        return $this->showOne($user, 201);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $user = User::findOrFail($id);

        $user->delete();

        return response()->json(['data' => $user], 201);
    }
}

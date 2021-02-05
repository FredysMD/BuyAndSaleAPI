<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\APIController;
use Illuminate\Http\Request;

use App\Models\User;
use App\Mail\UserCreated;
use Illuminate\Support\Facades\Mail;

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
    public function show(User $user)
    {

        return $this->showOne($user);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {


        $rules =[
          'email' => 'email|unique:users,email,'.$user->id,
          'password' => 'min:6|confirmed',
          'admin' => 'in:'.User::NOT_ADMIN_USER.','.User::ADMIN_USER,
        ];

        $this->validate($request, $rules);

        if ($request->name) {
            $user->name = $request->name;
        }

        if(strtolower($request->email) && $user->email != strtolower($request->email)){

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
    public function destroy(User $user)
    {
        $user->delete();

        return response()->json(['data' => $user], 201);
    }

    public function verify($token)
    {
        $user = User::where('verification_token', $token)->firstOrFail();

        $user->verified = User::VERIFIED_USER;

        $user->verification_token = null;

        $user->save();

        return $this->showMessage('La cuenta ha sido verificada');

    }

    public function resend(User $user)
    {
        if($user->isVerified())
            $this->errorResponse('El usuario ya es verificado.', 409);
        
        retry(5, function() use($user) {
            Mail::to($user)->send( new UserCreated($user));
        }, 100);

        return $this->showMessage('Ha sido reenviado el correo de verificación a su correo electrónico.');
    }
}

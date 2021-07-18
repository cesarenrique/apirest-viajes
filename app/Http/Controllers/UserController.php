<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\User;




class UserController extends ApiController
{
    public function __construct(){

      $this->middleware('auth:api')->only('index','store','destroy');
    }
    /**
    * @SWG\Get(
    *   path="/users",
    *   security={
    *     {"passport": {}},
    *   },
    *   summary="Get Users",
    *   @SWG\Response(response=200, description="successful operation",
    *     @SWG\Schema(
    *         type="array",
    *         @SWG\Items(ref="#definitions/User")
    *     )
    *   ),
    *   @SWG\Response(response=500, description="internal server error",
    *      @SWG\Schema(ref="#definitions/Errors")
    *   ),
    *)
    *
    */
    public function index()
    {
        $usuarios=User::all();

        return $this->showAll($usuarios);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     /**
     * @SWG\Post(
     *   path="/users",
     *   security={
     *     {"passport": {}},
     *   },
     *   summary="Create Users for store",
     *		  @SWG\Parameter(
     *          name="data",
     *          in="body",
     *          required=true,
     *          @SWG\Schema(
     *            @SWG\Property(property="name", type="string", example="nombre apellido"),
     *            @SWG\Property(property="email", type="string", example="nombre@gmail.com"),
     *            @SWG\Property(property="password", type="string", example="secret1234E"),
     *            @SWG\Property(property="password_confirmation", type="string", example="secret1234E"),
     *          ),
     *      ),
     *   @SWG\Response(
     *      response=201,
     *      description="Create successful operation",
     *      @SWG\Schema(ref="#definitions/User")
     *   ),
     *   @SWG\Response(
     *      response=500,
     *      description="internal server error",
     *      @SWG\Schema(ref="#definitions/Errors")
     *   )
     *)
     *
     **/
    public function store(Request $request)
    {
        //
        $rules=[
          'name'=>'required',
          'email'=> 'required|email|unique:users',
          'password' => 'required|min:6|confirmed'
        ];
        $this->validate($request,$rules);
        $campos=$request->all();
        $campos['password']= bcrypt($request->password);
        $campos['verified'] = User::USUARIO_NO_VERIFICADO;
        //$campos['verify_Token']= User::generateVerificationToken();
        $campos['tipo_usuario']= User::USUARIO_CLIENTE;

        $usuario= User::create($campos);
        //$campos['verify_Token'] = User::generateVerificationToken();
        //$usuario->verify_Token=$campos['verify_Token'];
        $user->verified = User::USUARIO_VERIFICADO;
        $user->verify_Token=null;
        $usuario->save();

        return $this->showOne($usuario,201);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     /**
     * @SWG\Get(
     *   path="/users/{user_id}",
     *   security={
     *     {"passport": {}},
     *   },
     *   summary="Ver un usuario",
     *		  @SWG\Parameter(
     *          name="user_id",
     *          in="path",
     *          required=true,
     *          type="string",
     *          description="un numero id"
     *      ),
     *   @SWG\Response(
     *      response=200,
     *      description="Show one User successful operation",
     *      @SWG\Schema(ref="#definitions/User")
     *   ),
     *   @SWG\Response(response=404, description="Not Found Exception",
     *      @SWG\Schema(ref="#definitions/Errors")
     *   ),
     *   @SWG\Response(
     *      response=500,
     *      description="internal server error",
     *      @SWG\Schema(ref="#definitions/Errors")
     *   )
     *)
     *
     **/
    public function show($id)
    {
        $usuario=User::findOrFail($id);

        return $this->showOne($usuario);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     /**
     * @SWG\Put(
     *   path="/users/{user_id}",
     *   security={
     *     {"passport": {}},
     *   },
     *   summary="update User",
     *		  @SWG\Parameter(
     *          name="user_id",
     *          in="path",
     *          required=true,
     *          type="string",
     *          description="un numero id"
     *      ),
     *		  @SWG\Parameter(
     *          name="data",
     *          in="body",
     *          required=false,
     *          @SWG\Schema(
     *            @SWG\Property(property="name", type="string", example="nombre apellido"),
     *            @SWG\Property(property="email", type="string", example="nombre@gmail.com"),
     *            @SWG\Property(property="password", type="string", example="secret1234E"),
     *            @SWG\Property(property="password_confirmation", type="string", example="secret1234E"),
     *          ),
     *      ),
     *   @SWG\Response(
     *      response=200,
     *      description="Update User successful operation",
     *      @SWG\Schema(ref="#definitions/User")
     *   ),
     *   @SWG\Response(response=404, description="Not Found Exception",
     *      @SWG\Schema(ref="#definitions/Errors")
     *   ),
     *   @SWG\Response(
     *      response=500,
     *      description="internal server error",
     *      @SWG\Schema(ref="#definitions/Errors")
     *   )
     *)
     *
     **/
    public function update(Request $request, $id)
    {
        //
        $user= User::findOrFail($id);
        $rules=[
          'email'=> 'email|unique:users,email,'.$user->id,
          'password' => 'min:6|confirmed',
          'tipo_usuario' => 'in:'.User::USUARIO_ADMINISTRADOR.','.User::USUARIO_EDITOR.','.User::USUARIO_CLIENTE,
        ];
        $this->validate($request,$rules);
        if($request->has('name')){
            $user->name=$request->name;
        }
        if($request->has('email') && $user->email!=$request->email){
            //$user->verified=User::USUARIO_NO_VERIFICADO;
            //$user->verify_Token=User::generateVerificationToken();
            $user->email=$request->email;
            $user->verified = User::USUARIO_VERIFICADO;
            $user->verify_Token=null;
        }
        if($request->has('password')){
            $user->password=bcrypt($request->name);
        }
        if($request->has('tipo_usuario')){
            if(!$user->esVerificado()){
              return $this->errorResponse('Unicamente los usuarios verificados pueden cambiar su valor administrador',409);
            }
            $user->tipo_usuario=$request->tipo_usuario;
        }
        if(!$user->isDirty()){
           return $this->errorResponse('Se debe especificar al menos un valor diferente para actualizar',409);
        }

        $user->save();

        return $this->showOne($user);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

     /**
     * @SWG\Delete(
     *   path="/users/{user_id}",
     *   security={
     *     {"passport": {}},
     *   },
     *   summary="update User",
     *		  @SWG\Parameter(
     *          name="user_id",
     *          in="path",
     *          required=true,
     *          type="string",
     *          description="un numero id"
     *      ),
     *   @SWG\Response(
     *      response=200,
     *      description="Delete User successful operation",
     *      @SWG\Schema(ref="#definitions/User")
     *   ),
     *   @SWG\Response(
     *      response=500,
     *      description="internal server error",
     *      @SWG\Schema(ref="#definitions/Errors")
     *   )
     *)
     *
     **/
    public function destroy($id)
    {
        $user= User::findOrFail($id);
        $user->delete();
        return $this->showOne($user);
    }

    public function verify($token){
       $user= User::where('verify_Token',$token)->firstOrFail();

       $user->verified = User::USUARIO_VERIFICADO;
       $user->verify_Token=null;

       $user->save();

       return $this->showMessage("la cuenta ha sido verificada");
    }
}

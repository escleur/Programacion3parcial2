<?php

namespace App\Controllers;
use App\Middlewares\Auth;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\Usuario;

class UsuarioController{
    /*public function getAll(Request $request, Response $response, $args){
        $rta = Usuario::get();
        $response->getBody()->write(json_encode($rta));
        return $response;
    }
    public function getOne(Request $request, Response $response, $args){
        $rta = Usuario::find($args['id']);
        $response->getBody()->write(json_encode($rta));
        return $response;
    }*/

    public function addOne(Request $request, Response $response, $args){
        $user = new Usuario;

        $user->email = strtolower ( $request->getParsedBody()['email'] ?? '');
        $user->nombre = strtolower ( $request->getParsedBody()['nombre'] ?? '');
        $user->clave =  $request->getParsedBody()['clave'] ?? '';;
        $user->tipo =  $request->getParsedBody()['tipo'] ?? '';
        ///echo $user->nombre;
        if( !strpos($user->nombre, ' ')){
        
            $rtaMail = Usuario::where('email', $user->email)
            ->first();
            $rtaNombre = Usuario::where('nombre', $user->nombre)
            ->first();
            echo $rtaNombre;
            if(empty($rtaMail) && empty($rtaNombre)){
                if(strlen($user->clave)>=4){
                    if($user->email != '' && $user->nombre != ''){
                        if($user->tipo == 'alumno' || $user->tipo == 'profesor' || $user->tipo == 'admin'){
                            $rta = $user->save();

                            
                            $response->getBody()->write(json_encode($rta));

                        }else{
                            $response->getBody()->write(json_encode('Tipo incorrecto'));

                        }
                    
                    }else{
                        $response->getBody()->write(json_encode('debe mandar todos los datos'));

                    }
                }else{
                    $response->getBody()->write(json_encode('Clave muy corta'));

                }

            }else{
                $response->getBody()->write(json_encode('Nombre o mail ya existen'));
            }

        }else{
            $response->getBody()->write(json_encode('Nombre no debe tener espacios'));

        }


        //echo $pos;
        //$rta = Usuario::find();

        
        //$rta = $user->save();
        return $response;

    }

    //paso por x-www-form-urlencoded
    /*public function updateOne(Request $request, Response $response, $args){
        $user = Usuario::find($args['id']);
        $user->email = $request->getParsedBody()['email'] ?? $user->email;
        $user->tipo =  $request->getParsedBody()['tipo'] ?? $user->tipo;
        $user->password =  $request->getParsedBody()['password'] ?? $user->password;;

        $rta = $user->save();

        $response->getBody()->write(json_encode($rta));
        return $response;
    }
    public function deleteOne(Request $request, Response $response, $args){
        $user = Usuario::find($args['id']);
        $rta = false;
        if($user)
            $rta = $user->delete();

        $response->getBody()->write(json_encode($rta));
        return $response;
    }*/

    public function login(Request $request, Response $response, $args){
        $nombre = strtolower($request->getParsedBody()['nombre'] ?? '');
        $email = strtolower($request->getParsedBody()['email'] ?? '');
        $password =  $request->getParsedBody()['clave'] ?? '';
        if($nombre == ''){
            $rta = Usuario::where('email',$email)->first();

        }else{
            $rta = Usuario::where('nombre',$nombre)->first();

        }
        

        if(!empty($rta) && strcmp($password, $rta['clave']) == 0){
            $token = Auth::SignIn(['tipo'=>$rta['tipo'],'nombre'=>$rta['nombre']]);
            $response->getBody()->write($token);
        }else{
            $response->getBody()->write("Error al loguear.");
        }
        return $response;
    }


}








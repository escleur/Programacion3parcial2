<?php

namespace App\Controllers;
use App\Middlewares\Auth;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use App\Models\Materia;

class MateriaController{
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
        $mat = new Materia;

        $mat->materia = $request->getParsedBody()['materia'] ?? '';
        $mat->cuatrimestre =  $request->getParsedBody()['cuatrimestre'] ?? '';
        $mat->cupos =  $request->getParsedBody()['cupos'] ?? '';;
        if($mat->cuatrimestre == 1 || $mat->cuatrimestre == 2 || $mat->cuatrimestre == 3 || $mat->cuatrimestre == 4){
            $rta = $mat->save();

        }else{
            $rta = "cuatrimestre invalido";
        }

        
        $response->getBody()->write(json_encode($rta));
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



}








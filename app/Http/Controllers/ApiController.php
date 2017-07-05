<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use League\Fractal\Manager;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\MessageBag;
use Illuminate\Contracts\Support\MessageProvider;

class ApiController extends Controller
{

    protected $statusCode = 200;

    public function __construct(Manager $fractal){
        $this->fractal = $fractal;
        $this->fractal->parseIncludes(explode(',', Input::get('include')));
        $this->setMiddlewareMethods();
    }

    protected function setMiddlewareMethods(){}

    public function getStatusCode(){
        return $this->statusCode;
    }

    public function setStatusCode($statusCode){
        $this->statusCode = $statusCode;
        return $this;
    }

    public function respondWithItem($item, $callback){
        $resource = new Item($item, $callback);
        $rootScope = $this->fractal->createData($resource);
        return $this->respondWithArray($rootScope->toArray());
    }

    public function respondWithCollection($collection, $callback){
        $resource = new Collection($collection, $callback);
        $rootScope = $this->fractal->createData($resource);
        return $this->respondWithArray($rootScope->toArray());
    }

    protected function respondWithArray(array $array, array $header = []){
        return Response::json($array, $this->statusCode, $header);
    }

    protected function respondWithError($message, $data = []){
        if($this->statusCode === 200) trigger_error("Something went wrong!", E_USER_WARNING);

        return $this->respondWithArray([
            'error' => [
                'http_code' => $this->statusCode,
                'message' => $message,
                'data' => $data
            ]
        ]);
    }

    public function errorForbidden($message = 'Forbidden', $data = []){
        return $this->setStatusCode(403)
            ->respondWithError($message, $data);
    }

    public function errorInternalError($message = 'Internal Error', $data = []){
        return $this->setStatusCode(500)
            ->respondWithError($message, $data);
    }

    public function errorNotFound($message = 'Resource Not Found', $data = []){
        return $this->setStatusCode(404)
            ->respondWithError($message, $data);
    }

    public function errorUnauthorized($message = 'Unauthorized', $data = []){
        return $this->setStatusCode(401)
            ->respondWithError($message, $data);
    }

    public function errorWrongArgs($message = 'Wrong Arguments', $data = []){
        return $this->setStatusCode(400)
            ->respondWithError($message, $data);
    }

    protected function parseErrors($provider)
    {
        if ($provider instanceof MessageProvider) {
            return $provider->getMessageBag();
        }

        return new MessageBag((array) $provider);
    }
}

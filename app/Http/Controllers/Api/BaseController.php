<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CompanyStoreRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BaseController extends Controller
{
    public function __construct(protected $model = null, protected $resource = null)
    {
        
    }

    protected function sendResponse($msg, $results = [])
    {
        return response()->json([
            'status'    =>      true,
            'message'   =>      $msg,
            'data'      =>      $results
        ], 200);
    }

    protected function sendError($msg, $errors = [], $ststus_code = 404)
    {
        return response()->json([
            'status'    =>      false,
            'message'   =>      $msg,
            'errors'   =>      $errors
        ], $ststus_code);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return $this->sendResponse('successfully retrived', $this->resource::collection($this->model::all()));
    }

    public function show(int $id)
    {
        return $this->sendResponse('successfully retrived', new $this->resource($this->model::find($id)) );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id)
    {
        $currentInstance = $this->model::find($id);

        if (is_null($currentInstance)) {
            return $this->sendError('validation error', ['id'   =>  'un exists'], Response::HTTP_BAD_REQUEST);
        }

        $currentInstance->delete();

        return $this->sendResponse('successfully deleted');
    }

}

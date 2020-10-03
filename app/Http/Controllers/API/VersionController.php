<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\ResponseResource;
use App\Models\Version;
use Illuminate\Http\Request;

class VersionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $version = Version::all()->last();
        return (new ResponseResource($this))->response($version->makeHidden('id', 'created_at', 'updated_at'));
    }

}

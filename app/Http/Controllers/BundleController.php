<?php

namespace App\Http\Controllers;

use App\Models\Bundle;
use Illuminate\Http\Request;
use App\Http\Requests\BundleRequest;

class BundleController extends Controller
{

    public function index()
    {
        return Bundle::all();
    }


    public function create()
    {
        //
    }


    public function store(BundleRequest $request)

    {
        $bundle = Bundle::create($request->all());
        return response()->json(['message' => 'bundle ' . $bundle->name . ' added successfully !'],200);
    }


    public function show(Bundle $bundle)
    {
        //
    }


    public function update(Request $request, Bundle $bundle)
    {

    }


    public function destroy($bundle_name)
    {
             $name =Bundle::where('name',$bundle_name)->first();

        if ($name != null) {
            $name->delete();

        return response()->json(['message'=>"The Bundle $bundle_name is Deleted"]);
        }

        return response()->json(['message'=>'wrong name !!']);

    }
}

<?php

namespace App\Http\Controllers\Category;

use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\ApiController;


class ControllerCategories extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::all();
        //return response()->json(['data' => $categories,200]);
      return $this->showAll($categories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('Category/add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $reglas =[
            'name' =>'required',
            'description' => 'required'
        ];

        $this->validate($request, $reglas);

        //return $this->showOne($categories, 201);
        //return $this->showOne($categories);


        $categories = new Categories($request->all());
        $categories->save();

        return 'Exitoso';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $categories = Category::findOrfail($id);
        //return response()->json(['categories' => $categories],200);
        return $this->showOne($categories);
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
    public function update(Request $request, $id)
    {
        $categories = Category::findOrfail($id);
    /*    $reglas = [
            'name' => 'unique:categories',
            'description' => 'unique:categories',
        ];

        $this->validate($request ,$reglas);
        */
        if($request->has('name')){
            $categories->name = $request->name;
        }

        if($request->has('description') && $categories->description != $request->description){
            $categories->description = $request->description;
        }
        if(!$categories->isDirty()){

            //return response()->json(['error'=>'Se debe especificar al menos un valor diferente para actualizar','code'=>422],422);
            return $this->errorResponse('Se debe especificar al menos un valor diferente para actualizar',422);
          }
        $categories->save();
        //return response()->json(['data'=>$categories],200);
        return $this->showOne($categories);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $categories = Category::findOrfail($id);
        $categories->delete();
        //return response()->json(['data' => $categories],200);
        return $this->showOne($categories);
    }
}

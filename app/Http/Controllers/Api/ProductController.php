<?php

namespace App\Http\Controllers\Api;

use Image;
use App\Model\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::query()
            ->with(array(
                'category' => function($query) {
                    $query->select('id','category_name');
                }
            ))->get();
        return response()->json($products);
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
     */
    public function store(Request $request)
    {
        $validation = $request->validate([
            'product_name' => 'required',
            'category_id' => 'required',
            'supplier_id' => 'required',
            'product_code' => 'required|unique:products|max:100',
            'buying_price' => 'required',
            'selling_price' => 'required',
            'buying_date' => 'required',
            'product_quantity' => 'required'
        ]);

        if ($request->image) {
            $position = strpos($request->image, ';');
            $sub = substr($request->image, 0, $position);
            $ext = explode('/', $sub)[1];
            $name = time().'.'.$ext;
            $img = Image::make($request->image)->resize(240, 200);
            $upload_part = 'public/backend/product/';
            $image_url = $upload_part.$name;
            $img->save($image_url);

            $products = Product::create([
                'product_name' => $request->product_name,
                'category_id' => $request->category_id,
                'supplier_id' => $request->supplier_id,
                'product_code' => $request->product_code,
                'buying_price' => $request->buying_price,
                'root' => $request->root,
                'selling_price' => $request->selling_price,
                'buying_date' => $request->buying_date,
                'product_quantity' => $request->product_quantity,
                'image' => $image_url
            ]);
        }else{                    
            $products = Product::create([
                'product_name' => $request->product_name,
                'category_id' => $request->category_id,
                'supplier_id' => $request->supplier_id,
                'product_code' => $request->product_code,
                'buying_price' => $request->buying_price,
                'root' => $request->root,
                'selling_price' => $request->selling_price,
                'buying_date' => $request->buying_date,
                'product_quantity' => $request->product_quantity
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::find($id);
        return response()->json($product);
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
        $data = array();
        $data['product_name'] = $request->product_name;
        $data['category_id'] = $request->category_id;
        $data['supplier_id'] = $request->supplier_id;
        $data['product_code'] = $request->product_code;
        $data['buying_price'] = $request->buying_price;
        $data['root'] = $request->root;
        $data['selling_price'] = $request->selling_price;
        $data['buying_date'] = $request->buying_date;
        $data['product_quantity'] = $request->product_quantity;
        $image = $request->newimage;
        if ($image) {
            $position = strpos($image, ';');
            $sub = substr($image, 0, $position);
            $ext = explode('/', $sub)[1];
            $name = time().'.'.$ext;
            $img = Image::make($image)->resize(240, 200);
            $upload_part = 'public/backend/product/';
            $image_url = $upload_part.$name;
            $success = $img->save($image_url);
            if ($success) {
                $data['image'] = $image_url;
                $img = DB::table('products')->where('id', $id)->first();
                $image_path = $img->image;
                $done = unlink($image_path);
                $user = DB::table('products')->where('id', $id)->update($data);
            }
        }else{  
            $oldimage = $request->image;
            $data['image'] = $oldimage;
            $user = DB::table('products')->where('id', $id)->update($data);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $photo = $product->image;
        if($photo){
            unlink($photo);
            Product::find($id)->delete();
        }else{
            Product::find($id)->delete();
        }
    }
}
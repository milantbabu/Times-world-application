<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\JsonResponse;
use App\Http\Trait\CommonTrait;
use App\Models\Variant;
use DataTables;
use Validator;
use Storage;

class ProductController extends Controller
{
    use CommonTrait;

    protected function index(Request $request)
    {
        if ($request->ajax()) {
            $products = $this->getProducts();
            return DataTables::of($products)
            ->addIndexColumn()
            ->addColumn('actions', function($row) {
                $button = "";

                $button .= '<a href=" '.route('showProduct', base64_encode($row->id)).' " target="_blank" class="' . \config('buttons.view-class') . '" title="Show">' . \config('buttons.view-icon') . '</a>&nbsp;';

                $button .= '<a href=" '.route('editProduct', base64_encode($row->id)).' " class="' . \config('buttons.edit-class') . '" title="Edit">' . \config('buttons.edit-icon') . '</a>&nbsp;';
            
               $button .= '<a href="javascript:void(0)" data-id="' . $row->id . '" class="' . \config('buttons.delete-class') . '" title="Delete">' . \config('buttons.delete-icon') . '</a>';
                
                return $button;

            })
            ->rawColumns(['actions'])
            ->toJson();
        }
        return view('product.index');
    }

    protected function create(): View
    {
        $counter = 1;
        return view('product.create', compact('counter'));
    }

    protected function edit($id = 0): View
    {
        $product = $this->getProducts()->findOrFail(base64_decode($id));
        $counter = 1;
        return view('product.edit', compact('product', 'counter'));
    }

    protected function store(Request $request): JsonResponse
    {
        try {
            $id = $request->id;
            $validatedData = Validator::make($request->all(), [
                'title' => 'bail|required|max:150|unique:products,title,'.$id.',id,deleted_at,NULL',
                'description' => 'bail|required|max:500',
                'image' => 'bail|image|mimes:jpeg,jpg,png|max:2048',
            ], [
                'title.required' => 'Title is mandatory.',
                'title.unique' => 'Title is already exist.',
                'description.required' => 'Description is mandatory'
            ]);
            if ($validatedData->fails()) {
                $jsonArray = [
                    'status' => 'validationError',
                    'messages' => $validatedData->messages()
                ];
            } else {
                //$formData = $request->all();
                $formData['title'] = $request->title;
                $formData['description'] = $request->description;
                if ($request->has('image')) {
                    $formData['image'] = $this->uploadLogo($request, 'image','product_images');
                }
                // dd($request->all());
                $product = $this->getProducts()->updateOrCreate(['id' => $id], $formData);
                
                $size = $request->input('size_title');
                $color = $request->input('color_title');
                if ($id > 0) { //edit case
                    Variant::whereIn('product_id', [$id])->delete();
                }
                for ($i = 0; $i < count($size); $i++) {
                    $variant = new Variant();
                    $variant->size = $size[$i];
                    $variant->color = $color[$i];
                    $variant->product_id = $product->id;
                    if ($size[$i] != "" || $color[$i] != "") {
                      $variant->save();
                    }
                }
                if ((!$product->wasRecentlyCreated && $product->wasChanged()) || (!$product->wasRecentlyCreated && !$product->wasChanged())) {
                    $message = "Product Updated Successfully!";
                } 
                if ($product->wasRecentlyCreated) {
                    $message = "Product Created Successfully!";
                }
                $jsonArray = [
                    'status' => 'success', 
                    'message' => $message,
                    'next' => route('products')
                ];
            }
        } catch (\Exception $e) {
            $jsonArray = [
                'status' => "error",
                'message' => $e->getMessage(),
            ];
        }
        return response()->json($jsonArray);
    }

    private function uploadLogo($request, $field, $folder)
    {
        if ($request->has($field)) {
            $request->file($field)->storePublicly($folder);
            return $request->file($field)->hashName();
        }
    }

    protected function show($id = 0): View
    {
        $product = $this->getProducts()->findOrFail(base64_decode($id));
        if ($product->image != null) {
            $product->image = Storage::url('product_images/' . $product->image);
        } else {
            $product->image = asset('assets/img/No-Image.jpg');
        }
        return view('product.show', compact('product'));
    }

    protected function delete(Request $request): JsonResponse
    {
        try {
            $validatedData = Validator::make($request->all(), [
                'id' => 'bail|required|exists:products,id'
            ]);
            if ($validatedData->fails()) {
                $jsonArray = [
                    'status' => 'validationError', 
                    'message' => 'Invalid Product.'
                ];
            } else {
                $product = $this->getProducts()->find($request->id);
                $product->variants()->delete();
                $product->delete();
                $jsonArray = [
                    'status' => 'success',
                    'message' => 'Product Deleted Successfully.' 
                ];
            }
        } catch (\Exception $e) {
            $jsonArray = [
                'status' => "error",
                'message' => $e->getMessage(),
            ];
        }
        return response()->json($jsonArray);
    }

}

<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentRequest;
use App\Models\Document;
use App\Models\DocumentProduct;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DocumentController extends Controller
{
    public function add(DocumentRequest $request)
    {
        DB::beginTransaction();
        try {
            $document = new Document();
            $document->title = $request->title;
            $document->address = $request->address;
            $document->user_id = Auth::id();
            $document->senior_id = Auth::user()->sinior_id;
            $document->save();
            $document_id = $document->id;
            $products = $request->products;
            foreach ($products as $product) {
                $this->addProduct($document_id, $product);
            }
            DB::commit();
            return response()->json(['success' => 'ok']);
        } catch (QueryException $e) {
            DB::rollBack();
            return response()->json([
                'error' => [
                    "message" => $e->getMessage()
                ]
            ], 503);
        }
    }

    public function addProduct(int $document_id, array $data)
    {
        $product = new DocumentProduct();
        $product->document_id = $document_id;
        $product->title = $data['title'];
        $product->measure = $data['measure'];
        $product->price = $data['price'];
        $product->count = $data['count'];
        $product->save();
    }
}

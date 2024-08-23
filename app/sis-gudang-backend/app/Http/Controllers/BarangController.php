<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use App\Http\Resources\BarangResource;
use App\Models\Barang;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BarangController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $barangs = Barang::all();

        return $this->sendResponse(BarangResource::collection($barangs), 'Items retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'nama_barang'   => 'required|string|max:255',
            'kode'          => 'required|string|max:255|unique:barangs',
            'kategori'      => 'required|string|max:255',
            'lokasi'        => 'required|string|max:255',
            'gambar'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        if ($request->hasFile('gambar')) {
            $file = $request->file('gambar');
            $path = $file->store('images', 'public');
            $input['gambar'] = $path;
        }

        $barang = Barang::create($input);

        return $this->sendResponse(new BarangResource($barang), 'Item created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id): JsonResponse
    {
        $barang = Barang::find($id);

        if (is_null($barang)) {
            return $this->sendError('Item not found.');
        }

        return $this->sendResponse(new BarangResource($barang), 'Item retrieved successfully.');
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Barang $barang): JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'nama_barang'   => 'required|string|max:255',
            'kode'          => 'required|string|max:255',
            'kategori'      => 'required|string|max:255',
            'lokasi'        => 'required|string|max:255',
            'gambar'        => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        if ($request->hasFile('gambar')) {

            if ($barang->gambar) {
                Storage::disk('public')->delete($barang->gambar);
            }
    
            $file = $request->file('gambar');
            $path = $file->store('images', 'public');
            $input['gambar'] = $path;
        }

        $barang->nama_barang = $input['nama_barang'];
        $barang->kode = $input['kode'];
        $barang->kategori = $input['kategori'];
        $barang->lokasi = $input['lokasi'];
        if($input['gambar']){
            $barang->gambar = $input['gambar'];
        }
        $barang->save();

        return $this->sendResponse(new BarangResource($barang), 'Item updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Barang $barang): JsonResponse
    {
        $barang->delete();

        if ($barang->gambar) {
            Storage::disk('public')->delete($barang->gambar);
        }    

        return $this->sendResponse([], 'Item deleted successfully.');
    }
}

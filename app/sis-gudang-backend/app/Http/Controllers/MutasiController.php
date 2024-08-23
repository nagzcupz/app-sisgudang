<?php

namespace App\Http\Controllers;

use App\Http\Resources\MutasiResource;
use App\Models\Barang;
use App\Models\Mutasi;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MutasiController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $mutasis = Mutasi::with(['user', 'barang'])->get();

        return $this->sendResponse(MutasiResource::collection($mutasis), 'Mutations retrieved successfully.');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): JsonResponse
    {
        $input = $request->all();

        $validator =  Validator::make($input, [
            'tanggal'      => 'required|date',
            'jenis_mutasi' => 'required|in:masuk,keluar',
            'jumlah'       => 'required|integer',
            'user_id'      => 'required|exists:users,id',
            'barang_id'    => 'required|exists:barangs,id',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $mutasi = Mutasi::create($input);

        return $this->sendResponse(new MutasiResource($mutasi), 'Mutation created successfully.');
    }

    /**
     * Display the specified resource of all mutation order by ID Mutation.
     */
    public function show($id): JsonResponse
    {
        $mutasi = Mutasi::with(['user', 'barang'])->findOrFail($id);

        if (is_null($mutasi)) {
            return $this->sendError('Item not found.');
        }

        return $this->sendResponse(new MutasiResource($mutasi), 'Mutation retrieved successfully.');
    }

    /**
     * Display the specified resource of all mutation order by user.
     */
    public function showMutationByUser($user_id): JsonResponse
    {
        $user = User::findOrFail($user_id);
        
        $mutasi = Mutasi::with(['user', 'barang'])->where('user_id', $user_id)->get();

        if ($mutasi->isEmpty()) {
            return $this->sendError('Item not found.');
        }

        return $this->sendResponse(MutasiResource::collection($mutasi), 'Mutation by user retrieved successfully.');
    }

    /**
     * Display the specified resource of all mutation order by item.
     */
    public function showMutationByItem($item_id): JsonResponse
    {
        $barang = Barang::findOrFail($item_id);

        $mutasi = Mutasi::with(['user', 'barang'])->where('barang_id', $item_id)->get();

        if ($mutasi->isEmpty()) {
            return $this->sendError('Item not found.');
        }

        return $this->sendResponse(MutasiResource::collection($mutasi), 'Mutation by item retrieved successfully.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Mutasi $mutasi): JsonResponse
    {
        $input = $request->all();

        $validator = Validator::make($input, [
            'tanggal'      => 'required|date',
            'jenis_mutasi' => 'required|in:masuk,keluar',
            'jumlah'       => 'required|integer',
            'user_id'      => 'required|exists:users,id',
            'barang_id'    => 'required|exists:barangs,id',
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $mutasi->tanggal = $input['tanggal'];
        $mutasi->jenis_mutasi = $input['jenis_mutasi'];
        $mutasi->jumlah = $input['jumlah'];
        $mutasi->user_id = $input['user_id'];
        $mutasi->barang_id = $input['barang_id'];
        $mutasi->save();

        return $this->sendResponse(new MutasiResource($mutasi), 'Mutation updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Mutasi $mutasi): JsonResponse
    {
        $mutasi->delete();   

        return $this->sendResponse([], 'Mutation deleted successfully.');
    }
}

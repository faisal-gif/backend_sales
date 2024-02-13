<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\PaketResource;
use App\Models\Paket;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaketController extends Controller
{
    private function validateRequest(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'keterangan' => 'required',
            'harga' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

    }


    public function index()
    {

        //get posts
        $paket = Paket::all();
        //return collection of pakets as a resource
        return new PaketResource(true, 'List Data Paket', $paket);
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {

        $this->validateRequest($request);

        //create paket
        $paket = Paket::create([
            'nama' => $request->nama,
            'keterangan' => $request->keterangan,
            'harga' => $request->harga,
        ]);

        //return response
        return new PaketResource(true, 'Data Paket Berhasil Ditambahkan!', $paket);
    }

    /**
     * show
     *
     * @param  mixed $paket
     * @return void
     */
    public function show(Paket $paket)
    {
        //return single paket as a resource
        return new PaketResource(true, 'Data Paket Ditemukan!', $paket);
    }

    /* update
     *
     * @param  mixed $request
     * @param  mixed $post
     * @return void
     */
    public function update(Request $request, Paket $paket)
    {
        //validate paket
        $this->validateRequest($request);

        //update paket
        $paket->update([
            'nama' => $request->nama,
            'keterangan' => $request->keterangan,
            'harga' => $request->harga,
        ]);

        //return response
        return new PaketResource(true, 'Data Paket Berhasil Diubah!', $paket);
    }

    /**
     * destroy
     *
     * @param  mixed $post
     * @return void
     */
    public function destroy(Paket $paket)
    {
        
        //delete paket
        $paket->delete();

        //return response
        return new PaketResource(true, 'Data Paket Berhasil Dihapus!', null);
    }

}

<?php

namespace App\Http\Controllers\Api;

use App\Models\Customer;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\CustomerResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CustomerController extends Controller
{
    private function validateRequest(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'foto_ktp' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'foto_rumah' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'nama' => 'required',
            'nomor_telepon' => 'required',
            'alamat' => 'required',
            'paket' => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

    }
    private function uploadKtp($ktp)
    {
        $ktp->storeAs('public/ktp', $ktp->hashName());
    }
    private function uploadRumah($rumah)
    {
        $rumah->storeAs('public/rumah', $rumah->hashName());
    }
    public function index()
    {
        //get posts
        $customer = Customer::all();
        //return collection of posts as a resource
        return new CustomerResource(true, 'List Data Customer', $customer);
    }


    /**
     * show
     *
     * @param  mixed $customer
     * @return void
     */
    public function show(Customer $customer)
    {
        //return single paket as a resource
        return new CustomerResource(true, 'Data Customer Ditemukan!', $customer);
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

        //upload image ktp
        $ktp = $request->file('foto_ktp');
        $this->uploadKtp($ktp);

        //upload image rumah
        $rumah = $request->file('foto_rumah');
        $this->uploadRumah($rumah);


        //create Customer
        $post = Customer::create([
            'foto_ktp' => $ktp->hashName(),
            'foto_rumah' => $rumah->hashName(),
            'nama' => $request->nama,
            'user_id' => $request->user_id,
            'nomor_telepon' => $request->nomor_telepon,
            'alamat' => $request->alamat,
            'paket_id' => $request->paket,
        ]);

        //return response
        return new CustomerResource(true, 'Data Customer Berhasil Ditambahkan!', $post);
    }

    /* update
     *
     * @param  mixed $request
     * @param  mixed $post
     * @return void
     */
    public function update(Request $request, Customer $customer)
    {
        //validate customer
        $this->validateRequest($request);

        if ($request->hasFile('foto_ktp')) {
            $ktp = $request->file('foto_ktp');
            $this->uploadKtp($ktp);

            Storage::delete('public/ktp/' . $customer->foto_ktp);

            $customer->foto_ktp = $ktp->hashName();
        } elseif ($request->hasFile('foto_rumah')) {
            $rumah = $request->file('foto_rumah');
            $this->uploadRumah($rumah);

            Storage::delete('public/rumah/' . $customer->foto_rumah);

            $customer->foto_rumah = $rumah->hashName();
        }

        //update customer
        $customer->nama = $request->nama;
        $customer->nomor_telepon = $request->nomor_telepon;
        $customer->alamat = $request->alamat;
        $customer->paket_id = $request->paket;
        $customer->save();


        //return response
        return new CustomerResource(true, 'Data Paket Berhasil Diubah!', $customer);
    }

    /**
     * destroy
     *
     * @param  mixed $post
     * @return void
     */
    public function destroy(Customer $customer)
    {
        //delete image kto
        Storage::delete('public/ktp/' . $customer->foto_ktp);

        //delete image rumah
        Storage::delete('public/rumah/' . $customer->foto_rumah);

        //delete paket
        $customer->delete();

        //return response
        return new CustomerResource(true, 'Data Customer Berhasil Dihapus!', null);
    }

    public function rekapCustomer()
    {
        //get Rekap Customer
        $customer = Customer::join('users', 'users.id', '=', 'customer.user_id')->join('paket', 'paket.id', '=', 'customer.paket_id')->select('users.name as sales', 'customer.*', 'paket.nama as nama_paket', 'paket.harga as harga_paket')->get();
        
        return new CustomerResource(true, 'List Data Rekap Customer', $customer);
    }


}

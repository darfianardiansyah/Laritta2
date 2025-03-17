<?php
namespace App\Http\Controllers;

use App\Models\Pegawai;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PegawaiController extends Controller
{
    public function index()
    {
        return view('pegawai.index');
    }

    public function list()
    {
        $pegawai = Pegawai::all();
        return response()->json([
            'data' => $pegawai,
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama'         => 'required|string|max:255',
            'alamat'       => 'required|string',
            'provinsi_id'  => 'required|integer',
            'kabkota_id'   => 'required|integer',
            'kecamatan_id' => 'required|integer',
            'kodepos_id'   => 'required|integer',
        ]);
        $pegawai = Pegawai::create($request->all());
        return response()->json($pegawai);
    }

    public function update(Request $request, $id)
    {
        $pegawai = Pegawai::findOrFail($id);
        $pegawai->update($request->all());
        return response()->json($pegawai);
    }

    public function destroy($id)
    {
        Pegawai::destroy($id);
        return response()->json(['message' => 'Deleted successfully']);
    }

    // API
    public function getProvinsi()
    {
        $response = Http::get('https://alamat.thecloudalert.com/api/provinsi/get/');
        return response()->json($response->json());
    }

    public function getKabKota($provinsi_id)
    {
        $response = Http::get("https://alamat.thecloudalert.com/api/kabkota/get/?d_provinsi_id=$provinsi_id");
        return response()->json($response->json());
    }

    public function getKecamatan($kabkota_id)
    {
        $response = Http::get("https://alamat.thecloudalert.com/api/kecamatan/get/?d_kabkota_id=$kabkota_id");
        return response()->json($response->json());
    }

    public function getKodePos($kabkota_id, $kecamatan_id)
    {
        $response = Http::get("https://alamat.thecloudalert.com/api/kodepos/get/?d_kabkota_id=$kabkota_id&d_kecamatan_id=$kecamatan_id");
        return response()->json($response->json());
    }
}

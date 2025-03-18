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
        try {
            $pegawai = Pegawai::all();
            return response()->json(['data' => $pegawai]);
        } catch (Exception $e) {
            return response()->json(['errors' => 'Gagal mengambil data pegawai: ' . $e->getMessage()], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'nama'         => 'required|string|max:255',
                'alamat'       => 'required|string',
                'provinsi_id'  => 'required|integer',
                'kabkota_id'   => 'required|integer',
                'kecamatan_id' => 'required|integer',
                'kodepos_id'   => 'required|integer',
            ]);

            $pegawai = Pegawai::create($validatedData);
            return response()->json($pegawai);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (Exception $e) {
            return response()->json(['errors' => 'Gagal menyimpan data pegawai: ' . $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $pegawai = Pegawai::findOrFail($id);
            $pegawai->update($request->all());
            return response()->json($pegawai);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['errors' => 'Data pegawai tidak ditemukan'], 404);
        } catch (Exception $e) {
            return response()->json(['errors' => 'Gagal memperbarui data pegawai: ' . $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $pegawai = Pegawai::findOrFail($id);
            $pegawai->delete();
            return response()->json(['message' => 'Deleted successfully']);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json(['errors' => 'Data pegawai tidak ditemukan'], 404);
        } catch (Exception $e) {
            return response()->json(['errors' => 'Gagal menghapus data pegawai: ' . $e->getMessage()], 500);
        }
    }

    // API
    public function getProvinsi()
    {
        try {
            $response = Http::get('https://alamat.thecloudalert.com/api/provinsi/get/');
            return response()->json($response->json());
        } catch (Exception $e) {
            return response()->json(['errors' => 'Gagal mengambil data provinsi: ' . $e->getMessage()], 500);
        }
    }

    public function getKabKota($provinsi_id)
    {
        try {
            $response = Http::get("https://alamat.thecloudalert.com/api/kabkota/get/?d_provinsi_id=$provinsi_id");
            return response()->json($response->json());
        } catch (Exception $e) {
            return response()->json(['errors' => 'Gagal mengambil data kabupaten/kota: ' . $e->getMessage()], 500);
        }
    }

    public function getKecamatan($kabkota_id)
    {
        try {
            $response = Http::get("https://alamat.thecloudalert.com/api/kecamatan/get/?d_kabkota_id=$kabkota_id");
            return response()->json($response->json());
        } catch (Exception $e) {
            return response()->json(['errors' => 'Gagal mengambil data kecamatan: ' . $e->getMessage()], 500);
        }
    }

    public function getKodePos($kabkota_id, $kecamatan_id)
    {
        try {
            $response = Http::get("https://alamat.thecloudalert.com/api/kodepos/get/?d_kabkota_id=$kabkota_id&d_kecamatan_id=$kecamatan_id");
            return response()->json($response->json());
        } catch (Exception $e) {
            return response()->json(['errors' => 'Gagal mengambil data kode pos: ' . $e->getMessage()], 500);
        }
    }
}

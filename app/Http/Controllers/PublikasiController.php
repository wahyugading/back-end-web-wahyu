<?php
namespace App\Http\Controllers;

use App\Models\Publikasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
class PublikasiController extends Controller
{
    // GET /api/publikasi
    public function index()
    {
        // Ambil semua data dari model Publikasi
        $publikasi = Publikasi::all();

        // Kembalikan data sebagai JSON
        return response()->json($publikasi);
    }
    // POST /api/publikasi
    public function store(Request $request)
    {
        $validated = $request->validate([
        'title' => 'required|string|max:255',
        'releaseDate' => 'required|date',
        'description' => 'nullable|string',
        'coverUrl' => 'nullable|url',
        ]);
        $publikasi = Publikasi::create($validated);
        return response()->json($publikasi, 201);
    }

    // GET /api/publikasi/{id}
    public function show($id)
    {
        $publikasi = Publikasi::find($id);

        if (!$publikasi) {
            return response()->json(['message' => 'Data tidak ditemukan'], 404);
        }

        return response()->json($publikasi);
    }

    // PUT /api/publikasi/{id}
    public function update(Request $request, $id)
    {
        // 1. Validasi data yang masuk dari form
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'releaseDate' => 'required|date',
            'coverUrl' => 'required|url',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors()->toJson(), 400);
        }

        // 2. Cari publikasi berdasarkan ID
        $publikasi = Publikasi::find($id);
        if (!$publikasi) {
            return response()->json(['message' => 'Publikasi tidak ditemukan'], 404);
        }

        // 3. Update setiap field secara eksplisit
        $publikasi->title = $request->input('title');
        $publikasi->description = $request->input('description');
        $publikasi->releaseDate = $request->input('releaseDate');
        $publikasi->coverUrl = $request->input('coverUrl');

        // 4. Simpan perubahan ke database
        $publikasi->save();

        // 5. Kembalikan data yang sudah diupdate sebagai konfirmasi
        return response()->json($publikasi, 200);
    }

    // DELETE /api/publikasi/{id}
    public function destroy($id)
    {
        // Cari publikasi berdasarkan ID
        $publikasi = Publikasi::find($id);

        // Jika tidak ditemukan, kembalikan error 404
        if (!$publikasi) {
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        // Hapus data dari database
        $publikasi->delete();

        // Kembalikan respons sukses
        return response()->json([
            'message' => 'Publikasi berhasil dihapus'
        ], 200);
    }
}

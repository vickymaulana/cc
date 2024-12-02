<?php

namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Models\Patient;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      // Validasi data yang dikirimkan
      $validatedData = $request->validate([
        'nama' => 'required|string|max:255',
        'nik' => 'required|string|size:16|unique:patients,nik',
        'tanggal_lahir' => 'required|date',
        'alamat' => 'required|string',
        'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
        'umur'=> 'required|number',
        'nomor_hp' => 'required|string|max:15|unique:patients,nomor_hp',
    ]);

    // Simpan data pasien ke database
    $patient = Patient::create($validatedData);

    // Kembalikan response JSON
    return response()->json([
        'message' => 'Data pasien berhasil disimpan.',
        'data' => $patient,
    ], 201);
}


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $patient = Patient::findOrFail($id);

        // Validasi data yang dikirimkan
        $validatedData = $request->validate([
            'nama' => 'nullable|string|max:255',
            'nik' => 'nullable|string|size:16|unique:patients,nik,' . $id,
            'tanggal_lahir' => 'nullable|date',
            'alamat' => 'nullable|string',
            'jenis_kelamin' => 'nullable|in:Laki-laki,Perempuan',
            'umur' => 'nullable|integer|min:0',
            'nomor_hp' => 'nullable|string|max:15|unique:patients,nomor_hp,' . $id,
        ]);

        // Perbarui data pasien
        $patient->update($validatedData);

        // Kembalikan respons JSON
        return response()->json([
            'message' => 'Data pasien berhasil diperbarui.',
            'data' => $patient,
        ], 200);
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
    // Cari pasien berdasarkan ID
    $patient = Patient::findOrFail($id);

    // Hapus data pasien
    $patient->delete();

    // Kembalikan respons JSON
    return response()->json([
        'message' => 'Data pasien berhasil dihapus.',
    ], 200);
}
    }


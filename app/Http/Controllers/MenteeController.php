<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Mentor;

class MenteeController extends Controller
{
    /**
     * Store a newly created mentee for a specific mentor.
     * This method handles adding a mentee to a mentor.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $mentorId // Laravel automatically injects the mentor ID from the nested route
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request, $mentorId)
    {
        $validator = Validator::make($request->all(), [
            'mentee_id' => 'required|integer|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => 'Validasi gagal', 'errors' => $validator->errors()], 422);
        }

        User::where('id', $request->mentee_id)->update(['mentor_id' => $mentorId]);

        // 2. Cari data mentor berdasarkan ID
        $mentor = Mentor::find($mentorId);
        $namaMentor = $mentor ? $mentor->nama : 'ID ' . $mentorId; // Gunakan nama jika ditemukan, jika tidak gunakan ID

        // 3. Gunakan nama mentor di dalam pesan response
        return response()->json(['message' => 'Mentee berhasil ditambahkan ke Mentor ' . $namaMentor . '!'], 200);
    }

    /**
     * Remove the specified mentee from a specific mentor.
     * This method handles detaching a mentee from a mentor.
     *
     * @param  int  $mentorId // Laravel automatically injects the mentor ID
     * @param  int  $menteeId // Laravel automatically injects the mentee ID
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($mentorId, $menteeId)
    {
        // --- Simulasi penghapusan mentee dari mentor ---
        // Dalam aplikasi nyata, Anda akan melakukan hal berikut:
        // 1. Cari mentor: $mentor = Mentor::findOrFail($mentorId);
        // 2. Detach mentee dari mentor: $mentor->mentees()->detach($menteeId);
        //    Atau jika ada model Mentee yang terhubung langsung ke pivot:
        //    Mentee::where('mentor_id', $mentorId)->where('user_id', $menteeId)->delete();

        User::where('id', $menteeId)->update(['mentor_id' => null]);

        // Untuk tujuan dummy, kita bisa mengembalikan pesan sukses
        return response()->json(['message' => 'Mentee ID ' . $menteeId . ' berhasil dihapus dari mentor ID ' . $mentorId . '!'], 200);
    }
}

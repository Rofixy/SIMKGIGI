<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\Dokter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Carbon\Carbon;

class JadwalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $dokter = $this->getDokterByAuth();

        if (!$dokter) {
            abort(403, 'Data dokter tidak ditemukan.');
        }

        $jadwals = $dokter->jadwal()
            ->orderBy('tanggal_praktik')
            ->orderBy('jam_mulai')
            ->get();

        return view('dokter.jadwal', compact('jadwals', 'dokter'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'tanggal_praktik' => [
                'required',
                'date',
                'after_or_equal:today'
            ],
            'hari' => [
                'required',
                'string',
                'in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu'
            ],
            'jam_mulai' => [
                'required',
                'date_format:H:i'
            ],
            'jam_selesai' => [
                'required',
                'date_format:H:i',
                'after:jam_mulai'
            ],
        ], [
            'tanggal_praktik.after_or_equal' => 'Tanggal praktik tidak boleh kurang dari hari ini.',
            'hari.in' => 'Hari harus berupa nama hari yang valid.',
            'jam_mulai.date_format' => 'Format jam mulai harus HH:MM (contoh: 08:00).',
            'jam_selesai.date_format' => 'Format jam selesai harus HH:MM (contoh: 17:00).',
            'jam_selesai.after' => 'Jam selesai harus lebih besar dari jam mulai.',
        ]);

        $dokter = $this->getDokterByAuth();

        if (!$dokter) {
            return back()->with('error', 'Data dokter tidak ditemukan.');
        }

        // Validasi konflik jadwal
        $conflictExists = $this->checkScheduleConflict(
            $dokter->id,
            $validated['tanggal_praktik'],
            $validated['jam_mulai'],
            $validated['jam_selesai']
        );

        if ($conflictExists) {
            return back()
                ->withInput()
                ->with('error', 'Jadwal bentrok dengan jadwal yang sudah ada.');
        }

        // Validasi hari sesuai tanggal
        $dayName = Carbon::parse($validated['tanggal_praktik'])->locale('id')->dayName;
        if (strtolower($dayName) !== strtolower($validated['hari'])) {
            return back()
                ->withInput()
                ->with('error', 'Hari tidak sesuai dengan tanggal yang dipilih.');
        }

        Jadwal::create([
            'dokter_id' => $dokter->id,
            'tanggal_praktik' => $validated['tanggal_praktik'],
            'hari' => $validated['hari'],
            'jam_mulai' => $validated['jam_mulai'],
            'jam_selesai' => $validated['jam_selesai'],
        ]);

        return back()->with('success', 'Jadwal berhasil ditambahkan.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        $jadwal = Jadwal::findOrFail($id);
        
        // Authorization check
        if (!$this->authorizeJadwal($jadwal)) {
            abort(403, 'Anda tidak memiliki akses untuk mengubah jadwal ini.');
        }

        $validated = $request->validate([
            'tanggal_praktik' => [
                'required',
                'date',
                'after_or_equal:today'
            ],
            'hari' => [
                'required',
                'string',
                'in:Senin,Selasa,Rabu,Kamis,Jumat,Sabtu,Minggu'
            ],
            'jam_mulai' => [
                'required',
                'date_format:H:i'
            ],
            'jam_selesai' => [
                'required',
                'date_format:H:i',
                'after:jam_mulai'
            ],
        ], [
            'tanggal_praktik.after_or_equal' => 'Tanggal praktik tidak boleh kurang dari hari ini.',
            'hari.in' => 'Hari harus berupa nama hari yang valid.',
            'jam_mulai.date_format' => 'Format jam mulai harus HH:MM (contoh: 08:00).',
            'jam_selesai.date_format' => 'Format jam selesai harus HH:MM (contoh: 17:00).',
            'jam_selesai.after' => 'Jam selesai harus lebih besar dari jam mulai.',
        ]);

        // Validasi konflik jadwal (kecuali dengan jadwal sendiri)
        $conflictExists = $this->checkScheduleConflict(
            $jadwal->dokter_id,
            $validated['tanggal_praktik'],
            $validated['jam_mulai'],
            $validated['jam_selesai'],
            $jadwal->id
        );

        if ($conflictExists) {
            return back()
                ->withInput()
                ->with('error', 'Jadwal bentrok dengan jadwal yang sudah ada.');
        }

        // Validasi hari sesuai tanggal
        $dayName = Carbon::parse($validated['tanggal_praktik'])->locale('id')->dayName;
        if (strtolower($dayName) !== strtolower($validated['hari'])) {
            return back()
                ->withInput()
                ->with('error', 'Hari tidak sesuai dengan tanggal yang dipilih.');
        }

        $jadwal->update($validated);

        return back()->with('success', 'Jadwal berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id): RedirectResponse
    {
        $jadwal = Jadwal::findOrFail($id);
        
        // Authorization check
        if (!$this->authorizeJadwal($jadwal)) {
            abort(403, 'Anda tidak memiliki akses untuk menghapus jadwal ini.');
        }

        // Hapus jadwal (tidak ada pengecekan appointments karena tidak ada relationship)
        $jadwal->delete();

        return back()->with('success', 'Jadwal berhasil dihapus.');
    }

    /**
     * Get dokter data by authenticated user
     */
    private function getDokterByAuth(): ?Dokter
    {
        return Dokter::where('user_id', Auth::id())->first();
    }

    /**
     * Check if authenticated user can access the jadwal
     */
    private function authorizeJadwal(Jadwal $jadwal): bool
    {
        $dokter = $this->getDokterByAuth();
        return $dokter && $dokter->id === $jadwal->dokter_id;
    }

    /**
     * Check for schedule conflicts
     */
    private function checkScheduleConflict(
        int $dokterId,
        string $tanggal,
        string $jamMulai,
        string $jamSelesai,
        ?int $excludeId = null
    ): bool {
        $query = Jadwal::where('dokter_id', $dokterId)
            ->where('tanggal_praktik', $tanggal)
            ->where(function ($q) use ($jamMulai, $jamSelesai) {
                $q->whereBetween('jam_mulai', [$jamMulai, $jamSelesai])
                  ->orWhereBetween('jam_selesai', [$jamMulai, $jamSelesai])
                  ->orWhere(function ($subQ) use ($jamMulai, $jamSelesai) {
                      $subQ->where('jam_mulai', '<=', $jamMulai)
                           ->where('jam_selesai', '>=', $jamSelesai);
                  });
            });

        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        return $query->exists();
    }
}
<?php
namespace App\Http\Controllers\Data;

use App\Http\Controllers\Controller;
use App\Models\Score;
use App\Models\User;
use App\Models\Workshop;
use App\Models\WorkshopRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Validator;

class ScoreController extends Controller
{
    public function index(Request $request)
    {
        $workshops = Workshop::all();
        $registrations = collect();

        if ($request->workshop_id) {
            $registrations = WorkshopRegistration::with(['user', 'score'])
                ->where('workshop_id', $request->workshop_id)
                ->get();
        }

        return view('data.score.index', compact('workshops', 'registrations'));
    }

    public function showUploadForm()
    {
        $workshops = Workshop::latest()->get();
        return view('data.score.upload', compact('workshops'));
    }

    public function importScores(Request $request)
    {
        $request->validate([
            'workshop_id' => 'required|exists:workshops,id',
            'score_file' => 'required|file|mimes:xlsx'
        ]);

        $workshopId = $request->workshop_id;

        $file = $request->file('score_file');
        $data = Excel::toArray([], $file)[0]; // Ambil sheet pertama

        $header = array_map('strtolower', $data[0]);
        $npmIndex = array_search('npm', $header);
        $scoreIndex = array_search('score', $header);

        if ($npmIndex === false || $scoreIndex === false) {
            return back()->with('error', 'Invalid file format. Columns "npm" and "score" are required.');
        }

        unset($data[0]); // Hapus header

        $successCount = 0;
        $failCount = 0;

        foreach ($data as $row) {
            $npm = trim($row[$npmIndex] ?? '');
            $score = trim($row[$scoreIndex] ?? '');

            if (!$npm || !is_numeric($score)) {
                $failCount++;
                continue;
            }

            $user = User::where('npm', $npm)->first();
            if (!$user) {
                $failCount++;
                continue;
            }

            $registration = WorkshopRegistration::where('user_id', $user->id)
                ->where('workshop_id', $workshopId)
                ->first();

            if (!$registration) {
                $failCount++;
                continue;
            }

            // Simpan skor
            Score::updateOrCreate(
                ['registration_id' => $registration->id],
                [
                    'user_id' => $user->id,
                    'score' => $score
                ]
            );

            // ✅ Update status menjadi "Completed" (4)
            $registration->update(['status' => 4]);

            $successCount++;
        }

        return back()->with('success', "Import complete. Success: $successCount, Failed: $failCount");
    }

}
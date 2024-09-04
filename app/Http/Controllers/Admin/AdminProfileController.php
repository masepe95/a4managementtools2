<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;

class AdminProfileController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $usr = AdminController::getRealUser($request);

        $photo = $usr->photo_file;
        if (!is_null($photo)) {
            $photo = GetImage::getImageInfo($photo);
            if ($photo == '') $photo = null;
        }

        $data = ['profile-firstname' => $usr->firstname, 'profile-lastname' => $usr->lastname,
                 'profile-acronym' => $usr->acronym, 'profile-id' => $usr->employee_id,
                 'profile-mobile-phone' => $usr->mobile_phone, 'profile-phone' => $usr->phone,
                 'profile-email' => $usr->email, 'profile-language-code' => $usr->language_code,
                 'profile-job-title' => $usr->job_title, 'profile-role' => $usr->role,
                 'profile-role-label' => __('globals.employee-role')[$usr->role],
                 'profile-password' => '', 'profile-password-new' => '',  // Annulla i campi delle password.
                 'profile-photo-image' => $photo];

        return response()->json([ 'user' => $data ]);
    }

    public function store(Request $request): JsonResponse
    {
        // Ottieni i codici ISO 639-1 delle lingue supportate.
        $langs = DB::scalar('SELECT GROUP_CONCAT(`code`) FROM `language`');

        $validated = $request->validate([
            'profile-firstname' => 'required|max:64',
            'profile-lastname' => 'required|max:64',
            'profile-mobile-phone' => 'nullable|max:32',
            'profile-phone' => 'nullable|max:32',
            'profile-email' => 'required|email:rfc|max:128',
            'profile-language-code' => "required|in:$langs|size:2",
            'profile-password' => 'nullable|required_with:profile-password-new|current_password',
            'profile-password-new' => 'nullable|required_with:profile-password|different:profile-password|min:8|max:64',
        ]);

        $usr = AdminController::getRealUser($request);

        $usr->firstname = $validated['profile-firstname'];
        $usr->lastname = $validated['profile-lastname'];
        $usr->mobile_phone = $validated['profile-mobile-phone'];
        $usr->phone = $validated['profile-phone'];
        $usr->email = $validated['profile-email'];
        $usr->language_code = $validated['profile-language-code'];

        // Modifica la password solo se non è blank.
        // La validazione controlla che la password attuale sia corretta.
        if (strlen(trim($validated['profile-password-new'])) > 0) $usr->password = Hash::make($validated['profile-password-new']);

        $usr->save();

        return response()->json([]);
    }

    public function uploadPhoto(Request $request): JsonResponse
    {
        // Carica la foto dell'utente impostando il campo `photo_file` con il parametro 'profilePhoto'.
        $usr = AdminController::getRealUser($request);
        $file = $request->file('profilePhoto');  // Path del file temporaneo (es.: 'C:\PHP8\uploadtemp\phpBDD3.tmp').
        $usr->photo_file = File::get($file);     // Equivalente alla funzione file_get_contents($file).
        $usr->save();

        File::delete($file);  // Elimina il file temporaneo caricato sul server.

        $photo = $usr->photo_file;
        if (!is_null($photo)) {
            $photo = GetImage::getImageInfo($photo);
            if ($photo == '') $photo = null;
        }

        return response()->json([ 'photo' => $photo ]);
    }

    public function deletePhoto(Request $request): JsonResponse
    {
        // Elimina la foto dell'utente impostando il campo `photo_file` con il valore null.
        $usr = AdminController::getRealUser($request);
        $usr->photo_file = null;
        $usr->save();

        return response()->json([]);
    }
}

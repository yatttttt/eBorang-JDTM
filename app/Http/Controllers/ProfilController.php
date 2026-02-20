<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    /**
     * Show the profile edit form
     */
    public function edit()
    {
        return view('edit_profile', ['user' => Auth::user()]);
    }

    /**
     * Update the user's profile
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        
        // Log incoming request for debugging
        \Log::info('Profile Update Started', [
            'user_id' => $user->id_user,
            'has_file' => $request->hasFile('gambar_profil'),
            'file_name' => $request->hasFile('gambar_profil') ? $request->file('gambar_profil')->getClientOriginalName() : null
        ]);
        
        // Validation rules based on your table structure
        $rules = [
            'nama' => ['required', 'string', 'max:100'],
            'email' => ['required', 'email', 'max:100', Rule::unique('users', 'email')->ignore($user->id_user, 'id_user')],
            'gambar_profil' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ];

        // Add password validation if password fields are filled
        if ($request->filled('kata_laluan')) {
            $rules['kata_laluan_semasa'] = ['required', function ($attribute, $value, $fail) use ($user) {
                if (!Hash::check($value, $user->kata_laluan)) {
                    $fail('Kata laluan semasa tidak tepat.');
                }
            }];
            $rules['kata_laluan'] = ['required', 'string', 'min:6', 'confirmed'];
        }

        // Validate request
        $validated = $request->validate($rules);

        // Prepare data for update
        $updateData = [
            'nama' => $validated['nama'],
            'email' => $validated['email'],
        ];

        // Handle profile photo upload BEFORE updating other data
        if ($request->hasFile('gambar_profil')) {
            try {
                \Log::info('Processing file upload...');
                
                // Delete old photo if exists
                if ($user->gambar_profil && \Storage::disk('public')->exists($user->gambar_profil)) {
                    \Storage::disk('public')->delete($user->gambar_profil);
                    \Log::info('Old photo deleted', ['old_path' => $user->gambar_profil]);
                }
                
                // Store new photo in 'profile-photos' folder
                $path = $request->file('gambar_profil')->store('profile-photos', 'public');
                $updateData['gambar_profil'] = $path;
                
                \Log::info('New photo uploaded successfully', ['new_path' => $path]);
                
            } catch (\Exception $e) {
                \Log::error('File upload failed', ['error' => $e->getMessage()]);
                return redirect()->back()->withErrors(['gambar_profil' => 'Gagal memuat naik gambar: ' . $e->getMessage()]);
            }
        }

        // Update password if provided
        if ($request->filled('kata_laluan')) {
            $updateData['kata_laluan'] = Hash::make($request->kata_laluan);
        }

        // Update user with all data including photo path
        $user->update($updateData);
        
        \Log::info('Profile updated successfully', [
            'user_id' => $user->id_user,
            'updated_fields' => array_keys($updateData)
        ]);

        return redirect()->route('profile.edit')->with('success', 'Profil berjaya dikemaskini!');
    }

    /**
     * Delete profile photo
     */
    public function deletePhoto()
    {
        $user = Auth::user();
        
        if ($user->deleteGambarProfil()) {
            return redirect()->route('profile.edit')->with('success', 'Gambar profil berjaya dipadam!');
        }

        return redirect()->route('profile.edit')->with('error', 'Tiada gambar profil untuk dipadam.');
    }

    /**
     * Upload signature (from file)
     */
    public function uploadSignature(Request $request)
    {
        \Log::info('Signature Upload Started', [
            'user_id' => Auth::id(),
            'has_file' => $request->hasFile('signature_file')
        ]);

        $rules = [
            'signature_file' => [
                'required',
                'image',
                'mimes:png,jpg,jpeg',
                'max:2048',
                'dimensions:min_width=200,min_height=100'
            ]
        ];

        $messages = [
            'signature_file.required' => 'Sila pilih fail tandatangan',
            'signature_file.image' => 'Fail mesti dalam format gambar',
            'signature_file.mimes' => 'Hanya format PNG, JPG atau JPEG dibenarkan',
            'signature_file.max' => 'Saiz maksimum adalah 2MB',
            'signature_file.dimensions' => 'Dimensi minimum adalah 200x100 pixel'
        ];

        $validated = $request->validate($rules, $messages);

        try {
            $user = Auth::user();
            $user->updateTandatangan($request->file('signature_file'));
            
            \Log::info('Signature uploaded successfully', ['user_id' => $user->id_user]);
            
            return redirect()->route('profile.edit')->with('success', 'Tandatangan berjaya dimuat naik!');
            
        } catch (\Exception $e) {
            \Log::error('Signature upload failed', ['error' => $e->getMessage()]);
            return redirect()->back()->withErrors(['signature_file' => 'Gagal memuat naik tandatangan: ' . $e->getMessage()]);
        }
    }

    /**
     * Draw signature (from canvas)
     */
    public function drawSignature(Request $request)
    {
        \Log::info('Draw Signature Started', ['user_id' => Auth::id()]);

        $validated = $request->validate([
            'signature_data' => 'required|string'
        ], [
            'signature_data.required' => 'Tandatangan tidak boleh kosong'
        ]);

        try {
            $user = Auth::user();

            // Delete old signature if exists
            if ($user->tandatangan && \Storage::disk('public')->exists('signatures/' . $user->tandatangan)) {
                \Storage::disk('public')->delete('signatures/' . $user->tandatangan);
                \Log::info('Old signature deleted');
            }

            // Process base64 data
            $signatureData = $request->signature_data;
            $signatureData = str_replace('data:image/png;base64,', '', $signatureData);
            $signatureData = str_replace(' ', '+', $signatureData);
            $imageData = base64_decode($signatureData);

            // Generate filename
            $filename = 'signature_' . $user->id_user . '_' . time() . '.png';
            
            // Save to storage
            \Storage::disk('public')->put('signatures/' . $filename, $imageData);
            
            // Update user record
            $user->update(['tandatangan' => $filename]);

            \Log::info('Signature drawn successfully', [
                'user_id' => $user->id_user,
                'filename' => $filename
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Tandatangan berjaya disimpan!',
                'signature_url' => \Storage::url('signatures/' . $filename)
            ]);

        } catch (\Exception $e) {
            \Log::error('Draw signature failed', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan tandatangan: ' . $e->getMessage()
            ], 500);
        }
    }

    public function deleteSignature(Request $request)
    {
        try {
            $user = Auth::user();
            
            // Check if AJAX request
            if ($request->expectsJson() || $request->ajax() || $request->wantsJson()) {
                if ($user->deleteTandatangan()) {
                    \Log::info('Signature deleted', ['user_id' => $user->id_user]);
                    
                    return response()->json([
                        'success' => true,
                        'message' => 'Tandatangan berjaya dipadam!'
                    ], 200);
                }

                return response()->json([
                    'success' => false,
                    'message' => 'Tiada tandatangan untuk dipadam.'
                ], 404);
            }
            
            // Normal form request
            if ($user->deleteTandatangan()) {
                \Log::info('Signature deleted', ['user_id' => $user->id_user]);
                return redirect()->route('profile.edit')->with('success', 'Tandatangan berjaya dipadam!');
            }

            return redirect()->route('profile.edit')->with('error', 'Tiada tandatangan untuk dipadam.');
            
        } catch (\Exception $e) {
            \Log::error('Delete signature error: ' . $e->getMessage());
            
            if ($request->expectsJson() || $request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Ralat: ' . $e->getMessage()
                ], 500);
            }
            
            return redirect()->route('profile.edit')->with('error', 'Ralat: ' . $e->getMessage());
        }
    }
}

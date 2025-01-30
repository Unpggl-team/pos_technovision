<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\License;
use App\User; // Asegúrate de que el modelo User está configurado
use Carbon\Carbon;
use App\Services\LicenseService;

class LicenseController extends Controller
{
    public function create()
    {
        return view('generate_license');
    }

    public function store(Request $request)
    {
        // Validar los datos del formulario
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'creation_date' => 'required|date',
            'expiration_date' => 'required|date|after:creation_date',
        ]);

        // Buscar o crear el usuario por el nombre
        $user = User::firstOrCreate(['name' => $validated['name']], [
            'email' => strtolower(str_replace(' ', '', $validated['name'])) . '@example.com', // Ejemplo de email si no existe
            'password' => bcrypt('defaultpassword'), // Cambia según tus necesidades
        ]);

        // Generar la licencia
        $licenseCode = LicenseService::generateLicense(
            $user->id,
            Carbon::parse($validated['expiration_date'])
        );

        // Guardar la licencia en la base de datos
        $license = License::create([
            'user_id' => $user->id,
            'license_code' => $licenseCode,
            'expires_at' => $validated['expiration_date'],
        ]);

        return redirect()->route('licenses.create')->with('success', 'Licencia generada: ' . $license->license_code);
    }
}

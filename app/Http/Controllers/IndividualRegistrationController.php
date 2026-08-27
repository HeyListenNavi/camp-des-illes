<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndividualRegistrationController extends Controller
{
    public function create()
    {
        return view('groups.register-individual');
    }

    public function store(Request $request)
    {
        $request->validate([
            'full_name' => 'required|string|min:3',
            'email' => 'required|email',
            'phone' => 'required|string',
        ]);

        return redirect()->back()->with('success', '¡Registro completado! Tus datos y documentos han sido asociados al grupo.');
    }
}
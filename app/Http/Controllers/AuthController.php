<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
    public function mostrarLogin(): View
    {
        return view('auth.login');
    }

    public function login(Request $request): RedirectResponse
    {
        $credenciales = $request->validate(
            [
                'email' => ['required', 'email'],
                'password' => ['required', 'string'],
            ],
            [
                'email.required' => 'El correo electrónico es obligatorio.',
                'email.email' => 'Debes ingresar un correo electrónico válido.',
                'password.required' => 'La contraseña es obligatoria.',
            ]
        );

        $recordar = $request->boolean('remember');

        if (Auth::attempt($credenciales, $recordar)) {
            $request->session()->regenerate();

            return redirect()
                ->intended(route('inicio'))
                ->with('exito', 'Sesión iniciada correctamente. Bienvenido de nuevo.');
        }

        return back()
            ->withErrors([
                'email' => 'Las credenciales no coinciden con nuestros registros.',
            ])
            ->onlyInput('email');
    }

    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('bienvenida')
            ->with('exito', 'Has cerrado sesión correctamente.');
    }

    public function mostrarRegistro(): View
    {
        return view('auth.registro');
    }

    public function registrar(Request $request): RedirectResponse
    {
        $datosValidados = $request->validate(
            [
                'name' => ['required', 'string', 'max:150'],
                'email' => ['required', 'email', 'max:150', 'unique:users,email'],
                'telefono_principal' => ['required', 'string', 'min:7', 'max:20'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'terminos' => ['accepted'],
            ],
            [
                'name.required' => 'El nombre completo es obligatorio.',
                'name.max' => 'El nombre no puede superar los 150 caracteres.',
                'email.required' => 'El correo electrónico es obligatorio.',
                'email.email' => 'Debes ingresar un correo electrónico válido.',
                'email.unique' => 'Este correo electrónico ya está registrado.',
                'telefono_principal.required' => 'El número de teléfono es obligatorio.',
                'telefono_principal.min' => 'El teléfono debe tener al menos 7 caracteres.',
                'telefono_principal.max' => 'El teléfono no puede superar los 20 caracteres.',
                'password.required' => 'La contraseña es obligatoria.',
                'password.min' => 'La contraseña debe tener al menos 8 caracteres.',
                'password.confirmed' => 'Las contraseñas no coinciden.',
                'terminos.accepted' => 'Debes aceptar los términos y condiciones.',
            ]
        );

        $usuario = User::create([
            'name' => $datosValidados['name'],
            'email' => $datosValidados['email'],
            'telefono_principal' => $datosValidados['telefono_principal'],
            'medio_contacto_preferido' => 'WhatsApp',
            'password' => $datosValidados['password'],
        ]);

        Auth::login($usuario);

        $request->session()->regenerate();

        return redirect()
            ->route('inicio')
            ->with('exito', 'Tu cuenta fue creada correctamente. Bienvenido a PetRescue.');
    }
}

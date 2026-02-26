<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function showForm()
    {
        $roles = [
            'student' => 'študent',
            'teacher' => 'učiteľ',
        ];

        $skills = ['PHP', 'JavaScript', 'HTML', 'CSS'];

        return view('profile.form', ['roles' => $roles, 'skills' => $skills,]);
    }

    public function processForm(Request $request)
    {
        $data = [
            'name'   => $request->input('name'),
            'email'  => $request->input('email'),
            'age'    => $request->input('age'),
            'role'   => $request->input('role'),
            'skills' => $request->input('skills', []),
        ];

        $additional_data = [
            'isAdult'      => (int) $data['age'] >= 18,
            'skillsCount'  => count($data['skills']),
            'roleLabel'    => $data['role'] === 'teacher' ? 'učiteľ' : 'študent',
        ];

        return view('profile.show', ['data' => $data, 'additional_data' => $additional_data]);
    }
}

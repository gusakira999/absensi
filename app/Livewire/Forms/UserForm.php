<?php

namespace App\Livewire\Forms;

use App\Models\User;
use Livewire\Attributes\Validate;
use Livewire\Form;
use Illuminate\Validation\Rule;

class UserForm extends Form
{
    public ?User $user = null;

    public string $name = '';

    public string $email = '';

    public string $role = 'mahasiswa';

    public ?string $nim = null;

    public string $password = '';

    public function rules(): array
    {
        $emailRule = $this->user
            ? Rule::unique('users', 'email')->ignore($this->user->id)
            : Rule::unique('users', 'email');

        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', $emailRule],
            'role' => ['required', 'in:dosen,mahasiswa'],
            'nim' => ['nullable', 'string', 'max:50'],
            'password' => [
                $this->user ? 'nullable' : 'required',
                $this->user ? 'nullable' : 'required',
                'string',
                'min:8',
            ],
        ];
    }


    public function setUser(User $user): void
    {
        $this->resetValidation();

        $this->user = $user;
        $this->name = $user->name ?? '';
        $this->email = $user->email ?? '';
        $this->role = $user->role ?? 'mahasiswa';
        $this->nim = $user->nim ?? null;
        $this->password = '';
    }

    public function store(): void
    {
        $this->validate();

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'nim' => $this->nim !== '' ? $this->nim : null,
            'password' => bcrypt($this->password),
        ]);

        $this->reset();
    }

    public function update(): void
    {
        if (! $this->user) {
            abort(400);
        }

        $this->validate([
            'name' => $this->rules()['name'],
            'email' => $this->rules()['email'],
            'role' => $this->rules()['role'],
            'nim' => $this->rules()['nim'],
            // password optional untuk update
        ]);

        $this->user->update([
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'nim' => $this->nim !== '' ? $this->nim : null,
        ]);

        if (trim($this->password) !== '') {
            $this->user->update(['password' => bcrypt($this->password)]);
        }

        $this->reset();
    }
}


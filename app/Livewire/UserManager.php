<?php

namespace App\Livewire;

use App\Livewire\Forms\UserForm;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserManager extends Component
{
    use WithPagination;

    public UserForm $form;

    public bool $showForm = false;

    public ?int $editingId = null;

    public string $searchTerm = '';

    public string $selectedRole = 'dosen'; // Tab yang aktif

    public function mount(): void
    {
        $this->form = new UserForm($this, 'form');
    }

    protected function userQueryByRole($role)
    {
        return User::query()->where('role', $role);
    }

    public function render()
    {
        // Query untuk Dosen
        $dosenQuery = $this->userQueryByRole('dosen');
        if ($this->searchTerm !== '') {
            $dosenQuery->where(function ($q) {
                $q->where('name', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('email', 'like', '%' . $this->searchTerm . '%');
            });
        }
        $dosens = $dosenQuery->orderBy('created_at', 'desc')->paginate(10, pageName: 'dosens_page');

        // Query untuk Mahasiswa
        $mahasiswaQuery = $this->userQueryByRole('mahasiswa');
        if ($this->searchTerm !== '') {
            $mahasiswaQuery->where(function ($q) {
                $q->where('name', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('email', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('nim', 'like', '%' . $this->searchTerm . '%');
            });
        }
        $mahasiswas = $mahasiswaQuery->orderBy('created_at', 'desc')->paginate(10, pageName: 'mahasiswas_page');

        return view('livewire.user-manager', compact('dosens', 'mahasiswas'));
    }

    public function openCreateForm(string $role = 'mahasiswa'): void
    {
        $this->editingId = null;
        $this->form->reset();
        $this->showForm = true;
        $this->form->role = $role;
    }

    public function openEditForm(int $userId): void
    {
        $this->editingId = $userId;

        $user = User::findOrFail($userId);

        abort_unless(in_array($user->role, ['dosen', 'mahasiswa'], true), 403);

        $this->form->setUser($user);
        $this->showForm = true;
    }

    public function save(): void
    {
        abort_unless(in_array(auth()->user()?->role, ['admin'], true), 403);

        if ($this->form->user) {
            $this->form->update();
            $this->dispatch('notify', message: 'User berhasil diperbarui', type: 'success');
        } else {
            $this->form->store();
            $this->dispatch('notify', message: 'User berhasil ditambahkan', type: 'success');
        }

        $this->closeForm();
    }

    public function delete(int $userId): void
    {
        $user = User::findOrFail($userId);
        abort_unless(in_array($user->role, ['dosen', 'mahasiswa'], true), 403);

        $user->delete();
        $this->dispatch('notify', message: 'User berhasil dihapus', type: 'success');
    }

    public function closeForm(): void
    {
        $this->showForm = false;
        $this->resetPage();
        $this->form->reset();
    }

    public function resetForm(): void
    {
        $this->resetValidation();
        $this->form->reset();
    }
}


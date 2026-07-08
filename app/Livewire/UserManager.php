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

    public function mount(): void
    {
        $this->form = new UserForm($this, 'form');
    }


    protected function userQuery()
    {
        return User::query()->whereIn('role', ['dosen', 'mahasiswa']);
    }

    public function render()
    {
        $query = $this->userQuery();

        if ($this->searchTerm !== '') {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('email', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('nim', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('role', 'like', '%' . $this->searchTerm . '%');
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('livewire.user-manager', compact('users'));
    }

    public function openCreateForm(): void
    {
        $this->editingId = null;

        $this->form->reset();
        $this->showForm = true;
        $this->form->role = 'mahasiswa';
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
        $this->form->reset();
        $this->resetValidation();
    }
}



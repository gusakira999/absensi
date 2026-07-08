<?php

use Livewire\Component;
use App\Livewire\Forms\CourseForm;
use Flux\Flux;

new class extends Component
{
    public CourseForm $form;

    public function save()
    {
        $this->form->store();
        Flux::modal('create-course')->close();

        session()->flash('success', 'Mata Kuliah berhasil ditambahkan.');
        
        $this->dispatch('course-updated');
        $this->redirectRoute('admin.courses', navigate: true);
    }

    public function resetForm()
    {
        $this->resetValidation();
        $this->form->reset();
    }
};
?>

<div>
    <flux:modal name="create-course" class="md:w-150" x-on:close="$wire.resetForm()">
        <form class="space-y-8" wire:submit.prevent="save">
            {{-- header --}}
            <div class="space-y-2">
                <flux:heading size="lg" class="text-zinc-900 dark:text-white">
                    Tambah Mata Kuliah Baru
                </flux:heading>
                <flux:text class="text-zinc-500 dark:text-zinc-400">
                    Silahkan isi form di bawah ini
                </flux:text>
            </div>

            {{-- form field --}}
            <div class="space-y-6">
                <flux:input
                    label="Nama Mata Kuliah"
                    placeholder="Contoh: Pemrograman Web"
                    wire:model="form.course_name"
                    type="text"
                />

                <flux:input
                    label="Kode Mata Kuliah"
                    placeholder="Contoh: CS301"
                    wire:model="form.course_code"
                    type="text"
                />

                <flux:input
                    label="Nama Dosen"
                    placeholder="Contoh: Dr. Budi Santoso"
                    wire:model="form.lecturer"
                    type="text"
                />

                <flux:select
                    label="Semester"
                    placeholder="Pilih semester"
                    wire:model="form.semester"
                >
                    @for($i = 1; $i <= 8; $i++)
                        <flux:select.option value="{{ $i }}">Semester {{ $i }}</flux:select.option>
                    @endfor
                </flux:select>
            </div>
    
            {{-- footer --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                <flux:modal.close>
                    <flux:button variant="outline" color="neutral">Batal</flux:button>
                </flux:modal.close>
                <flux:button variant="primary" color="primary" type="submit">Tambahkan</flux:button>
            </div>
        </form>   
    </flux:modal>
</div>

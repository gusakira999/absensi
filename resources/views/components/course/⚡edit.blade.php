<?php

use Livewire\Component;
use Livewire\Attributes\On;
use App\Models\Course;
use App\Livewire\Forms\CourseForm;
use Flux\Flux;

new class extends Component
{
    public CourseForm $form;

    #[On('edit-course')]
    public function editCourse($id)
    {
        $course = Course::find($id);
        $this->form->setCourse($course);
        Flux::modal('edit-course')->show();
    }

    public function updateCourse()
    {
        $this->form->update();
        Flux::modal('edit-course')->close();
        session()->flash('success', 'Mata Kuliah berhasil diperbarui.');
        
        $this->dispatch('course-updated');
        $this->redirectRoute('admin.courses', navigate: true);
    }

    public function resetForm()
    {
        $this->resetValidation();
        $this->form->reset();
    }
    
    #[On('confirm-delete')]
    public function confirmDelete($id)
    {
        $course = Course::find($id);
        $this->form->setCourse($course);
        Flux::modal('delete-course')->show();
    }

    public function deleteCourse()
    {
        $this->form->course->delete();
        Flux::modal('delete-course')->close();
        session()->flash('success', 'Mata Kuliah berhasil dihapus.');
        
        $this->dispatch('course-updated');
        $this->redirectRoute('admin.courses', navigate: true);
    }
}
?>

<div>
    {{-- Edit Modal --}}
    <flux:modal 
        name="edit-course" 
        class="md:w-150" 
        x-on:close="$wire.resetForm()" 
    >
        <form class="space-y-8" wire:submit.prevent="updateCourse">
            {{-- header --}}
            <div class="space-y-2">
                <flux:heading size="lg" class="text-zinc-900 dark:text-white">
                    Edit Mata Kuliah
                </flux:heading>
                <flux:text class="text-zinc-500 dark:text-zinc-400">
                    Perbarui detail mata kuliah di bawah ini
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

            <div 
                wire:show="$dirty"
                class="text-orange-500 dark:text-orange-400 text-sm"
            >
                Anda memiliki perubahan yang belum disimpan
            </div>
    
            {{-- footer --}}
            <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                <flux:modal.close>
                    <flux:button variant="outline" color="neutral">Batal</flux:button>
                </flux:modal.close>
                <flux:button variant="primary" color="primary" type="submit">Perbarui</flux:button>
            </div>
        </form>
    </flux:modal>

    {{-- Delete Confirmation Modal --}}
    <flux:modal name="delete-course" variant="danger" class="md:w-96">
        <div class="space-y-4">
            <div class="space-y-2">
                <flux:heading size="lg" class="text-zinc-900 dark:text-white">
                    Hapus Mata Kuliah
                </flux:heading>
                <flux:text class="text-zinc-500 dark:text-zinc-400">
                    Anda yakin ingin menghapus mata kuliah <strong>{{ $this->form->course?->course_name }}</strong>? Tindakan ini tidak dapat dibatalkan.
                </flux:text>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-zinc-200 dark:border-zinc-800">
                <flux:modal.close>
                    <flux:button variant="outline" color="neutral">Batal</flux:button>
                </flux:modal.close>
                <flux:button variant="danger" color="red" wire:click="deleteCourse">Hapus</flux:button>
            </div>
        </div>
    </flux:modal>
</div>

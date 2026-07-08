<?php

use Livewire\Component;
use Livewire\Attributes\Computed;
use Livewire\Attributes\On;
use Livewire\WithPagination;
use App\Models\Course;

new class extends Component
{
    use WithPagination;

    #[Computed]
    public function courses()
    {
        return Course::latest()->paginate(10);
    }

    #[On('course-updated')]
    public function refreshCourses()
    {
        $this->resetPage();
    }

    public function edit($id)
    {
        $this->dispatch('edit-course', id: $id);
    }

    public function confirmDelete($id)
    {
        $this->dispatch('confirm-delete', id: $id);
    }
};
?>

<div class="max-w-7xl mx-auto space-y-4">
    <flux:heading size="xl" class="text-zinc-800 dark:text-white">Mata Kuliah</flux:heading>
    <flux:subheading size="lg" class="text-zinc-600 dark:text-zinc-400">Kelola daftar mata kuliah</flux:subheading>
    <flux:separator variant="subtle" />

    <flux:modal.trigger name="create-course">
        <flux:button variant="primary" icon="plus" color="primary">Tambah Mata Kuliah</flux:button>
    </flux:modal.trigger>

    <livewire:course.create />
    <livewire:course.edit />
    <x-flash-message />

    <div class="overflow-x-auto">
        <flux:table :paginate="$this->courses">
            <flux:table.columns>
                <flux:table.column>No</flux:table.column>
                <flux:table.column>Kode Mata Kuliah</flux:table.column>
                <flux:table.column>Nama Mata Kuliah</flux:table.column>
                <flux:table.column>Dosen</flux:table.column>
                <flux:table.column>Semester</flux:table.column>
                <flux:table.column>Dibuat pada</flux:table.column>
                <flux:table.column>Action</flux:table.column>
            </flux:table.columns>

            <flux:table.rows>
                @foreach ($this->courses as $course)
                    <flux:table.row :key="$course->id">
                        <flux:table.cell>
                            {{ $loop->iteration + $this->courses->firstItem() - 1 }}
                        </flux:table.cell>

                        <flux:table.cell class="font-mono text-blue-600">
                            {{ $course->course_code }}
                        </flux:table.cell>

                        <flux:table.cell>
                            {{ $course->course_name }}
                        </flux:table.cell>

                        <flux:table.cell>
                            {{ $course->lecturer }}
                        </flux:table.cell>

                        <flux:table.cell>
                            <flux:badge size="sm" color="blue">
                                Sem {{ $course->semester }}
                            </flux:badge>
                        </flux:table.cell>

                        <flux:table.cell class="whitespace-nowrap">
                            {{ $course->created_at->diffForHumans() }}
                        </flux:table.cell>

                        <flux:table.cell>
                            <flux:dropdown>
                                <flux:button variant="ghost" size="sm" icon="ellipsis-horizontal" inset="top bottom"></flux:button>

                                <flux:menu>
                                    <flux:menu.item icon="pencil" wire:click="edit({{ $course->id }})">Edit</flux:menu.item>
                                    <flux:menu.separator />
                                    <flux:menu.item variant="danger" icon="trash" wire:click="confirmDelete({{ $course->id }})">Delete</flux:menu.item>
                                </flux:menu>
                            </flux:dropdown>
                        </flux:table.cell>
                    </flux:table.row>
                @endforeach
            </flux:table.rows>
        </flux:table>
    </div>
</div>

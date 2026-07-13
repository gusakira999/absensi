<?php

namespace App\Livewire;

use App\Models\Course;
use Livewire\Component;
use Livewire\WithPagination;

class CourseManager extends Component
{
    use WithPagination;

    public $course_name = '';
    public $course_code = '';
    public $semester = '';

    // lecturer dipilih dari daftar dosen saat tambah/edit course.
    public int $lecturer_id = 0;

    // (opsional) untuk menampilkan nama dosen lama saat edit
    public string $lecturer = '';

    // list dosen untuk dropdown
    public $dosens;







    public $editingId = null;
    public $showForm = false;
    public $searchTerm = '';

    protected $rules = [
        'course_name' => 'required|string|max:255',
        'course_code' => 'required|string|max:50|unique:courses,course_code',
        'lecturer_id' => 'required|integer|min:1',
        'semester' => 'required|integer|min:1|max:8',
    ];




    public function render()
    {
        $this->dosens = \App\Models\User::query()->where('role', 'dosen')->orderBy('name')->get();

        $courses = Course::when($this->searchTerm, function ($query) {

            $query->where('course_name', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('course_code', 'like', '%' . $this->searchTerm . '%')
                  ->orWhere('lecturer', 'like', '%' . $this->searchTerm . '%');
        })->paginate(10);

        return view('livewire.course-manager', compact('courses'));
    }

    public function openCreateForm()
    {
        $this->resetForm();
        $this->showForm = true;
        $this->editingId = null;
    }

    public function openEditForm($courseId)
    {
        $course = Course::findOrFail($courseId);
        $this->editingId = $courseId;
        $this->course_name = $course->course_name;
        $this->course_code = $course->course_code;
        $this->lecturer = $course->lecturer;
        $this->semester = $course->semester;

        // set lecturer_id berdasarkan nama dosen lama (kolom courses masih string)
        $this->lecturer_id = 0;
        if (!empty($course->lecturer)) {
            $user = \App\Models\User::query()->where('role', 'dosen')
                ->where('name', $course->lecturer)
                ->first();
            $this->lecturer_id = $user?->id ?? 0;
        }

        $this->showForm = true;
    }


    public function save()
    {
        // Update unique rule untuk edit
        if ($this->editingId) {
            $this->rules['course_code'] = 'required|string|max:50|unique:courses,course_code,' . $this->editingId;
        }

        $validated = $this->validate();

        if ($this->editingId) {
            $course = Course::findOrFail($this->editingId);
            // Course model masih simpan lecturer sebagai STRING.
            // Jadi saat simpan/edit, kita ubah lecturer_id -> nama dosen.
            $dosenName = \App\Models\User::query()->where('role','dosen')->find($validated['lecturer_id'])?->name;
            $validated['lecturer'] = $dosenName;
            unset($validated['lecturer_id']);

            $course->update($validated);

            $this->dispatch('notify', message: 'Course berhasil diperbarui', type: 'success');
        } else {
            // create: ubah lecturer_id -> lecturer (string nama dosen)
            $dosenName = \App\Models\User::query()->where('role','dosen')->find($validated['lecturer_id'])?->name;

            $validated['lecturer'] = $dosenName;
            unset($validated['lecturer_id']);

            Course::create($validated);
            $this->dispatch('notify', message: 'Course berhasil ditambahkan', type: 'success');
        }


        $this->closeForm();
    }

    public function delete($courseId)
    {
        Course::findOrFail($courseId)->delete();
        $this->dispatch('notify', message: 'Course berhasil dihapus', type: 'success');
    }

    public function closeForm()
    {
        $this->showForm = false;
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->course_name = '';
        $this->course_code = '';
        $this->lecturer = '';
        $this->semester = '';
        $this->editingId = null;
    }
}

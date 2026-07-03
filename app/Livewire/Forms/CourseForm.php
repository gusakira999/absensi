<?php

namespace App\Livewire\Forms;

use Livewire\Form;
use App\Models\Course;
use Illuminate\Validation\Rule;

class CourseForm extends Form
{
    public string $course_name = '';

    public string $course_code = '';

    public string $lecturer = '';

    public int|string $semester = '';

    public ?Course $course = null;

    public function rules(): array
    {
        return [
            'course_name' => [
                'required',
                'string',
                'min:3',
                'max:255',
            ],
            'course_code' => [
                'required',
                'string',
                'max:50',
                Rule::unique('courses', 'course_code')->ignore($this->course?->id),
            ],
            'lecturer' => [
                'required',
                'string',
                'max:255',
            ],
            'semester' => [
                'required',
                'integer',
                'min:1',
                'max:8',
            ],
        ];
    }

    public function store()
    {
        $this->validate();
        Course::create($this->only(['course_name', 'course_code', 'lecturer', 'semester']));
        $this->reset();
    }

    public function setCourse(Course $course): void
    {
        $this->course = $course;
        $this->course_name = $course->course_name;
        $this->course_code = $course->course_code;
        $this->lecturer = $course->lecturer;
        $this->semester = $course->semester;
    }

    public function update()
    {
        $this->validate();
        $this->course->update($this->only(['course_name', 'course_code', 'lecturer', 'semester']));
    }
}

<?php

namespace App\Livewire\Forms;

use App\Models\Course;
use Livewire\Attributes\Validate;
use Livewire\Form;

class CourseForm extends Form
{
    public $id = null;
//    #[Validate('required', as: 'type gang')]
    #[Validate('required', 'min:3', 'max:255')]
    public $type = null;

    // read the selected course
    public function read(Course $course)
    {
        $this->id = $course->id;
        $this->type = $course->type;
    }

    // create a new course
    public function create()
    {
        $this->validate();
        Course::create([
            'type' => $this->type,
        ]);
    }
    // update the selected course
    public function update()
    {
        $this->validate();
        Course::find($this->id)->update([
            'type' => $this->type,
        ]);
    }

    // delete the selected course
    public function delete(Course $course)
    {
        $course->delete();
    }
}

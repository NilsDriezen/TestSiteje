<?php

namespace App\Livewire\Admin;

use App\Models\Course;
use App\Models\Dish;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\Attributes\layout;
use Livewire\WithPagination;
use App\Livewire\Forms\CourseForm;

class Courses extends Component
{
    use WithPagination;
    public $search = '';
    public $perPage = 5;
    public $orderBy = 'type';
    public $orderAsc = true;
    public $noDish = false;
    public $showModal = false;

    public CourseForm $form;

    #[Layout('layouts.huiskamer', [
        'title' => 'Gangen',
        'subtitle' => 'Gangen',
         'description' => 'Beheer type gang van gerechten',
    ])]
    public function render()
    {
        /*$query = Course::orderBy('type')
            ->searchName($this->search);*/

        $query = Course::query()
            ->searchName($this->search);

            /*->paginate($this->perPage);*/
        if($this->noDish)
            $query = $query->doesntHave('dishes');

        /*$query->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc');*/
        $query->withCount('dishes')
            ->orderBy('dishes_count', $this->orderAsc ? 'asc' : 'desc')
            ->orderBy($this->orderBy, $this->orderAsc ? 'asc' : 'desc');

        $courses = $query
            ->paginate($this->perPage);

        $courses->load('dishes');
        return view('livewire.admin.courses', compact('courses'));
    }
    public function updated($propertyName, $propertyValue)
    {
        // reset if the $search, $noCover, $noStock or $perPage property has changed (updated)
        if (in_array($propertyName, ['search', 'noDish', 'perPage', 'orderBy', 'orderAsc']))
            $this->resetPage();
    }

    public function newCourse()
    {
        $this->form->reset();
        $this->resetErrorBag();
        $this->showModal = true;
    }


    public function createCourse()
    {
        $this->form->create();
        $this->showModal = false;
        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "De gang <b><i>{$this->form->type}</i></b> is toegevoegd",
            'icon' => 'success',
        ]);
    }

    public function editCourse(Course $course)
    {
        $this->resetErrorBag();
        $this->form->fill($course);
        $this->showModal = true;
    }


    public function updateCourse(Course $course)
    {
        $this->form->update($course);
        $this->showModal = false;
        $this->dispatch('swal:toast', [
            'background' => 'success',
            'html' => "De gang <b><i>{$this->form->type}</i></b> is aangepast",
            'icon' => 'success',
        ]);


    }


    // delete a course
    #[On('delete-course')]
    public function deleteCourse(Course $course)
    {

    // if referenced in any dish reject the delete
        if ($course->dishes()->exists()) {
            $this->dispatch('swal:toast', [
                'background' => 'warning',
                'icon' => 'warning',
                'title' => 'Waarschuwing!',
                'text' => "Hier zijn nog gerechten gekoppeld aan deze gang. U kunt het niet verwijderen.",
                'confirmButtonText' => 'OK',
            ]);
        } else {
            $course->delete();
            $this->dispatch('swal:toast', [
                'background' => 'success',
                'html' => "De gang <b><i>{$course->type}</i></b> is verwijderd",
                'icon' => 'success',
            ]);
        }
        // Check if the course is referenced in any dish
        //dump($course);
        //dump($course->dishes()->exists(), $course->dishes()->count());

    }

    public function resort($column)
    {
        $this->orderBy === $column ?
            $this->orderAsc = !$this->orderAsc :
            $this->orderAsc = true;
        $this->orderBy = $column;
    }

}

/*if ($course->dishes()->exists()) {
    $this->dispatch('swal:confirm', [
        'title' => 'Weet u het zeker?',
        'text' => "Hier zijn nog gerechten gekoppeld aan deze gang. Weet u zeker dat u het wilt verwijderen?",
        'icon' => 'warning',
        'confirmButtonText' => 'Ja, verwijder',
        'method' => 'deleteCourse',
        'params' => $courseId,
    ]);
} else {
    $this->form->delete($course);
    $this->dispatch('swal:toast', [
        'background' => 'success',
        'html' => "De gang <b><i>{$course->type}</i></b> is verwijderd",
        'icon' => 'success',
    ]);
}*/

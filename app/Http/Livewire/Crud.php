<?php

namespace App\Http\Livewire;
use Livewire\Component;
use App\Models\Student;


class Crud extends Component
{
    public $students, $name, $nim, $alamat, $student_id;
    public $isModalOpen = 0;

    public function render()
    {
        $this->students = Student::all();
        return view('livewire.crud');
    }

    public function create()
    {
        $this->resetCreateForm();
        $this->openModalPopover();
    }

    public function openModalPopover()
    {
        $this->isModalOpen = true;
    }

    public function closeModalPopover()
    {
        $this->isModalOpen = false;
    }

    private function resetCreateForm(){
        $this->name = '';
        $this->nim = '';
        $this->alamat = '';
    }
    
    public function store()
    {
        $this->validate([
            'name' => 'required',
            'nim' => 'required',
            'alamat' => 'required',
        ]);
    
        Student::updateOrCreate(['id' => $this->student_id], [
            'name' => $this->name,
            'nim' => $this->nim,
            'alamat' => $this->alamat,
        ]);

        session()->flash('message', $this->student_id ? 'Student updated.' : 'Student created.');

        $this->closeModalPopover();
        $this->resetCreateForm();
    }

    public function edit($id)
    {
        $student = Student::findOrFail($id);
        $this->id = $id;
        $this->name = $student->name;
        $this->nim = $student->nim;
        $this->alamat = $student->alamat;
    
        $this->openModalPopover();
    }
    
    public function delete($id)
    {
        Student::find($id)->delete();
        session()->flash('message', 'Student deleted.');
    }
}
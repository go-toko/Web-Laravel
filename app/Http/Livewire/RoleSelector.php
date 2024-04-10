<?php

namespace App\Http\Livewire;

use App\Models\RolesModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class RoleSelector extends Component
{
    public Model $model;
    public string $field;
    public int $role_id;


    public function mount()
    {
        $this->role_id = $this->model->getAttribute($this->field);
    }

    public function updating($field, $role_id)
    {
        Log::debug("Toggle-switch " . $role_id);
        $this->model->setAttribute($this->field, $role_id)->save();
        $this->dispatchBrowserEvent('show-toast', [
            'type' => 'success',
            'message' => 'Update berhasil dilakukan.',
            'title' => 'Sukses'
        ]);
    }

    public function render()
    {
        $roles = RolesModel::get();
        return view('livewire.role-selector', [
            'roles' => $roles,
        ]);
    }
}
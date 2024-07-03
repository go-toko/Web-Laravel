<?php

namespace App\Http\Livewire\Superadmin\Subscribe;

use Livewire\Component;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Model;

class ToggleSwitch extends Component
{
    public Model $model;
    public string $field;
    public bool $value;

    public function mount()
    {
        $this->value = (bool) $this->model->getAttribute($this->field);
    }

    public function updating($field, $value)
    {
        Log::debug("Toggle-switch " . $value);
        $this->model->setAttribute($this->field, $value)->save();
    }

    public function render()
    {
        return view('livewire.superadmin.subscribe.toggle-switch');
    }
}

<?php

namespace App\Http\Livewire\Superadmin\Subscribe;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class ToggleMax extends Component
{
    public Model $model;
    public string $field;
    public bool $value;
    public int $max = 3;

    public function mount()
    {
        $this->value = (bool) $this->model->getAttribute($this->field);
    }

    public function updating($field, $value)
    {
        $countIsActive = $this->model->where('isActive', 1)->count();
        if ($countIsActive < $this->max) {
            $this->model->setAttribute($this->field, $value)->save();
        } else {
            $this->model->setAttribute($this->field, $value)->save();
            $datas = $this->model->where('isActive', 1)->orderBy('updated_at', 'ASC')->take($this->max)->get();
            $datas[0]->update(['isActive' => 0]);

            Log::debug('Toggle-Max', ['datas' => $datas]);
            // $this->model->setAttribute($this->field, $value)->save();
        }

        $this->redirect(route('superadmin.subscription.management.index'),['_wire' => 1]);

        // Log::debug("Toggle-Max " . $value);
    }
    public function render()
    {
        return view('livewire.superadmin.subscribe.toggle-max');
    }
}

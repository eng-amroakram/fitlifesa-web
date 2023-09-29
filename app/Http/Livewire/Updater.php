<?php

namespace App\Http\Livewire;

use App\Traits\UpdaterHelper;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithFileUploads;

class Updater extends Component
{
    use LivewireAlert;
    use UpdaterHelper;
    use WithFileUploads;

    protected $listeners = [
        'updater' => 'updater',
        'update' => 'update',
        "refresh" => '$refresh',
    ];

    public $service = '';

    public $fillable = [];
    public $contents = [];
    public $tabs = [];
    public $rules = [];
    public $messages = [];

    public $title = '';
    public $updater_id;
    public $size = '';

    public $model_id = '';

    public $data = [];

    public function mount($service)
    {
        $this->service = $service;
        $service = $this->setService($this->service);
        $this->fillable = $service->fillable();
        $this->setFields($this->fillable);
    }

    public function render()
    {
        $service = $this->setService($this->service);
        $this->getContent($service, "Updater");

        return view('livewire.updater');
    }

    public function updater($service, $id)
    {
        $this->service = $service;
        $this->model_id = $id;
        $service = $this->setService($this->service);
        $model =   $service->model($id);

        $inputs_units_names = [];

        if ($this->service == "FoodExchangesService") {
            foreach ($model->measurement_units as $name => $id) {
                $model->{str_replace(' ', '_', strtolower($name))} = $model->measurement_units[$name];
            }
        }

        foreach ($this->fillable as $field) {
            $this->{$field} = $model->{$field};
            if (in_array($field, $inputs_units_names)) {
            }
        }

        foreach ($this->contents as $content) {
            foreach ($content['inputs'] as $input) {

                if (in_array($input['name'], ['description_ar', 'description_en', 'other_info_ar', 'other_info_en'])) {
                    $this->emit('setDescriptionAr', $input['id'], $model->{$input['name']});
                }

                if ($input['type'] == 'select') {

                    if ($input['name'] == 'meals') {
                        $ids = json_encode($model->meals);
                        $this->emit('setSelect2Multi', meals(true), "meals_select_id_updater", $ids);
                        continue;
                    }

                    if ($input['name'] == "equipment_ids") {
                        $ids = json_encode($model->equipment_ids);
                        $this->emit('setSelect2Multi', equipment(true), "equipment_ids_select_id_updater", $ids);
                        continue;
                    }

                    if ($input['name'] == "recipes") {
                        $ids = json_encode($model->recipes);
                        $this->emit('setSelect2Multi', recipes(true), "recipes_select_id_updater", $ids);
                        continue;
                    }

                    if ($input['name'] == "muscles_ids") {
                        $ids = json_encode($model->muscles_ids);
                        $this->emit('setSelect2Multi', muscles(true), "muscles_ids_select_id_updater", $ids);
                        continue;
                    }

                    if ($input['name'] == "food_exchange_ids") {
                        $ids = json_encode($model->food_exchange_ids);
                        $this->emit('setSelect2Multi', food_exchanges(true), "food_exchange_ids_select_id_updater", $ids);
                        continue;
                    }

                    if ($input['name'] == "measurement_unit_ids") {
                        $ids = json_encode($model->measurement_unit_ids);
                        $this->emit('setSelect2Multi', measurement_units(true), "measurement_unit_ids_select_id_updater", $ids);
                        continue;
                    }

                    if ($input['name'] == "place") {
                        $ids = json_encode($model->place);
                        $this->emit('setSelect2Multi', [__("Gym") => "gym", __("Home") => "home"], "place_select_id_updater", $ids);
                        continue;
                    }

                    $value = $model->{$input['name']};
                    $this->emit('select2', "#" . $input['id'], $value);
                }
            }
        }

        $this->data = $this->getFieldsValues($this->fillable);
        $data = json_encode($this->data);
        $this->emit('setDataFields', $data);
    }

    public function update($data)
    {
        $service = $this->setService($this->service);
        $data = $this->getFieldsValues($this->fillable);

        if (!$this->makeValidation($service, $data, 'updateError', $this->model_id)) {
            return false;
        }

        $result = $service->update($data, $this->model_id);

        $this->alertMessage($result);

        $this->getZeroPoint();
    }
}

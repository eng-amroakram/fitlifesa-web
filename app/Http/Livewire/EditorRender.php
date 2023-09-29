<?php

namespace App\Http\Livewire;

use App\Traits\UpdaterHelper;
use Livewire\Component;

class EditorRender extends Component
{
    use UpdaterHelper;

    protected $listeners = [
        'setContent' => 'setContent',
    ];

    public $model_id = null;
    public $service = null;
    public $description = null;
    public $other_info = null;

    public function mount()
    {
    }

    public function render()
    {
        return view('livewire.editor-render');
    }

    public function setContent($service, $id)
    {
        $this->service = $service;
        $service = $this->setService($this->service);
        $this->model_id = $id;
        $model = $service->model($this->model_id);

        $this->description = $model->description;
        $this->other_info = $model->other_info;

        if ($this->description) {
            $this->emit('editorRenderDescription', $this->description);
        }

        if ($this->other_info) {
            $this->emit('editorRenderOtherInfo', $this->other_info);
        }
    }
}

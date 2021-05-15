<?php

namespace App\Http\Livewire;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ApiKeys extends Component
{

    public $state = [
    ];

    public string $newTokenName = '';

    public function mount()
    {
        $this->state['tokens'] = $this->getUserProperty()->tokens->toArray();
    }

    /**
     * Get the current user of the application.
     *
     * @return mixed
     */
    public function getUserProperty()
    {
        return Auth::user();
    }

    public function generateApiKey()
    {
        $this->validate();

        $token = $this->getUserProperty()->createToken($this->newTokenName, [
            'blurthat:legacy'
        ]);

        $this->state['tokens'][] = array_merge([

            'name' => $this->newTokenName,
        ], $token->toArray());

        $this->newTokenName = '';

        $this->emit('key-added');
    }

    public function rules(): array
    {
        return [
            'newTokenName' => ['required', 'string', 'not_in:' . Collection::wrap($this->state['tokens'])->pluck('name')->implode(',')]
        ];
    }


    public function render()
    {
        return view('livewire.api-keys');
    }
}

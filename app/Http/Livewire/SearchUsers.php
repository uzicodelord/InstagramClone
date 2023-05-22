<?php

namespace App\Http\Livewire;

use App\Models\User;
use Livewire\Component;

class SearchUsers extends Component
{
    public $searchTerm;

    public function render()
    {
        $searchTerm = '%' . $this->searchTerm . '%';
        $users = User::where('name', 'like', $searchTerm)->get();

        return view('livewire.search-users', ['users' => $users]);
    }
}

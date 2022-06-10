<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Log;

class UserLogs extends Component
{
    public function render()
    {
        $logs = Log::orderBy('waktu', 'DESC')->limit(10)->get();

        return view('livewire.user-logs', [
            'logs' => $logs
        ]);
    }
}

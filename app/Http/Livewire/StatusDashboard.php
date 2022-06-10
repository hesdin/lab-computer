<?php

namespace App\Http\Livewire;

use Livewire\Component;

use App\Models\Slip;
use App\Models\User;

class StatusDashboard extends Component
{
    public function render()
    {
        $akunPending = User::where('status', '0')->get()->count();
        $akunAktif = User::where('status', '1')->where('level', 'user')->orWhere('level', 'koasisten')->orWhere('level', 'asisten')->get()->count();
        $slip = Slip::get()->count();
        return view('livewire.status-dashboard', [
            'akunAktif' => $akunAktif,
            'akunPending' => $akunPending,
            'slip' => $slip
        ]);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DigitalChina extends Controller
{
    public function TS() {
        return view('digital.ts');
    }
    public function postTS($type, $sn, $error, $contract_number, $case_contact) {
        return view('pages.root');
    }
}

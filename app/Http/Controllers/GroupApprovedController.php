<?php

namespace App\Http\Controllers;

class GroupApprovedController extends Controller
{
    public function show()
    {
        return view('groups.approved', [
            'groupName' => 'Youth Retreat 2026'
        ]);
    }
}
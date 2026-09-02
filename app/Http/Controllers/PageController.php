<?php

namespace App\Http\Controllers;

use App\Models\CompanyProfile;
use App\Models\TeamMember;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        $teamMembers = TeamMember::active()->ordered()->get();
        $company = CompanyProfile::query()->first();

        return view('pages.about', compact('teamMembers', 'company'));
    }

    public function technology()
    {
        return view('pages.technology');
    }

    public function contact()
    {
        return view('pages.contact');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\View\View;

class CertificatePublicController extends Controller
{
    public function index(): View
    {
        $certificates = Certificate::orderByDesc('issue_date')->paginate(12);

        return view('certificates.public.index', compact('certificates'));
    }
}

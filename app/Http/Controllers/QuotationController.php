<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;
use Inertia\Response;

class QuotationController extends Controller
{
    public function basic()
    {
        return Inertia::render('Quotation/Measurement/BasicInfo');
    }

    public function upload()
    {
        return Inertia::render('Quotation/Measurement/UploadPic');
    }

    public function final()
    {
        return Inertia::render("Quotation/Measurement/FinalReview");
    }
}
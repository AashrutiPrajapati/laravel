<?php

namespace App\Http\Controllers;
use App\Models\Teacher;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $a=Teacher::find(1);
        print_r($a);die;
    }
}

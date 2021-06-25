<?php

namespace App\Http\Controllers;
use App\Models\Teacher;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        echo "<pre>";
        $a=Teacher::find(1)->student;
        print_r($a);die;
        // print_R(Student::find(1)->student; 
    }
}

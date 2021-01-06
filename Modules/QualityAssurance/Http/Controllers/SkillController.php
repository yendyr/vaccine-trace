<?php

namespace Modules\QualityAssurance\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class SkillController extends Controller
{
    use AuthorizesRequests;

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        return view('quality::pages.skill.index');
    }

    public function create()
    {
        return view('quality::pages.skill.form');
    }

    public function store(Request $request)
    {
        
    }

    public function show(Skill $Skill)
    {
        return view('quality::show');
    }

    public function edit(Skill $Skill)
    {
        return view('quality::edit');
    }

    public function update(Request $request, Skill $Skill)
    {
        
    }

    public function destroy(Skill $Skill)
    {
        
    }

    //Validation array default for this controller
    public function getValidationArray($request = null){
        // $validationArray = [
        //     'empid' => ['required', 'string', 'max:20', 'alpha_num', 'unique:hr_employees,empid'],
        //     'fullname' => ['required', 'string', 'max:50'],
        //     'nickname' => ['required', 'string', 'max:50'],
        //     'photo' => ['file', 'image', 'mimes:jpeg,png,jpg', 'max:1024'],
        //     'pob' => ['required', 'string', 'max:30'],
        //     'dob' => ['required', 'date'],
        //     'gender' => ['required', 'string', 'size:1'],
        //     'religion' => ['required', 'string', 'max:15'],
        //     'mobile01' => ['nullable', 'alpha_num', 'digits_between:1,13'],
        //     'mobile02' => ['nullable', 'alpha_num', 'digits_between:1,13'],
        //     'email' => ['required', 'string', 'max:50'],
        //     'bloodtype' => ['required', 'string', 'max:4'],
        //     'maritalstatus' => ['required', 'string', 'size:1'],
        //     'empdate' => ['required', 'date'],
        //     'cessdate' => ['required', 'date'],
        //     'probation' => ['required', 'string', 'size:1'],
        //     'cesscode' => ['required', 'string', 'size:2'],
        //     'recruitby' => ['required', 'string', 'max:4'],
        //     'emptype' => ['required', 'string', 'size:2'],
        //     'workgrp' => ['required', 'string', 'max:4'],
        //     'site' => ['nullable', 'string', 'max:4'],
        //     'accsgrp' => ['nullable', 'string', 'max:4'],
        //     'achgrp' => ['nullable', 'string', 'max:4'],
        //     'jobgrp' => ['nullable', 'string', 'max:4'],
        //     'costcode' => ['nullable', 'string', 'max:4'],
        //     'orgcode' => ['required', 'string', 'max:6'],
        //     'orglvl' => ['required', 'string', 'max:4'],
        //     'title' => ['required', 'string', 'max:2'],
        //     'jobtitle' => ['required', 'string', 'max:100'],
        //     'remark' => ['nullable', 'string', 'max:255'],
        //     'status' => ['required', 'min:0', 'max:1'],
        // ];

        // return $validationArray;
    }
}

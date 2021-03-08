<?php

namespace App\Http\Controllers\Auth;


use App\Abstracts\Http\Controller;
use App\Http\Requests\Install\Setting as Request;
use App\Utilities\Installer;

class Register extends Controller 
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'destroy']);
    }

    public function create()
    {
        return view('auth.register.create');
    
    }

     /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
      
        // Create company
        Installer::createCompany($request->get('company_name'), $request->get('company_email'), 'es-ES');

        // Create user
        Installer::createUser($request->get('user_email'), $request->get('user_password'), 'es-ES');

        $message = trans('auth.register_notification');

        flash($message);

        // Redirect to login
        $response = [
            'message'  => $message,
            'status'   => null,
            'error'    => false,
            'success'  => true,
            'data'     => null,
            'redirect' => route('login')
        ];

        return response()->json($response);
    }




}




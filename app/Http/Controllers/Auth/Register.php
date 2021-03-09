<?php

namespace App\Http\Controllers\Auth;


use App\Abstracts\Http\Controller;
use App\Http\Requests\Install\Setting as Request;
use App\Models\Auth\User;
use App\Models\Common\Company;

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
      
        try {
            // Create company
            app()->setLocale('es-ES');
            $data['name'] = $request->company_name;
            $data['email'] = $request->company_email;
            
            \DB::transaction(function () use ($request, $data) {

                $company = Company::create([$data]);
                setting()->setExtraColumns(['company_id' => $company->id]);
                setting()->forgetAll();

                    $user = User::create([
                        'name' => 'Demo',
                        'email' => $request->get('user_email'),
                        'password' => $request->get('user_password'),
                        'locale' =>  'es-ES',
                        'enabled' => '1',
                    ]);

                    $user->roles()->attach('1');
                    $user->companies()->attach($company->id);

                    setting()->set([
                        'company.name' => $request->get('company_name'),
                        'company.email' => $request->get('company_email'),
                        'default.currency' => 'USD',
                        'default.locale' => 'es-ES',
                    ]);
            
                    if (!empty($this->request->settings)) {
                        foreach ($this->request->settings as $name => $value) {
                            setting()->set([$name => $value]);
                        }
                    }
            
                    setting()->save();
                    setting()->forgetAll();
            });

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
         } catch (\Exception $th) {
            return response()->json($th->getMessage());       
         }
    }




}




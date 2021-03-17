<?php

namespace App\Jobs\Common;

use App\Abstracts\Job;
use App\Events\Common\CompanyCreated;
use App\Events\Common\CompanyCreating;
use App\Models\Common\Company;
use Artisan;

class CreateCompany extends Job
{
    protected $company;

    protected $request;

    /**
     * Create a new job instance.
     *
     * @param  $request
     */
    public function __construct($request)
    {
        $this->request = $this->getRequestInstance($request);
    }

    /**
     * Execute the job.
     *
     * @return Company
     */
    public function handle()
    {
        event(new CompanyCreating($this->request));
      
        \DB::transaction(function () {
            $this->company = Company::create($this->request->all());

            // Clear settings
            setting()->setExtraColumns(['company_id' => $this->company->id]);
            setting()->forgetAll();

            $this->callSeeds();

            $this->updateSettings();
        });

        event(new CompanyCreated($this->company));
       
        return $this->company;
    }

    protected function callSeeds()
    {
        // Set custom locale
        if ($this->request->has('locale')) {
            app()->setLocale($this->request->get('locale'));
        }

        // Company seeds
        Artisan::call('company:seed', [
            'company' => $this->company->id
        ]);

        if (!$user = user()) {
            return;
        }

        // Attach company to user logged in
        $user->companies()->attach($this->company->id);

        // User seeds
        Artisan::call('user:seed', [
            'user' => $user->id,
            'company' => $this->company->id,
        ]);
    }

    protected function updateSettings()
    {
        if($this->request->file('certificate')) {
            $certificate_file = file_get_contents($this->request->file('certificate'));
            $base64 = base64_encode($certificate_file);
            setting()->set([
                'company.certificate' => $base64,
            ]);
        }

        if($this->request->file('key_private')) {
            $key_private_file = file_get_contents($this->request->file('key_private'));
            $base64_key = base64_encode($key_private_file);
            setting()->set([
                'company.key_private' => $base64_key,
            ]);
        }

        if ($this->request->file('logo')) {
            $company_logo = $this->getMedia($this->request->file('logo'), 'settings', $this->company->id);

            if ($company_logo) {
                $this->company->attachMedia($company_logo, 'company_logo');

                setting()->set('company.logo', $company_logo->id);
            }
        }


        // Create settings
        setting()->set([
            'company.name'          => $this->request->get('name'),
            'company.email'         => $this->request->get('email'),
            'company.tax_number'    => $this->request->get('tax_number'),
            'company.phone'         => $this->request->get('phone'),
            'company.address'       => $this->request->get('address'),
            'default.currency'      => $this->request->get('currency'),
            'default.locale'        => $this->request->get('locale', 'en-GB'),

            'company.street'        => $this->request->get('street'),
            'company.no_int'        => $this->request->get('no_int'),
            'company.state'         => $this->request->get('state'),
            'company.colony'        => $this->request->get('colony'),
            'company.reference'     => $this->request->get('reference'),
            'company.no_ext'        => $this->request->get('no_ext'),
            'company.zone_code'     => $this->request->get('zone_code'),
            'company.municipality'  => $this->request->get('municipality'),
            'company.location'      => $this->request->get('location'),
            'company.country'       => $this->request->get('country'),
            'company.curp'          => $this->request->get('curp')

        ]);

        if (!empty($this->request->settings)) {
            foreach ($this->request->settings as $name => $value) {
                setting()->set([$name => $value]);
            }
        }

        setting()->save();
        setting()->forgetAll();
    }
}

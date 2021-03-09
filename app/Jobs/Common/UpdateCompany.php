<?php

namespace App\Jobs\Common;

use App\Abstracts\Job;
use App\Events\Common\CompanyUpdated;
use App\Events\Common\CompanyUpdating;
use App\Models\Common\Company;
use App\Traits\Users;

class UpdateCompany extends Job
{
    use Users;

    protected $company;

    protected $request;

    protected $active_company_id;

    /**
     * Create a new job instance.
     *
     * @param  $company
     * @param  $request
     */
    public function __construct($company, $request, $active_company_id)
    {
        $this->company = $company;
        $this->request = $this->getRequestInstance($request);
        $this->active_company_id = $active_company_id;
    }

    /**
     * Execute the job.
     *
     * @return Company
     */
    public function handle()
    {
        $this->authorize();

        event(new CompanyUpdating($this->company, $this->request));

        \DB::transaction(function () {
            $this->company->update($this->request->all());

            // Clear current and load given company settings
            setting()->setExtraColumns(['company_id' => $this->company->id]);
            setting()->forgetAll();
            setting()->load(true);

            if ($this->request->has('name')) {
                setting()->set('company.name', $this->request->get('name'));
            }

            if ($this->request->has('email')) {
                setting()->set('company.email', $this->request->get('email'));
            }

            if ($this->request->has('tax_number')) {
                setting()->set('company.tax_number', $this->request->get('tax_number'));
            }

            if ($this->request->has('phone')) {
                setting()->set('company.phone', $this->request->get('phone'));
            }

            if ($this->request->has('address')) {
                setting()->set('company.address', $this->request->get('address'));
            }

            if ($this->request->has('currency')) {
                setting()->set('default.currency', $this->request->get('currency'));
            }

            if ($this->request->has('locale')) {
                setting()->set('default.locale', $this->request->get('locale'));
            }

            if ($this->request->has('street')) {
                setting()->set('company.street', $this->request->get('street'));
            }

            if ($this->request->has('no_int')) {
                setting()->set('company.no_int', $this->request->get('no_int'));
            }
            
            if ($this->request->has('state')) {
                setting()->set('company.state', $this->request->get('state'));
            }
            
            if ($this->request->has('colony')) {
                setting()->set('company.colony', $this->request->get('colony'));
            }
            
            if ($this->request->has('reference')) {
                setting()->set('company.reference', $this->request->get('reference'));
            }
            
            if ($this->request->has('no_ext')) {
                setting()->set('company.no_ext', $this->request->get('no_ext'));
            }
            
            if ($this->request->has('zone_code')) {
                setting()->set('company.zone_code', $this->request->get('zone_code'));
            }
            
            if ($this->request->has('municipality')) {
                setting()->set('company.municipality', $this->request->get('municipality'));
            }

            if ($this->request->has('location')) {
                setting()->set('company.location', $this->request->get('location'));
            }
            
            if ($this->request->has('country')) {
                setting()->set('company.country', $this->request->get('country'));
            }
            
            if ($this->request->file('logo')) {
                $company_logo = $this->getMedia($this->request->file('logo'), 'settings', $this->company->id);

                if ($company_logo) {
                    $this->company->attachMedia($company_logo, 'company_logo');

                    setting()->set('company.logo', $company_logo->id);
                }
            }

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

            setting()->save();
            setting()->forgetAll();
        });

        event(new CompanyUpdated($this->company, $this->request));

        return $this->company;
    }

    /**
     * Determine if this action is applicable.
     *
     * @return void
     */
    public function authorize()
    {
        // Can't disable active company
        if (($this->request->get('enabled', 1) == 0) && ($this->company->id == $this->active_company_id)) {
            $message = trans('companies.error.disable_active');

            throw new \Exception($message);
        }

        // Check if user can access company
        if (!$this->isUserCompany($this->company->id)) {
            $message = trans('companies.error.not_user_company');

            throw new \Exception($message);
        }
    }
}

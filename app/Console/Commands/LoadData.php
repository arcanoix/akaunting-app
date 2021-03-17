<?php

namespace App\Console\Commands;

use App\Models\FiscalRegime;
use App\Models\KeyItemService;
use App\Models\KeyProductService;
use App\Models\MethodPayment;
use App\Models\SellTo;
use App\Models\ShapePayment;
use App\Models\TypeVoucher;
use DB;
use Exception;
use Illuminate\Console\Command;


class LoadData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'load-data:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'load data default require';
    

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
              
        try
        {
            $this->info('Process load load_product_service');

            $this->load_product_service();

            $this->info('load_product_service Installation refreshed');


            $this->info('read file shape_payment.json Installation refreshed');

            $this->load_shape_payment();
            
            $this->info('ShapePayment Installation refreshed');


            $this->info('Process load type voucher');

            $this->load_voucher();

            $this->info('load_voucher Installation refreshed');

            $this->info('Process load method payment');

            $this->load_method_payment();

            $this->info('method payment Installation refreshed');

            $this->info('Process load load_fiscal_regime');

            $this->load_fiscal_regime();

            $this->info('load_fiscal_regime Installation refreshed');

            $this->info('Process load load_sell_to');

            $this->load_sell_to();

            $this->info('load_sell_to Installation refreshed');

            $this->info('Process load load_key_service');

            $this->load_key_service();

            $this->info('load_key_service Installation refreshed');

           

            $this->info('Finished');
        }
        catch (Exception $exception)
        {
           return $this->error($exception->getMessage());
        }
    }


    protected function load_shape_payment()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        DB::table('shape_payments')->truncate();

        $shape_payment = storage_path() . "/json/shape_payment.json"; // ie: /var/www/laravel/app/storage/json/filename.json

        $shape_payment_json = json_decode(file_get_contents($shape_payment), true);
    
        foreach($shape_payment_json as $data)
        {
            ShapePayment::create([
                'name' => $data['name'],
                'key'  => $data['key'] 
            ]);
        }
        return true;
    }

    protected function load_voucher()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        DB::table('type_vouchers')->truncate();

        TypeVoucher::create([
            'name' => 'Ingreso',
            'description' => 'Ingreso',
            'key' => 'I'
        ]);

        TypeVoucher::create([
            'name' => 'Egreso',
            'description' => 'Egreso',
            'key' => 'E'
        ]);

        TypeVoucher::create([
            'name' => 'Traslado',
            'description' => 'Traslado',
            'key' => 'T'
        ]);

        TypeVoucher::create([
            'name' => 'Nómina',
            'description' => 'Nómina',
            'key' => 'N'
        ]);

        TypeVoucher::create([
            'name' => 'Pago',
            'description' => 'Pago',
            'key' => 'P'
        ]);

        TypeVoucher::create([
            'name' => 'Nota de Cargo',
            'description' => 'Nota de Cargo',
            'key' => 'I'
        ]);

        TypeVoucher::create([
            'name' => 'Recibo de Honorarios',
            'description' => 'Recibo de Honorarios',
            'key' => 'I'
        ]);

        TypeVoucher::create([
            'name' => 'Arrendamiento',
            'description' => 'Arrendamiento',
            'key' => 'I'
        ]);

        TypeVoucher::create([
            'name' => 'Donativo',
            'description' => 'Donativo',
            'key' => 'I'
        ]);

        TypeVoucher::create([
            'name' => 'Nota de Credito',
            'description' => 'Nota de Credito',
            'key' => 'E'
        ]);

        TypeVoucher::create([
            'name' => 'Nota de Debito',
            'description' => 'Nota de Debito',
            'key' => 'E'
        ]);

        TypeVoucher::create([
            'name' => 'Carta Porte',
            'description' => 'Carta Porte',
            'key' => 'T'
        ]);

        return true;
    }

    protected function load_method_payment()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        DB::table('method_payment')->truncate();

        MethodPayment::create([
            'name' => 'Pago en una sola exhibición',
            'description' => 'Pago en una sola exhibición',
            'key' => 'PUE'
        ]);

        MethodPayment::create([
            'name' => 'Pago en parcialidades o diferido',
            'description' => 'Pago en parcialidades o diferido',
            'key' => 'PPD'
        ]);
        
        return true;
    }

    protected function load_fiscal_regime()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        DB::table('fiscal_regime')->truncate();
        
        FiscalRegime::create([
            'name' => 'General de Ley Personas Morales',
            'description' => 'General de Ley Personas Morales',
            'key' => '601'
        ]);

        FiscalRegime::create([
            'name' => 'Personas Morales con Fines no Lucrativos',
            'description' => 'Personas Morales con Fines no Lucrativos',
            'key' => '603'
        ]);

        FiscalRegime::create([
            'name' => 'Sueldos y Salarios e Ingresos Asimilados a Salarios',
            'description' => 'Sueldos y Salarios e Ingresos Asimilados a Salarios',
            'key' => '605'
        ]);

        FiscalRegime::create([
            'name' => 'Arrendamiento',
            'description' => 'Arrendamiento',
            'key' => '606'
        ]);

        FiscalRegime::create([
            'name' => 'Demás ingresos',
            'description' => 'Demás ingresos',
            'key' => '608'
        ]);

        FiscalRegime::create([
            'name' => 'Consolidación',
            'description' => 'Consolidación',
            'key' => '609'
        ]);

        FiscalRegime::create([
            'name' => 'Residentes en el Extranjero sin Establecimiento Permanente en México',
            'description' => 'Residentes en el Extranjero sin Establecimiento Permanente en México',
            'key' => '610'
        ]);

        FiscalRegime::create([
            'name' => 'Ingresos por Dividendos (socios y accionistas)',
            'description' => 'Ingresos por Dividendos (socios y accionistas)',
            'key' => '611'
        ]);

        FiscalRegime::create([
            'name' => 'Personas Físicas con Actividades Empresariales y Profesionales',
            'description' => 'Personas Físicas con Actividades Empresariales y Profesionales',
            'key' => '612'
        ]);

        FiscalRegime::create([
            'name' => 'Ingresos por intereses',
            'description' => 'Ingresos por intereses',
            'key' => '614'
        ]);
        
        FiscalRegime::create([
            'name' => 'Sin obligaciones fiscales',
            'description' => 'Sin obligaciones fiscales',
            'key' => '616'
        ]);

        FiscalRegime::create([
            'name' => 'Sociedades Cooperativas de Producción que optan por diferir sus ingresos',
            'description' => 'Sociedades Cooperativas de Producción que optan por diferir sus ingresos',
            'key' => '620'
        ]);

        FiscalRegime::create([
            'name' => 'Incorporación Fiscal',
            'description' => 'Incorporación Fiscal',
            'key' => '621'
        ]);

        FiscalRegime::create([
            'name' => 'Actividades Agrícolas, Ganaderas, Silvícolas y Pesqueras',
            'description' => 'Actividades Agrícolas, Ganaderas, Silvícolas y Pesqueras',
            'key' => '622'
        ]);

        FiscalRegime::create([
            'name' => 'Opcional para Grupos de Sociedades',
            'description' => 'Opcional para Grupos de Sociedades',
            'key' => '623'
        ]);

        FiscalRegime::create([
            'name' => 'Coordinados',
            'description' => 'Coordinados',
            'key' => '624'
        ]);

        FiscalRegime::create([
            'name' => 'Hidrocarburos',
            'description' => 'Hidrocarburos',
            'key' => '628'
        ]);

        FiscalRegime::create([
            'name' => 'Régimen de Enajenación o Adquisición de Bienes',
            'description' => 'Régimen de Enajenación o Adquisición de Bienes',
            'key' => '607'
        ]);

        FiscalRegime::create([
            'name' => 'De los Regímenes Fiscales Preferentes y de las Empresas Multinacionales',
            'description' => 'De los Regímenes Fiscales Preferentes y de las Empresas Multinacionales',
            'key' => '629'
        ]);

        FiscalRegime::create([
            'name' => 'Enajenación de acciones en bolsa de valores',
            'description' => 'Enajenación de acciones en bolsa de valores',
            'key' => '630'
        ]);

        FiscalRegime::create([
            'name' => 'Régimen de los ingresos por obtención de premios',
            'description' => 'Régimen de los ingresos por obtención de premios',
            'key' => '615'
        ]);

        return true;
    }
  
    protected function load_sell_to()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        DB::table('sells_to')->truncate();

        SellTo::create([
            'name' => 'Persona Fisica / Persona Moral',
            'key' => 'Persona Fisica / Persona Moral'
        ]);

        SellTo::create([
            'name' => 'Venta Mostrador / Venta al publico en general',
            'key' => 'Venta Mostrador / Venta al publico en general'
        ]);

        return true;
    }

    protected function load_key_service()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        DB::table('key_item_service')->truncate();

        $key_item_service = storage_path() . "/json/key_item_service.json"; // ie: /var/www/laravel/app/storage/json/filename.json

        $key_item_service_json = json_decode(file_get_contents($key_item_service), true);
    
        foreach($key_item_service_json as $data)
        {
            KeyItemService::create([
                'name' => $data['name'],
                'key'  => $data['key'] 
            ]);
        }
        return true;
    }

    protected function load_product_service()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');

        DB::table('key_product_service')->truncate();

        $this->info("The file data key_product_service");
        $key_product_service = storage_path() . "/json/data.json"; // ie: /var/www/laravel/app/storage/json/filename.json
        $key_product_service_json = file_get_contents($key_product_service);
        $service_json = json_decode($key_product_service_json, true);
       
        $this->info("Process loading data ... wait....");
        
        if(file_exists($key_product_service))
        {
            foreach($service_json as $data)
            {
                KeyProductService::create([
                    'name' => $data['name'],
                    'key'  => $data['key'] 
                ]);
            }
        }else {
            return $this->error("The file doesn't exist");
        }

        return true;
    }

}

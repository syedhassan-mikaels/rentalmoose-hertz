<?php

namespace App\Console\Commands;

use App\Jobs\ImportSupplierStation;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\File\Exception\FileNotFoundException;

class ImportSupplierStationCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'importSupplierStation {filePath} {supplierID}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import Supplier Stations Data By FileName';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        try {
            $filePath = $this->argument('filePath');
            $supplierID = $this->argument('supplierID');

            if( Storage::disk('public')->has($filePath) ){
                ImportSupplierStation::dispatch( $filePath, $supplierID );
            }else{
                throw new FileNotFoundException( $filePath );
            }

        } catch (\Exception $e) {
            $this->error($e->getMessage());
            return 2;
        }

        $this->info("Imported supplier stations into DB successfully!!!");

        return 0;
    }
}

<?php
  
namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Jobs\ProductCSVData;
use Illuminate\Support\Facades\Bus;
  
class ProductImportController extends Controller
{
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function index(): View
    {
        return view('productsImport');
    }
  
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function store(Request $request)
    {
        if( $request->has('csv') ) {
            $csv    = file($request->csv);
            $chunks = array_chunk($csv, 1000);
            $header = [];
            $batch  = Bus::batch([])->dispatch();
  
            foreach ($chunks as $key => $chunk) {
            $data = array_map('str_getcsv', $chunk);
              
                    $header = $data;
                    unset($data);
                
                $batch->add(new ProductCSVData($data, $header));
            }
  
            return redirect()->route('products.import.index')
                            ->with('success', 'CSV Import added on queue. will update you once done.');
            
        }
    }
}
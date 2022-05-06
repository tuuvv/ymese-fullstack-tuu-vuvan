<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests;
use Session;
use Barryvdh\DomPDF\Facade as PDF;
use App\Models\clientApp;
use Carbon\Carbon;
use Illuminate\support\Facades\Redirect; // <-- giống return 
session_start();



class PdfController extends Controller
{
    public function index() {
        return view('index');
    }
    

    public function clientApp() {
        // $all = DB::table('client_apps')->paginate(5);
        $all = clientApp::sortable()->paginate(10);
        // var_dump($all);
        // die();
        return view('clientApp', compact('all'));
        

    }
    public function exportPdf(Request $request){
        $data =  explode('{"text":', $request);
        $string = str_replace("}", "",$data[1]);
       
        $string = mb_convert_encoding($string, 'HTML-ENTITIES', 'UTF-8');
    	$pdf = PDF::loadView('index',compact('string'));
        $path = public_path('pdf_docs/'); // <--- folder to store the pdf documents into the server;
        $fileName =  time().'.'. 'pdf' ; // <--giving the random filename,
        $pdf->save($path . '/' . $fileName);
        $generated_pdf_link = str_replace("/index.php", "",url('pdf_docs/'.$fileName)) ;
        $data = array();
        $data['urlpdf'] = $generated_pdf_link;
        $data['nameissue'] = time(). "issue";
        $data['created_at'] =Carbon::now();
        $data['updated_at'] =Carbon::now();
        DB::table('client_apps')->insert($data);
        try{
           
                if($generated_pdf_link){

                    return response()->json(['message' => 'Lưu pdf thành công chuỗi', 'code' =>'200','text' => $generated_pdf_link],200 );
                    
                }else{
                    return response()->json(['message' =>  'Không lưu pdf được chuỗi', 'code' =>'201'],200);
                }
            }catch (\Exception $e) {
                return response()->json(['result' => ['code'=>1,'masage' => $e->getMessage()]],200);
            }
    }
   

}


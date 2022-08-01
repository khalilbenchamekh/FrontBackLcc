<?php

namespace App\Http\Controllers\Genrator;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\BillDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;
use Dompdf\Dompdf;
use Barryvdh\DomPDF\PDF;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\File;


class PDFController extends Controller
{
    public function __construct()
    {
        set_time_limit(8000000);
    }

    private function store_file($content, $type, $fileName, $clientName)
    {
        try {
            $path = $this->createPathIfNotExisted($clientName, $type);
            File::put($path . $fileName, $content);
            $path = $path . $fileName;
            return $path;
        } catch (\Exception $e) {
            return null;
        }

    }

    private function createPathIfNotExisted($clientName, $type = null)
    {

        if ($type != null) {
            $filesArray = [
                'geoMapping',
                'geoMapping/' . $clientName,
                'geoMapping/' . $clientName . '/' . $type,
            ];
            foreach ($filesArray as $item) {
                $path = public_path() . '/' . $item . '/';
                if (!File::isDirectory($path)) {
                    File::makeDirectory($path, 0777, true, true);
                }
            }
            return public_path() . '/geoMapping/' . $clientName . '/' . $type . '/';
        } else {
            return public_path() . '/geoMapping/';
        }

    }

    public function generatePDF(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'devis_date_c' => 'required|date:Y-m-d',
                'devis_date_e' => 'required|date:Y-m-d',
                'client_n' => 'required|integer',
                'client_ice' => 'required|integer',
                'Etablissement' => 'required|string|max:255',
                'details' => 'string|max:255',
                'REF' => 'string|max:255',
//                'tableDetails.*.Ds' => 'required|string|max:255',
//                'tableDetails.*.Un' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
//                'tableDetails.*.pt' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
//                'tableDetails.*.pu' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
//                'tableDetails.*.qt' => 'required|integer',
                'type' => 'required|in:devis,factures,bon de commande,border de livraison'
            ]);
            if ($validator->fails()) {
                return response('erroe',400);
                return response($validator->errors(), 400);
            }
            $ref = $request->input("REF");
            $type = $request->input("type");
            $bills = null;
            if (empty($ref)) {
                $posts = Bill::orderBy('id', 'DESC')->get();
                if (isset($posts->id)) {
                    $ref = 1;
                } else {
                    $id = $posts->id;
                    $ref = $id + 1;
                }
                $bills = new Bill();
            } else {
                $bills = Bill::where('REF', 'like', $ref)->first();
                if (empty($bills)) {
                    if (count((array)$bills) == 0) {
                        $bills = new Bill();
                    }
                }
            }
            $bills->devis_date_e = $request->input("devis_date_e");
            $bills->devis_date_c = $request->input("devis_date_c");
            $bills->client_ice = $request->input("client_ice");
            $bills->client_n = $request->input("client_n");
            $bills->Etablissement = $request->input("Etablissement");
            $bills->details = empty($request->input("details")) ? 'details' : $request->input("details");
            $bills->REF = $ref;
            $bills->save();
            $tableDetails = $request->input("tableDetails");
            $csapat = json_decode($tableDetails, true);
//            $csapat = (array)$csapat;
            if (is_array($csapat) || is_object($csapat)) {
                $i = 0;

                foreach ($csapat as $detail) {
                    {
                        $bills_Details = new BillDetail();
                        $bills_Details->bills()->associate(
                            $bills->id
                        );

                        if (isset($detail['Un'])) {
                            $bills_Details->Un = $detail['Un'];
                            $bills_Details->Ds = $detail['Ds'];
                            $bills_Details->pt = $detail['pt'];
                            $bills_Details->pu = $detail['pu'];
                            $bills_Details->qt = $detail['qt'];
                        } else {
                            $bills_Details->Un = $detail[$i]->Un;
                            $bills_Details->Ds = $detail[$i]->Ds;
                            $bills_Details->pt = $detail[$i]->pt;
                            $bills_Details->pu = $detail[$i]->pu;
                            $bills_Details->qt = $detail[$i]->qt;
                        }

                        $bills_Details->save();
                        $i++;
                    }
                }
                $data = array(
                    'devis_n' => $ref,
                    'devis_date_c' => $request->input("devis_date_c"),
                    'devis_date_e' => $request->input("devis_date_e"),
                    'client_n' => $request->input("client_n"),
                    'client_ice' => $request->input("client_ice"),
                    'Etablissement' => $request->input("Etablissement"),
                    'details' => $request->input("details"),
                    "tableDetails" => $csapat,
                    "type" => $type
                );
                $fileName = $request->input("client_ice") . '_' . $ref . '.pdf';
                $html = View::make('htmlPDF', compact('data'));
                $dompdf = new DOMPDF();
                $dompdf->set_paper("A4", "portrait");
                $dompdf->load_html($html);
                $dompdf->render();
                $dompdf->stream($fileName);
                // Output the generated PDF to Browser
                $output = $dompdf->output();
                $name = $bills->client_n;
                $file = $this->store_file($output, $type, $fileName, $name);
                if ($file == null) {
                    abort(400, 'mal généré');
                }
                $headers = [
                    'Access-Control-Allow-Origin' => '*',
                ];
                return response()->download($file, $fileName, $headers);
            } else {
                abort(400, 'mal généré');

            }


        } catch (\Exception $e) {
            return response()->json($e);
        }


    }
}

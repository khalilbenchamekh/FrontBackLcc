<?php

namespace App\Http\Controllers\Genrator;

use App\Http\Controllers\Controller;
use App\Services\Bill\IBillService;
use App\Services\Organisation\IOrganisationService;
use App\Services\SaveFile\ISaveFileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Dompdf\Dompdf;
use Illuminate\Support\Facades\View;

class PDFController extends Controller
{
    private $iBillService;
    private $iSaveFileService;
    private $organisationService;

    public function __construct(IOrganisationService $organisationService,IBillService $iBillService,ISaveFileService $iSaveFileService)
    {
        $this->iBillService = $iBillService;
        $this->iSaveFileService = $iSaveFileService;
        $this->organisationService=$organisationService;
        set_time_limit(8000000);
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
                'type' => 'required|in:devis,factures,bon de commande,border de livraison'
            ]);
            if ($validator->fails()) {
                return response($validator->errors(), 400);
            }
            $ref = $request->input("REF");
            $type = $request->input("type");
            if (empty($ref)) {
                $ref = $this->iBillService->generateRef($type);
            }
            $res = $this->iBillService->get($ref);
            $bills = is_null($res) ? $this->iBillService->store($request,$ref) :$this->iBillService->update($res,$request,$ref);
            $tableDetails = $request->input("tableDetails");
            $csapat = json_decode($tableDetails, true);
            if (is_array($csapat) || is_object($csapat)) {
                $this->iBillService->storeBillDetail($request,$bills->id);
                $data = array(
                    'devis_n' => $ref,
                    'devis_date_c' => $bills->devis_date_c,
                    'devis_date_e' => $bills->devis_date_e,
                    'client_n' => $bills->client_n,
                    'client_ice' => $bills->client_ice,
                    'Etablissement' => $bills->Etablissement,
                    'details' => $bills->details,
                    "tableDetails" => $csapat,
                    "org" => $this->organisationService->getOrganisationWithSupInfo(),
                    "type" => $type
                );
                $fileName = $bills->cclient_ice . '_' . $ref . '.pdf';
                $html = View::make('htmlPDF', compact('data'));
                $dompdf = new DOMPDF();
                $dompdf->set_paper("A4", "portrait");
                $dompdf->load_html($html);
                $dompdf->render();
                $dompdf->stream($fileName);
                // Output the generated PDF to Browser
                $output = $dompdf->output();
                $name = $bills->client_n;
                $file = $this->iSaveFileService->store_file($output, $type, $fileName, $name);
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

<?php


namespace App\Services\InvoiceStatus;

use App\Helpers\LogActivity;
use App\Http\Requests\Enums\LogsEnumConst;
use App\Models\InvoiceStatus;
use App\Repository\InvoiceStatus\IInvoiceStatusRepository;

class InvoiceStatusService implements IInvoiceStatusService
{
    private $iInvoiceStatusRepository;
    public function __construct(IInvoiceStatusRepository $iInvoiceStatusRepository)
    {
        $this->iInvoiceStatusRepository=$iInvoiceStatusRepository;
    }
    public function save($request)
    {
        $invoiceStatus=$this->iInvoiceStatusRepository->save($request->all());
        if(!is_null($invoiceStatus)){
            $subject = LogsEnumConst::Add . LogsEnumConst::InvoiceStatus . $invoiceStatus->name;
            $logs = new LogActivity();
            $logs->addToLog($subject, $request);
            return $invoiceStatus;
        }
        return null;
    }
    public function index($request)
    {
        return $this->iInvoiceStatusRepository->index($request);
    }
    public function show($id)
    {
        return $this->iInvoiceStatusRepository->show($id);
    }
    public function update($id,$request)
    {
        $perInvoiceStatus=$this->show($id);
        if($perInvoiceStatus instanceof InvoiceStatus){
            $invoiceStatus=$this->iInvoiceStatusRepository->update($perInvoiceStatus,$request);
            if(!is_null($invoiceStatus)){
                $subject = LogsEnumConst::Update . LogsEnumConst::InvoiceStatus . $invoiceStatus->name;
                $logs = new LogActivity();
                $logs->addToLog($subject, $request);
                return $invoiceStatus;
            }
        }
        return null;
    }
    public function destroy($request)
    {
        $res= $this->iInvoiceStatusRepository->destroy($request['id']);
        if($res === 0 || is_null($res)){
            return false;
        }else{
            $subject = LogsEnumConst::Delete . LogsEnumConst::Intermediate . $request['Name'];
            $logs = new LogActivity();
            $logs->addToLog($subject, $request);
        }
        return true;
    }
}

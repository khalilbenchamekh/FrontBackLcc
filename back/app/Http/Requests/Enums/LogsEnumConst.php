<?php
/**
 * Created by PhpStorm.
 * User: khali
 * Date: 24/06/2020
 * Time: 16:12
 */

namespace App\Http\Requests\Enums;


class LogsEnumConst
{
    const  Add= 'a crée une ';
    const  Update= 'a modifié une ';
    const  Delete = 'a supprimé une ';
    const Business='Affaire ';
    const FolderTech='Dossier Technique ';

    const BusinessNature='Affaire Nature ';
    const FolderTechNature='Dossier Technique Nature';
    const Cadastral ='les consultaion cadastraux ';
    const BusinessSituation='Situation Affaire  ';
    const FolderTechSituation='Situation Dossier Technique ';
    const BusinessFees='Business Fees';
    const FileModel='FileModel';

    const FolderTechFees='Dossier Technique Fees';

    const BusinessManagement="Business Management";
    const Fees='Fees';

    const Mission='Mission';

    const Charge='Charge';

    const Affaire='Affaire';
    const TypesChange='TypesChange';
    const FeesFolderTech='FeesFolderTech';

    const Intermediate='Intermediate';
    const InvoiceStatus ='InvoiceStatus';

    const Client='Client ';
    const Employee='Employee ';
    const Particular='Particular ';
    const GSC='Grand Chantier ';
    const Load='Charge ';
    const LoadType='Type de Charge ';
    const Bill='Facture ';

    const BillDetails = 'Facture Details';


}

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

    const BusinessManagement="Business Management";
    const Fees='Fees';

    const Charge='Charge';

    const Client='Client ';
    const Employee='Employee ';
    const Particular='Particular ';
    const GSC='Grand Chantier ';
    const Load='Charge ';
    const LoadType='Type de Charge ';
}

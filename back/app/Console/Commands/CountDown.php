<?php

namespace App\Console\Commands;

use App\Events\CountDown as CountDownEvent;
use App\Models\Affaire;
use App\Models\BusinessManagement;
use App\Models\FolderTech;
use App\Models\GreatConstructionSites;
use App\Models\Notification;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CountDown extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'countdoun:owner';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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

       $from = Carbon::now()->toDateString();
        $to = date("Y-m-d", strtotime(Carbon::now() . "+15 days"));

        $great = GreatConstructionSites::whereBetween('DATE_LAI', [$from, $to])
            ->select('Market_title')
            ->get();

        $affaire = Affaire::whereBetween('DATE_LAI', [$from, $to])
            ->select('REF')
            ->get();

        $folderTech = FolderTech::whereBetween('DATE_LAI', [$from, $to])
            ->select('REF')
            ->get();
        $arrayNotification = [];
        if (count($great) !== 0) {
            $temp = [];
            foreach ($great as $item) {
                array_push($temp, [
                    'description' => "Le Grand Chantier sous référence" . $item->Market_title . "arrivera à échéance le" . $to,
                    'created_at' => $to, 'updated_at' => $to
                ]);
            }
            array_push($arrayNotification, $temp);

        }
        if (count($affaire) !== 0) {

            $temp = [];
            foreach ($affaire as $item) {
                array_push($temp, [
                    'description' => "L'affaire sous référence" . $item->REF . "arrivera à échéance le" . $to,
                    'created_at' => $to, 'updated_at' => $to
                ]);
            }
            array_push($arrayNotification, $temp);
        }
        if (count($folderTech) !== 0) {
            $temp = [];
            foreach ($folderTech as $item) {
                array_push($temp, [
                    'description' => " Le dossier technique sous référence " . $item->REF . "arrivera à échéance le" . $to,
                    'created_at' => $to, 'updated_at' => $to
                ]);
            }
            array_push($arrayNotification, $temp);
        }

        if (!empty($arrayNotification)) {
            $notifications = $arrayNotification[0];
            if (!empty($notifications)) {
                $not = new Notification();
                $not->newQuery()->insert($notifications);
                broadcast(new CountDownEvent($notifications));
            }
        }
    }
}

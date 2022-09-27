<?php

namespace App\Providers;

use App\Models\ChatMessage;
use App\Models\LogActivity;
use App\Observers\ChatMessageObserver;
use App\Observers\LogActivityObserver;
use App\Repository\Admin\AdminRepository;
use App\Repository\Admin\IAdminRepository;
use App\Repository\Admin\IConversationRepository;
use App\Repository\Affaire\AffaireRepository;
use App\Repository\Affaire\IAffaireRepository;
use App\Repository\AffaireNature\AffaireNatureRepository;
use App\Repository\AffaireNature\IAffaireNatureRepository;
use App\Repository\AffaireSituation\AffaireSituationRepository;
use App\Repository\AffaireSituation\IAffaireSituationRepository;
use App\Repository\Conversation\ConversationRepository;
use App\Repository\Employee\EmployeeRepository;
use App\Repository\Employee\IEmployeeRepository;
use App\Repository\FileLoad\FileLoadRepository;
use App\Repository\FileLoad\IFileLoadRipository;
use App\Repository\Client\IClientRepository;
use App\Repository\Client\ClientRepository;
use App\Repository\Fees\FeesRepository;
use App\Repository\Fees\IFeesRepository;
use App\Repository\FeesFolderTech\FeesFolderTechRepository;
use App\Repository\FeesFolderTech\IFeesFolderTechRepository;
use App\Repository\FolderTech\FolderTechRepository;
use App\Repository\FolderTech\IFolderTechRepository;
use App\Repository\FolderTechNature\FolderTechNatureRepository;
use App\Repository\FolderTechNature\IFolderTechNatureRepository;
use App\Repository\FolderTechSituation\FolderTechSituationRepository;
use App\Repository\FolderTechSituation\IFolderTechSituationRepository;
use App\Repository\Intermediate\IIntermediateRepository;
use App\Repository\Intermediate\IntermediateRepository;
use App\Repository\InvoiceStatus\IInvoiceStatusRepository;
use App\Repository\InvoiceStatus\InvoiceStatusRepository;
use App\Repository\Role\IRoleRepository;
use App\Repository\Role\RoleRepository;
use App\Services\AffaireNature\AffaireNatureService;
use App\Services\AffaireNature\IAffaireNatureService;
use App\Services\AffaireSituation\AffaireSituationService;
use App\Services\AffaireSituation\IAffaireSituationService;
use App\Services\Employee\EmployeeService;
use App\Services\Employee\IEmployeeService;
use App\Services\FileLoad\FileLoadService;
use App\Services\FileLoad\IFileLoadService;
use App\Services\Role\IRoleService;
use App\Services\Role\RoleService;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Services\Load\ILoadService;
use App\Services\Load\LoadService;
use App\Repository\Load\LoadRepository;
use App\Repository\Load\ILoadRepository;
use App\Repository\LoadTypes\ILoadTypesRepository;
use App\Repository\LoadTypes\LoadTypesRepository;
use App\Repository\Organisation\IOrganisationRepository;
use App\Repository\Organisation\OrganisationRepository;
use App\Repository\TypesCharge\ITypesChargeRepository;
use App\Repository\TypesCharge\TypesChargeRepository;
use App\Services\Admin\AdminService;
use App\Services\Admin\IAdminService;
use App\Services\Affaire\AffaireService;
use App\Services\Affaire\IAffaireService;
use App\Services\Client\ClientService;
use App\Services\Client\IClientService;
use App\Services\Fees\FeesService;
use App\Services\Fees\IFeesService;
use App\Services\FeesFolderTech\FeesFolderTechService;
use App\Services\FeesFolderTech\IFeesFolderTechService;
use App\Services\FolderTech\FolderTechService;
use App\Services\FolderTech\IFolderTechService;
use App\Services\FolderTechNature\FolderTechNatureService;
use App\Services\FolderTechNature\IFolderTechNatureService;
use App\Services\FolderTechSituation\FolderTechSituationService;
use App\Services\FolderTechSituation\IFolderTechSituationService;
use App\Services\ImageService;
use App\Services\ImageService\IImageService;
use App\Services\Intermediate\IIntermediateService;
use App\Services\Intermediate\IntermediateService;
use App\Services\InvoiceStatus\IInvoiceStatusService;
use App\Services\InvoiceStatus\InvoiceStatusService;
use App\Services\LoadTypes\LoadTypesService;
use App\Services\LoadTypes\ILoadTypesService;
use App\Services\Organisation\IOrganisationService;
use App\Services\Organisation\OrganisationService;
use App\Services\SaveFile\ISaveFileService;
use App\Services\SaveFile\SaveFileService;
use App\Services\TypesCharge\ITypesChargeService;
use App\Services\TypesCharge\TypesChargeService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Schema::defaultStringLength(191);
        // Services
        $this->app->bind(IOrganisationService::class,OrganisationService::class);
        $this->app->bind(IImageService::class,ImageService::class);
        $this->app->bind(IAdminService::class,AdminService::class);

        $this->app->bind(IAffaireNatureService::class,AffaireNatureService::class);
        $this->app->bind(ILoadService::class,LoadService::class);
        $this->app->bind(ILoadTypesService::class,LoadTypesService::class);
        $this->app->bind(ISaveFileService::class,SaveFileService::class);
        $this->app->bind(IFileLoadService::class,FileLoadService::class);
        $this->app->bind(IAffaireSituationService::class,AffaireSituationService::class);
        $this->app->bind(IEmployeeService::class,EmployeeService::class);
        $this->app->bind(IRoleService::class,RoleService::class);
        $this->app->bind(IClientService::class,ClientService::class);
        $this->app->bind(IFeesService::class,FeesService::class);
        $this->app->bind(IAffaireService::class,AffaireService::class);
        $this->app->bind(IAffaireService::class,AffaireService::class);
        $this->app->bind(IFolderTechService::class,FolderTechService::class);
        $this->app->bind(IFeesFolderTechService::class,FeesFolderTechService::class);
        $this->app->bind(IFolderTechNatureService::class,FolderTechNatureService::class);
        $this->app->bind(IFolderTechSituationService::class,FolderTechSituationService::class);
        $this->app->bind(IIntermediateService::class,IntermediateService::class);
        $this->app->bind(IInvoiceStatusService::class,InvoiceStatusService::class);
        $this->app->bind(ITypesChargeService::class,TypesChargeService::class);
        $this->app->bind(IAdminService::class,AdminService::class);




        //  Repositories
        $this->app->bind(IOrganisationRepository::class,OrganisationRepository::class);
        $this->app->bind(IAdminRepository::class,AdminRepository::class);
        $this->app->bind(IAffaireNatureRepository::class,AffaireNatureRepository::class);
        $this->app->bind(ILoadRepository::class,LoadRepository::class);
        $this->app->bind(ILoadTypesRepository::class,LoadTypesRepository::class);
        $this->app->bind(IFileLoadRipository::class,FileLoadRepository::class);
        $this->app->bind(IAffaireSituationRepository::class,AffaireSituationRepository::class);
        $this->app->bind(IEmployeeRepository::class,EmployeeRepository::class);
        $this->app->bind(IRoleRepository::class,RoleRepository::class);
        $this->app->bind(IConversationRepository::class,ConversationRepository::class);
        $this->app->bind(IClientRepository::class,ClientRepository::class);
        $this->app->bind(IFeesRepository::class,FeesRepository::class);
        $this->app->bind(IAffaireRepository::class,AffaireRepository::class);
        $this->app->bind(IFolderTechRepository::class,FolderTechRepository::class);
        $this->app->bind(IFeesFolderTechRepository::class,FeesFolderTechRepository::class);
        $this->app->bind(IFolderTechNatureRepository::class,FolderTechNatureRepository::class);
        $this->app->bind(IFolderTechSituationRepository::class,FolderTechSituationRepository::class);
        $this->app->bind(IIntermediateRepository::class,IntermediateRepository::class);
        $this->app->bind(IInvoiceStatusRepository::class,InvoiceStatusRepository::class);
        $this->app->bind(ITypesChargeRepository::class,TypesChargeRepository::class);
        $this->app->bind(IAdminRepository::class,AdminRepository::class);

        if($this->app->environment()==='local'){
            if(isset($_SERVER['REQUEST_METHOD'],$_SERVER['REQUEST_URI'])){
                file_put_contents('php://stdout',"\e[34m{HTTP::{$_SERVER['REQUEST_METHOD']}] \e[0m{$_SERVER['REQUEST_URI']}\n");
            }

            DB::listen(/**
             * @param QueryExecuted $query
             */
                function (QueryExecuted $query)
                {
                    file_put_contents('php://stdout',"\e[34m{$query->sql}\t\e[37m" . json_encode($query->bindings) . "\t\e[32m{$query->time}ms\e[0m\n");

                });
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        ChatMessage::observe(ChatMessageObserver::class);
        LogActivity::observe(LogActivityObserver::class);
    }
}

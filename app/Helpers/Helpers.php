<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Models\Invoice;

class Helpers
{

    /**
     * activeLink
     *
     * @param  mixed $links
     * @return void
     */
    public static function  activeLink(array $links)
    {
        $route = Route::current()->getName();

        if (in_array($route, $links)) {
            echo "active";
        } else {
            echo "";
        }
    }
    /**
     * selectMonthInvoices
     *
     * @param  mixed $mois
     * @return void
     */
    public static function selectMonthInvoices(string $mois)
    {
        return DB::select('select * from afm_invoices where date like  :mois', ["mois" => "%".$mois."%"]);
    }

    /**
     * selectYearInvoices
     *
     * @param  mixed $mois
     * @return void
     */
    public static function selectYearInvoices($year)
    {
        $data = DB::select('select * from afm_invoices where date like  :year', ["year" => "%".$year."%"]);
        return $data; 
    }
    
     /**
     * yearMonthHasInvoices
     *
     * @param  mixed $mois
     * @return void
     */
    public static function yearMonthHasInvoices($year, $month)
    {
        $data = $invoices = Invoice::where("date", "LIKE", "%".$year."%")->where("date", "LIKE", "%".$month."%")->get();
        
        // if(count($data) > 0 ){
        // return true;     
        // }else{
        // return false; 
        // }
        
        return $data;
    }

    /**
     * displayMonthName
     *
     * @param  mixed $month
     * @return void
     */
    public static function displayMonthName(string $month)
    {
        $months = ["Jan" => "Janvier", "Fev" => "Fevrier", "Mars" => "Mars", "Avr" => "Avril", "Mai" => "Mai",
        "Juin" => "Juin", "Juil" => "Juillet", "Août" => "Août", "Sept" => "Septembre", "Oct" => "Octobre",
         "Nov" => "Novembre", "Dec" => "Decembre"];
         return $months[$month];
    }

        /**
     * setMaliMarocAmount
     *
     * @param  mixed $type
     * @param  mixed $montant_total
     * @param  mixed $montant_recevoir
     * @return void
     */
    public static function setMaliMarocAmount($type, $montant_total, $montant_recevoir)
    {
    // Prend Le dernier transfert effectué
    //    Ajoute le montant total au montant du Mali et le montant à recevoir est rétiré du montant au Maroc si réception (Entrant)
    //    Retire le montant à récevoir au montant du Mali et on ajoute le montant total au montant du Maroc si envoi (Sortant)
    $capitaux = [];
    $lastOpx = DB::table("afm_invoices")->orderBy('id', 'desc')->first();
     if (!empty($lastOpx) && $type == "Sortant") {
        $capitaux["montant_mali"] = number_format(filter_var($lastOpx->montant_mali, FILTER_SANITIZE_NUMBER_INT) - $montant_recevoir) ;
        $capitaux["montant_maroc"] = number_format(filter_var($lastOpx->montant_maroc, FILTER_SANITIZE_NUMBER_INT) + $montant_total);
     }elseif (!empty($lastOpx) && $type == "Entrant") {
        $capitaux["montant_mali"] = number_format(filter_var($lastOpx->montant_mali, FILTER_SANITIZE_NUMBER_INT) + $montant_total);
        $capitaux["montant_maroc"] = number_format(filter_var($lastOpx->montant_maroc, FILTER_SANITIZE_NUMBER_INT) - $montant_recevoir) ;
    }
    return $capitaux;
    }
}

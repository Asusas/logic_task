<?php

namespace App\Http\Controllers;

use App\CatModel;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class PageController extends Controller
{
    public function index($n)
    {

        /*________________________Reiksmiu "cache'avimo" logika________________________*/

        // Sukuriame $value kintamaji is kurio gausime tam tikro N puslapio "cache'uojamu" kaciu reiksmes
        $value = Cache::get('cats' . $n);

        // Tikriname ar reiksmes yra ir ar praejes laikas nuo N puslapio uzsikrovimo yra daugiau nei 60 sekunciu
        if (!$value || (time() - $value['time']) > 60) {

            // Kreipiames i "CatModel" modelio metoda, kuriame apsiraseme atsitiktines tvarkos 3-iju kaciu radima
            $cats = CatModel::getCatsRandom();

            // Sukeliame reiksmes kurios bus "cache'uojamos" bei pradedame skaiciuoti pradini laika
            $value = [
                'cats' => $cats,
                'time' => time(),
            ];

            // Atsitikus taip jei programa reiksmiu nerado, graziname laika i pradine padeti
        } else {
            $value['time'] = time();
        }

        // "cache'uojame" reiksmes 60 sekundziu. Perkrovus puslapi nepraejus nustatytam laikui, reiksmes islieka tokios pacios
        // Praejus 60 sekundziu - kaciu reiksmes pasikeicia
        Cache::put('cats' . $n, $value, 60);

        /*________________________ Tinklapio vizitu logika:________________________*/

        // Sukuriame $total kintamaji is kurio gausime visu puslapiu vizito reiksmes
        $total = Cache::get('statsTotal');

        // Jei kintamojo nera, vizita visada prilyginame vienetui
        if (!$total) {
            $total = 1;
            // Kitu atveju kiekvieno vizito (puslapio perkrovimo metu) vizita padidiname vienetu
        } else {
            $total += 1;
        }

        /*________________________ Tam tikro N puslapio vizitu logika:________________________*/
        /* ANALOGISKA VISO TINKLAPIO VIZITU LOGIKAI */

        $pageStats = Cache::get('pageStats' . $n);

        if (!$pageStats) {
            $pageStats = 1;
        } else {
            $pageStats += 1;
        }

        // Issaugome visus tinklapio vizitus
        Cache::forever('statsTotal', $total);

        // Issaugome tam tikro N puslapio vizitus
        Cache::forever('pageStats' . $n, $pageStats);

        /*________________________ Tinklapio Log failo logika:________________________*/
        Log::channel('catLog')->info(
            ['total website visits' => $total,
                'visits for ' . $n . ' page' => $pageStats]
        );

        /*________________________ Isvedame kintamuosius i view faila kad galetume atvaizduoti informacija narsykleje:________________________*/
        return view('index', [
            'cats' => $value['cats'],
            'total' => $total,
            'pageStats' => $pageStats,
            'page' => $n,
        ]);

        // return view('index', $value);

    }
}
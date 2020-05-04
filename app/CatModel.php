<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CatModel extends Model
{
    public static function getCatsRandom()
    {
        // Nuskaitome reiksmes is pasirinkto cats.txt failo
        $catArray = file(storage_path('app/cats.txt'));

        // Suskaiciuojame masyvo elementu kieki
        $totalCats = count($catArray) - 3;

        // Atsitiktine tvarka isrenkame viena masyvo elementa
        $j = rand(0, $totalCats);

        // Sukuriame tuscia masyva i kuri talpinsime 3 kates
        $cats = [];

        // Kadangi reikia 3-iju kaciu, sukame cikla 3 kartus
        for ($i = 0; $i < 3; $i++) {

            // Surandame 3-iju is eiles einanciu kaciu masyvo indeksus
            $index = $j + $i;

            // Sukeliame rastas kates i $cats masyva kartu su masyvo indekso reiksmemis bei kaciu pavadinimais
            // ($index - 1) - sioje vietoje atimame vienetea, nes ciklo "sukimo metu" index reiksmes pasislenka per vieneto reiksme,
            // todel graziname 3-iju kaciu index reiksmes i vieta
            array_push($cats, ($index - 1) . ' - ' . $catArray[$index]);
        }
        // Graziname sukurta masyva kuriame patalpintos 3 kates
        return $cats;
    }
}
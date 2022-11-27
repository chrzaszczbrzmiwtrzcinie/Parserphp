<?php
    include("simple_html_dom.php");
    
    $html = file_get_html("wo_for_parse.html");

    $csv = [];

    $head = [];

    $csv[]=$head;
    //Find element's in "wo_for_parse.html"
    foreach($html->find(".card") as $item)
    {
        $td = $item->find("h3");
        $temp =[];
        for($i=0;$i<sizeof($td); $i++)
        {
            //Replace Space
            $text = $td[$i]->text();
            if(empty($text)){
                continue;
            }
            $temp[]=trim(preg_replace('!\s+!', ' ', $text));

            //Delete single elements from code "ghetto flex"
            $temp = array_filter($temp, static function ($element) {
                return $element !== "REPAIR";
            });
            $temp = array_filter($temp, static function ($element) {
                return $element !== "Emergency-4hrs";
            });
            $temp = array_filter($temp, static function ($element) {
                return $element !== "COOK LINE/PREP";
            });
            $temp = array_filter($temp, static function ($element) {
                return $element !== "Exhaust System/Kitchen";
            });
            $temp = array_filter($temp, static function ($element) {
                return $element !== "Exhaust Fan";
            });
            $temp = array_filter($temp, static function ($element) {
                return $element !== "Repair";
            });


        }
        if(sizeof($td)>0)
        {
            $csv[]=$temp;
        }
    }

    $file = fopen("data.csv","w");
    fputs($file, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));
    foreach($csv as $line)
    {
        fputcsv($file,$line);
    }
    fclose($file);

    var_dump($csv);


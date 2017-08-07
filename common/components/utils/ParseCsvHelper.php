<?php
/**
 * Project: quark.
 * Date: 3/16/2016
 * Name: TDT
 */

namespace app\components\utils;


class ParseCsvHelper
{
    /**
     * @param string $fileCsv
     * @return array
     *
     */
    public static function parseCsv($fileCsv)
    {
        if (!file_exists($fileCsv)) {
            return [];
        }
        $file = fopen($fileCsv, 'r');

        $header = str_getcsv(fgets($file), ",");
        $count = count($header);
        $result = [];
        $k = 0;
        while (($line = fgets($file)) !== false) {
            $csv = str_getcsv($line, ",");

            for($i = 0; $i < $count; $i++){
                $result[$k][$header[$i]] = isset($csv[$i]) ? $csv[$i] : null;
            }
            $k++;
        }

        fclose($file);

        return $result;
    }
}
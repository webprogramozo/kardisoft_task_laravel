<?php

namespace App\Kardisoft;

use DOMDocument;
use DOMElement;
use DOMXPath;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Http;

class MedLoader{
    /**
     * @throws OgyeiDownloadFailureException
     */
    public static function loadOgyeiItem($id): string{
        $response = Http::setClient(new Client(['verify' => false]))->get("https://ogyei.gov.hu/gyogyszeradatbazis&action=show_details&item={$id}");
        if(!$response->successful()){
            throw new OgyeiDownloadFailureException();
        }
        return $response->body();
    }
    public static function getElementsFromHtml($html, $xpathQuery):array{
        $dom = new DOMDocument('1.0', 'UTF8');
        if ($html instanceof DOMElement){
            $cloned = $html->cloneNode(true);
            $dom->appendChild($dom->importNode($cloned, true));
        } else{
            @$dom->loadHTML($html);
        }
        $xpath = new DOMXPath($dom);
        $elements = $xpath->query($xpathQuery);
        $result = [];
        /** @var DOMElement $element */
        foreach ($elements as $element){
            $result[] = trim($element->textContent);
        }
        return $result;
    }

    /**
     * @throws MalformedDateStringException
     */
    public static function parseDate($ogyeiDate): string{
        if (preg_match('/^(\d{4}).(\d{2}).(\d{2})$/', $ogyeiDate, $match)){
            return "{$match[1]}-{$match[2]}-{$match[3]}";
        }
        throw new MalformedDateStringException('Wrong date received! ' . $ogyeiDate);
    }

    /**
     * @throws MissingMedicineNameException
     * @throws MissingMedicineDataException
     * @throws MalformedDateStringException
     */
    public static function loadAllItems():array{
        $resultSet = [];
        foreach (array_filter(explode("\n", file_get_contents(resource_path() . '/source.txt')), 'intval') as $id){
            $resultSet[] = self::loadItem(trim($id));
        }
        return $resultSet;
    }

    /**
     * @param $id
     * @return array
     * @throws MalformedDateStringException
     * @throws MissingMedicineDataException
     * @throws MissingMedicineNameException
     */
    public static function loadItem($id): array{
        $keyMap = [
            "Nyilvántartási szám"                => "med_reg_number",
            "Hatóanyag"                          => "med_active_ingredient",
            "ATC-kód"                            => "med_atc_code",
            "Készítmény engedélyezésének dátuma" => "med_auth_date",
        ];
        $result = self::loadOgyeiItem($id);
        $name = self::getElementsFromHtml($result, "//h3[@class[contains(., 'gy-content__title')]]");
        if (count($name) != 1){
            throw new MissingMedicineNameException('No medicine name found!');
        }
        $keys = self::getElementsFromHtml($result, "//div[@class[contains(., 'gy-content__top-table')]]/div[@class[contains(.,'top-table__line')]]/*[1]");
        $values = self::getElementsFromHtml($result, "//div[@class[contains(., 'gy-content__top-table')]]/div[@class[contains(.,'top-table__line')]]/*[2]");

        $return = [
            'med_id'   => $id,
            'med_name' => $name[0],
        ];

        foreach ($keys as $index => $key){
            if (array_key_exists($key, $keyMap)){
                $return[$keyMap[$key]] = $values[$index];
            }
        }
        $return['med_auth_date'] = self::parseDate($return['med_auth_date']);
        if (count($return) != 6){
            throw new MissingMedicineDataException('Partial or malformed data detected!');
        }
        return $return;
    }
}

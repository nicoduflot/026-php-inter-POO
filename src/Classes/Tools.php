<?php

namespace Utils;

use PDO;
use Exception;

class Tools implements Config_interface{
    static $pi = 3.1415926535898;
    /**
     * @param float rayon
     * @return float
     *  */
    public static function circo($rayon): float
    {
        return 2 * self::$pi * $rayon;
    }

    /**
     * @param any data
     */
    public static function prePrint($data)
    {
        echo '<pre>' . var_dump($data) . '</pre>';
    }

    /**
     * @param string page
     */
    public static function classActive($page)
    {
        if (basename($_SERVER['PHP_SELF']) === $page) {
            echo 'active';
        }
    }

    /*
    public static function setBdd($host, $dbname, $user = 'root', $psw = ''){
        try{
            $bdd = new PDO('mysql:host='.$host.';dbname='.$dbname.';charset=UTF8', $user, $psw, array(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION));
        }
        catch(Exception $e){
            die('Erreur de connexion : '. $e->getMessage());
        };
        return $bdd;
    }
    */

    /* on se sert de l'interface Config_interface pour récupérer la configuration du mysql local ou en ligne */
    public static function setBdd()
    {
        try {
            $bdd = new PDO('mysql:host=' . Config_interface::DBHOST . ';dbname=' . Config_interface::DBNAME . ';charset=UTF8', Config_interface::DBUSER, Config_interface::DBUPSW, array(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION));
        } catch (Exception $e) {
            die('Erreur de connexion : ' . $e->getMessage());
        }
        return $bdd;
    }

    /**
     * @param string $sql
     * @param array $params
     * @return mixed
     */
    public static function modBdd($sql, $params = []) : mixed{
        $bdd = self::setBdd();
        $req = $bdd->prepare($sql);
        $req->execute($params);
        return $req;
    }

    /**
     * @param string $sql
     * @param array $params
     * @return mixed
     */
    public static function insertBdd($sql, $params = []) : mixed{
        $bdd = self::setBdd();
        $req = $bdd->prepare($sql);
        $req->execute($params);
        return $bdd->lastInsertId();
    }
    /**
     * @param string $title
     * @return string
     */
    public static function slugTitle($title) : string{
        $slugTitle = str_replace("'", "-", $title);
        $slugTitle = str_replace(" ", "-", $slugTitle);
        $slugTitle = str_replace("?", "", $slugTitle);
        $slugTitle = str_replace("!", "", $slugTitle);
        $slugTitle = str_replace(";", "", $slugTitle);
        $slugTitle = str_replace(",", "", $slugTitle);
        $slugTitle = str_replace(".", "", $slugTitle);
        $slugTitle = str_replace("\"", "", $slugTitle);
        $slugTitle = str_replace("----", "-", $slugTitle);
        $slugTitle = str_replace("---", "-", $slugTitle);
        $slugTitle = str_replace("--", "-", $slugTitle);
        $a = array( 'À',    'Á',    'Â',    'Ã',    'Ä',    'Å',    'Æ',    'Ç',    
                    'È',    'É',    'Ê',    'Ë',    'Ì',    'Í',    'Î',    'Ï',    
                    'Ð',    'Ñ',    'Ò',    'Ó',    'Ô',    'Õ',    'Ö',    'Ø',    
                    'Ù',    'Ú',    'Û',    'Ü',    'Ý',    'ß',    'à',    'á',    
                    'â',    'ã',    'ä',    'å',    'æ',    'ç',    'è',    'é',    
                    'ê',    'ë',    'ì',    'í',    'î',    'ï',    'ñ',    'ò',    
                    'ó',    'ô',    'õ',    'ö',    'ø',    'ù',    'ú',    'û',    
                    'ü',    'ý',    'ÿ',    'Ā',    'ā',    'Ă',    'ă',    'Ą',    
                    'ą',    'Ć',    'ć',    'Ĉ',    'ĉ',    'Ċ',    'ċ',    'Č',    
                    'č',    'Ď',    'ď',    'Đ',    'đ',    'Ē',    'ē',    'Ĕ',    
                    'ĕ',    'Ė',    'ė',    'Ę',    'ę',    'Ě',    'ě',    'Ĝ',    
                    'ĝ',    'Ğ',    'ğ',    'Ġ',    'ġ',    'Ģ',    'ģ',    'Ĥ',    
                    'ĥ',    'Ħ',    'ħ',    'Ĩ',    'ĩ',    'Ī',    'ī',    'Ĭ',    
                    'ĭ',    'Į',    'į',    'İ',    'ı',    'Ĳ',    'ĳ',    'Ĵ',    
                    'ĵ',    'Ķ',    'ķ',    'Ĺ',    'ĺ',    'Ļ',    'ļ',    'Ľ',    
                    'ľ',    'Ŀ',    'ŀ',    'Ł',    'ł',    'Ń',    'ń',    'Ņ',    
                    'ņ',    'Ň',    'ň',    'ŉ',    'Ō',    'ō',    'Ŏ',    'ŏ',    
                    'Ő',    'ő',    'Œ',    'œ',    'Ŕ',    'ŕ',    'Ŗ',    'ŗ',    
                    'Ř',    'ř',    'Ś',    'ś',    'Ŝ',    'ŝ',    'Ş',    'ş',    
                    'Š',    'š',    'Ţ',    'ţ',    'Ť',    'ť',    'Ŧ',    'ŧ',    
                    'Ũ',    'ũ',    'Ū',    'ū',    'Ŭ',    'ŭ',    'Ů',    'ů',    
                    'Ű',    'ű',    'Ų',    'ų',    'Ŵ',    'ŵ',    'Ŷ',    'ŷ',    
                    'Ÿ',    'Ź',    'ź',    'Ż',    'ż',    'Ž',    'ž',    'ſ',    
                    'ƒ',    'Ơ',    'ơ',    'Ư',    'ư',    'Ǎ',    'ǎ',    'Ǐ',    
                    'ǐ',    'Ǒ',    'ǒ',    'Ǔ',    'ǔ',    'Ǖ',    'ǖ',    'Ǘ',    
                    'ǘ',    'Ǚ',    'ǚ',    'Ǜ',    'ǜ',    'Ǻ',    'ǻ',    'Ǽ',    
                    'ǽ',    'Ǿ',    'ǿ
                    ');     
                    
                    
                    $b = array(
                    'A',    'A',    'A',    'A',    'A',    'A',    'AE',   'C',    
                    'E',    'E',    'E',    'E',    'I',    'I',    'I',    'I',    
                    'D',    'N',    'O',    'O',    'O',    'O',    'O',    'O',    
                    'U',    'U',    'U',    'U',    'Y',    's',    'a',    'a',    
                    'a',    'a',    'a',    'a',    'ae',   'c',    'e',    'e',    
                    'e',    'e',    'i',    'i',    'i',    'i',    'n',    'o',    
                    'o',    'o',    'o',    'o',    'o',    'u',    'u',    'u',    
                    'u',    'y',    'y',    'A',    'a',    'A',    'a',    'A',    
                    'a',    'C',    'c',    'C',    'c',    'C',    'c',    'C',    
                    'c',    'D',    'd',    'D',    'd',    'E',    'e',    'E',    
                    'e',    'E',    'e',    'E',    'e',    'E',    'e',    'G',    
                    'g',    'G',    'g',    'G',    'g',    'G',    'g',    'H',    
                    'h',    'H',    'h',    'I',    'i',    'I',    'i',    'I',    
                    'i',    'I',    'i',    'I',    'i',    'IJ',   'ij',   'J',    
                    'j',    'K',    'k',    'L',    'l',    'L',    'l',    'L',    
                    'l',    'L',    'l',    'L',    'l',    'N',    'n',    'N',    
                    'n',    'N',    'n',    'n',    'O',    'o',    'O',    'o',    
                    'O',    'o',    'OE',   'oe',   'R',    'r',    'R',    'r',    
                    'R',    'r',    'S',    's',    'S',    's',    'S',    's',    
                    'S',    's',    'T',    't',    'T',    't',    'T',    't',    
                    'U',    'u',    'U',    'u',    'U',    'u',    'U',    'u',    
                    'U',    'u',    'U',    'u',    'W',    'w',    'Y' ,   'y',    
                    'Y',    'Z',    'z',    'Z',    'z',    'Z',    'z',    's',    
                    'f',    'O',    'o',    'U',    'u',    'A',    'a',    'I',    
                    'i',    'O',    'o',    'U',    'u',    'U',    'u',    'U',    
                    'u',    'U',    'u',    'U',    'u',    'A',    'a',    'AE',   
                    'ae',   'O', 'o');
        $slugTitle = str_replace($a, $b, $slugTitle);
        return $slugTitle;
    }
}

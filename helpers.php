<?php

/**
 * CKEditör gibi editörlerden gelen veriyi sınırlamak için kullanılır.
 * @param string $string
 * @return string
 */
function strLimitWithStrip(string $string, $limit = 100, $end = '...'): string
{
    return str_limit(strip_tags($string), $limit, $end);
}

/**
 * Anlık olarak kullanılan cihaz mobil ise true döner.
 * @return bool
 */
function isMobile(): bool
{
    $userAgent = $_SERVER["HTTP_USER_AGENT"];
    return preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up.browser|up.link|webos|wos)/i", $userAgent);
}

/**
 * Array içinde verilen key'de ki de değerleri siler.
 * @param array $data
 * @param array $keys
 */
function unsetMultiple(array &$data, array $keys): void
{
    foreach ($keys as $key) {
        unset($data[$key]);
    }
}

/**
 * Dosya boyutlarının daha anlaşılır olması için kullanılır.
 * @param int $bytes
 * @return array
 */
function unitSizeForHuman(int $bytes): array
{
    $returnByte = $bytes;
    if ($bytes >= 1073741824) {
        $returnByte = number_format($bytes / 1073741824, 2);
        $unit = 'GB';
    } elseif ($bytes >= 1048576) {
        $returnByte = number_format($bytes / 1048576, 2);
        $unit = 'MB';
    } elseif ($bytes >= 1024) {
        $returnByte = number_format($bytes / 1024, 2);
        $unit = 'KB';
    } elseif ($bytes >= 0) {
        $returnByte = $bytes;
        $unit = 'byte';
    } else {
        trigger_error('Bytes must be bigger then 0.', E_USER_ERROR);
    }

    return [$returnByte, $unit];
}

/**
 * Verilen String'in tüm harflerini büyütür ve ya küçültür.
 * @param string $to
 * @param string $string
 * @return string
 */
function strto(string $to, string $string): string
{
    if ($to == 'lower') {
        $return = mb_strtolower(str_replace(array('I', 'Ğ', 'Ü', 'Ş', 'İ', 'Ö', 'Ç'), array('ı', 'ğ', 'ü', 'ş', 'i', 'ö', 'ç'), $string), 'utf-8');
    } elseif ($to == 'upper') {
        $return = mb_strtoupper(str_replace(array('ı', 'ğ', 'ü', 'ş', 'i', 'ö', 'ç'), array('I', 'Ğ', 'Ü', 'Ş', 'İ', 'Ö', 'Ç'), $string), 'utf-8');
    } else {
        trigger_error('First parameter must be "lower" or "upper"', E_USER_ERROR);
    }
    return $return;
}

/**
 * Verilen string'in kelimelerinin ilk harfini büyütür.
 * @param string $string
 * @return string
 */
function ucwordsTR(string $string): string
{
    return ltrim(mb_convert_case(str_replace(array(' I', ' ı', ' İ', ' i'), array(' I', ' I', ' İ', ' İ'), ' ' . $string), MB_CASE_TITLE, "UTF-8"));
}

/**
 * Verilen string'in sadece ilk kelimesinin ilk harfini büyütür.
 * @param string $string
 * @return string
 */
function ucfirstTR(string $string): string
{
    $tmp = preg_split("//u", $string, 2, PREG_SPLIT_NO_EMPTY);
    return mb_convert_case(str_replace("i", "İ", $tmp[0]), MB_CASE_TITLE, "UTF-8") . $tmp[1];
}

/**
 * Türkçe dilinde tarihte ki ay ve gün isimlerini çevirir.
 * @param string $format
 * @param string $datetime
 * @return string
 */
function dateFormatTR(string $format = 'd m Y', $datetime = 'now'): string
{
    $date = date($format, strtotime($datetime));
    $monthAndDays = array(
        'January' => 'Ocak',
        'February' => 'Şubat',
        'March' => 'Mart',
        'April' => 'Nisan',
        'May' => 'Mayıs',
        'June' => 'Haziran',
        'July' => 'Temmuz',
        'August' => 'Ağustos',
        'September' => 'Eylül',
        'October' => 'Ekim',
        'November' => 'Kasım',
        'December' => 'Aralık',

        "Monday" => 'Pazartesi',
        "Tuesday" => 'Salı',
        "Wednesday" => 'Çarşamba',
        "Thursday" => 'Perşembe',
        "Friday" => 'Cuma',
        "Saturday" => 'Cumartesi',
        "Sunday" => 'Pazar',
    );

    return str_replace(array_keys($monthAndDays), array_values($monthAndDays), $date);
}

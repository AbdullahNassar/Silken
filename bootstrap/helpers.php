<?php
/**
* Checks if the given string is valid json string.
*
* @param  json  $string [description]
* @return boolean         [description]
*/
function is_json($string) {
    return is_string($string) && is_array(json_decode($string, true)) && (json_last_error() == JSON_ERROR_NONE) ? true : false;
}

/**
* Checks if the given string is valid url string.
*
* @param  json  $string [description]
* @return boolean         [description]
*/
function is_url($string) {
    // Remove all illegal characters from a url
    $string = filter_var($string, FILTER_SANITIZE_URL);
    return (!filter_var($string, FILTER_VALIDATE_URL) === false);
}

/**
* Return custom flash status msgs for json response.
*
* @param  string $type path of msg type
* @param  array $data override
* @param  array $options extra options
* @return array       [description]
*/

function msg($type,array $data = [], array $options = [])
{
    // if the msg is not string
    if(!is_string($type)){
        return $type;
    }

    $path = explode('.', $type);

    // check the count of path
    if(count($path) != 2){
        return $type;
    }

    $status = $path[0];
    $process = $path[1];

    // load the custom msgs array
    $msgs = trans('global.msg');

    return array_merge([
        'status' => $status,
        'title' => isset($data['title']) ? $data['title'] : $msgs[$status][$process]['title'],
        'msg' => isset($data['msg']) ? $data['msg'] : $msgs[$status][$process]['msg'],
    ], $options);
}

/**
* Determine if the current locale is ltr.
* @return boolean
*/
function is_ltr()
{
    return App\Locale::where('name' , app()->getLocale())->first()->isLtr();
}


/**
* Convert the given text to its slug representation.
*
* @param string $text text to be converted
* @param boolean $translate convert arabic into franco
* @return string
*/
function slugify($text) {
    $replace = [
        '&lt;' => '', '&gt;' => '', '&#039;' => '', '&amp;' => '',
        '&quot;' => '', 'À' => 'A', 'Á' => 'A', 'Â' => 'A', 'Ã' => 'A', 'Ä' => 'Ae',
        '&Auml;' => 'A', 'Å' => 'A', 'Ā' => 'A', 'Ą' => 'A', 'Ă' => 'A', 'Æ' => 'Ae',
        'Ç' => 'C', 'Ć' => 'C', 'Č' => 'C', 'Ĉ' => 'C', 'Ċ' => 'C', 'Ď' => 'D', 'Đ' => 'D',
        'Ð' => 'D', 'È' => 'E', 'É' => 'E', 'Ê' => 'E', 'Ë' => 'E', 'Ē' => 'E',
        'Ę' => 'E', 'Ě' => 'E', 'Ĕ' => 'E', 'Ė' => 'E', 'Ĝ' => 'G', 'Ğ' => 'G',
        'Ġ' => 'G', 'Ģ' => 'G', 'Ĥ' => 'H', 'Ħ' => 'H', 'Ì' => 'I', 'Í' => 'I',
        'Î' => 'I', 'Ï' => 'I', 'Ī' => 'I', 'Ĩ' => 'I', 'Ĭ' => 'I', 'Į' => 'I',
        'İ' => 'I', 'Ĳ' => 'IJ', 'Ĵ' => 'J', 'Ķ' => 'K', 'Ł' => 'K', 'Ľ' => 'K',
        'Ĺ' => 'K', 'Ļ' => 'K', 'Ŀ' => 'K', 'Ñ' => 'N', 'Ń' => 'N', 'Ň' => 'N',
        'Ņ' => 'N', 'Ŋ' => 'N', 'Ò' => 'O', 'Ó' => 'O', 'Ô' => 'O', 'Õ' => 'O',
        'Ö' => 'Oe', '&Ouml;' => 'Oe', 'Ø' => 'O', 'Ō' => 'O', 'Ő' => 'O', 'Ŏ' => 'O',
        'Œ' => 'OE', 'Ŕ' => 'R', 'Ř' => 'R', 'Ŗ' => 'R', 'Ś' => 'S', 'Š' => 'S',
        'Ş' => 'S', 'Ŝ' => 'S', 'Ș' => 'S', 'Ť' => 'T', 'Ţ' => 'T', 'Ŧ' => 'T',
        'Ț' => 'T', 'Ù' => 'U', 'Ú' => 'U', 'Û' => 'U', 'Ü' => 'Ue', 'Ū' => 'U',
        '&Uuml;' => 'Ue', 'Ů' => 'U', 'Ű' => 'U', 'Ŭ' => 'U', 'Ũ' => 'U', 'Ų' => 'U',
        'Ŵ' => 'W', 'Ý' => 'Y', 'Ŷ' => 'Y', 'Ÿ' => 'Y', 'Ź' => 'Z', 'Ž' => 'Z',
        'Ż' => 'Z', 'Þ' => 'T', 'à' => 'a', 'á' => 'a', 'â' => 'a', 'ã' => 'a',
        'ä' => 'ae', '&auml;' => 'ae', 'å' => 'a', 'ā' => 'a', 'ą' => 'a', 'ă' => 'a',
        'æ' => 'ae', 'ç' => 'c', 'ć' => 'c', 'č' => 'c', 'ĉ' => 'c', 'ċ' => 'c',
        'ď' => 'd', 'đ' => 'd', 'ð' => 'd', 'è' => 'e', 'é' => 'e', 'ê' => 'e',
        'ë' => 'e', 'ē' => 'e', 'ę' => 'e', 'ě' => 'e', 'ĕ' => 'e', 'ė' => 'e',
        'ƒ' => 'f', 'ĝ' => 'g', 'ğ' => 'g', 'ġ' => 'g', 'ģ' => 'g', 'ĥ' => 'h',
        'ħ' => 'h', 'ì' => 'i', 'í' => 'i', 'î' => 'i', 'ï' => 'i', 'ī' => 'i',
        'ĩ' => 'i', 'ĭ' => 'i', 'į' => 'i', 'ı' => 'i', 'ĳ' => 'ij', 'ĵ' => 'j',
        'ķ' => 'k', 'ĸ' => 'k', 'ł' => 'l', 'ľ' => 'l', 'ĺ' => 'l', 'ļ' => 'l',
        'ŀ' => 'l', 'ñ' => 'n', 'ń' => 'n', 'ň' => 'n', 'ņ' => 'n', 'ŉ' => 'n',
        'ŋ' => 'n', 'ò' => 'o', 'ó' => 'o', 'ô' => 'o', 'õ' => 'o', 'ö' => 'oe',
        '&ouml;' => 'oe', 'ø' => 'o', 'ō' => 'o', 'ő' => 'o', 'ŏ' => 'o', 'œ' => 'oe',
        'ŕ' => 'r', 'ř' => 'r', 'ŗ' => 'r', 'š' => 's', 'ù' => 'u', 'ú' => 'u',
        'û' => 'u', 'ü' => 'ue', 'ū' => 'u', '&uuml;' => 'ue', 'ů' => 'u', 'ű' => 'u',
        'ŭ' => 'u', 'ũ' => 'u', 'ų' => 'u', 'ŵ' => 'w', 'ý' => 'y', 'ÿ' => 'y',
        'ŷ' => 'y', 'ž' => 'z', 'ż' => 'z', 'ź' => 'z', 'þ' => 't', 'ß' => 'ss',
        'ſ' => 'ss', 'ый' => 'iy', 'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G',
        'Д' => 'D', 'Е' => 'E', 'Ё' => 'YO', 'Ж' => 'ZH', 'З' => 'Z', 'И' => 'I',
        'Й' => 'Y', 'К' => 'K', 'Л' => 'L', 'М' => 'M', 'Н' => 'N', 'О' => 'O',
        'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T', 'У' => 'U', 'Ф' => 'F',
        'Х' => 'H', 'Ц' => 'C', 'Ч' => 'CH', 'Ш' => 'SH', 'Щ' => 'SCH', 'Ъ' => '',
        'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'YU', 'Я' => 'YA', 'а' => 'a',
        'б' => 'b', 'в' => 'v', 'г' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo',
        'ж' => 'zh', 'з' => 'z', 'и' => 'i', 'й' => 'y', 'к' => 'k', 'л' => 'l',
        'м' => 'm', 'н' => 'n', 'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's',
        'т' => 't', 'у' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'c', 'ч' => 'ch',
        'ш' => 'sh', 'щ' => 'sch', 'ъ' => '', 'ы' => 'y', 'ь' => '', 'э' => 'e',
        'ю' => 'yu', 'я' => 'ya'
    ];
    // make a human readable string
    $text = strtr($text, $replace);
    $text = preg_replace('/[^A-Za-z0-9-\pL]+/u', '-', $text);

    $text = trim($text, ' -');
    $text = preg_replace_callback('/([A-Za-z0-9]+)/', function ($match) {
        return strtolower($match[0]);
    }, $text);
    return $text;
}

/**
* Paginate a laravel colletion or array of items.
*
* @param  array $items   array to paginate
* @param  int $perPage number of pages
* @return Illuminate\Pagination\LengthAwarePaginator          Paginator class
*/
function paginate($items, $perPage)
{
    if(is_array($items)){
        $items = collect($items);
    }

    return new Illuminate\Pagination\LengthAwarePaginator(
        $items->forPage(Illuminate\Pagination\Paginator::resolveCurrentPage() , $perPage),
        $items->count(), $perPage,
        Illuminate\Pagination\Paginator::resolveCurrentPage(),
        ['path' => Illuminate\Pagination\Paginator::resolveCurrentPath()]
    );
}

/**
 * Convert a timestamp to arabic date/time format,
 *
 * @param  string $format format string
 * @param  bigint $time   timestamp
 * @return string        formatted arabic date.
 */
function ar_date($time = null, $format = 'l dS F Y h:i:s A')
{
    $time = $time ?: time();
    $Arabic = app()->make(\I18N_Arabic::class);
    return $Arabic->date($format, $time);
}

/**
 * Generate random number with size N.
 *
 * @param  integer $length length of the number
 * @return number         random number
 */
function num_random($length = 16){
    $num = '';
    for ($i=0; $i < $length; $i++) {
        $num .= mt_rand(0 , 9);
    }
    return $num;
}

/**
 * Fetch the alternative language.
 *
 * @return string|url
 */
function alt_locale()
{
    switch (session('locale')) {
        case 'ar':
            return route('locale', [
                    'locale' => 'en'
                ]);
        case 'en':
            return route('locale', [
                    'locale' => 'ar'
                ]);
        default:
            return route('locale', [
                'locale' => App\Setting::first()->default_locale
            ]);
    }
}
/**
 * Format a number based on its decimality.
 *
 * @param  integer|float  $number  number to be formatted
 * @param  integer $decimal number of decimal places
 * @return string          the formatted number
 */
function num_format($number, $decimal = 2)
{
    if($number == round($number)){
        return number_format($number);
    }

    return number_format($number,$decimal);
}

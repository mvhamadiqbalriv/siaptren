<?php

use App\Models\Menu;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

if (!function_exists('getNavigations')) {
    /**
     * @see get navigations from database
     * 
     * @return collection
     */
    function getNavigations()
    {
        if (Cache::has('navigation')) {
            $nav = Cache::get('navigation');
        } else {
            $nav = Menu::with(['subMenus' => function ($query) {
                $query->orderBy('id');
            }])->whereNull('main_menu')
                ->get()->groupBy('jenis');

            Cache::forever('navigation', $nav);
        }

        return $nav;
    }
}

if (!function_exists('dateFormat')) {
    /**
     * Change date format
     * @param string $date
     * @param string $format
     * 
     * @return string
     */
    function dateFormat($date, $format)
    {
        $time = strtotime($date);
        $split = str_split($format);

        $date = '';
        foreach ($split as $char) {
            $split_date = date($char, $time);
            $date .= days($split_date) ?? (shortDays($split_date) ?? (months($split_date) ?? (shortMonths($split_date) ?? $split_date)));
        }
        return $date;
    }
}

if (!function_exists('days')) {
    function days($key = null)
    {
        $days = [
            'Sunday' => 'Ahad',
            'Monday' => 'Senin',
            'Tuesday' => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday' => 'Kamis',
            'Friday' => 'Jum\'at',
            'Saturday' => 'Sabtu',
        ];

        return $key ? ($days[$key] ?? null) : $days;
    }
}

if (!function_exists('shortDays')) {
    function shortDays($key = null)
    {
        $days = [
            'Sun' => 'Aha',
            'Mon' => 'Sen',
            'Tue' => 'Sel',
            'Wed' => 'Rab',
            'Thu' => 'Kam',
            'Fri' => 'Jum',
            'Sat' => 'Sab',
        ];

        return $key ? ($days[$key] ?? null) : $days;
    }
}

if (!function_exists('months')) {
    function months($key = null)
    {
        $months = [
            'January' => 'Januari',
            'February' => 'Februari',
            'March' => 'Maret',
            'May' => 'Mei',
            'June' => 'Juni',
            'July' => 'Juli',
            'August' => 'Agustus',
            'September' => 'September',
            'October' => 'Oktober',
            'November' => 'November',
            'December' => 'Desember',
        ];

        return $key ? ($months[$key] ?? null) : $months;
    }
}

if (!function_exists('shortMonths')) {
    function shortMonths($key = null)
    {
        $months = [
            'Jan' => 'Jan',
            'Feb' => 'Feb',
            'Mar' => 'Mar',
            'May' => 'Mei',
            'Jun' => 'Jun',
            'Jul' => 'Jul',
            'Aug' => 'Agu',
            'Sep' => 'Sep',
            'Oct' => 'Okt',
            'Nov' => 'Nov',
            'Dec' => 'Des',
        ];

        return $key ? ($months[$key] ?? null) : $months;
    }
}

if (!function_exists('reverseDate')) {
    /**
     * Reverse date format
     * 
     * @param string $date
     * @param string $separator
     * 
     * @return string 
     */
    function reverseDate($date, $separator = '-')
    {
        $arr_date = explode($separator, $date);

        return implode($separator, array_reverse($arr_date));
    }
}

if (!function_exists('generateKode')) {
    /**
     * Generate last code from database with given table name
     * 
     * @param string $table
     * @param string $format
     * @param string $column
     * @param int $digits
     * 
     * @return string
     */
    function generateKode($table, $column, $format, $digits = 3)
    {
        $last = DB::table($table)->where("$column", 'like', "$format%")->max($column);
        $next = ($last ? substr($last, strlen($format), $digits) : 0) + 1;

        return $format . sprintf("%0{$digits}s", $next);
    }
}

if (!function_exists('responseMessage')) {
    /**
     * Return response message for user
     * 
     * @param string $status success or error
     * @param string $message
     * @param int $code a valid status code http
     * @param boolean $refresh
     * @param array $errors
     * 
     * @return json
     */
    function responseMessage($status = 'success', $message = 'Data berhasil disimpan', $code = 200, $refresh = false, $errors = [])
    {
        if (count($errors)) {
            return response()->json([
                'message' => $message,
                'errors' => $errors
            ], 422);
        }

        $code = $status == 'error' ? 500 : $code;
        return response()->json([
            'status' => $status,
            'message' => $message,
            'shouldRefresh' => $refresh
        ], $code);
    }
}

if (!function_exists('pageTitle')) {
    /**
     * Get page title for breadcrumb
     * 
     * @param string $path
     * 
     * @return string
     */

    function pageTitle($path)
    {
        $exp = explode('/', $path);
        $title = (array_reverse($exp))[0];
        return ucwords(str_replace('-', ' ', $title));
    }
}

if (!function_exists('spp')) {
    /**
     * Get biaya spp
     * 
     * @return int
     */
    function spp()
    {
        return 100000;
    }
}

if (!function_exists('numberFormat')) {
    /**
     * Format number
     * 
     * @param int|float $angka
     * @param int $digit_decimal
     * @param string $prefix
     * 
     * @return string
     */
    function numberFormat($angka, $digit_decimal, $prefix = null)
    {
        $angka = number_format($angka, $digit_decimal, ',', '.');
        return ($prefix ?? '') . $angka;
    }
}

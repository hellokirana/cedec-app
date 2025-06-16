<?php

use App\Models\Kategori;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

if (!function_exists('ListPerPage')) {
    function ListPerPage()
    {
        return ['10' => '10', '25' => '25', '50' => '50', '100' => '100', '500' => '500', '1000' => '1000'];
    }
}

if (!function_exists('status_active')) {
    function status_active()
    {
        return array(
            1 => 'Aktif',
            2 => 'Draft',
        );
    }
}

if (!function_exists('status_publish')) {
    function status_publish()
    {
        return array(
            1 => 'Publish',
            2 => 'Draft',
        );
    }
}

if (!function_exists('jam_layanan')) {
    function jam_layanan()
    {
        return array(
            '07:00:00' => '07:00',
            '08:00:00' => '08:00',
            '09:00:00' => '09:00',
            '10:00:00' => '10:00',
            '11:00:00' => '11:00',
            '12:00:00' => '12:00',
            '13:00:00' => '13:00',
            '14:00:00' => '14:00',
            '15:00:00' => '15:00',
            '16:00:00' => '16:00',
            '17:00:00' => '17:00',
            '18:00:00' => '18:00',
            '19:00:00' => '19:00',
            '20:00:00' => '20:00',
        );
    }
}


if (!function_exists('jenkel')) {
    function jenkel()
    {
        return array(
            1 => 'Laki-Laki',
            2 => 'Perempuan'
        );
    }
}



if (!function_exists('list_bank')) {
    function list_bank()
    {
        return array(
            "Bank Mandiri",
            "Bank Central Asia (BCA)",
            "Bank Rakyat Indonesia (BRI)",
            "Bank Negara Indonesia (BNI)",
            "Bank Syariah Indonesia (BSI)",
            "Bank CIMB Niaga",
            "Bank Danamon",
            "Bank Tabungan Negara (BTN)",
            "Bank Permata",
            "Bank OCBC NISP",
            "Bank Maybank Indonesia",
            "Bank Mega",
            "Bank Bukopin",
            "Bank BTPN",
            "Bank Jago",
            "Bank Sinarmas"
        );
    }
}


if (!function_exists('list_status_pembayaran')) {
    function list_status_pembayaran()
    {
        return array(
            1 => 'Menunggu Bayar',
            2 => 'Menunggu Approval',
            3 => 'Terima',
            4 => 'Tolak',
        );
    }
}
if (!function_exists('list_status_order')) {
    function list_status_order()
    {
        return array(
            1 => 'Menunggu Bayar',
            2 => 'Mencari Pekerja',
            3 => 'progress',
            4 => 'Selesai',
            5 => 'Ditolak',
        );
    }
}

if (!function_exists('list_status_withdraw')) {
    function list_status_withdraw()
    {
        return array(
            1 => 'Pending',
            2 => 'Di proses',
            3 => 'Selesai',
            4 => 'Tolak',
        );
    }
}


if (!function_exists('formating_tanggal')) {
    function formating_tanggal($date, $full = null)
    {
        $tanggal = date_create($date);
        if ($full == 1) {
            return date_format($tanggal, "d M Y H:i");
        }
        return date_format($tanggal, "d M Y");
    }
}
if (!function_exists('formating_number')) {
    function formating_number($value, $digit = 2)
    {

        return number_format($value, $digit, ',', '.');
    }
}

if (!function_exists('numberToRomanRepresentation')) {
    function numberToRomanRepresentation($number)
    {
        $map = array('M' => 1000, 'CM' => 900, 'D' => 500, 'CD' => 400, 'C' => 100, 'XC' => 90, 'L' => 50, 'XL' => 40, 'X' => 10, 'IX' => 9, 'V' => 5, 'IV' => 4, 'I' => 1);
        $returnValue = '';
        while ($number > 0) {
            foreach ($map as $roman => $int) {
                if ($number >= $int) {
                    $number -= $int;
                    $returnValue .= $roman;
                    break;
                }
            }
        }
        return $returnValue;
    }
}


if (!function_exists('terbilang')) {
    function terbilang($x)
    {

        $angka = ["", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas"];

        if ($x < 12)
            return " " . $angka[$x];
        elseif ($x < 20)
            return terbilang($x - 10) . " belas";
        elseif ($x < 100)
            return terbilang($x / 10) . " puluh" . terbilang($x % 10);
        elseif ($x < 200)
            return "seratus" . terbilang($x - 100);
        elseif ($x < 1000)
            return terbilang($x / 100) . " ratus" . terbilang($x % 100);
        elseif ($x < 2000)
            return "seribu" . terbilang($x - 1000);
        elseif ($x < 1000000)
            return terbilang($x / 1000) . " ribu" . terbilang($x % 1000);
        elseif ($x < 1000000000)
            return terbilang($x / 1000000) . " juta" . terbilang($x % 1000000);
    }
}



if (!function_exists('kategori_all')) {
    function kategori_all()
    {
        $data_kategori = Kategori::orderBy('title')->pluck('title', 'id')->toArray();
        return $data_kategori;
    }
}

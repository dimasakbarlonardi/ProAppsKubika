<?php

function rupiah($angka)
{
    $hasil_rupiah = "Rp " . number_format($angka, 0, ',', '.');
    echo $hasil_rupiah;
}

function RupiahNumber($angka)
{
    $hasil_rupiah = number_format($angka, 0, ',', '.');
    echo $hasil_rupiah;
}

function DecimalRupiah($angka)
{
    $hasil_rupiah = number_format($angka, 2, ',', '.');
    echo $hasil_rupiah;
}

function DecimalRupiahRP($angka)
{
    $hasil_rupiah = "Rp " . number_format($angka, 2, ',', '.');
    echo $hasil_rupiah;
}

function terbilang($rupiah)
{
    $angka = ["", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas"];

    if ($rupiah < 12)
        return " " . $angka[$rupiah];
    elseif ($rupiah < 20)
        return terbilang($rupiah - 10) . " Belas";
    elseif ($rupiah < 100)
        return terbilang($rupiah / 10) . " Puluh" . terbilang($rupiah % 10);
    elseif ($rupiah < 200)
        return "seratus" . terbilang($rupiah - 100);
    elseif ($rupiah < 1000)
        return terbilang($rupiah / 100) . " Ratus" . terbilang($rupiah % 100);
    elseif ($rupiah < 2000)
        return "seribu" . terbilang($rupiah - 1000);
    elseif ($rupiah < 1000000)
        return terbilang($rupiah / 1000) . " Ribu" . terbilang($rupiah % 1000);
    elseif ($rupiah < 1000000000)
        return terbilang($rupiah / 1000000) . " Juta" . terbilang($rupiah % 1000000);
}

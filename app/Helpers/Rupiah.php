<?php

function rupiah($angka){
	$hasil_rupiah = "Rp " . number_format($angka,0,',','.');
	echo $hasil_rupiah;
}

function RupiahNumber($angka){
	$hasil_rupiah = number_format($angka,0,',','.');
	echo $hasil_rupiah;
}

function DecimalRupiah($angka) {
    $hasil_rupiah = number_format($angka,2,',','.');
	echo $hasil_rupiah;
}

function DecimalRupiahRP($angka) {
    $hasil_rupiah = "Rp " . number_format($angka,2,',','.');
	echo $hasil_rupiah;
}

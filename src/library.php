<?php

function redirect($location)
{
	header('Location: ' . $location);
	exit();
}

function currency_format($number, $suffix = 'đ')
{
	if (!empty($number)) {
		return number_format($number, 0, ',', '.') . "{$suffix}";
	}
}

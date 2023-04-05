<?php
require_once('../vendor/autoload.php');
$host = "localhost";
$dbUser = "root";
$dbPassword = "pass";
$dbName = "booking";
$cabinetNumber = 1;
$bookingTime = "2021-08-12 15:01:00";
$contact = "test@mail.com, +992921234567";

$booking = new \App\Booking($host, $dbUser, $dbPassword, $dbName);
// проверка свободности кабинета

$result = $booking->checkAvailability($cabinetNumber, $bookingTime);
if ($result === true) {
    echo "Кабинет свободен, можно забронировать \n";
} else {
    echo $result;
}

// бронирование кабинета
if ($result === true) {
    $result = $booking->bookCabinet($cabinetNumber, $bookingTime, $contact);
    if ($result === true) {
        echo "Кабинет успешно забронирован";
    } else {
        echo $result;
    }
}
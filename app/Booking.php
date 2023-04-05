<?php
namespace App;

class Booking
{
    private $cabinets = [];
    private $conn;

    public function __construct($host, $user, $password, $database)
    {
        $this->conn = mysqli_connect($host, $user, $password, $database);
        for ($i = 1; $i <= 5; $i++) {
            $this->cabinets[$i] = new Cabinet($i, $this->conn);
        }
    }

    public function checkAvailability($number, $time)
    {
        if (isset($this->cabinets[$number])) {
            $cabinet = $this->cabinets[$number];
            if ($cabinet->isFree($time)) {
                return true;
            } else {
                return $cabinet->getInfo();
            }
        } else {
            return "Кабинет не найден";
        }
    }

    public function bookCabinet($number, $time, $contact)
    {
        if (isset($this->cabinets[$number])) {
            $cabinet = $this->cabinets[$number];
            if ($cabinet->isFree($time)) {
                $cabinet->book($time, $contact);
                $cabinet->notify();
                return true;
            } else {
                return $cabinet->getInfo();
            }
        } else {
            return "Кабинет не найден";
        }
    }
}
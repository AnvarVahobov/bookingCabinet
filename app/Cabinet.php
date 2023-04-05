<?php
namespace App;

class Cabinet
{
    private $number;
    private $time;
    private $contact;
    private $conn;

    public function __construct($number, $conn)
    {
        $this->number = $number;
        $this->conn = $conn;
    }

    public function isFree($time)
    {
        $sql = "SELECT * FROM cabinets WHERE number = {$this->number} AND time = '{$time}'";
        $result = mysqli_query($this->conn, $sql);
        if (mysqli_num_rows($result) == 0) {
            return true;
        } else {
            $row = mysqli_fetch_assoc($result);
            $this->time = $row['time'];
            $this->contact = $row['contact'];
            return false;
        }
    }

    public function book($time, $contact)
    {
        $sql = "INSERT INTO cabinets (number, time, contact) VALUES ({$this->number}, '{$time}', '{$contact}')";
        mysqli_query($this->conn, $sql);
        $this->time = $time;
        $this->contact = $contact;
    }

    public function notify()
    {
        if ($this->contact != null) {
            // отправка уведомления на E-mail и номер телефона
            echo 'Уведомления на E-mail и номер телефона: Вы заняли кабинет №' .$this->number . ' в ' . $this->time . "\n";
        }
    }

    public function getInfo()
    {
        if ($this->time == null) {
            return "Кабинет свободен";
        } else {
            return "Кабинет занят до " . $this->time . " человеком с контактной информацией: " . $this->contact . "\n";
        }
    }
}
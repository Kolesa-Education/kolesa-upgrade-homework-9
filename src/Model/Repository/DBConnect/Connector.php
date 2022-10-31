<?php
namespace App\Model\Repository\DBConnect;
use PDO;
class Connector
{
public function Connect(){
    $host = 'localhost';
$db   = 'AdvertsDB';
$user = 'root';
$pass = 'Applejesus$#1';
$charset = 'utf8';
    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $opt = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $pdo = new PDO($dsn, $user, $pass, $opt);
    return $pdo;

}
public function GetData(){
$pdo = $this->Connect();
$stmt = $pdo->query('SELECT * FROM Adverts');
return $stmt->fetchall();


}
public function CreateData($title, $description, $price, $id){
    $pdo = $this->Connect();
    $stmt = $pdo->prepare('insert into Adverts values (?,?,?,?)');
    $stmt->execute(array($title, $description, $price, $id));

    }

    public function EditData($title, $description, $price, $id){
        $pdo = $this->Connect();
        $stmt = $pdo->prepare('UPDATE Adverts
        SET title =?, description = ?, price = ?
        WHERE id = ?');
        $stmt->execute(array($title, $description, $price, $id));
    
        }
}

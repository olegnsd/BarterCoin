<?php

//Database
//CREATE TABLE `Session` (
//  `Session_Id` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
//  `Session_Expires` datetime NOT NULL,
//  `Session_Data` text COLLATE utf8_unicode_ci,
//  PRIMARY KEY (`Session_Id`)
//) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

class SysSession implements SessionHandlerInterface
{
    public $link;
   
    public function open($savePath, $sessionName)
    {
//        $link = mysqli_connect("server","user","pwd","mydatabase");
//        if($link){
//            $this->link = $link;
//            return true;
//        }else{
//            return false;
//        }
        return true;
    }
    public function close()
    {
        mysqli_close($this->link);
        return true;
    }
    public function read($id)
    {
        $result = mysqli_query($this->link,"SELECT Session_Data FROM Session WHERE Session_Id = '".$id."' AND Session_Expires > '".date('Y-m-d H:i:s')."'");
        if($row = mysqli_fetch_assoc($result)){
            return $row['Session_Data'];
        }else{
            return "";
        }
    }
    public function write($id, $data)
    {
        $DateTime = date('Y-m-d H:i:s');
        $NewDateTime = date('Y-m-d H:i:s',strtotime($DateTime.' + 1 hour'));
        $result = mysqli_query($this->link,"REPLACE INTO Session SET Session_Id = '".$id."', Session_Expires = '".$NewDateTime."', Session_Data = '".$data."'");
        if($result){
            return true;
        }else{
            return false;
        }
    }
    public function destroy($id)
    {
        $result = mysqli_query($this->link,"DELETE FROM Session WHERE Session_Id ='".$id."'");
        if($result){
            return true;
        }else{
            return false;
        }
    }
    public function gc($maxlifetime)
    {
        $result = mysqli_query($this->link,"DELETE FROM Session WHERE ((UNIX_TIMESTAMP(Session_Expires) + ".$maxlifetime.") < ".$maxlifetime.")");
        if($result){
            return true;
        }else{
            return false;
        }
    }
}
ini_set('session.gc_maxlifetime', '86400'); // время жизни сессии, 30 минут (60*30)
$handler = new SysSession();
$handler->link = $mysqli;
session_set_save_handler($handler, true);

session_start();
?>
<?php
class Crontab extends CI_Controller{
    function __construct(){
        parent::__construct();
    }
    
    function index(){
        /*$ip = "203.142.70.66";
        $Connect = fsockopen($ip, "8011", $errno, $errstr, 1);
        $Key = 0;
        if($Connect){
            $soap_request="<GetAttLog><ArgComKey xsi:type=\"xsd:integer\">".$Key."</ArgComKey><Arg><PIN xsi:type=\"xsd:integer\">All</PIN></Arg></GetAttLog>";
            $newLine="\r\n";
            fputs($Connect, "POST /iWsService HTTP/1.0".$newLine);
            fputs($Connect, "Content-Type: text/xml".$newLine);
            fputs($Connect, "Content-Length: ".strlen($soap_request).$newLine.$newLine);
            fputs($Connect, $soap_request.$newLine);
            $buffer="";
            while($Response=fgets($Connect, 1024)){
                $buffer=$buffer.$Response;
            }

            //$this->db->query("Truncate table employee_absensi");

            $buffer = $this->m_login->Parse_Data($buffer,"<GetAttLogResponse>","</GetAttLogResponse>");
            $buffer=explode("\r\n",$buffer);
            for($a=0;$a<count($buffer);$a++){
                $data= $this->m_login->Parse_Data($buffer[$a],"<Row>","</Row>");
                $PIN= $this->m_login->Parse_Data($data,"<PIN>","</PIN>");
                $DateTime= $this->m_login->Parse_Data($data,"<DateTime>","</DateTime>");
                $Verified= $this->m_login->Parse_Data($data,"<Verified>","</Verified>");
                $Status= $this->m_login->Parse_Data($data,"<Status>","</Status>");

                $data = array(
                    'id_absensi'    => $PIN,
                    'absensi_date'  => substr($DateTime,0,19),
                    'absensi_time'  => substr($DateTime,11,18)
                );
                //$this->db->insert('employee_absensi',$data);
            }
        }*/
    }
}
?>
<?php

namespace App\Twig;

use Extension\AbstractExtension;
use Twig\TwigFilter;

use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpFoundation\Session\Session;
use \Twig_Function;

class AcmExtension extends \Twig_Extension
{
    public function getSesssion()
    {
        return $session = new Session();
    }
    ///FUNCTION FROM NICAW AAC EDITED BY GHOST ornot
    public function getServerStatus(){

        $cfg['status_update_interval'] = 5; //SECONDS
        $cfg['server_ip'] = '127.0.0.1';
        $cfg['server_port'] = 7171;
        $cfg['statusDir'] = 'status.xml';
        $a = function ($host='127.0.0.1',$port=7171){
            // connects to server
            $errorCode;
            $errorString;
            $socket = @fsockopen('127.0.0.1',7171, $errorCode, $errorString, 0.3);
            //var_dump($errorString);
            $data = '';
            // if connected then checking statistics
            //echo '1function ';
            //var_dump($socket);
            if($socket)
            {//echo 'socket ';
                // sets 1 second timeout for reading and writing
                stream_set_timeout($socket, 1);

                // sends packet with request
                // 06 - length of packet, 255, 255 is the comamnd identifier, 'info' is a request
                fwrite($socket, chr(6).chr(0).chr(255).chr(255).'info');

                // reads respond
                while (!feof($socket)){
                    $data .= fread($socket, 128);
                }

                // closing connection to current server
                fclose($socket);
                return $data;
            }
            //var_dump($data);
            return null;
            
        };

        $modtime = filemtime($cfg['statusDir']);

        $test=(time() - $modtime);
        //echo "{$test} > {$cfg['status_update_interval']} ";
        $info = $a($cfg['server_ip'], $cfg['server_port']);
        if ((time() - $modtime) > $cfg['status_update_interval']){
            //var_dump($info);
            if ($info === null){
                return null;
            }
            //echo 'ccccccccccccccccccccccc '.(time() - $modtime).'<br>'.$modtime.'<br>';
            //var_dump($info);
            if (!empty($info)){
            //echo 'file put ';
                file_put_contents($cfg['statusDir'],$info);
            }

        }else{
            $info = file_get_contents($cfg['statusDir']);
            //echo 'file_get_contents ';
        }
        $infooo = file_get_contents($cfg['statusDir']);
        if (!empty($infooo)) {
            //echo 'aaaaaas';
            $infoXML = simplexml_load_string($infooo);
        
            $up = (int)$infoXML->serverinfo['uptime'];
            $online = (int)$infoXML->players['online'];
            $max = (int)$infoXML->players['max'];
            
            $h = floor($up/3600);
            $up = $up - $h*3600;
            $m = floor($up/60);
            $up = $up - $m*60;
            if ($h < 10) {$h = "0".$h;}
            if ($m < 10) {$m = "0".$m;}

            $array = [
                'uptime' => "{$h}:{$m}",
                'online' => "$online",
                'max' => $max
            ];

            return $array;
        }
        $array = [
            'uptime' => "NaN",
            'online' => "NaN",
            'max' => "NaN"
        ];

        return $array;
    }

    public function getFunctions()
    {
        return array(
            'getSesssion' => new Twig_Function('getSesssion', [$this, 'getSesssion']),
            'getServerStatus' => new Twig_Function('getServerStatus', [$this, 'getServerStatus']),
        );
    }
}
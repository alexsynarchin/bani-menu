<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class TestController extends Controller
{
    public function index()
    {
        $username =  "broni";
        $password = "3(7#m7)Tt6Sw";
        $curl = curl_init(); // Инициализируем запрос
        curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://109.233.168.27:30001/rk7api/v0/xmlinterface.xml', // Полный адрес метода
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER, 0,

            CURLOPT_RETURNTRANSFER => true, // Возвращать ответ
            //CURLOPT_POST => true, // Метод POST,

            CURLOPT_USERPWD=> "$username:$password",
           // CURLOPT_POSTFIELDS => http_build_query($data) // Данные в запросе
        ));
         // Выполняем запрос
        if(curl_exec($curl) === false)
        {
            $response = curl_error($curl);
            echo 'Ошибка curl: ' . curl_error($curl);
        }
        else
        {
            $response = curl_exec($curl);
            echo 'Операция завершена без каких-либо ошибок';
        }
        //$response = json_decode($response, true); // Декодируем из JSON в массив
        curl_close($curl); // Закрываем соединение
        //$oXML = new SimpleXMLElement($response);

        return $response; // Возвращаем ответ
    }
}

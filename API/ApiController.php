<?php

namespace API\ApiController;

class ApiController{

    #url
    private $urlApiToken = "https://testapi.zabiray.ru/token";
    private $urlApiCards = "https://testapi.zabiray.ru/cards";
    #user data
    private $username = 'test';
    private $password = 'test1234';

    #token
    private $token = null;
    private $tokenType = null;
    


    public function __construct()
    {
        
    }

    public function getToken(){
        // Получение токена
        $ch = curl_init($this->urlApiToken);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            "username" => $this->username,
            "password" => $this->password,
        ]));
        $response = curl_exec($ch);

        if (curl_getinfo($ch, CURLINFO_HTTP_CODE) !== 200) {
            die("Ошибка получения токена");
        }

        // Парсим ответ и получаем токен авторизации
        $response_data = json_decode($response);
        if (!$response_data || !isset($response_data->access_token) || !isset($response_data->token_type)) {
            die("Ошибка парсинга токена");
        }
        //переменные для хранения токена и типа авторизации пользователя
        $this->token = $response_data->access_token;
        $this->tokenType = $response_data->token_type;
    }

    public function getCards($id_card){
        if($this->token && $this->tokenType){
                $data = array("id" => $id_card);
            $data_json = json_encode($data);

            $ch = curl_init($this->urlApiCards);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                "Authorization: $this->tokenType $this->token"
            ));
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_json);
            $response = curl_exec($ch);

            if (curl_getinfo($ch, CURLINFO_HTTP_CODE) !== 200) {
                die("Ошибка получения карты");
            }

            curl_close($ch);

            // парсим ответ и получаем данные о карте
            $card_data = json_decode($response);
            return array_reverse($card_data);
        }    
    }

}
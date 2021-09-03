<?php

namespace App\UseCase;

class CurlRequest
{
    public function post($postData, string $linkPost)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_URL, $linkPost);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $postData);

        $out = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        $code = (int)$code;
        $errors = [
            400 => 'Bad request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not found',
            500 => 'Internal server error',
            502 => 'Bad gateway',
            503 => 'Service unavailable',
        ];

        try {
            /** Если код ответа не успешный - возвращаем сообщение об ошибке  */
            if ($code < 200 || $code > 204) {
                throw new \Exception($errors[$code] ?? 'Undefined error', $code);
            }

            print_r($out);

            return $out;
        } catch (\Exception $errors) {
            print_r(json_decode($out));
            die('Ошибка: ' . $errors->getMessage() . PHP_EOL . 'Код ошибки: ' . $errors->getCode());
        }

    }

    public function get(string $link, array $header)
    {
        $curl = curl_init($link);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $header);

        $out = curl_exec($curl);
        $code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);

        $code = (int)$code;
        $errors = [
            400 => 'Bad request',
            401 => 'Unauthorized',
            403 => 'Forbidden',
            404 => 'Not found',
            500 => 'Internal server error',
            502 => 'Bad gateway',
            503 => 'Service unavailable',
        ];

        try {
            if ($code < 200 || $code > 204) {
                throw new \Exception($errors[$code] ?? 'Undefined error', $code);
            }
            return json_decode($out, true);
        } catch (\Exception $e) {
            print_r(json_decode($out));
            die('Ошибка: ' . $e->getMessage() . PHP_EOL . 'Код ошибки: ' . $e->getCode());
        }
    }



    public function getHeadersForKaspi(): array
    {
        return [
            'Content-Type:application/vnd.api+json',
            'X-Auth-Token: token'
        ];
    }
}


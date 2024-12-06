<?php

class WebServiceModel {
    private $apiUrl = 'https://develop1.datacrm.la/jdimate/pruebatecnica/webservice.php?operation=query&sessionName=71486ac0675341de87b8c&query=select * from Contacts;';

    public function fetchContacts() {
        //$curl = curl_init("https://develop1.datacrm.la/jdimate/pruebatecnica/webservice.php?operation=query&sessionName=71486ac0675341de87b8c&query=select * from Contacts;");

        //curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        //curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        //curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);

        //curl_setopt($curl, CURLOPT_HTTPHEADER, [
          //  'Content-Type: application/json',
            // 'Authorization: Bearer YOUR_TOKEN' // Si requiere autenticación
        //]);

        $baseUrl = "https://develop1.datacrm.la/jdimate/pruebatecnica/webservice.php";
        $operation = "query";
        $sessionName = "71486ac0675341de87b8c";
        $query = urlencode("select * from Contacts;");
        
        $url = "$baseUrl?operation=$operation&sessionName=$sessionName&query=$query";
        
        $curl = curl_init($url);
        
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);


        $response = curl_exec($curl);
        if ($response === false) {
            $error = curl_error($curl);
            throw new Exception("Error cURL: " . $error);
        }


        $data = json_decode($response, true);
        var_export($data);
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);

        if ($httpCode !== 200) {
            throw new Exception('Error al conectar con el web service: ' . $httpCode);
        }

        curl_close($curl);
        return array_map(function ($item) {
            return [
                'id' => $item['id'],
                'contact_no' => $item['contact_no'],
                'lastname' => $item['lastname'],
                'createdtime' => $item['createdtime'],
            ];
        }, $data);
    }
}

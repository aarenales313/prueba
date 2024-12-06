<?php

class WebServiceModel {


    public function getAccesKey() {

        $curl = curl_init("https://develop1.datacrm.la/jdimate/pruebatecnica/webservice.php?operation=getchallenge&username=prueba");
        
        curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
        
        $response = curl_exec($curl);
        
        if(curl_errno($curl)){
            $error_msg = curl_errno($curl);
            echo "ERROR AL CONECTARSE A LA API";
        } else {
            curl_close($curl);
            $data = json_decode($response,true);
            $sessionName = $this->getSessionName($data['result']['token']);
            return $sessionName;
        }    
    }

    public function getSessionName($token) {

        // Definir las variables
        $accesskey = '2IPfpYL3SxRRjLWx';
        $token = $token;

        // Se concatena token y accesskey
        $combined = $token . $accesskey;

        // Generar el hash MD5
        $accessKey = md5($combined);

        // URL del servicio
        $url = "https://develop1.datacrm.la/jdimate/pruebatecnica/webservice.php";

        // Datos a enviar en formato application/x-www-form-urlencoded
        $data = http_build_query([
            'operation' => 'login',
            'username' => 'prueba',
            'accessKey' => $accessKey, // Reemplaza {{accessKey}} con el valor real
        ]);

        // Inicializar cURL
        $curl = curl_init($url);

        // Configuración de cURL
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); // Para obtener la respuesta como string
        curl_setopt($curl, CURLOPT_POST, true);          // Método POST
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            'Content-Type: application/x-www-form-urlencoded'
        ]); // Header de Content-Type
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);  // Datos de la solicitud

        // Ejecutar la solicitud
        $response = curl_exec($curl);

        // Verificar errores
        if (curl_errno($curl)) {
            echo 'Error cURL: ' . curl_error($curl);
        } else {
            $data = json_decode($response,true);

            return $data['result']['sessionName'];
        }

        // Cerrar la conexión
        curl_close($curl);  
    }



    public function fetchContacts() {

        $baseUrl = "https://develop1.datacrm.la/jdimate/pruebatecnica/webservice.php";
        $operation = "query";
        $sessionName = $this->getAccesKey();
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
        }, $data['result']);
    }
}

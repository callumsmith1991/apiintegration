<?php


class ApiRequest
{
    private $api_key = '3NLTTNlXsi6rBWl7nYGluOdkl2htFHug';

    public function get($url, $params = array())
    {

        $build_params = array();

        $build_params['api_key'] = $this->api_key;

        if(count($params) > 0 && is_array($params)) 
        {

            foreach($params as $k => $v)
            {

                $build_params[$k] = $v;

            }

        }

        $query_string =  http_build_query($build_params);
        // echo $query_string;
        $url .= '?'.$query_string;

        $ch = curl_init();
        // Will return the response, if false it print the response
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        // Set the url
        curl_setopt($ch, CURLOPT_URL, $url);

        curl_setopt($ch, CURLOPT_FAILONERROR, true);

        // Execute
        $result = curl_exec($ch);
        // Closing

        if(curl_errno($ch)) {

            $error_message = curl_error($ch);

            curl_close($ch);

            return false;

        }  else {
            
            curl_close($ch);

            return $this->jsonDecode($result);

        }



    }

    private function jsonDecode($json)
    {
        $json = json_decode($json, true);

        return $json;

    }
}


?>
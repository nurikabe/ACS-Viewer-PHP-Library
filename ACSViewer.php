<!-- @version 1.0.0
     @author Alexandra Debish
     @last-updated Jan 28, 2015

Copyright (c) 2015 Accusoft Corporation

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in
all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
THE SOFTWARE. -->

<?php

class ACSViewer {

    private $config;
    private $initialized = false;
    private $viewingSessionId = null;

    private static $required_parameters = array(
        'key' => '/^\S{8,}\z/',
        'document' => '/^(([^:\/?#]+):)?(\/\/([^\/?#]*))?([^?#]*)(\?([^#]*))?(#(.*))?$/i'
    );

    private static $optional_parameters = array(
        'viewerwidth' => '#^\d+(%|px)?$#i',
        'viewerheight' => '#^\d+(%|px)?$#i',
        'printButton' => '#^(yes|no)$#i',
        'plainText' => '#^(yes|no)$#i',
        'toolbarColor' => '#^[0-9a-f]{6}$#i',
        'viewerType' => '#^(html5|flash|slideshow)$#i',
        'logoImage' => '/^(([^:\/?#]+):)?(\/\/([^\/?#]*))?([^?#]*)(\?([^#]*))?(#(.*))?$/i',
        'animSpeed' => '#^(0|[1-9][0-9]*)$#',
        'automatic' => '#^(yes|no)$#i',
        'showControls' => '#^(yes|no)$#i',
        'centerControls' => '#^(yes|no)$#i',
        'keyboardNav' => '#^(yes|no)$#i',
        'hoverPause' => '#^(yes|no)$#i'
    );

    private static $baseViewerUrl = 'api.accusoft.com';

    //initializes the viewer for use
    public function __construct($parameters = array()) {
        $this->config = self::buildConfiguration($parameters);
        $this->initialized = true;
    }

    //getContent() makes a call to the viewer api and returns the viewer, using the parameters
    //defined at initialization, for use on a page
    public function getContent() {
        if (!$this->initialized) throw new Exception('ACS Viewer was not properly initialized.');

        return $this->viewerGetRequest('/v2/viewer/content?' . http_build_query($this->config));
    }

    //getDocumentText() makes a call to the api and extracts the plain text from the document 
    //defined at initialization
    public function getDocumentText() {
        if (!$this->initialized) throw new Exception('ACS Viewer was not properly initialized.');

        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, self::$baseViewerUrl . '/v1/documentTextExtractors');
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode(array(
            "input" => array(
                "documentUrl" => $this->config['document']
            )
        )));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'acs-api-key: ' . $this->config['key']
        ));

        $response = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($code != 200) throw new Exception('Error retrieving information from ACS Viewer service.');

        $responseObj = json_decode($response);

        return $responseObj->{'output'}->{'text'};
    }

    //sends a request to the api and based on a url passed
    private function viewerGetRequest($url) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, self::$baseViewerUrl . $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, 10);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');

        $response = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if ($code != 200) throw new Exception('Error retrieving information from ACS Viewer service.');

        return $response;
    }

    //builds the configuration based on the parameters passed by the user, making sure they are valid based on the
    //regular expressions defined above
    private static function buildConfiguration($config) {
        $output_config = array();

        foreach (self::$required_parameters as $name => $regex) {
            if (!isset($config[$name])) throw new Exception('Parameter ' . $name . ' is required for ACS Viewer.');
            if (!preg_match($regex, $config[$name])) throw new Exception('Parameter ' . $name . ' was assigned an invalid value.');
            $output_config[$name] = $config[$name];
        }
        foreach (self::$optional_parameters as $name => $regex) {
            if (isset($config[$name]) && !preg_match($regex, $config[$name])) {
                throw new Exception('Parameter ' . $name . ' was assigned an invalid value.');
            } else if (isset($config[$name])) {
                $output_config[$name] = $config[$name];
            }
        }

        return $output_config;
    }
}

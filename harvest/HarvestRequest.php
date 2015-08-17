<?php
/**
 * This file is part of the harvest package.
 *
 * (c) Freshbyte Inc <http://freshbyteinc.com/>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace harvest;

use logger\Logger;

/**
 * Class HarvestRequest
 * @package harvest
 */
class HarvestRequest
{
  /**
   * @var string
   *   The Harvest URL.
   */
  protected $url;

  /**
   * @var string
   *   The request data (XML).
   */
  protected $requestData;

  /**
   * Getter for $url.
   *
   * @return string
   */
  public function getUrl()
  {
    return $this->url;
  }

  /**
   * Setter for $url.
   *
   * @param string $url
   *
   * @return $this;
   */
  public function setUrl($url)
  {
    $this->url = $url;

    return $this;
  }

  /**
   * Getter for $requestData.
   *
   * @return string
   */
  public function getRequestData()
  {
    return $this->requestData;
  }

  /**
   * Setter for $requestData.
   *
   * @param string $requestData
   *
   * @return $this;
   */
  public function setRequestData($requestData)
  {
    $this->requestData = $requestData;

    return $this;
  }

  /**
   * Send request to Harvest web services.
   *
   * @param string $type
   *   Request type. Possible values: POST, GET, DELETE. Default value: POST.
   *
   * @return mixed
   *   The response array or FALSE.
   */
  public function sendRequest($type = 'POST')
  {
    $curl = curl_init();

    $curlOptions = array(
      CURLOPT_URL => $this->url,
      CURLOPT_RETURNTRANSFER => TRUE,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => $type,
      CURLOPT_HTTPHEADER => array(
        "accept: application/json",
        "authorization: Basic " . HARVEST_AUTH,
        "content-type: application/json"
      ),
    );
    curl_setopt_array($curl, $curlOptions);


    if ($type == 'POST' && $this->requestData) {
      curl_setopt($curl, CURLOPT_POSTFIELDS, $this->requestData);
    }

    $data = curl_exec($curl);
    if (curl_errno($curl)) {
      $message = 'Error code: ' . curl_errno($curl) . ' (' . $this->url . ')';
      Logger::log('HarvestRequest::sendRequest', $message, curl_error($curl), 'ERROR');
      curl_close($curl);

      return FALSE;
    }
    else {
      curl_close($curl);
    }


    Logger::log('HarvestRequest::sendRequest', 'Response (' . $this->url . ')', $data);
    $response = json_decode($data, TRUE);

    return $response;
  }
}

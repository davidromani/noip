<?php namespace Buonzz\NoIP;

use GuzzleHttp\Client as GClient;
use GuzzleHttp\Exception\ClientException;
use Dotenv\Dotenv;

/**
 * Class Client
 */
class Client
{
    /**
     * @var bool
     */
    private $use_https;

    /**
     * @var array|false|string
     */
    private $host;

    /**
     * @var array|false|string
     */
    private $username;

    /**
     * @var array|false|string
     */
    private $password;

    /**
     * @var string
     */
    private $api_url;

    /**
     * Methods
     */

    /**
     * Client constructor.
     *
     * @param bool $use_https
     * @param null|string $host
     * @param null|string $username
     * @param null|string $password
     */
    public function __construct($use_https = true, $host = null, $username = null, $password = null)
    {
        $dotenv = new Dotenv(getcwd());
        $dotenv->load();

        $this->host = is_null($host) ? getenv('NOIP_HOST') : $host;
        $this->username = is_null($username) ? getenv('NOIP_USERNAME') : $username;
        $this->password = is_null($password) ? getenv('NOIP_PASSWORD') : $password;
        $this->use_https = $use_https;

        if ($use_https) {
            $this->api_url = "https";
        } else {
            $this->api_url = "http";
        }

        $this->api_url .= "://$this->username:$this->password@dynupdate.no-ip.com/nic/update";
    }

    /**
     * @param $ip
     *
     * @return string
     */
    public function update($ip)
    {
        $uri = $this->api_url."?hostname=".$this->host."&myip=".$ip;
        $client = new GClient(['headers' => ['User-Agent' => 'Buonzz Update Client PHP/v1.0 buonzz@gmail.com']]);

        try {
            $response = $client->request('GET', $uri);
            $reason = $response->getReasonPhrase(); // OK

            return $reason;

        } catch (ClientException $e) {

            return $e->getMessage();
        }
    }
}

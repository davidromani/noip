<?php namespace Buonzz\NoIP;

use GuzzleHttp\Client as GClient;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\RequestException;
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
     */
    public function __construct($use_https = true)
    {
        $dotenv = new Dotenv(getcwd());
        $dotenv->load();

        $this->username = getenv('NOIP_USERNAME');
        $this->password = getenv('NOIP_PASSWORD');
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
     * @param null $phostname
     *
     * @return string
     */
    public function update($ip, $phostname = null)
    {
        if (is_null($phostname)) {
            $hostname = getenv('NOIP_HOST');
        } else {
            $hostname = $phostname;
        }

        $uri = $this->api_url."?hostname=".$hostname."&myip=".$ip;
        $client = new GClient(['headers' => ['User-Agent' => 'Buonzz Update Client PHP/v1.0 buonzz@gmail.com']]);

        try {
            $response = $client->request('GET', $uri);
            $code = $response->getStatusCode(); // 200
            $reason = $response->getReasonPhrase(); // OK

            return $reason;

        } catch (ClientException $e) {

            return $e->getMessage();
        }
    }
}

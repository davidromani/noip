PHP Client for Integrating to NoIP.com
======================================

Client to update the DDNS hostname to a specific IP.

see [http://www.noip.com/integrate/request](http://www.noip.com/integrate/request)

## Installation



### Install as globally executable script

```
wget https://github.com/buonzz-systems/noip/raw/master/dist/noip_php.phar
sudo mv noip_php.phar  /usr/local/bin/noip_php
chmod +x /usr/local/bin/noip_php
noip_php -V
```

Place a configuration file named ".env" on  home folder with the following contents:

```
NOIP_HOST=yourhost.ddns.net
NOIP_USERNAME=yourusername
NOIP_PASSWORD=yourpassword
```

### Running as cron job every 4 hours

```
0 */4 * * * cd ~;/usr/local/bin/noip_php client:update
```


### Install via Composer in a Project

```
composer require buonzz/noip
```

Create the configuration file with filename .env
```
vi .env
```

The config file should contain this variables that you need to set

* NOIP_HOST - is your NoIP Hostname, (e.g. myhostname.ddns.net )
* NOIP_USERNAME - your account username
* NOIP_PASSWORD - your password


Remember to not commit the .env file to your git repository! These variables is automatically loaded by app as environment variable. This is a security feature so that your credentials is not hardcoded in your application source codes.


Instantiate Client and set IP


```
use Buonzz\NoIP\Client;

$client = new Buonzz\NoIP\Client();

$result = $client->update("1.1.1.1");

if($result == 'OK')
  // the ddns host is successfully updated
```


### Install it as CLI script


You can install it globally in your machine:

```
composer global require buonzz/noip
```

Simply add this directory to your PATH in your ~/.bash_profile (and/or ~/.bashrc) like this:

```
export PATH=~/.composer/vendor/bin:$PATH
```

load the current config

```
source ~/.bash_profile
```


Set the .env file in 

~/.env folder

```
vi ~/.env
```

(look at the above section for configuring projects to know what vars is required )

Now you are ready to run the script

```
noip_php client:update
```

Or you can use it with optional input arguments instead of .env configuration. Follow this example:

```
noip_php client:update <NOIP_HOST> <NOIP_USERNAME> <NOIP_PASSWORD>
```

### Phar Build

[https://gist.github.com/buonzz/07193b92ee10e9eaac19](Install) first box in your Homestead.

```
box build
```
```
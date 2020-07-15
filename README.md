# Fail2banBundle
Symfony Fail2banBundle like linux fail2ban

# Instalation

```bash
$ composer require karolkrupa/fail2ban-bundle
```

# Configuration

```yaml
# config/packages/fail2ban.yaml

fail2ban:
  enabled: false
  block_for: '30 seconds'
  allowed_attempts_count: 2
  #config_provider: App\Service\Fail2BanConfigProvider
```

# Configuration provider

The configuration provider is a class that can provide package configuration variables. 
Thanks to it you can easily store your configuration in the database.

### Configuration provider implementation

To create a configuration provider, you need to create your own service that implements 
the ConfigProvider interface and assign it to the `config_provider` package configuration key.


#### Sample implementation
```php
<?php

namespace App\Service;


use KarolKrupa\Fail2banBundle\ConfigProvider;

class Fail2BanConfigProvider implements ConfigProvider
{
    private $systemSettings;

    public function __construct(SystemSettings $systemSettings)
    {
        $this->systemSettings = $systemSettings;
    }

    public function get($name)
    {
        if($name == 'enabled') {
            return boolval($this->systemSettings->get('fail2ban.enabled', false));
        }

        if($name == 'block_for') {
            return $this->systemSettings->get('fail2ban.block_for', null);
        }

        if($name == 'allowed_attempts_count') {
            return intval($this->systemSettings->get('fail2ban.attempts_count', 3));
        }

        return false;
    }
}
```

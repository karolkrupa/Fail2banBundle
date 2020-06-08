<?php
/**
 * User: Karol Krupa <k.krupa@mits.pl>
 * Date: 08/06/2020
 */

namespace KarolKrupa\Fail2banBundle;


class DefaultConfigProvider implements ConfigProvider
{
    private $config;

    public function __construct($config)
    {
        $this->config = $config;
    }

    public function get($name)
    {
        return $this->config[$name];
    }

}
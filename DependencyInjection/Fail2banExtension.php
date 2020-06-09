<?php
/**
 * User: Karol Krupa <k.krupa@mits.pl>
 * Date: 07/06/2020
 */

namespace KarolKrupa\Fail2banBundle\DependencyInjection;


use KarolKrupa\Fail2banBundle\ConfigProvider;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;

class Fail2banExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__ . '/../Resources/config')
        );
        $loader->load('services.yml');

        $configuration = new Configuration();

        $config = $this->processConfiguration($configuration, $configs);

        $configProvider = 'fail2ban_config_provider';
        if(isset($config['config_provider'])) {
            $configProvider = $config['config_provider'];
        }

        $container->setAlias(ConfigProvider::class, $configProvider);
    }
}
<?php
/**
 * User: Karol Krupa <k.krupa@mits.pl>
 * Date: 07/06/2020
 */

namespace KarolKrupa\Fail2banBundle\DependencyInjection;


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

        $container->getDefinition('fail2ban_config_provider')
            ->replaceArgument('$config', $config);
    }
}
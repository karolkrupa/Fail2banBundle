<?php
/**
 * User: Karol Krupa <k.krupa@mits.pl>
 * Date: 08/06/2020
 */

namespace KarolKrupa\Fail2banBundle\DependencyInjection;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder('fail2ban');

        $treeBuilder->getRootNode()
            ->children()
            ->booleanNode('enabled')->defaultFalse()->end()
            ->integerNode('allowed_attempts_count')->defaultValue(3)->end()
            ->scalarNode('block_for')->defaultValue('30 days')->end()
            ->scalarNode('config_provider')->end()
            ->end();

        return $treeBuilder;
    }
}
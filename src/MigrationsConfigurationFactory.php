<?php
/**
 * container-interop-doctrine
 *
 * @link      http://github.com/DASPRiD/container-interop-doctrine For the canonical source repository
 * @copyright 2016 Ben Scholzen 'DASPRiD'
 * @license   http://opensource.org/licenses/BSD-2-Clause Simplified BSD License
 */

namespace ContainerInteropDoctrine;

use Psr\Container\ContainerInterface;
use Doctrine\DBAL\Migrations\Configuration\Configuration;


class MigrationsConfigurationFactory extends AbstractFactory
{
    
    protected function createWithConfig(ContainerInterface $container, $configKey)
    {
        $config = $this->retrieveConfig($container, $configKey, 'migrations_configuration');
        
        $configuration = new Configuration(
            $this->retrieveDependency(
                $container,
                $configKey,
                'connection',
                ConnectionFactory::class
                )
            );
        
        $configuration->setMigrationsNamespace($config['namespace']);
        $configuration->setName($config['name']);
        $configuration->setMigrationsDirectory($config['directory']);
        $configuration->setMigrationsTableName($config['table']);
        
        return $configuration;
    }
    
    protected function getDefaultConfig($configKey)
    {
        return [
            'directory' => 'data/migrations',
            'name'      => 'Doctrine database migrations',
            'namespace' => 'Migrations',
            'table'     => 'migrations'
        ];
    }
    
}


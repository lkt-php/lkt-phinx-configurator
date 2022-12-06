<?php

namespace Lkt\Phinx\Tests;


use Lkt\DatabaseConnectors\DatabaseConnections;
use Lkt\DatabaseConnectors\MySQLConnector;
use Lkt\Phinx\PhinxConfigurator;
use PHPUnit\Framework\TestCase;

class ConfiguratorTest extends TestCase
{
    public function test_001()
    {
        DatabaseConnections::set(MySQLConnector::define('test-mysql')
            ->setUser('username')
            ->setPassword('password')
            ->setHost('server-address')
            ->setDatabase('dbname')
        );

        PhinxConfigurator::addMigrationPath(__DIR__);

        $config = PhinxConfigurator::getConfig();

        $this->assertEquals(3, count($config['environments']));
        $this->assertEquals('test-mysql', $config['environments']['default_database']);
        $this->assertEquals('phinxlog', $config['environments']['default_migration_table']);
        $this->assertEquals('server-address', $config['environments']['test-mysql']['host']);
        $this->assertEquals('password', $config['environments']['test-mysql']['pass']);
        $this->assertEquals('username', $config['environments']['test-mysql']['user']);
        $this->assertEquals('dbname', $config['environments']['test-mysql']['name']);
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Mohammad Yazdani
 * Date: 3/6/2017
 * Time: 9:00 PM
 */

use Doctrine\Common\ClassLoader,
    Doctrine\ORM\Configuration,
    Doctrine\ORM\EntityManager,
    Doctrine\Common\Cache\ArrayCache,
    Doctrine\DBAL\Logging\EchoSQLLogger,
    Doctrine\ORM\Tools\Setup,
    Doctrine\ORM\EntityManager as EntityManager2,
    Doctrine\ORM\Mapping\Driver\AnnotationDriver,
    Doctrine\Common\Annotations\AnnotationReader,
    Doctrine\Common\Annotations\AnnotationRegistry;

class Doctrine {

    public $em = null;

    public function __construct()
    {
        // load database configuration from CodeIgniter
        require_once APPPATH.'config/database.php';

        // Set up class loading. You could use different autoloaders, provided by your favorite framework,
        // if you want to.
        require_once APPPATH.'libraries/Doctrine/Common/ClassLoader.php';

        $doctrineClassLoader = new ClassLoader('Doctrine',  APPPATH.'libraries');
        $doctrineClassLoader->register();
        $entitiesClassLoader = new ClassLoader('models', rtrim(APPPATH, "/" ));
        $entitiesClassLoader->register();
        $proxiesClassLoader = new ClassLoader('Proxies', APPPATH.'models/proxies');
        $proxiesClassLoader->register();

        // Set up caches
        $config = new Configuration;
        $cache = new ArrayCache;
        $config->setMetadataCacheImpl($cache);
        $driverImpl = $config->newDefaultAnnotationDriver(array(APPPATH.'models/Entities'), false);
        $config->setMetadataDriverImpl($driverImpl);
        $config->setQueryCacheImpl($cache);

        $config->setQueryCacheImpl($cache);

        // Proxy configuration
        $config->setProxyDir(APPPATH.'/models/proxies');
        $config->setProxyNamespace('Proxies');

        // Set up logger
        //$logger = new EchoSQLLogger;
        //$config->setSQLLogger($logger);

        $config->setAutoGenerateProxyClasses( TRUE );
      
        // Database connection information

        $connectionOptions = array(
          'dbname' =>   'gatekeeper',
          'user' =>     'gatekeeper',
          'password' => 'gatekeeper',
          'host' =>     'localhost',   
          'driver' => 'pdo_mysql'
        );

        // Create EntityManager
        $this->em = EntityManager::create($connectionOptions, $config);
    }
}
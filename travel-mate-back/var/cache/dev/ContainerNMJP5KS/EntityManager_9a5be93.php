<?php

namespace ContainerNMJP5KS;
include_once \dirname(__DIR__, 4).'/vendor/doctrine/persistence/lib/Doctrine/Persistence/ObjectManager.php';
include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/EntityManagerInterface.php';
include_once \dirname(__DIR__, 4).'/vendor/doctrine/orm/lib/Doctrine/ORM/EntityManager.php';

class EntityManager_9a5be93 extends \Doctrine\ORM\EntityManager implements \ProxyManager\Proxy\VirtualProxyInterface
{
    /**
     * @var \Doctrine\ORM\EntityManager|null wrapped object, if the proxy is initialized
     */
    private $valueHolder42887 = null;

    /**
     * @var \Closure|null initializer responsible for generating the wrapped object
     */
    private $initializerfd19c = null;

    /**
     * @var bool[] map of public properties of the parent class
     */
    private static $publicProperties057ff = [
        
    ];

    public function getConnection()
    {
        $this->initializerfd19c && ($this->initializerfd19c->__invoke($valueHolder42887, $this, 'getConnection', array(), $this->initializerfd19c) || 1) && $this->valueHolder42887 = $valueHolder42887;

        return $this->valueHolder42887->getConnection();
    }

    public function getMetadataFactory()
    {
        $this->initializerfd19c && ($this->initializerfd19c->__invoke($valueHolder42887, $this, 'getMetadataFactory', array(), $this->initializerfd19c) || 1) && $this->valueHolder42887 = $valueHolder42887;

        return $this->valueHolder42887->getMetadataFactory();
    }

    public function getExpressionBuilder()
    {
        $this->initializerfd19c && ($this->initializerfd19c->__invoke($valueHolder42887, $this, 'getExpressionBuilder', array(), $this->initializerfd19c) || 1) && $this->valueHolder42887 = $valueHolder42887;

        return $this->valueHolder42887->getExpressionBuilder();
    }

    public function beginTransaction()
    {
        $this->initializerfd19c && ($this->initializerfd19c->__invoke($valueHolder42887, $this, 'beginTransaction', array(), $this->initializerfd19c) || 1) && $this->valueHolder42887 = $valueHolder42887;

        return $this->valueHolder42887->beginTransaction();
    }

    public function getCache()
    {
        $this->initializerfd19c && ($this->initializerfd19c->__invoke($valueHolder42887, $this, 'getCache', array(), $this->initializerfd19c) || 1) && $this->valueHolder42887 = $valueHolder42887;

        return $this->valueHolder42887->getCache();
    }

    public function transactional($func)
    {
        $this->initializerfd19c && ($this->initializerfd19c->__invoke($valueHolder42887, $this, 'transactional', array('func' => $func), $this->initializerfd19c) || 1) && $this->valueHolder42887 = $valueHolder42887;

        return $this->valueHolder42887->transactional($func);
    }

    public function commit()
    {
        $this->initializerfd19c && ($this->initializerfd19c->__invoke($valueHolder42887, $this, 'commit', array(), $this->initializerfd19c) || 1) && $this->valueHolder42887 = $valueHolder42887;

        return $this->valueHolder42887->commit();
    }

    public function rollback()
    {
        $this->initializerfd19c && ($this->initializerfd19c->__invoke($valueHolder42887, $this, 'rollback', array(), $this->initializerfd19c) || 1) && $this->valueHolder42887 = $valueHolder42887;

        return $this->valueHolder42887->rollback();
    }

    public function getClassMetadata($className)
    {
        $this->initializerfd19c && ($this->initializerfd19c->__invoke($valueHolder42887, $this, 'getClassMetadata', array('className' => $className), $this->initializerfd19c) || 1) && $this->valueHolder42887 = $valueHolder42887;

        return $this->valueHolder42887->getClassMetadata($className);
    }

    public function createQuery($dql = '')
    {
        $this->initializerfd19c && ($this->initializerfd19c->__invoke($valueHolder42887, $this, 'createQuery', array('dql' => $dql), $this->initializerfd19c) || 1) && $this->valueHolder42887 = $valueHolder42887;

        return $this->valueHolder42887->createQuery($dql);
    }

    public function createNamedQuery($name)
    {
        $this->initializerfd19c && ($this->initializerfd19c->__invoke($valueHolder42887, $this, 'createNamedQuery', array('name' => $name), $this->initializerfd19c) || 1) && $this->valueHolder42887 = $valueHolder42887;

        return $this->valueHolder42887->createNamedQuery($name);
    }

    public function createNativeQuery($sql, \Doctrine\ORM\Query\ResultSetMapping $rsm)
    {
        $this->initializerfd19c && ($this->initializerfd19c->__invoke($valueHolder42887, $this, 'createNativeQuery', array('sql' => $sql, 'rsm' => $rsm), $this->initializerfd19c) || 1) && $this->valueHolder42887 = $valueHolder42887;

        return $this->valueHolder42887->createNativeQuery($sql, $rsm);
    }

    public function createNamedNativeQuery($name)
    {
        $this->initializerfd19c && ($this->initializerfd19c->__invoke($valueHolder42887, $this, 'createNamedNativeQuery', array('name' => $name), $this->initializerfd19c) || 1) && $this->valueHolder42887 = $valueHolder42887;

        return $this->valueHolder42887->createNamedNativeQuery($name);
    }

    public function createQueryBuilder()
    {
        $this->initializerfd19c && ($this->initializerfd19c->__invoke($valueHolder42887, $this, 'createQueryBuilder', array(), $this->initializerfd19c) || 1) && $this->valueHolder42887 = $valueHolder42887;

        return $this->valueHolder42887->createQueryBuilder();
    }

    public function flush($entity = null)
    {
        $this->initializerfd19c && ($this->initializerfd19c->__invoke($valueHolder42887, $this, 'flush', array('entity' => $entity), $this->initializerfd19c) || 1) && $this->valueHolder42887 = $valueHolder42887;

        return $this->valueHolder42887->flush($entity);
    }

    public function find($className, $id, $lockMode = null, $lockVersion = null)
    {
        $this->initializerfd19c && ($this->initializerfd19c->__invoke($valueHolder42887, $this, 'find', array('className' => $className, 'id' => $id, 'lockMode' => $lockMode, 'lockVersion' => $lockVersion), $this->initializerfd19c) || 1) && $this->valueHolder42887 = $valueHolder42887;

        return $this->valueHolder42887->find($className, $id, $lockMode, $lockVersion);
    }

    public function getReference($entityName, $id)
    {
        $this->initializerfd19c && ($this->initializerfd19c->__invoke($valueHolder42887, $this, 'getReference', array('entityName' => $entityName, 'id' => $id), $this->initializerfd19c) || 1) && $this->valueHolder42887 = $valueHolder42887;

        return $this->valueHolder42887->getReference($entityName, $id);
    }

    public function getPartialReference($entityName, $identifier)
    {
        $this->initializerfd19c && ($this->initializerfd19c->__invoke($valueHolder42887, $this, 'getPartialReference', array('entityName' => $entityName, 'identifier' => $identifier), $this->initializerfd19c) || 1) && $this->valueHolder42887 = $valueHolder42887;

        return $this->valueHolder42887->getPartialReference($entityName, $identifier);
    }

    public function clear($entityName = null)
    {
        $this->initializerfd19c && ($this->initializerfd19c->__invoke($valueHolder42887, $this, 'clear', array('entityName' => $entityName), $this->initializerfd19c) || 1) && $this->valueHolder42887 = $valueHolder42887;

        return $this->valueHolder42887->clear($entityName);
    }

    public function close()
    {
        $this->initializerfd19c && ($this->initializerfd19c->__invoke($valueHolder42887, $this, 'close', array(), $this->initializerfd19c) || 1) && $this->valueHolder42887 = $valueHolder42887;

        return $this->valueHolder42887->close();
    }

    public function persist($entity)
    {
        $this->initializerfd19c && ($this->initializerfd19c->__invoke($valueHolder42887, $this, 'persist', array('entity' => $entity), $this->initializerfd19c) || 1) && $this->valueHolder42887 = $valueHolder42887;

        return $this->valueHolder42887->persist($entity);
    }

    public function remove($entity)
    {
        $this->initializerfd19c && ($this->initializerfd19c->__invoke($valueHolder42887, $this, 'remove', array('entity' => $entity), $this->initializerfd19c) || 1) && $this->valueHolder42887 = $valueHolder42887;

        return $this->valueHolder42887->remove($entity);
    }

    public function refresh($entity)
    {
        $this->initializerfd19c && ($this->initializerfd19c->__invoke($valueHolder42887, $this, 'refresh', array('entity' => $entity), $this->initializerfd19c) || 1) && $this->valueHolder42887 = $valueHolder42887;

        return $this->valueHolder42887->refresh($entity);
    }

    public function detach($entity)
    {
        $this->initializerfd19c && ($this->initializerfd19c->__invoke($valueHolder42887, $this, 'detach', array('entity' => $entity), $this->initializerfd19c) || 1) && $this->valueHolder42887 = $valueHolder42887;

        return $this->valueHolder42887->detach($entity);
    }

    public function merge($entity)
    {
        $this->initializerfd19c && ($this->initializerfd19c->__invoke($valueHolder42887, $this, 'merge', array('entity' => $entity), $this->initializerfd19c) || 1) && $this->valueHolder42887 = $valueHolder42887;

        return $this->valueHolder42887->merge($entity);
    }

    public function copy($entity, $deep = false)
    {
        $this->initializerfd19c && ($this->initializerfd19c->__invoke($valueHolder42887, $this, 'copy', array('entity' => $entity, 'deep' => $deep), $this->initializerfd19c) || 1) && $this->valueHolder42887 = $valueHolder42887;

        return $this->valueHolder42887->copy($entity, $deep);
    }

    public function lock($entity, $lockMode, $lockVersion = null)
    {
        $this->initializerfd19c && ($this->initializerfd19c->__invoke($valueHolder42887, $this, 'lock', array('entity' => $entity, 'lockMode' => $lockMode, 'lockVersion' => $lockVersion), $this->initializerfd19c) || 1) && $this->valueHolder42887 = $valueHolder42887;

        return $this->valueHolder42887->lock($entity, $lockMode, $lockVersion);
    }

    public function getRepository($entityName)
    {
        $this->initializerfd19c && ($this->initializerfd19c->__invoke($valueHolder42887, $this, 'getRepository', array('entityName' => $entityName), $this->initializerfd19c) || 1) && $this->valueHolder42887 = $valueHolder42887;

        return $this->valueHolder42887->getRepository($entityName);
    }

    public function contains($entity)
    {
        $this->initializerfd19c && ($this->initializerfd19c->__invoke($valueHolder42887, $this, 'contains', array('entity' => $entity), $this->initializerfd19c) || 1) && $this->valueHolder42887 = $valueHolder42887;

        return $this->valueHolder42887->contains($entity);
    }

    public function getEventManager()
    {
        $this->initializerfd19c && ($this->initializerfd19c->__invoke($valueHolder42887, $this, 'getEventManager', array(), $this->initializerfd19c) || 1) && $this->valueHolder42887 = $valueHolder42887;

        return $this->valueHolder42887->getEventManager();
    }

    public function getConfiguration()
    {
        $this->initializerfd19c && ($this->initializerfd19c->__invoke($valueHolder42887, $this, 'getConfiguration', array(), $this->initializerfd19c) || 1) && $this->valueHolder42887 = $valueHolder42887;

        return $this->valueHolder42887->getConfiguration();
    }

    public function isOpen()
    {
        $this->initializerfd19c && ($this->initializerfd19c->__invoke($valueHolder42887, $this, 'isOpen', array(), $this->initializerfd19c) || 1) && $this->valueHolder42887 = $valueHolder42887;

        return $this->valueHolder42887->isOpen();
    }

    public function getUnitOfWork()
    {
        $this->initializerfd19c && ($this->initializerfd19c->__invoke($valueHolder42887, $this, 'getUnitOfWork', array(), $this->initializerfd19c) || 1) && $this->valueHolder42887 = $valueHolder42887;

        return $this->valueHolder42887->getUnitOfWork();
    }

    public function getHydrator($hydrationMode)
    {
        $this->initializerfd19c && ($this->initializerfd19c->__invoke($valueHolder42887, $this, 'getHydrator', array('hydrationMode' => $hydrationMode), $this->initializerfd19c) || 1) && $this->valueHolder42887 = $valueHolder42887;

        return $this->valueHolder42887->getHydrator($hydrationMode);
    }

    public function newHydrator($hydrationMode)
    {
        $this->initializerfd19c && ($this->initializerfd19c->__invoke($valueHolder42887, $this, 'newHydrator', array('hydrationMode' => $hydrationMode), $this->initializerfd19c) || 1) && $this->valueHolder42887 = $valueHolder42887;

        return $this->valueHolder42887->newHydrator($hydrationMode);
    }

    public function getProxyFactory()
    {
        $this->initializerfd19c && ($this->initializerfd19c->__invoke($valueHolder42887, $this, 'getProxyFactory', array(), $this->initializerfd19c) || 1) && $this->valueHolder42887 = $valueHolder42887;

        return $this->valueHolder42887->getProxyFactory();
    }

    public function initializeObject($obj)
    {
        $this->initializerfd19c && ($this->initializerfd19c->__invoke($valueHolder42887, $this, 'initializeObject', array('obj' => $obj), $this->initializerfd19c) || 1) && $this->valueHolder42887 = $valueHolder42887;

        return $this->valueHolder42887->initializeObject($obj);
    }

    public function getFilters()
    {
        $this->initializerfd19c && ($this->initializerfd19c->__invoke($valueHolder42887, $this, 'getFilters', array(), $this->initializerfd19c) || 1) && $this->valueHolder42887 = $valueHolder42887;

        return $this->valueHolder42887->getFilters();
    }

    public function isFiltersStateClean()
    {
        $this->initializerfd19c && ($this->initializerfd19c->__invoke($valueHolder42887, $this, 'isFiltersStateClean', array(), $this->initializerfd19c) || 1) && $this->valueHolder42887 = $valueHolder42887;

        return $this->valueHolder42887->isFiltersStateClean();
    }

    public function hasFilters()
    {
        $this->initializerfd19c && ($this->initializerfd19c->__invoke($valueHolder42887, $this, 'hasFilters', array(), $this->initializerfd19c) || 1) && $this->valueHolder42887 = $valueHolder42887;

        return $this->valueHolder42887->hasFilters();
    }

    /**
     * Constructor for lazy initialization
     *
     * @param \Closure|null $initializer
     */
    public static function staticProxyConstructor($initializer)
    {
        static $reflection;

        $reflection = $reflection ?? new \ReflectionClass(__CLASS__);
        $instance   = $reflection->newInstanceWithoutConstructor();

        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $instance, 'Doctrine\\ORM\\EntityManager')->__invoke($instance);

        $instance->initializerfd19c = $initializer;

        return $instance;
    }

    protected function __construct(\Doctrine\DBAL\Connection $conn, \Doctrine\ORM\Configuration $config, \Doctrine\Common\EventManager $eventManager)
    {
        static $reflection;

        if (! $this->valueHolder42887) {
            $reflection = $reflection ?? new \ReflectionClass('Doctrine\\ORM\\EntityManager');
            $this->valueHolder42887 = $reflection->newInstanceWithoutConstructor();
        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $this, 'Doctrine\\ORM\\EntityManager')->__invoke($this);

        }

        $this->valueHolder42887->__construct($conn, $config, $eventManager);
    }

    public function & __get($name)
    {
        $this->initializerfd19c && ($this->initializerfd19c->__invoke($valueHolder42887, $this, '__get', ['name' => $name], $this->initializerfd19c) || 1) && $this->valueHolder42887 = $valueHolder42887;

        if (isset(self::$publicProperties057ff[$name])) {
            return $this->valueHolder42887->$name;
        }

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder42887;

            $backtrace = debug_backtrace(false, 1);
            trigger_error(
                sprintf(
                    'Undefined property: %s::$%s in %s on line %s',
                    $realInstanceReflection->getName(),
                    $name,
                    $backtrace[0]['file'],
                    $backtrace[0]['line']
                ),
                \E_USER_NOTICE
            );
            return $targetObject->$name;
        }

        $targetObject = $this->valueHolder42887;
        $accessor = function & () use ($targetObject, $name) {
            return $targetObject->$name;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = & $accessor();

        return $returnValue;
    }

    public function __set($name, $value)
    {
        $this->initializerfd19c && ($this->initializerfd19c->__invoke($valueHolder42887, $this, '__set', array('name' => $name, 'value' => $value), $this->initializerfd19c) || 1) && $this->valueHolder42887 = $valueHolder42887;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder42887;

            $targetObject->$name = $value;

            return $targetObject->$name;
        }

        $targetObject = $this->valueHolder42887;
        $accessor = function & () use ($targetObject, $name, $value) {
            $targetObject->$name = $value;

            return $targetObject->$name;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = & $accessor();

        return $returnValue;
    }

    public function __isset($name)
    {
        $this->initializerfd19c && ($this->initializerfd19c->__invoke($valueHolder42887, $this, '__isset', array('name' => $name), $this->initializerfd19c) || 1) && $this->valueHolder42887 = $valueHolder42887;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder42887;

            return isset($targetObject->$name);
        }

        $targetObject = $this->valueHolder42887;
        $accessor = function () use ($targetObject, $name) {
            return isset($targetObject->$name);
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $returnValue = $accessor();

        return $returnValue;
    }

    public function __unset($name)
    {
        $this->initializerfd19c && ($this->initializerfd19c->__invoke($valueHolder42887, $this, '__unset', array('name' => $name), $this->initializerfd19c) || 1) && $this->valueHolder42887 = $valueHolder42887;

        $realInstanceReflection = new \ReflectionClass('Doctrine\\ORM\\EntityManager');

        if (! $realInstanceReflection->hasProperty($name)) {
            $targetObject = $this->valueHolder42887;

            unset($targetObject->$name);

            return;
        }

        $targetObject = $this->valueHolder42887;
        $accessor = function () use ($targetObject, $name) {
            unset($targetObject->$name);

            return;
        };
        $backtrace = debug_backtrace(true, 2);
        $scopeObject = isset($backtrace[1]['object']) ? $backtrace[1]['object'] : new \ProxyManager\Stub\EmptyClassStub();
        $accessor = $accessor->bindTo($scopeObject, get_class($scopeObject));
        $accessor();
    }

    public function __clone()
    {
        $this->initializerfd19c && ($this->initializerfd19c->__invoke($valueHolder42887, $this, '__clone', array(), $this->initializerfd19c) || 1) && $this->valueHolder42887 = $valueHolder42887;

        $this->valueHolder42887 = clone $this->valueHolder42887;
    }

    public function __sleep()
    {
        $this->initializerfd19c && ($this->initializerfd19c->__invoke($valueHolder42887, $this, '__sleep', array(), $this->initializerfd19c) || 1) && $this->valueHolder42887 = $valueHolder42887;

        return array('valueHolder42887');
    }

    public function __wakeup()
    {
        \Closure::bind(function (\Doctrine\ORM\EntityManager $instance) {
            unset($instance->config, $instance->conn, $instance->metadataFactory, $instance->unitOfWork, $instance->eventManager, $instance->proxyFactory, $instance->repositoryFactory, $instance->expressionBuilder, $instance->closed, $instance->filterCollection, $instance->cache);
        }, $this, 'Doctrine\\ORM\\EntityManager')->__invoke($this);
    }

    public function setProxyInitializer(\Closure $initializer = null) : void
    {
        $this->initializerfd19c = $initializer;
    }

    public function getProxyInitializer() : ?\Closure
    {
        return $this->initializerfd19c;
    }

    public function initializeProxy() : bool
    {
        return $this->initializerfd19c && ($this->initializerfd19c->__invoke($valueHolder42887, $this, 'initializeProxy', array(), $this->initializerfd19c) || 1) && $this->valueHolder42887 = $valueHolder42887;
    }

    public function isProxyInitialized() : bool
    {
        return null !== $this->valueHolder42887;
    }

    public function getWrappedValueHolderValue()
    {
        return $this->valueHolder42887;
    }
}

if (!\class_exists('EntityManager_9a5be93', false)) {
    \class_alias(__NAMESPACE__.'\\EntityManager_9a5be93', 'EntityManager_9a5be93', false);
}

<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */
namespace ECSPrefix20210730\Symfony\Component\VarDumper\Cloner;

use ECSPrefix20210730\Symfony\Component\VarDumper\Caster\Caster;
use ECSPrefix20210730\Symfony\Component\VarDumper\Exception\ThrowingCasterException;
/**
 * AbstractCloner implements a generic caster mechanism for objects and resources.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 */
abstract class AbstractCloner implements \ECSPrefix20210730\Symfony\Component\VarDumper\Cloner\ClonerInterface
{
    public static $defaultCasters = ['__PHP_Incomplete_Class' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\Caster', 'castPhpIncompleteClass'], 'ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\CutStub' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'castStub'], 'ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\CutArrayStub' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'castCutArray'], 'ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\ConstStub' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'castStub'], 'ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\EnumStub' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'castEnum'], 'Closure' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castClosure'], 'Generator' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castGenerator'], 'ReflectionType' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castType'], 'ReflectionAttribute' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castAttribute'], 'ReflectionGenerator' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castReflectionGenerator'], 'ReflectionClass' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castClass'], 'ReflectionClassConstant' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castClassConstant'], 'ReflectionFunctionAbstract' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castFunctionAbstract'], 'ReflectionMethod' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castMethod'], 'ReflectionParameter' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castParameter'], 'ReflectionProperty' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castProperty'], 'ReflectionReference' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castReference'], 'ReflectionExtension' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castExtension'], 'ReflectionZendExtension' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\ReflectionCaster', 'castZendExtension'], 'ECSPrefix20210730\\Doctrine\\Common\\Persistence\\ObjectManager' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'cutInternals'], 'ECSPrefix20210730\\Doctrine\\Common\\Proxy\\Proxy' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\DoctrineCaster', 'castCommonProxy'], 'ECSPrefix20210730\\Doctrine\\ORM\\Proxy\\Proxy' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\DoctrineCaster', 'castOrmProxy'], 'ECSPrefix20210730\\Doctrine\\ORM\\PersistentCollection' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\DoctrineCaster', 'castPersistentCollection'], 'ECSPrefix20210730\\Doctrine\\Persistence\\ObjectManager' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'cutInternals'], 'DOMException' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castException'], 'DOMStringList' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castLength'], 'DOMNameList' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castLength'], 'DOMImplementation' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castImplementation'], 'DOMImplementationList' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castLength'], 'DOMNode' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castNode'], 'DOMNameSpaceNode' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castNameSpaceNode'], 'DOMDocument' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castDocument'], 'DOMNodeList' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castLength'], 'DOMNamedNodeMap' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castLength'], 'DOMCharacterData' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castCharacterData'], 'DOMAttr' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castAttr'], 'DOMElement' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castElement'], 'DOMText' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castText'], 'DOMTypeinfo' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castTypeinfo'], 'DOMDomError' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castDomError'], 'DOMLocator' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castLocator'], 'DOMDocumentType' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castDocumentType'], 'DOMNotation' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castNotation'], 'DOMEntity' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castEntity'], 'DOMProcessingInstruction' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castProcessingInstruction'], 'DOMXPath' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\DOMCaster', 'castXPath'], 'XMLReader' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\XmlReaderCaster', 'castXmlReader'], 'ErrorException' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\ExceptionCaster', 'castErrorException'], 'Exception' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\ExceptionCaster', 'castException'], 'Error' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\ExceptionCaster', 'castError'], 'ECSPrefix20210730\\Symfony\\Bridge\\Monolog\\Logger' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'cutInternals'], 'ECSPrefix20210730\\Symfony\\Component\\DependencyInjection\\ContainerInterface' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'cutInternals'], 'ECSPrefix20210730\\Symfony\\Component\\EventDispatcher\\EventDispatcherInterface' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'cutInternals'], 'ECSPrefix20210730\\Symfony\\Component\\HttpClient\\CurlHttpClient' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\SymfonyCaster', 'castHttpClient'], 'ECSPrefix20210730\\Symfony\\Component\\HttpClient\\NativeHttpClient' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\SymfonyCaster', 'castHttpClient'], 'ECSPrefix20210730\\Symfony\\Component\\HttpClient\\Response\\CurlResponse' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\SymfonyCaster', 'castHttpClientResponse'], 'ECSPrefix20210730\\Symfony\\Component\\HttpClient\\Response\\NativeResponse' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\SymfonyCaster', 'castHttpClientResponse'], 'ECSPrefix20210730\\Symfony\\Component\\HttpFoundation\\Request' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\SymfonyCaster', 'castRequest'], 'ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Exception\\ThrowingCasterException' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\ExceptionCaster', 'castThrowingCasterException'], 'ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\TraceStub' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\ExceptionCaster', 'castTraceStub'], 'ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\FrameStub' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\ExceptionCaster', 'castFrameStub'], 'ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Cloner\\AbstractCloner' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'cutInternals'], 'ECSPrefix20210730\\Symfony\\Component\\ErrorHandler\\Exception\\SilencedErrorContext' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\ExceptionCaster', 'castSilencedErrorContext'], 'ECSPrefix20210730\\Imagine\\Image\\ImageInterface' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\ImagineCaster', 'castImage'], 'ECSPrefix20210730\\Ramsey\\Uuid\\UuidInterface' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\UuidCaster', 'castRamseyUuid'], 'ECSPrefix20210730\\ProxyManager\\Proxy\\ProxyInterface' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\ProxyManagerCaster', 'castProxy'], 'PHPUnit_Framework_MockObject_MockObject' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'cutInternals'], 'ECSPrefix20210730\\PHPUnit\\Framework\\MockObject\\MockObject' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'cutInternals'], 'ECSPrefix20210730\\PHPUnit\\Framework\\MockObject\\Stub' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'cutInternals'], 'ECSPrefix20210730\\Prophecy\\Prophecy\\ProphecySubjectInterface' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'cutInternals'], 'ECSPrefix20210730\\Mockery\\MockInterface' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\StubCaster', 'cutInternals'], 'PDO' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\PdoCaster', 'castPdo'], 'PDOStatement' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\PdoCaster', 'castPdoStatement'], 'AMQPConnection' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\AmqpCaster', 'castConnection'], 'AMQPChannel' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\AmqpCaster', 'castChannel'], 'AMQPQueue' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\AmqpCaster', 'castQueue'], 'AMQPExchange' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\AmqpCaster', 'castExchange'], 'AMQPEnvelope' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\AmqpCaster', 'castEnvelope'], 'ArrayObject' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\SplCaster', 'castArrayObject'], 'ArrayIterator' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\SplCaster', 'castArrayIterator'], 'SplDoublyLinkedList' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\SplCaster', 'castDoublyLinkedList'], 'SplFileInfo' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\SplCaster', 'castFileInfo'], 'SplFileObject' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\SplCaster', 'castFileObject'], 'SplHeap' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\SplCaster', 'castHeap'], 'SplObjectStorage' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\SplCaster', 'castObjectStorage'], 'SplPriorityQueue' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\SplCaster', 'castHeap'], 'OuterIterator' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\SplCaster', 'castOuterIterator'], 'WeakReference' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\SplCaster', 'castWeakReference'], 'Redis' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\RedisCaster', 'castRedis'], 'RedisArray' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\RedisCaster', 'castRedisArray'], 'RedisCluster' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\RedisCaster', 'castRedisCluster'], 'DateTimeInterface' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\DateCaster', 'castDateTime'], 'DateInterval' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\DateCaster', 'castInterval'], 'DateTimeZone' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\DateCaster', 'castTimeZone'], 'DatePeriod' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\DateCaster', 'castPeriod'], 'GMP' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\GmpCaster', 'castGmp'], 'MessageFormatter' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\IntlCaster', 'castMessageFormatter'], 'NumberFormatter' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\IntlCaster', 'castNumberFormatter'], 'IntlTimeZone' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\IntlCaster', 'castIntlTimeZone'], 'IntlCalendar' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\IntlCaster', 'castIntlCalendar'], 'IntlDateFormatter' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\IntlCaster', 'castIntlDateFormatter'], 'Memcached' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\MemcachedCaster', 'castMemcached'], 'ECSPrefix20210730\\Ds\\Collection' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\DsCaster', 'castCollection'], 'ECSPrefix20210730\\Ds\\Map' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\DsCaster', 'castMap'], 'ECSPrefix20210730\\Ds\\Pair' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\DsCaster', 'castPair'], 'ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\DsPairStub' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\DsCaster', 'castPairStub'], 'CurlHandle' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castCurl'], ':curl' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castCurl'], ':dba' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castDba'], ':dba persistent' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castDba'], 'GdImage' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castGd'], ':gd' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castGd'], ':mysql link' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castMysqlLink'], ':pgsql large object' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\PgSqlCaster', 'castLargeObject'], ':pgsql link' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\PgSqlCaster', 'castLink'], ':pgsql link persistent' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\PgSqlCaster', 'castLink'], ':pgsql result' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\PgSqlCaster', 'castResult'], ':process' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castProcess'], ':stream' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castStream'], 'OpenSSLCertificate' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castOpensslX509'], ':OpenSSL X.509' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castOpensslX509'], ':persistent stream' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castStream'], ':stream-context' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\ResourceCaster', 'castStreamContext'], 'XmlParser' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\XmlResourceCaster', 'castXml'], ':xml' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\XmlResourceCaster', 'castXml'], 'RdKafka' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\RdKafkaCaster', 'castRdKafka'], 'ECSPrefix20210730\\RdKafka\\Conf' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\RdKafkaCaster', 'castConf'], 'ECSPrefix20210730\\RdKafka\\KafkaConsumer' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\RdKafkaCaster', 'castKafkaConsumer'], 'ECSPrefix20210730\\RdKafka\\Metadata\\Broker' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\RdKafkaCaster', 'castBrokerMetadata'], 'ECSPrefix20210730\\RdKafka\\Metadata\\Collection' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\RdKafkaCaster', 'castCollectionMetadata'], 'ECSPrefix20210730\\RdKafka\\Metadata\\Partition' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\RdKafkaCaster', 'castPartitionMetadata'], 'ECSPrefix20210730\\RdKafka\\Metadata\\Topic' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\RdKafkaCaster', 'castTopicMetadata'], 'ECSPrefix20210730\\RdKafka\\Message' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\RdKafkaCaster', 'castMessage'], 'ECSPrefix20210730\\RdKafka\\Topic' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\RdKafkaCaster', 'castTopic'], 'ECSPrefix20210730\\RdKafka\\TopicPartition' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\RdKafkaCaster', 'castTopicPartition'], 'ECSPrefix20210730\\RdKafka\\TopicConf' => ['ECSPrefix20210730\\Symfony\\Component\\VarDumper\\Caster\\RdKafkaCaster', 'castTopicConf']];
    protected $maxItems = 2500;
    protected $maxString = -1;
    protected $minDepth = 1;
    private $casters = [];
    private $prevErrorHandler;
    private $classInfo = [];
    private $filter = 0;
    /**
     * @param callable[]|null $casters A map of casters
     *
     * @see addCasters
     */
    public function __construct(array $casters = null)
    {
        if (null === $casters) {
            $casters = static::$defaultCasters;
        }
        $this->addCasters($casters);
    }
    /**
     * Adds casters for resources and objects.
     *
     * Maps resources or objects types to a callback.
     * Types are in the key, with a callable caster for value.
     * Resource types are to be prefixed with a `:`,
     * see e.g. static::$defaultCasters.
     *
     * @param callable[] $casters A map of casters
     */
    public function addCasters($casters)
    {
        foreach ($casters as $type => $callback) {
            $this->casters[$type][] = $callback;
        }
    }
    /**
     * Sets the maximum number of items to clone past the minimum depth in nested structures.
     * @param int $maxItems
     */
    public function setMaxItems($maxItems)
    {
        $this->maxItems = $maxItems;
    }
    /**
     * Sets the maximum cloned length for strings.
     * @param int $maxString
     */
    public function setMaxString($maxString)
    {
        $this->maxString = $maxString;
    }
    /**
     * Sets the minimum tree depth where we are guaranteed to clone all the items.  After this
     * depth is reached, only setMaxItems items will be cloned.
     * @param int $minDepth
     */
    public function setMinDepth($minDepth)
    {
        $this->minDepth = $minDepth;
    }
    /**
     * Clones a PHP variable.
     *
     * @param mixed $var    Any PHP variable
     * @param int   $filter A bit field of Caster::EXCLUDE_* constants
     *
     * @return Data The cloned variable represented by a Data object
     */
    public function cloneVar($var, $filter = 0)
    {
        $this->prevErrorHandler = \set_error_handler(function ($type, $msg, $file, $line, $context = []) {
            if (\E_RECOVERABLE_ERROR === $type || \E_USER_ERROR === $type) {
                // Cloner never dies
                throw new \ErrorException($msg, 0, $type, $file, $line);
            }
            if ($this->prevErrorHandler) {
                return ($this->prevErrorHandler)($type, $msg, $file, $line, $context);
            }
            return \false;
        });
        $this->filter = $filter;
        if ($gc = \gc_enabled()) {
            \gc_disable();
        }
        try {
            return new \ECSPrefix20210730\Symfony\Component\VarDumper\Cloner\Data($this->doClone($var));
        } finally {
            if ($gc) {
                \gc_enable();
            }
            \restore_error_handler();
            $this->prevErrorHandler = null;
        }
    }
    /**
     * Effectively clones the PHP variable.
     *
     * @param mixed $var Any PHP variable
     *
     * @return array The cloned variable represented in an array
     */
    protected abstract function doClone($var);
    /**
     * Casts an object to an array representation.
     *
     * @param bool $isNested True if the object is nested in the dumped structure
     *
     * @return array The object casted as array
     * @param \Symfony\Component\VarDumper\Cloner\Stub $stub
     */
    protected function castObject($stub, $isNested)
    {
        $obj = $stub->value;
        $class = $stub->class;
        if (\PHP_VERSION_ID < 80000 ? "\0" === ($class[15] ?? null) : \strpos($class, "@anonymous\0") !== \false) {
            $stub->class = \get_debug_type($obj);
        }
        if (isset($this->classInfo[$class])) {
            list($i, $parents, $hasDebugInfo, $fileInfo) = $this->classInfo[$class];
        } else {
            $i = 2;
            $parents = [$class];
            $hasDebugInfo = \method_exists($class, '__debugInfo');
            foreach (\class_parents($class) as $p) {
                $parents[] = $p;
                ++$i;
            }
            foreach (\class_implements($class) as $p) {
                $parents[] = $p;
                ++$i;
            }
            $parents[] = '*';
            $r = new \ReflectionClass($class);
            $fileInfo = $r->isInternal() || $r->isSubclassOf(\ECSPrefix20210730\Symfony\Component\VarDumper\Cloner\Stub::class) ? [] : ['file' => $r->getFileName(), 'line' => $r->getStartLine()];
            $this->classInfo[$class] = [$i, $parents, $hasDebugInfo, $fileInfo];
        }
        $stub->attr += $fileInfo;
        $a = \ECSPrefix20210730\Symfony\Component\VarDumper\Caster\Caster::castObject($obj, $class, $hasDebugInfo, $stub->class);
        try {
            while ($i--) {
                if (!empty($this->casters[$p = $parents[$i]])) {
                    foreach ($this->casters[$p] as $callback) {
                        $a = $callback($obj, $a, $stub, $isNested, $this->filter);
                    }
                }
            }
        } catch (\Exception $e) {
            $a = [(\ECSPrefix20210730\Symfony\Component\VarDumper\Cloner\Stub::TYPE_OBJECT === $stub->type ? \ECSPrefix20210730\Symfony\Component\VarDumper\Caster\Caster::PREFIX_VIRTUAL : '') . '⚠' => new \ECSPrefix20210730\Symfony\Component\VarDumper\Exception\ThrowingCasterException($e)] + $a;
        }
        return $a;
    }
    /**
     * Casts a resource to an array representation.
     *
     * @param bool $isNested True if the object is nested in the dumped structure
     *
     * @return array The resource casted as array
     * @param \Symfony\Component\VarDumper\Cloner\Stub $stub
     */
    protected function castResource($stub, $isNested)
    {
        $a = [];
        $res = $stub->value;
        $type = $stub->class;
        try {
            if (!empty($this->casters[':' . $type])) {
                foreach ($this->casters[':' . $type] as $callback) {
                    $a = $callback($res, $a, $stub, $isNested, $this->filter);
                }
            }
        } catch (\Exception $e) {
            $a = [(\ECSPrefix20210730\Symfony\Component\VarDumper\Cloner\Stub::TYPE_OBJECT === $stub->type ? \ECSPrefix20210730\Symfony\Component\VarDumper\Caster\Caster::PREFIX_VIRTUAL : '') . '⚠' => new \ECSPrefix20210730\Symfony\Component\VarDumper\Exception\ThrowingCasterException($e)] + $a;
        }
        return $a;
    }
}

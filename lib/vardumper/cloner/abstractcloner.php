<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Silversite\Toolkit\VarDumper\Cloner;

use Silversite\Toolkit\VarDumper\Caster\Caster;
use Silversite\Toolkit\VarDumper\Exception\ThrowingCasterException;

/**
 * AbstractCloner implements a generic caster mechanism for objects and resources.
 *
 * @author Nicolas Grekas <p@tchwork.com>
 */
abstract class AbstractCloner implements ClonerInterface
{
    public static $defaultCasters = array(
        'Silversite\Toolkit\VarDumper\Caster\CutStub' => 'Silversite\Toolkit\VarDumper\Caster\StubCaster::castStub',
        'Silversite\Toolkit\VarDumper\Caster\CutArrayStub' => 'Silversite\Toolkit\VarDumper\Caster\StubCaster::castCutArray',
        'Silversite\Toolkit\VarDumper\Caster\ConstStub' => 'Silversite\Toolkit\VarDumper\Caster\StubCaster::castStub',
        'Silversite\Toolkit\VarDumper\Caster\EnumStub' => 'Silversite\Toolkit\VarDumper\Caster\StubCaster::castEnum',

        'Closure' => 'Silversite\Toolkit\VarDumper\Caster\ReflectionCaster::castClosure',
        'Generator' => 'Silversite\Toolkit\VarDumper\Caster\ReflectionCaster::castGenerator',
        'ReflectionType' => 'Silversite\Toolkit\VarDumper\Caster\ReflectionCaster::castType',
        'ReflectionGenerator' => 'Silversite\Toolkit\VarDumper\Caster\ReflectionCaster::castReflectionGenerator',
        'ReflectionClass' => 'Silversite\Toolkit\VarDumper\Caster\ReflectionCaster::castClass',
        'ReflectionFunctionAbstract' => 'Silversite\Toolkit\VarDumper\Caster\ReflectionCaster::castFunctionAbstract',
        'ReflectionMethod' => 'Silversite\Toolkit\VarDumper\Caster\ReflectionCaster::castMethod',
        'ReflectionParameter' => 'Silversite\Toolkit\VarDumper\Caster\ReflectionCaster::castParameter',
        'ReflectionProperty' => 'Silversite\Toolkit\VarDumper\Caster\ReflectionCaster::castProperty',
        'ReflectionExtension' => 'Silversite\Toolkit\VarDumper\Caster\ReflectionCaster::castExtension',
        'ReflectionZendExtension' => 'Silversite\Toolkit\VarDumper\Caster\ReflectionCaster::castZendExtension',

        'Doctrine\Common\Persistence\ObjectManager' => 'Silversite\Toolkit\VarDumper\Caster\StubCaster::cutInternals',
        'Doctrine\Common\Proxy\Proxy' => 'Silversite\Toolkit\VarDumper\Caster\DoctrineCaster::castCommonProxy',
        'Doctrine\ORM\Proxy\Proxy' => 'Silversite\Toolkit\VarDumper\Caster\DoctrineCaster::castOrmProxy',
        'Doctrine\ORM\PersistentCollection' => 'Silversite\Toolkit\VarDumper\Caster\DoctrineCaster::castPersistentCollection',

        'DOMException' => 'Silversite\Toolkit\VarDumper\Caster\DOMCaster::castException',
        'DOMStringList' => 'Silversite\Toolkit\VarDumper\Caster\DOMCaster::castLength',
        'DOMNameList' => 'Silversite\Toolkit\VarDumper\Caster\DOMCaster::castLength',
        'DOMImplementation' => 'Silversite\Toolkit\VarDumper\Caster\DOMCaster::castImplementation',
        'DOMImplementationList' => 'Silversite\Toolkit\VarDumper\Caster\DOMCaster::castLength',
        'DOMNode' => 'Silversite\Toolkit\VarDumper\Caster\DOMCaster::castNode',
        'DOMNameSpaceNode' => 'Silversite\Toolkit\VarDumper\Caster\DOMCaster::castNameSpaceNode',
        'DOMDocument' => 'Silversite\Toolkit\VarDumper\Caster\DOMCaster::castDocument',
        'DOMNodeList' => 'Silversite\Toolkit\VarDumper\Caster\DOMCaster::castLength',
        'DOMNamedNodeMap' => 'Silversite\Toolkit\VarDumper\Caster\DOMCaster::castLength',
        'DOMCharacterData' => 'Silversite\Toolkit\VarDumper\Caster\DOMCaster::castCharacterData',
        'DOMAttr' => 'Silversite\Toolkit\VarDumper\Caster\DOMCaster::castAttr',
        'DOMElement' => 'Silversite\Toolkit\VarDumper\Caster\DOMCaster::castElement',
        'DOMText' => 'Silversite\Toolkit\VarDumper\Caster\DOMCaster::castText',
        'DOMTypeinfo' => 'Silversite\Toolkit\VarDumper\Caster\DOMCaster::castTypeinfo',
        'DOMDomError' => 'Silversite\Toolkit\VarDumper\Caster\DOMCaster::castDomError',
        'DOMLocator' => 'Silversite\Toolkit\VarDumper\Caster\DOMCaster::castLocator',
        'DOMDocumentType' => 'Silversite\Toolkit\VarDumper\Caster\DOMCaster::castDocumentType',
        'DOMNotation' => 'Silversite\Toolkit\VarDumper\Caster\DOMCaster::castNotation',
        'DOMEntity' => 'Silversite\Toolkit\VarDumper\Caster\DOMCaster::castEntity',
        'DOMProcessingInstruction' => 'Silversite\Toolkit\VarDumper\Caster\DOMCaster::castProcessingInstruction',
        'DOMXPath' => 'Silversite\Toolkit\VarDumper\Caster\DOMCaster::castXPath',

        'ErrorException' => 'Silversite\Toolkit\VarDumper\Caster\ExceptionCaster::castErrorException',
        'Exception' => 'Silversite\Toolkit\VarDumper\Caster\ExceptionCaster::castException',
        'Error' => 'Silversite\Toolkit\VarDumper\Caster\ExceptionCaster::castError',
        'Silversite\Toolkit\DependencyInjection\ContainerInterface' => 'Silversite\Toolkit\VarDumper\Caster\StubCaster::cutInternals',
        'Silversite\Toolkit\VarDumper\Exception\ThrowingCasterException' => 'Silversite\Toolkit\VarDumper\Caster\ExceptionCaster::castThrowingCasterException',
        'Silversite\Toolkit\VarDumper\Caster\TraceStub' => 'Silversite\Toolkit\VarDumper\Caster\ExceptionCaster::castTraceStub',
        'Silversite\Toolkit\VarDumper\Caster\FrameStub' => 'Silversite\Toolkit\VarDumper\Caster\ExceptionCaster::castFrameStub',

        'PHPUnit_Framework_MockObject_MockObject' => 'Silversite\Toolkit\VarDumper\Caster\StubCaster::cutInternals',
        'Prophecy\Prophecy\ProphecySubjectInterface' => 'Silversite\Toolkit\VarDumper\Caster\StubCaster::cutInternals',
        'Mockery\MockInterface' => 'Silversite\Toolkit\VarDumper\Caster\StubCaster::cutInternals',

        'PDO' => 'Silversite\Toolkit\VarDumper\Caster\PdoCaster::castPdo',
        'PDOStatement' => 'Silversite\Toolkit\VarDumper\Caster\PdoCaster::castPdoStatement',

        'AMQPConnection' => 'Silversite\Toolkit\VarDumper\Caster\AmqpCaster::castConnection',
        'AMQPChannel' => 'Silversite\Toolkit\VarDumper\Caster\AmqpCaster::castChannel',
        'AMQPQueue' => 'Silversite\Toolkit\VarDumper\Caster\AmqpCaster::castQueue',
        'AMQPExchange' => 'Silversite\Toolkit\VarDumper\Caster\AmqpCaster::castExchange',
        'AMQPEnvelope' => 'Silversite\Toolkit\VarDumper\Caster\AmqpCaster::castEnvelope',

        'ArrayObject' => 'Silversite\Toolkit\VarDumper\Caster\SplCaster::castArrayObject',
        'SplDoublyLinkedList' => 'Silversite\Toolkit\VarDumper\Caster\SplCaster::castDoublyLinkedList',
        'SplFileInfo' => 'Silversite\Toolkit\VarDumper\Caster\SplCaster::castFileInfo',
        'SplFileObject' => 'Silversite\Toolkit\VarDumper\Caster\SplCaster::castFileObject',
        'SplFixedArray' => 'Silversite\Toolkit\VarDumper\Caster\SplCaster::castFixedArray',
        'SplHeap' => 'Silversite\Toolkit\VarDumper\Caster\SplCaster::castHeap',
        'SplObjectStorage' => 'Silversite\Toolkit\VarDumper\Caster\SplCaster::castObjectStorage',
        'SplPriorityQueue' => 'Silversite\Toolkit\VarDumper\Caster\SplCaster::castHeap',
        'OuterIterator' => 'Silversite\Toolkit\VarDumper\Caster\SplCaster::castOuterIterator',

        'MongoCursorInterface' => 'Silversite\Toolkit\VarDumper\Caster\MongoCaster::castCursor',

        ':curl' => 'Silversite\Toolkit\VarDumper\Caster\ResourceCaster::castCurl',
        ':dba' => 'Silversite\Toolkit\VarDumper\Caster\ResourceCaster::castDba',
        ':dba persistent' => 'Silversite\Toolkit\VarDumper\Caster\ResourceCaster::castDba',
        ':gd' => 'Silversite\Toolkit\VarDumper\Caster\ResourceCaster::castGd',
        ':mysql link' => 'Silversite\Toolkit\VarDumper\Caster\ResourceCaster::castMysqlLink',
        ':pgsql large object' => 'Silversite\Toolkit\VarDumper\Caster\PgSqlCaster::castLargeObject',
        ':pgsql link' => 'Silversite\Toolkit\VarDumper\Caster\PgSqlCaster::castLink',
        ':pgsql link persistent' => 'Silversite\Toolkit\VarDumper\Caster\PgSqlCaster::castLink',
        ':pgsql result' => 'Silversite\Toolkit\VarDumper\Caster\PgSqlCaster::castResult',
        ':process' => 'Silversite\Toolkit\VarDumper\Caster\ResourceCaster::castProcess',
        ':stream' => 'Silversite\Toolkit\VarDumper\Caster\ResourceCaster::castStream',
        ':stream-context' => 'Silversite\Toolkit\VarDumper\Caster\ResourceCaster::castStreamContext',
        ':xml' => 'Silversite\Toolkit\VarDumper\Caster\XmlResourceCaster::castXml',
    );

    protected $maxItems = 2500;
    protected $maxString = -1;
    protected $useExt;

    private $casters = array();
    private $prevErrorHandler;
    private $classInfo = array();
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
        $this->useExt = extension_loaded('symfony_debug');
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
    public function addCasters(array $casters)
    {
        foreach ($casters as $type => $callback) {
            $this->casters[strtolower($type)][] = $callback;
        }
    }

    /**
     * Sets the maximum number of items to clone past the first level in nested structures.
     *
     * @param int $maxItems
     */
    public function setMaxItems($maxItems)
    {
        $this->maxItems = (int) $maxItems;
    }

    /**
     * Sets the maximum cloned length for strings.
     *
     * @param int $maxString
     */
    public function setMaxString($maxString)
    {
        $this->maxString = (int) $maxString;
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
        $this->prevErrorHandler = set_error_handler(function ($type, $msg, $file, $line, $context) {
            if (E_RECOVERABLE_ERROR === $type || E_USER_ERROR === $type) {
                // Cloner never dies
                throw new \ErrorException($msg, 0, $type, $file, $line);
            }

            if ($this->prevErrorHandler) {
                return call_user_func($this->prevErrorHandler, $type, $msg, $file, $line, $context);
            }

            return false;
        });
        $this->filter = $filter;

        try {
            $data = $this->doClone($var);
        } catch (\Exception $e) {
        }
        restore_error_handler();
        $this->prevErrorHandler = null;

        if (isset($e)) {
            throw $e;
        }

        return new Data($data);
    }

    /**
     * Effectively clones the PHP variable.
     *
     * @param mixed $var Any PHP variable
     *
     * @return array The cloned variable represented in an array
     */
    abstract protected function doClone($var);

    /**
     * Casts an object to an array representation.
     *
     * @param Stub $stub     The Stub for the casted object
     * @param bool $isNested True if the object is nested in the dumped structure
     *
     * @return array The object casted as array
     */
    protected function castObject(Stub $stub, $isNested)
    {
        $obj = $stub->value;
        $class = $stub->class;

        if (isset($class[15]) && "\0" === $class[15] && 0 === strpos($class, "class@anonymous\x00")) {
            $stub->class = get_parent_class($class).'@anonymous';
        }
        if (isset($this->classInfo[$class])) {
            $classInfo = $this->classInfo[$class];
        } else {
            $classInfo = array(
                new \ReflectionClass($class),
                array_reverse(array($class => $class) + class_parents($class) + class_implements($class) + array('*' => '*')),
            );

            $this->classInfo[$class] = $classInfo;
        }

        $a = $this->callCaster('Silversite\Toolkit\VarDumper\Caster\Caster::castObject', $obj, $classInfo[0], null, $isNested);

        foreach ($classInfo[1] as $p) {
            if (!empty($this->casters[$p = strtolower($p)])) {
                foreach ($this->casters[$p] as $p) {
                    $a = $this->callCaster($p, $obj, $a, $stub, $isNested);
                }
            }
        }

        return $a;
    }

    /**
     * Casts a resource to an array representation.
     *
     * @param Stub $stub     The Stub for the casted resource
     * @param bool $isNested True if the object is nested in the dumped structure
     *
     * @return array The resource casted as array
     */
    protected function castResource(Stub $stub, $isNested)
    {
        $a = array();
        $res = $stub->value;
        $type = $stub->class;

        if (!empty($this->casters[':'.$type])) {
            foreach ($this->casters[':'.$type] as $c) {
                $a = $this->callCaster($c, $res, $a, $stub, $isNested);
            }
        }

        return $a;
    }

    /**
     * Calls a custom caster.
     *
     * @param callable        $callback The caster
     * @param object|resource $obj      The object/resource being casted
     * @param array           $a        The result of the previous cast for chained casters
     * @param Stub            $stub     The Stub for the casted object/resource
     * @param bool            $isNested True if $obj is nested in the dumped structure
     *
     * @return array The casted object/resource
     */
    private function callCaster($callback, $obj, $a, $stub, $isNested)
    {
        try {
            $cast = call_user_func($callback, $obj, $a, $stub, $isNested, $this->filter);

            if (is_array($cast)) {
                $a = $cast;
            }
        } catch (\Exception $e) {
            $a[(Stub::TYPE_OBJECT === $stub->type ? Caster::PREFIX_VIRTUAL : '').'⚠'] = new ThrowingCasterException($e);
        }

        return $a;
    }
}

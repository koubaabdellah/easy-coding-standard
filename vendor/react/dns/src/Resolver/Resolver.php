<?php

namespace ECSPrefix20220130\React\Dns\Resolver;

use ECSPrefix20220130\React\Dns\Model\Message;
use ECSPrefix20220130\React\Dns\Query\ExecutorInterface;
use ECSPrefix20220130\React\Dns\Query\Query;
use ECSPrefix20220130\React\Dns\RecordNotFoundException;
/**
 * @see ResolverInterface for the base interface
 */
final class Resolver implements \ECSPrefix20220130\React\Dns\Resolver\ResolverInterface
{
    private $executor;
    public function __construct(\ECSPrefix20220130\React\Dns\Query\ExecutorInterface $executor)
    {
        $this->executor = $executor;
    }
    public function resolve($domain)
    {
        return $this->resolveAll($domain, \ECSPrefix20220130\React\Dns\Model\Message::TYPE_A)->then(function (array $ips) {
            return $ips[\array_rand($ips)];
        });
    }
    public function resolveAll($domain, $type)
    {
        $query = new \ECSPrefix20220130\React\Dns\Query\Query($domain, $type, \ECSPrefix20220130\React\Dns\Model\Message::CLASS_IN);
        $that = $this;
        return $this->executor->query($query)->then(function (\ECSPrefix20220130\React\Dns\Model\Message $response) use($query, $that) {
            return $that->extractValues($query, $response);
        });
    }
    /**
     * [Internal] extract all resource record values from response for this query
     *
     * @param Query   $query
     * @param Message $response
     * @return array
     * @throws RecordNotFoundException when response indicates an error or contains no data
     * @internal
     */
    public function extractValues(\ECSPrefix20220130\React\Dns\Query\Query $query, \ECSPrefix20220130\React\Dns\Model\Message $response)
    {
        // reject if response code indicates this is an error response message
        $code = $response->rcode;
        if ($code !== \ECSPrefix20220130\React\Dns\Model\Message::RCODE_OK) {
            switch ($code) {
                case \ECSPrefix20220130\React\Dns\Model\Message::RCODE_FORMAT_ERROR:
                    $message = 'Format Error';
                    break;
                case \ECSPrefix20220130\React\Dns\Model\Message::RCODE_SERVER_FAILURE:
                    $message = 'Server Failure';
                    break;
                case \ECSPrefix20220130\React\Dns\Model\Message::RCODE_NAME_ERROR:
                    $message = 'Non-Existent Domain / NXDOMAIN';
                    break;
                case \ECSPrefix20220130\React\Dns\Model\Message::RCODE_NOT_IMPLEMENTED:
                    $message = 'Not Implemented';
                    break;
                case \ECSPrefix20220130\React\Dns\Model\Message::RCODE_REFUSED:
                    $message = 'Refused';
                    break;
                default:
                    $message = 'Unknown error response code ' . $code;
            }
            throw new \ECSPrefix20220130\React\Dns\RecordNotFoundException('DNS query for ' . $query->describe() . ' returned an error response (' . $message . ')', $code);
        }
        $answers = $response->answers;
        $addresses = $this->valuesByNameAndType($answers, $query->name, $query->type);
        // reject if we did not receive a valid answer (domain is valid, but no record for this type could be found)
        if (0 === \count($addresses)) {
            throw new \ECSPrefix20220130\React\Dns\RecordNotFoundException('DNS query for ' . $query->describe() . ' did not return a valid answer (NOERROR / NODATA)');
        }
        return \array_values($addresses);
    }
    /**
     * @param \React\Dns\Model\Record[] $answers
     * @param string                    $name
     * @param int                       $type
     * @return array
     */
    private function valuesByNameAndType(array $answers, $name, $type)
    {
        // return all record values for this name and type (if any)
        $named = $this->filterByName($answers, $name);
        $records = $this->filterByType($named, $type);
        if ($records) {
            return $this->mapRecordData($records);
        }
        // no matching records found? check if there are any matching CNAMEs instead
        $cnameRecords = $this->filterByType($named, \ECSPrefix20220130\React\Dns\Model\Message::TYPE_CNAME);
        if ($cnameRecords) {
            $cnames = $this->mapRecordData($cnameRecords);
            foreach ($cnames as $cname) {
                $records = \array_merge($records, $this->valuesByNameAndType($answers, $cname, $type));
            }
        }
        return $records;
    }
    private function filterByName(array $answers, $name)
    {
        return $this->filterByField($answers, 'name', $name);
    }
    private function filterByType(array $answers, $type)
    {
        return $this->filterByField($answers, 'type', $type);
    }
    private function filterByField(array $answers, $field, $value)
    {
        $value = \strtolower($value);
        return \array_filter($answers, function ($answer) use($field, $value) {
            return $value === \strtolower($answer->{$field});
        });
    }
    private function mapRecordData(array $records)
    {
        return \array_map(function ($record) {
            return $record->data;
        }, $records);
    }
}

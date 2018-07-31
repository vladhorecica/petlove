<?php

namespace Util\MySql;

use Util\MySql\Util\DeleteQueryBuilder;
use Util\MySql\Util\SelectQueryBuilder;
use Util\Value\Enum;
use Util\Value\ScalarValueObject;
use Psr\Log\LoggerInterface;
use Symfony\Component\Stopwatch\Stopwatch;

class Connection
{
    const QUERY_EVENT = 'Util.mysql.query';

    /** @var string */
    private $host;
    /** @var string */
    private $username;
    /** @var string */
    private $password;
    /** @var string */
    private $database;
    /** @var int */
    private $port;
    /** @var \mysqli */
    private $handle;

    /** @var Stopwatch */
    private $stopwatch;
    /** @var LoggerInterface */
    private $logger;

    /**
     * @param string $host
     * @param string $username
     * @param string $password
     * @param string $database
     * @param int    $port
     */
    public function __construct($host, $username, $password, $database, $port = 3306)
    {
        $this->host = $host;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
        $this->port = $port;
    }

    /**
     * @param Stopwatch       $stopwatch
     * @param LoggerInterface $logger
     */
    public function enableProfiling(Stopwatch $stopwatch, LoggerInterface $logger)
    {
        $this->stopwatch = $stopwatch;
        $this->logger = $logger;
    }

    /**
     */
    private function connect()
    {
        if ($this->handle === null) {
            $this->handle = new \mysqli($this->host, $this->username, $this->password, null, $this->port);
            $this->handle->select_db($this->database);
            if ($this->handle->error) {
                throw new Error($this->handle->error, $this->handle->errno);
            }
            $this->handle->set_charset('utf8');
        }
    }

    /**
     * @param string  $sql
     * @param mixed[] $parameters
     *
     * @return \mysqli_stmt
     */
    private function query($sql, array $parameters)
    {
        $this->connect();
        $stmt = $this->handle->prepare($sql);
        if ($stmt === false) {
            throw new Error($this->handle->error, $this->handle->errno);
        }
        $this->bind($stmt, $parameters);

        if ($this->stopwatch) {
            $this->stopwatch->start(self::QUERY_EVENT);
        }

        $stmt->execute();

        if ($this->stopwatch) {
            $event = $this->stopwatch->stop(self::QUERY_EVENT);
            $this->logger->debug(self::QUERY_EVENT, [
                'duration' => $event->getDuration(),
                'sql' => $sql,
                'parameters' => $parameters,
            ]);
        }

        if ($this->handle->error) {
            throw new Error($this->handle->error, $this->handle->errno);
        }

        return $stmt;
    }

    /**
     * @param \mysqli_stmt $stmt
     * @param mixed[]      $parameters
     */
    private function bind(\mysqli_stmt $stmt, array $parameters)
    {
        if (count($parameters) === 0) {
            return;
        }

        $types = '';
        $bindArgs = [];
        foreach ($parameters as &$parameter) {
            if ($parameter instanceof ScalarValueObject) {
                $parameter = $parameter->getValue();
            } elseif ($parameter instanceof Enum) {
                $parameter = $parameter->getValue();
            }

            if (is_int($parameter) || is_bool($parameter)) {
                $types .= 'i';
            } elseif (is_float($parameter)) {
                $types .= 'd';
            } else {
                $types .= 's';
            }

            $bindArgs[] = &$parameter;
        }

        $stmt->bind_param($types, ...$bindArgs);
    }

    /**
     * @param $sql
     */
    public function rawQuery($sql)
    {
        $this->connect();

        if ($this->stopwatch) {
            $this->stopwatch->start(self::QUERY_EVENT);
        }

        $this->handle->query($sql);

        if ($this->stopwatch) {
            $event = $this->stopwatch->stop(self::QUERY_EVENT);
            $this->logger->debug(self::QUERY_EVENT, [
                'duration' => $event->getDuration(),
                'sql' => $sql,
                'parameters' => null,
            ]);
        }

        if ($this->handle->error) {
            throw new Error($this->handle->error, $this->handle->errno);
        }
    }

    /**
     * @param string|DeleteQueryBuilder $sql
     * @param array                     $parameters
     *
     * @return int
     */
    public function commandQuery($sql, ...$parameters)
    {
        if ($sql instanceof DeleteQueryBuilder) {
            assert(!$parameters);
            $stmt = $this->query($sql->getSql(), $sql->getParameters());
        } else {
            $stmt = $this->query($sql, $parameters);
        }

        return $stmt->affected_rows;
    }

    /**
     * @param string|SelectQueryBuilder $query
     * @param array                     $parameters
     *
     * @return BufferedResultSet|\mixed[][]
     */
    public function bufferedQuery($query, ...$parameters)
    {
        if ($query instanceof SelectQueryBuilder) {
            assert(!$parameters);
            $stmt = $this->query($query->getSql(), $query->getParameters());
        } else {
            $stmt = $this->query($query, $parameters);
        }

        return new BufferedResultSet($stmt);
    }

    /**
     * @param string|SelectQueryBuilder $query
     * @param array                     $parameters
     *
     * @return StreamingResultSet
     */
    public function streamingQuery($query, ...$parameters)
    {
        if ($query instanceof SelectQueryBuilder) {
            assert(!$parameters);
            $stmt = $this->query($query->getSql(), $query->getParameters());
        } else {
            $stmt = $this->query($query, $parameters);
        }

        return new StreamingResultSet($stmt);
    }

    /**
     * @param string  $table
     * @param mixed[] $data
     *
     * @return mixed
     */
    public function insert($table, array $data)
    {
        // @codingStandardsIgnoreStart
        $sql = "INSERT INTO `$table`";
        if ($data) {
            $sql .= ' ('.implode(', ', array_map(function ($field) { return "`$field`"; }, array_keys($data))).')'
                .' VALUES ('.implode(', ', array_map(function () { return '?'; }, array_values($data))).')';
        } else {
            $sql .= ' () VALUES ()';
        }
        // @codingStandardsIgnoreStop
        $this->query($sql, array_values($data));

        return $this->handle->insert_id;
    }

    /**
     * @param $table
     * @param mixed[] $data
     * @param mixed[] $key
     *
     * @return int
     */
    public function update($table, array $data, array $key)
    {
        // @codingStandardsIgnoreStart
        if (!$data) {
            return 0;
        }
        $sql = "UPDATE `$table`"
            .' SET '.implode(', ', array_map(function ($field) { return "`$field` = ?"; }, array_keys($data)))
            .' WHERE '.implode(' AND ', array_map(function ($field) { return "`$field` = ?"; }, array_keys($key)));
        // @codingStandardsIgnoreStop
        $this->query($sql, array_merge(array_values($data), array_values($key)));

        return $this->handle->affected_rows;
    }

    /**
     * @param string  $table
     * @param mixed[] $key
     *
     * @return int
     */
    public function delete($table, array $key)
    {
        $sql = "DELETE FROM `$table` WHERE ".implode(' AND ', array_map(function ($field) { return "`$field` <=> ?"; }, array_keys($key)));
        $this->query($sql, array_values($key));

        return $this->handle->affected_rows;
    }

    /**
     * @param callable $func
     *
     * @return mixed
     */
    public function transactional(callable $func)
    {
        $this->connect();
        $this->handle->query('START TRANSACTION');
        try {
            $r = $func($this);
            $this->handle->commit();

            return $r;
        } catch (\Exception $e) {
            $this->handle->rollback();
            throw $e;
        }
    }

    /**
     */
    public function close()
    {
        if ($this->handle !== null) {
            $this->handle->close();
            $this->handle = null;
        }
    }

    /**
     * @return string
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getDatabase()
    {
        return $this->database;
    }

    /**
     * @return int
     */
    public function getPort()
    {
        return $this->port;
    }
}

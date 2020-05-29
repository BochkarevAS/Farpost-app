<?php

declare(strict_types=1);

namespace App\Entity;

use App\Core\Db;

abstract class ActiveRecord
{
    /**
     * @var int
     */
    protected $id;

    public function __set(string $name, $value)
    {
        $camelCaseName = $this->underscoreToCamelCase($name);
        $this->$camelCaseName = $value;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public static function findAll(): array
    {
        $db = Db::getInstance();

        return $db->query('SELECT * FROM ' . static::getTableName(), [], static::class);
    }

    public static function findById(int $id): ?self
    {
        $db = Db::getInstance();

        $entities = $db->query('SELECT * FROM ' . static::getTableName() . ' WHERE id=:id', [':id' => $id], static::class);

        return $entities ? $entities[0] : null;
    }

    public static function findOneByColumn(string $columnName, $value): ?self
    {
        $db = Db::getInstance();

        $sql = 'SELECT * FROM ' . static::getTableName() . ' WHERE ' . $columnName . ' = :value LIMIT 1;';

        $result = $db->query($sql, [':value' => $value], static::class);

        if ([] === $result) {
            return null;
        }

        return $result[0];
    }

    public function save(): void
    {
        $mappedProperties = $this->mapPropertiesToDbFormat();

        if (null !== $this->id) {
            $this->update($mappedProperties);
        } else {
            $this->insert($mappedProperties);
        }
    }

    private function update(array $mappedProperties): void
    {
        $db = Db::getInstance();

        $params = [];
        $values = [];
        $index  = 1;

        foreach ($mappedProperties as $column => $value) {
            $param          = ':param' . $index;
            $params[]       = $column . ' = ' . $param;
            $values[$param] = $value;
            $index++;
        }

        $sql = 'UPDATE ' . static::getTableName() . ' SET ' . implode(', ', $params) . ' WHERE id = ' . $this->id;

        $db->query($sql, $values, static::class);
    }

    private function insert(array $mappedProperties): void
    {
        $db = Db::getInstance();

        $filteredProperties = array_filter($mappedProperties);

        $columns = [];
        $names   = [];
        $values  = [];

        foreach ($filteredProperties as $columnName => $value) {
            $columns[]      =  $columnName;
            $param          = ':' . $columnName;
            $names[]        = $param;
            $values[$param] = $value;
        }

        $columnsViaSemicolon     = implode(', ', $columns);
        $paramsNamesViaSemicolon = implode(', ', $names);

        $sql = 'INSERT INTO ' . static::getTableName() . ' (' . $columnsViaSemicolon . ') VALUES (' . $paramsNamesViaSemicolon . ')';

        $db->query($sql, $values, static::class);

        $this->id = $db->getLastInsertId();
    }

    public function delete(): void
    {
        $db = Db::getInstance();

        $db->query('DELETE FROM ' . static::getTableName() . ' WHERE id = :id', [':id' => $this->id]);

        $this->id = null;
    }

    private function mapPropertiesToDbFormat(): array
    {
        $reflector  = new \ReflectionObject($this);
        $properties = $reflector->getProperties();

        $mappedProperties = [];

        foreach ($properties as $property) {
            $property                                = $property->getName();
            $propertyAsUnderscore                    = $this->camelCaseToUnderscore($property);
            $mappedProperties[$propertyAsUnderscore] = $this->$property;
        }

        return $mappedProperties;
    }

    private function underscoreToCamelCase(string $source): string
    {
        return lcfirst(str_replace('_', '', ucwords($source, '_')));
    }

    private function camelCaseToUnderscore(string $source): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $source));
    }

    abstract protected static function getTableName(): string;
}
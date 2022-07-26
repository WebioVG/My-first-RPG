<?php

Class DB
{
    // Properties
    private const DB_HOST = 'localhost';
    private const DB_NAME = 'rpg';
    private const DB_USER = 'root';
    private const DB_PASSWORD = '';
    private static $db;

    public static function db()
    {
        if(!self::$db) {
            return new PDO('mysql:host='.DB::DB_HOST.';dbname='.DB::DB_NAME, DB::DB_USER, DB::DB_PASSWORD, [
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ]);
        }

        return self::$db;
    }

    // Queries
    public static function selectAll($query, $bindings = [])
    {
        $query = self::db()->prepare($query);
        $query->execute($bindings);

        return $query->fetchAll();
    }
    public static function selectOne($query, $bindings = [])
    {
        $query = self::db()->prepare($query);
        $query->execute($bindings);

        return $query->fetch();
    }
    public static function insert($query, $bindings = [])
    {
        return self::db()->prepare($query)->execute($bindings);
    }

}
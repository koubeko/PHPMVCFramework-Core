<?php
/**
 * File Name: DBModel.php
 * @author Ondřej Koubek
 * Date: 27.01.2022
 * Time: 10:19
 */

namespace app\core\db;

use app\core\Application;
use app\core\Model;

/**
 * Class DBModel
 *
 * @author Ondřej Koubek
 * @namespace app\core
 */
abstract class DBModel extends Model
{
    abstract public function tableName(): string;

    abstract public function attributes(): array;

    abstract public function primaryKey(): string;

    public function save()
    {
        $tableName = $this->tableName();
        $attributes = $this->attributes();
        $params = array_map(fn($attr) => ":$attr", $attributes);
        $stmt = self::prepare("INSERT INTO $tableName (" . implode(',', $attributes) . ")
            VALUES(" . implode(',', $params) . ") ");

        foreach ($attributes as $attribute) {
            $stmt->bindValue(":$attribute", $this->{$attribute});
        }
        $stmt->execute();
        return true;
    }

    public function findOne($where): mixed
    {
        $tableName = static::tableName();
        $attributes = array_keys($where);
        $sql = implode("AND", array_map(fn($attr) => "$attr = :$attr", $attributes));
        $stmt = self::prepare("SELECT * FROM $tableName WHERE $sql");
        foreach ($where as $key => $item) {
            $stmt->bindValue(":$key", $item);
        }
        $stmt->execute();
        return $stmt->fetchObject(static::class);
    }

    public static function prepare(string $sql): bool|\PDOStatement
    {
        return Application::$app->db->pdo->prepare($sql);
    }
}
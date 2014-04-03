<?php
namespace Gazpacho;

use \Gazpacho\Application;
use \Gazpacho\Logger;

class Model
{
    protected $_tableName;
    protected $_fields;

    public function __construct($tableName, $fields)
    {
        $this->_tableName = $tableName;
        $this->_fields = $fields;

        $tables = Application::database()->query("SHOW TABLES");

        if (!empty($tables) && in_array($tableName, $tables[0])) {
            Logger::write('>> Table "' . $this->_tableName . '" found in database');
        }
        else {
            $this->up();
        }
    }

    public function up()
    {
        Logger::write('Migrating ' . $this->_tableName);
        Logger::write('Creating database tables…');

        $table = $this->_tableName;
        $fieldsText = 'id INT NOT NULL, ';

        foreach ($this->_fields as $key => $type) {
            switch ($type) {
                case 'string':
                    $type = 'VARCHAR(255)';
                    break;
                case 'integer':
                    $type = 'INT';
                    break;
                case 'datetime':
                    $type = 'DATETIME';
                    break;
                case 'text':
                    $type = 'TEXT';
                    break;
                default:
                    Logger::write('Data "' . $type . '" type not yet supported…', Logger::WARNING);
                    break;
            }
            $fieldsText .= $key . ' ' . $type . ', ';
        }

        $fieldsText = substr($fieldsText, 0, -2);

        $sql = <<<SQL
CREATE TABLE IF NOT EXISTS {$table} (
    {$fieldsText}
) DEFAULT CHARSET=utf8
SQL;
        try {
            Application::Database()->query($sql, NULL, Database::FETCH_MODE_NONE);
            Logger::write('Table "' . $table . '" created successfuly!');
        } catch (DatabaseException $e) {
            Logger::write('Database error…');
        }
    }
    public function getOne($id)
    {
        $table = $this->_tableName;
        $sql = <<<SQL
SELECT * FROM {$table} WHERE id = {$id}
SQL;
        return Application::database()->query($sql);
    }
    
    public function getAll()
    {
        $table = $this->_tableName;
        $sql = <<<SQL
SELECT * FROM {$table}
SQL;
        return Application::database()->query($sql);
    }
}
<pre><?php
/**
 * Created by PhpStorm.
 * User: Joris
 * Date: 15/04/2017
 * Time: 18:53
 */

class Database {
    private static $db = null;

    public static function getDatabase() {
        if (self::$db === null) {
            try {
                // Make PDO Connection
                self::$db = new PDO('mysql:host=mysqldb;dbname=simpletodo;charset=utf8', 'root', 'Azerty123');
                self::$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                echo 'Could not connect to database simpletodo';
            }
        }
        return self::$db;
    }
}

class Model {

    private $assocArray = []; // 'id' => 0 means: not stored in DB

    public function __get($key) { // magic method for inaccessible properties '->'
        return $this->assocArray[$key];
    }

    public function __set($key, $value) { // magic method for inaccessible properties '->'
        $this->assocArray[$key] = $value;
    }

    protected static function getTablename() {
        return strtolower(get_called_class()) . 's'; // needs some linguistic optimization
    }

    public function __construct($assocArray = []) {
        if (!array_key_exists('id', $assocArray)) {
            $assocArray['id'] = 0;
        }
        $this->assocArray = $assocArray;
    }

    public function save() {
        $assocWithoutId = array_diff_key($this->assocArray, array('id' => 'dummy'));
        if ($this->id === 0) {
            $stmt = Database::getDatabase()->prepare('INSERT INTO ' . self::getTablename() .
                ' (' . implode(',', array_keys($assocWithoutId)) . ') VALUES (' . substr(str_repeat("?,", count($assocWithoutId)), 0, -1) . ');');
            $stmt->execute(array_values($assocWithoutId));
            $this->id = Database::getDatabase()->lastInsertId();
        } else {
            $stmt = Database::getDatabase()->prepare('UPDATE ' . self::getTablename() . ' SET ' .  implode(' = ?,', array_keys($assocWithoutId)) . ' = ? WHERE id = ?;');
            $stmt->execute(array_values($this->assocArray));
        }
    }

    public function delete() {
        if ($this->id !== 0) {
            $stmt = Database::getDatabase()->prepare('DELETE FROM ' . self::getTablename() . ' WHERE id = ?;');
            $stmt->execute(array($this->id));
            $this->id = 0;
        }
    }

    public static function all() {
        $todoObjects = [];
        $stmt = Database::getDatabase()->query('SELECT * FROM ' . self::getTablename() . ';');
        while ($todo = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $subclassName = get_called_class();
            $todoObjects[] = new $subclassName($todo);
        }
        return $todoObjects;
    }
}

class Todo extends Model {
    // override getTablename() if you need to
}

$todos = Todo::all();
print_r($todos);

echo $todos[0]->what;

$todo = new Todo();
$todo->what = 'Go lunching !!';
$todo->priority = 'high';
$todo->save();

print_r(Todo::all());
$todo->delete();
print_r(Todo::all());
?></pre>

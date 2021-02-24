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

class Todo {

    private $id = 0; // 0 means: not stored in DB
    public $what;
    public $priority;

    public function __construct($assocArray = []) {
        $this->id = array_key_exists('id', $assocArray)? $assocArray['id'] : 0;
        $this->what = array_key_exists('what', $assocArray)? $assocArray['what'] : '';
        $this->priority = array_key_exists('priority', $assocArray)? $assocArray['priority'] : 'low';
    }
    public function save() {
        if ($this->id === 0) {
            $stmt = Database::getDatabase()->prepare('INSERT INTO todos (what, priority) VALUES (?, ?);');
            $stmt->execute(array($this->what, $this->priority ));
            $this->id = Database::getDatabase()->lastInsertId();
        } else {
            $stmt = Database::getDatabase()->prepare('UPDATE todos SET what = ?, priority = ? WHERE id = ?;');
            $stmt->execute(array($this->what, $this->priority, $this->id ));
        }
    }

    public function delete() {
        if ($this->id !== 0) {
            $stmt = Database::getDatabase()->prepare('DELETE FROM todos WHERE id = ?;');
            $stmt->execute(array($this->id));
            $this->id = 0;
        }
    }

    public static function all() {
        $todoObjects = [];
        $stmt = Database::getDatabase()->query('SELECT * FROM todos;');
        while ($todo = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $todoObjects[] = new Todo($todo);
        }
        return $todoObjects;
    }
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

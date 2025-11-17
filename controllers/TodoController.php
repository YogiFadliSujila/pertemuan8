<?php
require_once 'models/TodoModel.php';

class TodoController {
    private $model;

    public function __construct() {
        $this->model = new TodoModel();
    }

    public function index() {
        $todos = $this->model->getAllTodos();

        // Fitur pencarian
        if (isset($_GET['search']) && $_GET['search'] !== '') {
            $keyword = strtolower($_GET['search']);
            $todos = array_filter($todos, function ($item) use ($keyword) {
                return strpos(strtolower($item['task']), $keyword) !== false;
            });
        }

        return $todos;
    }

    public function add($task) {
        if (!empty($task)) {
            $this->model->createTodo($task);
        }
        header("Location: index.php");
        exit;
    }

    public function markAsCompleted($id) {
        $this->model->updateTodoStatus($id, 1);
        header("Location: index.php");
        exit;
    }

    public function delete($id) {
        $this->model->deleteTodo($id);
        header("Location: index.php");
        exit;
    }
}
?>

<?php 
class Task{
    private $connexion;
    private $table = "tasks";
    protected $title;
    protected $description;
    protected $typeTask;
    protected $severity;
    protected $priority;
    

    public function __construct($db, $title, $description, $typeTask, $severity = null, $priority = null){
        $this->connexion = $db;
        $this->title = $title;
        $this->description = $description;
        $this->typeTask = $typeTask;
        $this->severity = $severity;
        $this->priority = $priority;
    }
    public function get_title(){
        return $this->title;
    }
    public function get_description(){
        return $this->description;
    }
    public function get_typeTask(){
        return $this->typeTask;
    }
    public function set_title($title){
        $this->title=$title;
    }
    public function set_description($description){
        $this->description=$description;
    }
    public function set_typeTask($typeTask){
        $this->typeTask=$typeTask;
    }

    public function addTask() {
        $sql = "INSERT INTO " . $this->table . " (title, description, status, type) VALUES (:title, :description, :status, :type)";
        $query = $this->connexion->prepare($sql);
        $query->execute([
            ":title" => $this->title,
            ":description" => $this->description,
            ":status" => "to-do",
            ":type" => $this->typeTask
        ]);

        $taskId = $this->connexion->lastInsertId();

        if ($this->typeTask === 'bug') {
            $sql = "INSERT INTO bugs (id_task, severity) VALUES (:id_task, :severity)";
            $query = $this->connexion->prepare($sql);
            $query->execute([
                ":id_task" => $taskId,
                ":severity" => $this->severity
            ]);
        } 
        elseif ($this->typeTask === 'feature') {
            $sql = "INSERT INTO features (id_task, priority) VALUES (:id_task, :priority)";
            $query = $this->connexion->prepare($sql);
            $query->execute([
                ":id_task" => $taskId,
                ":priority" => $this->priority
            ]);
        }

        return true;
    }
    
    public function getAllTasks() {
        $sql = "SELECT t.*, 
                b.severity, 
                f.priority 
                FROM tasks t 
                LEFT JOIN bugs b ON t.id_task = b.id_task 
                LEFT JOIN features f ON t.id_task = f.id_task 
                ORDER BY t.created_at DESC";
                
        $query = $this->connexion->prepare($sql);
        $query->execute();
        
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function assignTask($taskId, $userId) {
        $sql = "UPDATE tasks SET id_user = :userId WHERE id_task = :taskId";
        $query = $this->connexion->prepare($sql);
        return $query->execute([
            ':userId' => $userId,
            ':taskId' => $taskId
        ]);
    }

    public function updateStatus($taskId, $newStatus) {
        $sql = "UPDATE tasks SET status = :status WHERE id_task = :taskId";
        $query = $this->connexion->prepare($sql);
        return $query->execute([
            ':status' => $newStatus,
            ':taskId' => $taskId
        ]);
    }
}
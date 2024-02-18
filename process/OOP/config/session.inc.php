<?php
class CustomSessionHandler implements SessionHandlerInterface {
    private $db;

    public function open($savePath, $sessionName): bool {
        // Инициализация соединения с базой данных (PDO)
        include_once 'config.php';

        try {
            $this->db = new PDO('mysql:host=' . $config['host'] . ';dbname=' . $config['dbname'], $config['user'], $config['password']);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return true;
        } catch (PDOException $e) {
            error_log("Failed to connect to database: " . $e->getMessage());
            return false;
        }
    }

    public function close(): bool {
        // Закрытие соединения с базой данных
        $this->db = null;
        return true;
    }

    public function read($sessionId): string {
        // Чтение данных из базы данных
        $stmt = $this->db->prepare("SELECT data FROM sessions WHERE session_id = :session_id");
        $stmt->execute(['session_id' => $sessionId]);
        $result = $stmt->fetchColumn();

        return $result !== false ? $result : '';
    }
    
    private function getNextSessionSuffix($login): int {
        // Получение максимального суффикса для данного логина
        $stmt = $this->db->prepare("SELECT MAX(session_number) FROM sessions WHERE login = ?");
        $stmt->execute([$login]);
        $maxSuffix = $stmt->fetchColumn();

        // Если нет сессий для данного логина, начнем с 1
        return $maxSuffix !== null ? intval($maxSuffix) + 1 : 1;
    }

    public function write($sessionId, $data): bool { //записи сессий-куки, сделать добавление или чтение по логину, или в users добавление id их сессий
        $login = isset($_POST['login']) ? $_POST['login'] : 'default';
    
        try {
            // Обновление данных, если session_id уже существует
            $stmt = $this->db->prepare("UPDATE sessions SET data = ?, last_accessed = NOW() WHERE session_id = ?");
            $stmt->execute([$data, $sessionId]);
    
            if ($stmt->rowCount() > 0) {
                // Обновление прошло успешно
                return true;
            }
    
            // Перезапись session_id, если запись существует
            $stmt = $this->db->prepare("UPDATE sessions SET session_id = ?, last_accessed = NOW() WHERE login = ? AND data = ?");
            $stmt->execute([$sessionId, $login, $data]);
    
            if ($stmt->rowCount() > 0) {
                // Перезапись прошла успешно
                return true;
            }
    
            // Запись новых данных в базу данных, если ни одна из проверок не прошла
            $suffix = $this->getNextSessionSuffix($login);
            $stmt = $this->db->prepare("INSERT INTO sessions (session_id, login, data, last_accessed, session_number) VALUES (?, ?, ?, NOW(), ?)");
            $stmt->execute([$sessionId, $login, $data, $suffix]);
    
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            // Обработка ошибок
            error_log("Database error: " . $e->getMessage());
            return false;
        }
    }

    public function destroy($sessionId): bool {
        // Удаление сессии из базы данных
        $stmt = $this->db->prepare("DELETE FROM sessions WHERE session_id = ?");
        return $stmt->execute([$sessionId]);
    }

    public function gc($maxlifetime = '-1'): bool {
        // Очистка устаревших сессий из базы данных
        $stmt = $this->db->prepare("DELETE FROM sessions WHERE last_accessed < DATE_SUB(NOW(), INTERVAL :maxlifetime SECOND)");
        return $stmt->execute(['maxlifetime' => $maxlifetime]);
    }
}
?>
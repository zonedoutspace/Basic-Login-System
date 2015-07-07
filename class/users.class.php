<?php

session_start();

    class User {

        public $mysqli;
        public function __construct($HOST, $USER, $PASS, $DATABASE) {
            $this->mysqli = new mysqli($HOST, $USER, $PASS, $DATABASE);
        }

        public function postLogin($username, $pass, $ip) {

            $users = array();
            $result = $this->mysqli->query("SELECT password FROM users WHERE username='$username'");
            while($row = $result->fetch_assoc()) {
                $users[] = $row;
            }
            $result->free();

            if($users[0]['password'] == '') {
                echo "user not recognized";
            } else {

                if (password_verify($pass, $users[0]['password'])) {
                    $_SESSION['username'] = $username;
                    $_SESSION['AUTH'] = true;

                    $stmt = $this->mysqli->prepare("UPDATE users SET ip = ? WHERE username = ?");
                    $stmt->bind_param('ss', $ip, $username);
                    $stmt->execute();
                    $stmt->close();

                } else {
                    $_SESSION['AUTH'] = false;
                    echo "invalid password \n";
                }

            }
        }

        public function postRegister($username, $pass, $email, $ip) {
            $password = password_hash($pass, PASSWORD_DEFAULT);
            $stmt = $this->mysqli->prepare("INSERT INTO users (username, password, email, reg_ip) VALUES (?, ?, ?, ?)");
            $stmt->bind_param('ssss', $username, $password, $email, $ip);
            $stmt->execute();
            $stmt->close();
        }

        public function getLogout($LOGINPAGE) {
            $_SESSION = array();
            if (ini_get("session.use_cookies")) {
                $params = session_get_cookie_params();
                setcookie(session_name(), '', time() - 42000,
                    $params["path"], $params["domain"],
                    $params["secure"], $params["httponly"]
                );
            }
            session_destroy();
            header ('Location: https://'.$LOGINPAGE);
        }


    }
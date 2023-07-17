<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class database
{
    private string $servername = "db";
    private string $username = "php_docker";
    private string $password = "password";
    private string $dbname = "victr";

    private ?mysqli $conn;

    function __construct()
    {
        try {
            $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
            if ($conn->connect_error) {
                $this->conn = null;
            } else {
                $this->conn = $conn;
            }
        } catch (Exception $e) {
            $this->conn = null;
        }

    }

    public function saveDataInDb($datas)
    {
        if ($this->conn) {

            $insert_repo = [];
            $update_repo = [];
            $fetched_repo_id = [];
            foreach ($datas as $data) {
                $fetched_repo_id[] = $data['id'];
            }
            // search all existing id in table
            $search_existing_stmnt_query = "SELECT repo_id FROM git_repos WHERE repo_id IN (";
            $search_existing_stmnt_query .= str_repeat("?,", count($fetched_repo_id) - 1) . "?";
            $search_existing_stmnt_query .= ")";
            $search_existing_stmnt = $this->conn->prepare($search_existing_stmnt_query);
            $search_existing_stmnt->bind_param(str_repeat("i", count($fetched_repo_id)), ...$fetched_repo_id);
            $search_existing_stmnt->execute();
            $search_existing_stmnt->store_result();
            if ($search_existing_stmnt->num_rows > 0) {
                $search_existing_stmnt->bind_result($repoId);
                while ($search_existing_stmnt->fetch()) {
                    $found = 0;
                    $index = 0;
                    foreach ($datas as $i => $v) {
                        if ($repoId == $v['id']) {
                            $found = 1;
                            $index = $i;
                        }
                    }
                    if ($found) {
                        $update_repo[] = $datas[$index];
                        unset($datas[$index]);
                    }
                }
            }
            $insert_repo = $datas;

            if (count($insert_repo) > 0) {
                $stmt = $this->conn->prepare("INSERT INTO git_repos (repo_id, name, url,created_date,last_push_date,description,stars) VALUES (?,?,?,?,?,?,?)");
                $stmt->bind_param("sssssss", $repo_id, $name, $url, $created_date, $last_push_date, $description, $stars);
                foreach ($insert_repo as $data) {
                    $repo_id = $data['id'];
                    $name = $data['name'];
                    $url = $data['html_url'];
                    $created_date = date('Y-m-d H:i:s', strtotime($data['created_at']));
                    $last_push_date = date('Y-m-d H:i:s', strtotime($data['pushed_at']));
                    $description = $data['description'];
                    $stars = $data['stargazers_count'];
                    try {
                        if (!$stmt->execute()) {
                            die('12');
                            echo $this->conn->error;
                            $this->conn->close();
                            return false;
                        }
                    } catch (Exception $ex) {
                        echo $ex->getMessage();
                        die('123');
                        $this->conn->close();
                        return false;
                    }
                }
            }
            if (count($update_repo) > 0) {
                $stmt = $this->conn->prepare("UPDATE git_repos SET name=?, url=?,created_date=?,last_push_date=?,description=?,stars=? WHERE repo_id=?");
                $stmt->bind_param("sssssss", $name, $url, $created_date, $last_push_date, $description, $stars, $repo_id,);
                foreach ($update_repo as $data) {
                    $repo_id = $data['id'];
                    $name = $data['name'];
                    $url = $data['html_url'];
                    $created_date = date('Y-m-d H:i:s', strtotime($data['created_at']));
                    $last_push_date = date('Y-m-d H:i:s', strtotime($data['pushed_at']));
                    $description = $data['description'];
                    $stars = $data['stargazers_count'];
                    try {
                        if (!$stmt->execute()) {
                            $this->conn->close();
                            return false;
                        }
                    } catch (Exception $ex) {
                        $this->conn->close();
                        return false;
                    }
                }
            }
            $this->conn->close();
            return true;
        }
        return false;
    }

    public function searchFromDB()
    {
        $result["status"] = "100";
        $result["message"] = "DB Error";
        if ($this->conn) {
            $stmt = $this->conn->prepare("SELECT id,name,stars FROM  git_repos order by stars DESC");
            if (!$stmt->execute()) {
                $this->conn->close();
                return $result;
            }
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $result["status"] = "200";
                $stmt->bind_result($id, $name, $stars);
                /* fetch values */
                while ($stmt->fetch()) {
                    $rows[] = [$id, $name, $stars];
                }
                $result["message"] = $rows;
                $this->conn->close();
            } else {
                $result["status"] = "203";
                $result["message"] = "No Records Found Please Use Refresh Button To Fetch From Git";
            }
        }
        return $result;
    }

    public function searchFromDBById($id)
    {
        $result["status"] = "100";
        $result["message"] = "DB Error";
        if ($this->conn) {
            $stmt = $this->conn->prepare("SELECT repo_id,name,url,created_date,last_push_date,description,stars FROM  git_repos WHERE id=?");
            $stmt->bind_param("i", $id);
            if (!$stmt->execute()) {
                $this->conn->close();
                return $result;
            }
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $result["status"] = "200";
                $stmt->bind_result($repo_id, $name, $url, $created_date, $last_push_date, $description, $stars);

                /* fetch values */
                while ($stmt->fetch()) {
                    $rows[] = [$repo_id, $name, $url, $created_date, $last_push_date, $description, $stars];

                }
                $result["message"] = $rows;
                $this->conn->close();
            } else {
                $result["status"] = "203";
                $result["message"] = "No Records Found Please Use Refresh Button To Fetch From Git";
            }
        }
        return $result;
    }
}

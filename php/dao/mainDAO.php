<?php
require_once "../util/encryption.php";
require_once "../sql/sqlData.php";

class mainDAO
{
    
    private $conn;
    private $stmt;
    
    private $sqlData;
    
    private $encrypktion;
    
    public function setData()
    {
        $this->sqlData = new sqlData();
        $this->encrypktion = new encryption();
    }
    
    public function getConnection()
    {
        try {
            $this->conn = mysqli_connect($this->encrypktion->decrypt($this->sqlData->getHost()), $this->encrypktion->decrypt($this->sqlData->getUser()), $this->encrypktion->decrypt($this->sqlData->getPassword()), $this->encrypktion->decrypt($this->sqlData->getDatabase()), $this->encrypktion->decrypt($this->sqlData->getPort()));
            if (! mysqli_connect_error($this->conn)) {
                mysqli_query($this->conn, "set session character_set_conn=utf8;");
                mysqli_query($this->conn, "set session character_set_results=utf8;");
                mysqli_query($this->conn, "set session character_set_client=utf8;");
            } else {
                echo "DB 연결 실패:", mysqli_connect_error();
                exit();
            }
        } catch (Exception $e) {}
    }
    
    public function disConnection()
    {
        try {
            if ($this->conn != null)
                $this->conn->close();
                if($this->stmt != null)
                    $this->stmt->close();
        } catch (Exception $e) {}
    }
    
    public function insertGameRanking($gameIdx, $memberIdx, $score) {
        try {
            self::getConnection();
            
            $sql = "CALL game_ranking_insert(?, ?, ?)";
            $this->stmt = $this->conn->prepare($sql);
            $this->stmt->bind_param("iii", $gameIdx, $memberIdx, $score);
            $this->stmt->execute();
        } catch (Exception $e) {} finally {
            self::disConnection();
        }
    }
    
    public function selectGameRankingTop30($gameIdx) {
        try {
            self::getConnection();
            
            $sql = "CALL game_ranking_top30(?)";
            $this->stmt = $this->conn->prepare($sql);
            $this->stmt->bind_param("i", $gameIdx);
            $this->stmt->execute();
            $result = $this->stmt->get_result();
        } catch (Exception $e) {} finally {
            self::disConnection();
        }
        
        return $result;
    }
    
    public function selectGameRankingMy30($gameIdx, $memberIdx) {
        try {
            self::getConnection();
            
            $sql = "CALL game_ranking_my30(?, ?)";
            $this->stmt = $this->conn->prepare($sql);
            $this->stmt->bind_param("ii", $gameIdx, $memberIdx);
            $this->stmt->execute();
            $result = $this->stmt->get_result();
        } catch (Exception $e) {} finally {
            self::disConnection();
        }
        
        return $result;
    }
    
    public function userCheck($gameIdx, $memberIdx) {
        try {
            self::getConnection();
            
            $sql = "select score from game_ranking where game_idx like ? and member_idx like ?";
            $this->stmt = $this->conn->prepare($sql);
            $this->stmt->bind_param("ii", $gameIdx, $memberIdx);
            $this->stmt->execute();
            $result = $this->stmt->get_result();
        } catch (Exception $e) {} finally {
            self::disConnection();
        }
        
        return $result;
    }
    
    public function dashAdventureCheck($memberIdx) {
        try {
            self::getConnection();
            
            $sql = "select dia, ball, shop_ball, normal_stage, normal_stage_count, hard_stage_open, hard_stage, hard_stage_count " 
            ."from game_dash_adventure where member_idx = ?";
            $this->stmt = $this->conn->prepare($sql);
            $this->stmt->bind_param("i", $memberIdx);
            $this->stmt->execute();
            $result = $this->stmt->get_result();
        } catch (Exception $e) {} finally {
            self::disConnection();
        }
        
        return $result;
    }
    
    public function insertDashAdventure($memberIdx, $dia, $ball, $shopBall, $normalStage, $normalStageCount, $hardStageOpen, $hardStage, $hardStageCount) {
        try {
            self::getConnection();
            
            $sql = "CALL game_dash_adventure_insert(?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $this->stmt = $this->conn->prepare($sql);
            $this->stmt->bind_param("iiisiiiii", $memberIdx, $dia, $ball, $shopBall, $normalStage, $normalStageCount, $hardStageOpen, $hardStage, $hardStageCount);
            $this->stmt->execute();
        } catch (Exception $e) {} finally {
            self::disConnection();
        }
    }
}
?>
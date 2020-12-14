<?php
    class publickeys
    {
        private $id;
        private $userId;
        private $publicKey;
        private $createdOn;
        protected $dbConn;

        function setId($id) { $this->id = $id; }
        function getId() { return $this->id; }

        function setUserId($userId) { $this->userId = $userId; }
        function getUserId() { return $this->userId; }

        function setKey($publicKey) { $this->publicKey = $publicKey; }
        function getKey() { return $this->publicKey; }

        function setCreatedOn($createdOn) { $this->createdOn = $createdOn; }
        function getCreatedOn() { return $this->createdOn; }

        public function __construct()
        {
            require_once('DbConnect.php');
            $db = new DbConnect();
            $this->dbConn = $db->connect();
        }
        public function savePublicKey()
        {
            $stmt = $this->dbConn->prepare('INSERT INTO publickeys VALUES(null, :userid, :publicKey, :createdOn)');
            $stmt->bindParam(':userid', $this->userId);
            $stmt->bindParam(':publicKey', $this->publicKey);
            $stmt->bindParam(':createdOn', $this->createdOn);
            try
            {
                if($stmt->execute())
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
            catch (Exception $e)
            {
                echo $e->getMessage();
            }
        }
        public function updatePublicKey()
        {
            $stmt = $this->dbConn->prepare('UPDATE publickeys SET publicKey = :publicKey, created_on = :created_on WHERE userid = :userid');
            $stmt->bindParam(':publicKey', $this->publicKey);
            $stmt->bindParam(':created_on', $this->createdOn);
            $stmt->bindParam(':userid', $this->userId);
            try
            {
                if($stmt->execute())
                {
                    return true;
                }
                else
                {
                    return false;
                }
            }
            catch (Exception $e)
            {
                echo $e->getMessage();
            }
        }
        public function getPublicKeys()
        {
            $stmt = $this->dbConn->prepare("SELECT p.*, u.name FROM publickeys p JOIN users u ON(p.userid = u.id) ORDER BY p.id DESC");
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);;
        }
        public function existsPublicKeys()
        {
            $stmt = $this->dbConn->prepare("SELECT userid FROM publickeys WHERE userid = :userid");
            $stmt->bindParam(':userid', $this->userId);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
    }
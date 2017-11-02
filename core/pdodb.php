<?php
    /*
	Plugin Name: CFC database PDO Class
	Description: Adds a basic PDO database abstraction layer for custom queries
	Version: 11.0.0
	Author: ChelseaStats
	Plugin URI: https://thechels.co.uk
	Author URI: https://thechels.co.uk
	Copyright (c) 2016 ChelseaStats Limited
	*/

    defined( 'ABSPATH' ) or die();
	
    class pdodb {
        // use WordPress Configs DB defines
        private $host   = DB_HOST;
        private $user   = DB_USER;
        private $pass   = DB_PASSWORD;
        private $dbname = DB_NAME;

	    /** @var $dbh PDO  */
        private $dbh;
        private $error;

	    /** @var $stmt PDOStatement */
        private $stmt;

	    /**
	     * pdodb constructor.
	     */
	    public function __construct() {
            // Set DSN
            $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
            // Set options
            $options = array(
                PDO::ATTR_PERSISTENT => true,
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            );
            // Create a new PDO instance
            try {
                $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
            }
                // Catch any errors
            catch (PDOException $e) {
                $this->error = $e->getMessage();
            }
        }

	    /**
	     * @param $query
	     */
	    public function query($query) {
            $this->stmt = $this->dbh->prepare($query);
        }

	    /**
	     * @param      $param
	     * @param      $value
	     * @param null $type
	     */
	    public function bind($param, $value, $type = null) {
            if (is_null($type)) {
                switch (true) {
                    case is_int($value):
                        $type = PDO::PARAM_INT;
                        break;
                    case is_bool($value):
                        $type = PDO::PARAM_BOOL;
                        break;
                    case is_null($value):
                        $type = PDO::PARAM_NULL;
                        break;
                    default:
                        $type = PDO::PARAM_STR;
                }
            }
            $this->stmt->bindValue($param, $value, $type);
        }

	    /**
	     * @return bool
	     */
	    public function execute() {
            return $this->stmt->execute();
        }

	    /**
	     * @return array
	     */
	    public function rows() {
            $this->execute();
            return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
        }

	    /**
	     * @return mixed
	     */
	    public function row() {
            $this->execute();
            return $this->stmt->fetch(PDO::FETCH_ASSOC);
        }

	    /**
	     * @return array
	     */
	    public function resultset() {
		    $this->execute();
		    return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
	    }
	    
	    /**
	     * @param $tableName
	     * @return mixed
	     */
	    public function returnCountAll($tableName) {
		    $this->query("Select count(*) as Counter from {$tableName}");
		    $counter = $this->row();
		    return $counter['Counter'];
	    }

	    /**
	     * @return int
	     */
	    public function rowCount() {
            return $this->stmt->rowCount();
        }

	    /**
	     * @return string
	     */
	    public function lastInsertId() {
            return $this->dbh->lastInsertId();
        }

	    /**
	     * @return bool
	     */
	    public function beginTransaction(){
            return $this->dbh->beginTransaction();
        }

	    /**
	     * @return bool
	     */
	    public function endTransaction(){
            return $this->dbh->commit();
        }

	    /**
	     * @return bool
	     */
	    public function cancelTransaction() {
            return $this->dbh->rollBack();
        }
	    
	    /**
	     *
	     */
	    public function __destruct() {
            $this->dbh;
        }

	    /**
	     * @param $dbh
	     */
	    public function closeDbConnection($dbh) {
            register_shutdown_function($dbh);
        }
    }

<?php

    require_once './CommonInterface.php';

    class DatabaseInterface {
        const debug = true;

        public function __construct() {
            try {
                $this->MySQLdb = new PDO("mysql:host=localhost;dbname=bank", "root", "");
                $this->MySQLdb->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $exception) {
                echo "Connection Error: ".$exception;
            }
        }

        public function GetMySQLdb() {
            return $this->MySQLdb;
        }

        /*
        * CheckErrors - if debug mode is set we will output the error in the response, if the debug is off we will be redirected to 404.php
        */
        public function CheckErrors($e,$pass = false) {
            if ($pass == true) return true;

            if (self::debug){
                die($e->getMessage());
            }
            else {
                // return error if there is something strange in the database
                return_error(":)");
            }
        }

        public function login($userName, $password) {
            try {
                $cursor = $this->MySQLdb->prepare("SELECT * FROM users WHERE userName='".$userName."' AND password='".$password."'");
                $cursor->execute();
            } catch(PDOException $e) { //SQL injection
                $this->CheckErrors($e);
            }
            
            if($cursor->rowCount() && $cursor->rowCount() > 0) {
                $cursor->setFetchMode(PDO::FETCH_ASSOC);
                return array("success"=>true,"data"=>$cursor->fetch());
            } else {
                return array("success"=>false,"data"=>"Wrong Username/Password!<br>");
            }
        }

        public function register($userName, $password, $phoneNumber, $address) {
            try {
                # Check if the username is taken
                $cursor = $this->MySQLdb->prepare("SELECT `userName` FROM `users` WHERE `userName`=:userName");
                $cursor->execute( array(":userName"=>$userName) );
            } catch(PDOException $e) {
                $this->CheckErrors($e);
            }

            /* New User */
            if(!($cursor->rowCount())){
                try {
                    $cursor = $this->MySQLdb->prepare("INSERT INTO `users` (`userName`, `password`, `phoneNumber`, `address`) VALUES (:userName, :password, :phoneNumber, :address)");

                    $cursor->execute(array(
                        ":password"=>$password,
                        ":userName"=>$userName,
                        ":phoneNumber"=>$phoneNumber,
                        ":address"=>$address
                    ));
                    return array("success"=>true,"data"=>"You have successfully registered!");
                } catch(PDOException $e) {
                    $this->CheckErrors($e);
                }
            } else { /* Already exists */
                return array("success"=>false,"data"=>"username already exists in the system!");
            }
        }

        public function newTransaction($userName, $destinationUserName, $amount, $notes) {
            $transactionDate = date("d/m/Y");
            
            try {
                $cursor = $this->MySQLdb->prepare("INSERT INTO `transactions` (`userName`, `destinationUserName`, `amount`, `transactionDate`, `notes`) value (:userName,:destinationUserName,:amount,:transactionDate,:notes)");
                $cursor->execute(array(":userName"=>$userName,":destinationUserName"=>$destinationUserName, ":amount"=>$amount, ":transactionDate"=>$transactionDate, ":notes"=>$notes));

                if($cursor->rowCount() && $cursor->rowCount() > 0) {
                    $cursor->setFetchMode(PDO::FETCH_ASSOC);
                    return array("success"=>true,"data"=>$cursor->fetch());
                } else {
                    return array("success"=>false,"data"=>"Error transferring money!");
                }
            }
            catch(PDOException $e) {
                $this->CheckErrors($e);
            }
            return false;
        }

        public function getTransactions($userName) {
            try {
                $cursor = $this->MySQLdb->prepare("SELECT * FROM `transactions` WHERE `userName` = '$userName' OR `destinationUserName` = '$userName'");
                $cursor->execute();
                $retval = "";

                foreach ($cursor->fetchAll() as $obj) {
                    $userName = $obj["userName"];
                    $transactionId = $obj["transactionId"];
                    // $transactionDate = $obj["transactionDate"];
                    $amount = $obj["amount"];
                    $destinationUserName = $obj["destinationUserName"];
                    $notes = $obj["notes"];

                    $retval.="<tr><td>$transactionId</td><td>$userName</td><td>$amount</td><td>$destinationUserName</td><td>$notes</td></tr>";
                }

                return array("success"=>true,"data"=>$retval);
            }
            catch(PDOException $e) {
                $this->CheckErrors($e);
            }
            return false;
        }

        public function getUserId($userName) {
            try {
                $cursor = $this->MySQLdb->prepare("SELECT `userId` FROM `users` WHERE `userName` = '$userName'");
                $cursor->execute();
                $retval = $cursor->fetch();
                return $retval["userId"];
            }
            catch(PDOException $e) {
                $this->CheckErrors($e);
            }
            return false;
        }

        public function getUsers($userId) {
            try {
                $cursor = $this->MySQLdb->prepare("SELECT `userId`, `userName` FROM `users` WHERE NOT `userName` = $userId");
                $cursor->execute();
                $retval = "";
                $retval = "<select id='userNameSelection'>";

                foreach ($cursor->fetchAll() as $obj) {
                    $differentUserId = $obj["userId"];
                    $differentUserName = $obj["userName"];

                    $retval.="<option value='$differentUserName'>$differentUserId - $differentUserName</option>";
                }

                $retval.="</select>";
                return $retval;
            }
            catch(PDOException $e) {
                $this->CheckErrors($e);
            }
            return false;
        }

        public function getProfile($userName) {
            try {
                $cursor = $this->MySQLdb->prepare("SELECT `userName`, `fullName`, `email`, `phoneNumber`, `address` FROM `users` WHERE `userName` = '$userName'");
                $cursor->execute();
                $retval = $cursor->fetch();
                return array("success"=>true,"data"=>$retval);
            }
            catch(PDOException $e) {
                $this->CheckErrors($e);
            }
            return false;
        }

        public function editProfile($userName, $fullName, $email, $address, $phoneNumber) {
            try {
                $cursor = $this->MySQLdb->prepare("UPDATE `users` SET `fullName`='$fullName', `email`='$email', `phoneNumber`='$phoneNumber', `address`='$address' WHERE `userName`='$userName'");
                $data = $cursor->execute();
                return array("success"=>true,"data"=>$data);
            }
            catch(PDOException $e) {
                $this->CheckErrors($e);
            }
            return false;
        }

    }
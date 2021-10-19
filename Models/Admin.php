<?php
    namespace Models;
    

    class Admin
    {
        private $adminId;
        private $adminName;
        private $adminPass;


        public function getAdminId()
        {
            return $this->adminId;
        }

        public function setAdminId($adminId)
        {
            $this->adminId = $adminId;
        }

        /**
         * Get the value of adminName
         */ 
        public function getAdminName()
        {
                return $this->adminName;
        }

        /**
         * Set the value of adminName
         *
         * @return  self
         */ 
        public function setAdminName($adminName)
        {
                $this->adminName = $adminName;

                return $this;
        }

        /**
         * Get the value of adminPass
         */ 
        public function getAdminPass()
        {
                return $this->adminPass;
        }

        /**
         * Set the value of adminPass
         *
         * @return  self
         */ 
        public function setAdminPass($adminPass)
        {
                $this->adminPass = $adminPass;

                return $this;
        }
    }
?>
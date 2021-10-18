<?php

    namespace Models;

    use Models\Person as Person;

    class Admin extends Person
    {
        private $adminId;


        public function getAdminId()
        {
            return $this->adminId;
        }

        public function setAdminId($adminId)
        {
            $this->adminId = $adminId;
        }
    }
?>
<?php
    namespace DAO;

    use DAO\ICompanyDAO as ICompanyDAO;
    use Models\Company as Company;

    class CompanyDAO implements ICompanyDAO
    {
        private $companyList = array();
        private $fileName;
        
        public function __construct()    
        {
            $this->fileName = dirname(__DIR__) . "/Data/companies.json";
        }



        public function Add(Company $company)
        {
            $this->RetrieveData();

            array_push($this->companyList, $company);

            $this->SaveData();
        }


        public function GetAll()
        {
            $this->RetrieveData();

            return $this->companyList;
        }


        private function SaveData()
        {
            $arrayToEncode = array();

            foreach ($this->companyList as $company)
            {
                $valuesArray["companyId"] = $company->setCompanyId();
                $valuesArray["companyName"] = $company->setCompanyName();
                $valuesArray["location"] = $company->setLocation();
                $valuesArray["description"] = $company->setDescription();
                $valuesArray["email"] = $company->setEmail();
                $valuesArray["phoneNumber"] = $company->setPhoneNumber();

                array_push($arrayToEncode, $valuesArray);
            }

            $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);

            file_put_contents('Data/companies.json', $jsonContent);
        }


        private function RetrieveData()
        {
            $this->companyList = array();

            if (file_exists('Data/companies.json'))
            {
                $jsonContent = file_get_contents('Data/companies.json');

                $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

                foreach ($arrayToDecode as $valuesArray)
                {
                    $company = new Company();

                    $company->setCompanyId($valuesArray['companyId']);
                    $company->setCompanyName($valuesArray['companyName']);
                    $company->setLocation($valuesArray['location']);
                    $company->setDescription($valuesArray['description']);
                    $company->setEmail($valuesArray['email']);
                    $company->setPhoneNumber($valuesArray['phoneNumber']);

                    array_push($this->companyList, $company);
                }
            }
        }
    }
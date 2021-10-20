<?php
    namespace DAO;

    use DAO\ICareerDAO as ICareerDAO;
    use Models\Career as Career;

    class CareerDAO implements ICareerDAO
    {
        private $careerList = array();
        private $fileName;
        private $ch;

        public function __construct()
        {
            $this->fileName = dirname(__DIR__) . "/Data/careers.json";

            $this->ch = curl_init();
            $url = 'https://utn-students-api.herokuapp.com/api/Career';
            $header = array('x-api-key: 4f3bceed-50ba-4461-a910-518598664c08');

            curl_setopt($this->ch, CURLOPT_URL, $url);
            curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($this->ch, CURLOPT_HTTPHEADER, $header);
        }



        private function FetchAll()
        {
            $resp = curl_exec($this->ch);

            $decode = json_decode($resp, true);

            curl_close($this->ch);

            $this->careerList = array();

            if ($resp != null)
            {
                foreach($decode as $valuesArray)
                {
                    $career = new Career();

                    $career->setCareerId($valuesArray["careerId"]);
                    $career->setDescription($valuesArray["description"]);
                    $career->setActive($valuesArray["active"]);

                    array_push($this->careerList, $career);
                }

                $this->SaveData();
            }
        }


        public function Add(Career $career)
        {
            $this->RetrieveData();
            
            array_push($this->careerList, $career);

            $this->SaveData();
        }


        public function GetAll()
        {
            $this->RetrieveData();

            return $this->careerList;
        }

        private function SaveData()
        {
            $arrayToEncode = array();

            foreach($this->careerList as $career)
            {
                $valuesArray["careerId"] = $career->getCareerId();
                $valuesArray["description"] = $career->getDescription();
                $valuesArray["active"] = $career->getActive();                

                array_push($arrayToEncode, $valuesArray);
            }

            $jsonContent = json_encode($arrayToEncode, JSON_PRETTY_PRINT);
            
            file_put_contents('Data/careers.json', $jsonContent);
        }


        private function RetrieveData()
        {
            $this->careerList = array();

            if(file_exists('Data/careers.json'))
            {
                $jsonContent = file_get_contents('Data/careers.json');

                $arrayToDecode = ($jsonContent) ? json_decode($jsonContent, true) : array();

                foreach($arrayToDecode as $valuesArray)
                {
                    $career = new Career();
                    
                    $career->setCareerId($valuesArray["careerId"]);
                    $career->setDescription($valuesArray["description"]);
                    $career->setActive($valuesArray["active"]);
                    
                    array_push($this->careerList, $career);
                }
            }
        }
    }
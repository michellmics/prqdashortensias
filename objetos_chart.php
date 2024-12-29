<?php

    //include_once 'db.php'; 

	class SITE_CHARTS
	{
        //declaração de variaveis 
        public $pdo;
        public $configPath = '/home/hortensias/config.cfg';
        public $ARRAY_DESPESAFULLINFO;
        public $ARRAY_INADIMPLENCIAFULLINFO;


        function conexao()
        {
            $this->configPath = '/home/hortensias/config.cfg';

            if (!file_exists($this->configPath)) {
                die("Erro: Arquivo de configuração não encontrado.");
            }

            $configContent = parse_ini_file($this->configPath, true);  // true para usar sessões

            if (!$configContent) {
                die("Erro: Não foi possível ler o arquivo de configuração.");
            }

            $host = $configContent['DATA DB']['host'];
            $dbname = $configContent['DATA DB']['dbname'];
            $user = $configContent['DATA DB']['user'];
            $pass = $configContent['DATA DB']['pass'];

            try {
                $this->pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
                $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Erro na conexão: " . $e->getMessage());
            }
        }

        public function getDespesasFull()
        {          
                // Verifica se a conexão já foi estabelecida
                if(!$this->pdo){$this->conexao();}
            
            try{           
                $sql = "SELECT * FROM REP_REPORT WHERE REP_DCTIPO LIKE 'DESPESA%'";

                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
                $this->ARRAY_DESPESAFULLINFO = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }          
        }     

        public function getInadimplenciaFull()
        {          
                // Verifica se a conexão já foi estabelecida
                if(!$this->pdo){$this->conexao();}
            
            try{           
                $sql = "SELECT * FROM REP_REPORT WHERE REP_DCTIPO LIKE 'INADIMPLENCIA%'";

                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
                $this->ARRAY_INADIMPLENCIAFULLINFO = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }          
        }  


    }
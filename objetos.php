<?php

    //include_once 'db.php'; 

    include 'phpMailer/src/PHPMailer.php';
    include 'phpMailer/src/SMTP.php';
    include 'phpMailer/src/Exception.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;


	class SITE_ADMIN
	{
        //declaração de variaveis 
        public $pdo;
        public $ARRAY_SITEINFO;
        public $ARRAY_LISTAINFO;
        public $ARRAY_USERINFOLIST;
        public $ARRAY_USERINFOBYID;
        public $ARRAY_DESCEMPRESAINFO;
        public $ARRAY_CLIENTINFO;
        public $ARRAY_PRODUCTINFO;
        public $ARRAY_CONTRATOINFO;    
        public $ARRAY_LIQUIDACAOFINANCEIRA; 
        public $ARRAY_BALANCOMENSAL;
        public $ARRAY_PROXVENCIMENTOS;
        public $ARRAY_ALERTA;
        public $ARRAY_AGENDAINFO;
        public $ARRAY_AGENDAATIVIDADES;
        public $ARRAY_PROSPEC_CLIENTESINFO;
        public $ARRAY_WHATSAPPBOTINFO;
        public $ARRAY_PARAMETERINFO;
        public $ARRAY_MORADORINFO;
        public $ARRAY_LISTAMORADORESINFO;
        public $configPath = '/home/hortensias/config.cfg';


        function conexao()
        {
            /*
                load fiule config.cfg

                [DATA DB]
                host = localhost
                dbname = dbname
                user = dbuser
                pass = dbpass
            */

            $this->configPath = '/home/hortensias/config.cfg';

            if (!file_exists($this->configPath)) {
                die("Erro: Arquivo de configuração não encontrado.");
            }

            $configContent = parse_ini_file($this->configPath, true);  // true para usar seções

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

        public function sendEmailPHPMailer($addAddress, $Subject, $Body, $anexo)
        {     
            if (!file_exists($this->configPath)) {
                die("Erro: Arquivo de configuração não encontrado.");
            }
                       
            $configMail = parse_ini_file($this->configPath, true);  // true para usar seções
            $user = $configMail['EMAIL']['Username'];
            $pass = $configMail['EMAIL']['Password'];

            $mail = new PHPMailer(true);

            if($anexo != "na")
            {
                foreach ($anexo as $item) 
                {
                    if (!empty($item)) 
                    { 
                        $fileContent = file_get_contents($item); 
                        $fileName = basename($item); 
                        $mail->addStringAttachment($fileContent, $fileName, 'base64', 'application/pdf');
                    } else {
                        $this->InsertAlarme("Gerar Boleto: Caminho do arquivo está vazio.","High");
                        return "O caminho do arquivo está vazio: $item<br>";
                    }
                    sleep(2);
                }
            }
           

            try {
                //Configurações do servidor
                $mail->isSMTP(); 
                $mail->Host = $configMail['EMAIL']['Host'];
                $mail->SMTPAuth = true; 
                $mail->Username = $user;
                $mail->Password = $pass;
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
                $mail->Port = $configMail['EMAIL']['Port'];

                // Configurações de codificação
                $mail->CharSet = 'UTF-8';
                $mail->Encoding = 'base64';
            
                // Destinatários
                $mail->setFrom('no-reply@dominio.com', 'Codemaze');
                $mail->addAddress($addAddress); // Adicione um destinatário
                $mail->addBCC('suporte@codemaze.com.br'); // Se desejar enviar cópia oculta
            
                // Conteúdo do e-mail
                $mail->isHTML(true); // Defina o formato do e-mail como HTML
                $mail->Subject = $Subject;
                $mail->Body    = $Body; 
            
                $mail->send();
                return 'E-mail enviado com sucesso';
            } catch (Exception $e) {
                $this->InsertAlarme("Erro ao enviar e-mail. $mail->ErrorInfo","High");
                return "Erro ao enviar e-mail: {$mail->ErrorInfo}";
            }            
        }

        public function updateMailCobranca($LFI_IDOP)
        {          
            try {
                $sql = "UPDATE LFI_LIQUIDACAOFINANCEIRA 
                        SET LFI_DCEMAIL_SENDED = :LFI_DCEMAIL_SENDED
                        WHERE 	LFI_IDOP = :LFI_IDOP";

                $stmt = $this->pdo->prepare($sql);
            
                // Liga os parâmetros aos valores
                $status = 'ENVIADO';
                $stmt->bindParam(':LFI_DCEMAIL_SENDED', $status, PDO::PARAM_STR);
                $stmt->bindParam(':LFI_IDOP', $LFI_IDOP, PDO::PARAM_STR);

                $stmt->execute();
            
                return ["success" => "Status de notificação atualizado com sucesso."];
            } catch (PDOException $e) {
                // Captura e retorna o erro
                $this->InsertAlarme("Erro na função updateMailCobranca.","High");
                return ["error" => $e->getMessage()];
            }
        }


        public function stmtToArray($stmtFunction)
		{		
			$stmtFunction_array = array();							
			while ($row = $stmtFunction->fetch(PDO::FETCH_ASSOC))
			{	
				array_push($stmtFunction_array, $row);	
			}		
	
			return $stmtFunction_array;
		}	
	

        public function getParameterInfo()
        {          
                // Verifica se a conexão já foi estabelecida
                if(!$this->pdo){$this->conexao();}
            
            try{           
                $sql = "SELECT CFG_DCPARAMETRO, 
                                CFG_DCVALOR
                                FROM CFG_CONFIGURACAO";

                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
                $this->ARRAY_PARAMETERINFO = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }       
        }

        public function getVarEnvInfo()
        {       
            if(!$this->pdo){$this->conexao();}            
                      
            $sql = "SELECT VEN_IDVARENV, VEN_PARAMETER, VEN_VALUE FROM VEN_VARENV ORDER BY VEN_IDVARENV ASC";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);  
            return $result;              
        }

        public function getClientInfo()
        {          
                // Verifica se a conexão já foi estabelecida
                if(!$this->pdo){$this->conexao();}
            
            try{           
                $sql = "SELECT CLI_IDCLIENT,                                  
                                CLI_NMNAME, 
                                CLI_DCEMAIL,
                                CLI_DCCPFCNPJ,
                                CLI_DCRSOCIAL,
                                CLI_DCCITY,
                                CLI_DCSTATE,
                                CLI_STSTATUSPENDING,
                                CLI_STSTATUS,
                                CLI_DCCEP
                                FROM CLI_CLIENT
                                WHERE CLI_STSTATUS = 'ATIVO'
                                ORDER BY CLI_STSTATUSPENDING ASC";

                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
                $this->ARRAY_CLIENTINFO = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }          
        }

        public function getProspecInfo()
        {          
                // Verifica se a conexão já foi estabelecida
                if(!$this->pdo){$this->conexao();}
            
            try{           
                $sql = "SELECT *
                                FROM PRC_PROSPEC_CLIENTES
                                ORDER BY PRC_NMNOME ASC";

                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
                $this->ARRAY_PROSPEC_CLIENTESINFO = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }          
        }

        public function getListaInfoByid($LIS_IDLISTACONVIDADOS)
        {          
                // Verifica se a conexão já foi estabelecida
                if(!$this->pdo){$this->conexao();}
            
            try{           
                $sql = "SELECT *
                                FROM LIS_LISTACONVIDADOS
                                WHERE LIS_IDLISTACONVIDADOS = :LIS_IDLISTACONVIDADOS";

                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':LIS_IDLISTACONVIDADOS', $LIS_IDLISTACONVIDADOS, PDO::PARAM_STR);
                $stmt->execute();
                $this->ARRAY_LISTAINFO = $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }          
        }

        public function getListaMoradoresInfo()
        {          
                // Verifica se a conexão já foi estabelecida
                if(!$this->pdo){$this->conexao();}
            
            try{           
                $sql = "SELECT *
                                FROM USU_USUARIO
                                WHERE USU_DCNIVEL = 'SINDICO' OR USU_DCNIVEL = 'MORADOR'
                                ORDER BY USU_DCAPARTAMENTO ASC";

                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
                $this->ARRAY_LISTAMORADORESINFO = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }          
        }

        public function getMoradoreInfoById($USU_IDUSUARIO)
        {          
                // Verifica se a conexão já foi estabelecida
                if(!$this->pdo){$this->conexao();}
            
            try{           
                $sql = "SELECT *
                                FROM USU_USUARIO
                                WHERE USU_IDUSUARIO = :USU_IDUSUARIO";

                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':USU_IDUSUARIO', $USU_IDUSUARIO, PDO::PARAM_STR);
                $stmt->execute();
                $this->ARRAY_MORADORINFO = $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }          
        }

        public function getListaMoradoresInfoBySearch($SEARCH)
        {          
                // Verifica se a conexão já foi estabelecida
                if(!$this->pdo){$this->conexao();}
            
            try{           
                $sql = "SELECT *
                                FROM USU_USUARIO
                                WHERE 
                                (USU_DCNIVEL = 'SINDICO' OR USU_DCNIVEL = 'MORADOR') 
                                AND (USU_DCNOME LIKE :SEARCH
                                OR USU_DCAPARTAMENTO LIKE :SEARCH)
                                ORDER BY USU_DCAPARTAMENTO ASC";

                $stmt = $this->pdo->prepare($sql);
                $stmt->bindValue(':SEARCH', '%' . $SEARCH . '%', PDO::PARAM_STR);
                $stmt->execute();
                $this->ARRAY_LISTAMORADORESINFO = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }          
        }
       
        public function getProspecInfoByUserId($USA_IDUSERADMIN)
        {          
                // Verifica se a conexão já foi estabelecida
                if(!$this->pdo){$this->conexao();}
            
            try{           
                $sql = "SELECT *
                                FROM PRC_PROSPEC_CLIENTES
                                WHERE USA_IDUSERADMIN = :USA_IDUSERADMIN
                                ORDER BY PRC_NMNOME ASC";

                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':USA_IDUSERADMIN', $USA_IDUSERADMIN, PDO::PARAM_STR);
                $stmt->execute();
                $this->ARRAY_PROSPEC_CLIENTESINFO = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }          
        }

        public function getClientInactiveInfo()
        {          
                // Verifica se a conexão já foi estabelecida
                if(!$this->pdo){$this->conexao();}
            
            try{           
                $sql = "SELECT CLI_IDCLIENT,                                  
                                CLI_NMNAME, 
                                CLI_DCEMAIL,
                                CLI_DCCPFCNPJ,
                                CLI_DCRSOCIAL,
                                CLI_DCCITY,
                                CLI_DCSTATE,
                                CLI_STSTATUSPENDING,
                                CLI_STSTATUS,
                                CLI_DCCEP
                                FROM CLI_CLIENT
                                WHERE CLI_STSTATUS != 'ATIVO'
                                ORDER BY CLI_STSTATUSPENDING ASC";

                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
                $this->ARRAY_CLIENTINFO = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }          
        }

        public function getContratoInfo()
        {          
                // Verifica se a conexão já foi estabelecida
                if(!$this->pdo){$this->conexao();}
            
            try{           
                $sql = "SELECT *
                                FROM VW_TABLE_GESTAO_CONTRATO
                                WHERE GEC_STCONTRATO <> 'INATIVO'
                                ORDER BY GEC_IDGESTAO_CONTRATO ASC";

                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
                $this->ARRAY_CONTRATOINFO = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }          
        }

        public function getContratoInactiveInfo()
        {          
                // Verifica se a conexão já foi estabelecida
                if(!$this->pdo){$this->conexao();}
            
            try{           
                $sql = "SELECT *
                                FROM VW_TABLE_GESTAO_CONTRATO
                                WHERE GEC_STCONTRATO = 'INATIVO'
                                ORDER BY GEC_IDGESTAO_CONTRATO ASC";

                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
                $this->ARRAY_CONTRATOINFO = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }          
        }

        public function getAlertaInfo()
        {          
                // Verifica se a conexão já foi estabelecida
                if(!$this->pdo){$this->conexao();}
            
            try{           
                $sql = "SELECT *
                                FROM ALE_ALERTA
                                WHERE ALE_STALERTA = 'ALARMANDO'
                                ORDER BY ALE_DTALERTA DESC";

                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
                $this->ARRAY_ALERTA = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }          
        }

        public function getLiquidacaoFinanceiraInfo()
        {          
                // Verifica se a conexão já foi estabelecida
                if(!$this->pdo){$this->conexao();}
            
            try{           
                $sql = "SELECT * 
                        FROM VW_TABLE_LIQUIDACAOFINANCEIRA
                        ORDER BY 
                            CASE 
                                WHEN LFI_DTVENCIMENTO >= CURDATE() THEN 0 -- Vencimentos futuros ou hoje
                                ELSE 1 -- Vencimentos passados
                            END, 
                            LFI_DTVENCIMENTO ASC";

                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
                $this->ARRAY_LIQUIDACAOFINANCEIRA = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }          
        }

        public function getLiquidacaoFinanceiraConciliacaoBancaria()
        {          
                // Verifica se a conexão já foi estabelecida
                if(!$this->pdo){$this->conexao();}
            
            try{           
                $sql = "SELECT * 
                        FROM VW_TABLE_LIQUIDACAOFINANCEIRA
                         WHERE LFI_STPAGAMENTO != 'LIQUIDADO' 
                            OR LFI_STPAGAMENTO IS NULL
                            AND LFI_PAGSEGURO_LINK_BOLETO != '' 
                            AND LFI_PAGSEGURO_LINK_BOLETO IS NOT NULL";

                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
                $this->ARRAY_LIQUIDACAOFINANCEIRA = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }          
        }

        public function getProxContratosAVencer()
        {          
                // Verifica se a conexão já foi estabelecida
                if(!$this->pdo){$this->conexao();}
            
            try{           
                $sql = "SELECT * 
                        FROM VW_BOLETO_PROX_VENCIMENTO
                        WHERE LFI_DCEMAIL_SENDED != 'ENVIADO' AND GEC_DCFORMAPAGAMENTO = 'BOLETO'";

                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
                $this->ARRAY_PROXVENCIMENTOS = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }          
        }

        public function getProxContratosAVencerTransferenciaBancaria()
        {          
                // Verifica se a conexão já foi estabelecida
                if(!$this->pdo){$this->conexao();}
            
            try{           
                $sql = "SELECT * 
                        FROM VW_BOLETO_PROX_VENCIMENTO
                        WHERE LFI_DCEMAIL_SENDED != 'ENVIADO' AND GEC_DCFORMAPAGAMENTO = 'TRANSF BANCARIA'";

                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
                $this->ARRAY_PROXVENCIMENTOS = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }          
        }

        public function getPendenciaInfo($GEC_IDGESTAO_CONTRATO)
        {          
                // Verifica se a conexão já foi estabelecida
                if(!$this->pdo){$this->conexao();}
            
            try{           
                $sql = "SELECT *
                                FROM VW_TABLE_LIQUIDACAOFINANCEIRA
                                WHERE GEC_IDGESTAO_CONTRATO = :GEC_IDGESTAO_CONTRATO
                                ORDER BY LFI_STPAGAMENTO DESC";

                $stmt = $this->pdo->prepare($sql);
                $stmt->bindParam(':GEC_IDGESTAO_CONTRATO', $GEC_IDGESTAO_CONTRATO, PDO::PARAM_STR);
                $stmt->execute();
                $arrayResult = $stmt->fetchAll(PDO::FETCH_ASSOC);
                if(count($arrayResult) == 0){return "Sem Dados";}
                
                foreach ($arrayResult as $contrato)
                {
                    $now = new DateTime(); 
                    $vencimento = new DateTime($contrato['LFI_DTVENCIMENTO']); 
                    
                    // Calcula a diferença em dias
                    $diferenca = (int)$now->diff($vencimento)->format('%r%a');

                    if ($diferenca < -5 && $contrato['LFI_STPAGAMENTO'] != "LIQUIDADO"){return "PENDENTE";}  
                }
                return "EM DIA";
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }          
        }

        public function getLiquidacaoFinanceiraInfoBySearch($search)
        {          
                // Verifica se a conexão já foi estabelecida
                if(!$this->pdo){$this->conexao();}
            
            try{           
                $sql = "SELECT *
                                FROM VW_TABLE_LIQUIDACAOFINANCEIRA
                                WHERE
                                GEC_IDGESTAO_CONTRATO LIKE :search                                
                                OR CLI_NMNAME LIKE :search
                                OR PRS_NMNOME LIKE :search
                                OR LFI_DTVENCIMENTO LIKE :search
                                OR LFI_STPAGAMENTO LIKE :search
                                OR LFI_IDOP LIKE :search
                                ORDER BY 
                            CASE 
                                WHEN LFI_DTVENCIMENTO >= CURDATE() THEN 0 -- Vencimentos futuros ou hoje
                                ELSE 1 -- Vencimentos passados
                            END, 
                            LFI_DTVENCIMENTO ASC";

                $stmt = $this->pdo->prepare($sql);
                $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
                $stmt->execute();
                $this->ARRAY_LIQUIDACAOFINANCEIRA = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }          
        }

        public function alarmeRecon($ALE_IDALERTA)
        {          
            // Verifica se a conexão já foi estabelecida
            if (!$this->pdo) {
                $this->conexao();
            }
            $now = new DateTime(); 
            $DATA = $now->format('Y-m-d');
            
            $ALE_STALERTA = "RECONHECIDO";

            try {
                $sql = "UPDATE ALE_ALERTA 
                        SET ALE_STALERTA = :ALE_STALERTA,
                        ALE_DTRECONALERTA = :ALE_DTRECONALERTA
                        WHERE ALE_IDALERTA = :ALE_IDALERTA";

                $stmt = $this->pdo->prepare($sql);
            
                // Liga os parâmetros aos valores
                $stmt->bindParam(':ALE_STALERTA', $ALE_STALERTA, PDO::PARAM_STR);
                $stmt->bindParam(':ALE_IDALERTA', $ALE_IDALERTA, PDO::PARAM_STR);
                $stmt->bindParam(':ALE_DTRECONALERTA', $DATA, PDO::PARAM_STR);

                $stmt->execute();
            
                return ["success" => "Alarme reconhecido com sucesso."];
            } catch (PDOException $e) {
                // Captura e retorna o erro
                return ["error" => $e->getMessage()];
            }
        }

        public function InsertAlarme($ALE_DCMSG,$ALE_DCLEVEL)
        {          
            // Verifica se a conexão já foi estabelecida
            if (!$this->pdo) {
                $this->conexao();
            }
            $now = new DateTime(); 
            $DATA = $now->format('Y-m-d');
            $ALE_STALERTA = "ALARMANDO";
            
            try {
                $sql = "INSERT INTO ALE_ALERTA (ALE_DCMSG,ALE_DCLEVEL,ALE_DTALERTA,ALE_STALERTA) VALUES (:ALE_DCMSG,:ALE_DCLEVEL,:ALE_DTALERTA,:ALE_STALERTA)";

                $stmt = $this->pdo->prepare($sql);
            
                // Liga os parâmetros aos valores
                $stmt->bindParam(':ALE_DCMSG', $ALE_DCMSG, PDO::PARAM_STR);
                $stmt->bindParam(':ALE_DCLEVEL', $ALE_DCLEVEL, PDO::PARAM_STR);
                $stmt->bindParam(':ALE_DTALERTA', $DATA, PDO::PARAM_STR);
                $stmt->bindParam(':ALE_STALERTA', $ALE_STALERTA, PDO::PARAM_STR);

                $stmt->execute();
            
                return ["success" => "Alerta inserido com sucesso."];
            } catch (PDOException $e) {
                // Captura e retorna o erro
                return ["error" => $e->getMessage()];
            }
        }

        public function updateVisitanteInfo($LIS_DCNOME, $USU_IDUSUARIO, $LIS_DCDOCUMENTO, $LIS_STSTATUS, $LIS_IDLISTACONVIDADOS)
        {          
            // Verifica se a conexão já foi estabelecida
            if (!$this->pdo) {
                $this->conexao();
            }
          
            try {
                $sql = "UPDATE LIS_LISTACONVIDADOS 
                        SET LIS_DCNOME = :LIS_DCNOME,
                        LIS_DCDOCUMENTO = :LIS_DCDOCUMENTO,
                        LIS_STSTATUS = :LIS_STSTATUS
                        WHERE LIS_IDLISTACONVIDADOS = :LIS_IDLISTACONVIDADOS";

                $stmt = $this->pdo->prepare($sql);
            
                // Liga os parâmetros aos valores
                $stmt->bindParam(':LIS_DCNOME', $LIS_DCNOME, PDO::PARAM_STR);
                $stmt->bindParam(':LIS_DCDOCUMENTO', $LIS_DCDOCUMENTO, PDO::PARAM_STR);
                $stmt->bindParam(':LIS_STSTATUS', $LIS_STSTATUS, PDO::PARAM_STR);
                $stmt->bindParam(':LIS_IDLISTACONVIDADOS', $LIS_IDLISTACONVIDADOS, PDO::PARAM_STR);

                $stmt->execute();
            
                return ["success" => "Convidado atualizado com sucesso."];
            } catch (PDOException $e) {
                // Captura e retorna o erro
                return ["error" => $e->getMessage()];
            }
        }

        public function getAgendaAtividadeInfoBySearch($search)
        {          
                // Verifica se a conexão já foi estabelecida
                if(!$this->pdo){$this->conexao();}
            
            try{           
                $sql = "SELECT *
                                FROM VW_AGENDA_ATIVIDADES
                                WHERE 
                                AGE_DCTITULO LIKE :search                                
                                OR AGE_DTINI LIKE :search
                                OR AGE_DTFIM LIKE :search
                                OR AGE_STSTATUS LIKE :search
                                OR USA_DCNOME LIKE :search                              
                                ORDER BY AGE_DTFIM DESC";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
                $stmt->execute();
                $this->ARRAY_AGENDAATIVIDADES = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }          
        }

        public function getAgendaAtividadeInfoByIdBySearch($search, $USA_IDUSERADMIN)
        {          
                // Verifica se a conexão já foi estabelecida
                if(!$this->pdo){$this->conexao();}
            
            try{           
                $sql = "SELECT *
                                FROM VW_AGENDA_ATIVIDADES
                                WHERE 
                                USA_IDUSERADMIN = :USA_IDUSERADMIN
                                AND (AGE_DCTITULO LIKE :search                                
                                OR AGE_DTINI LIKE :search
                                OR AGE_DTFIM LIKE :search
                                OR AGE_STSTATUS LIKE :search
                                OR USA_DCNOME LIKE :search)                             
                                ORDER BY AGE_DTFIM DESC";
                $stmt = $this->pdo->prepare($sql);
                $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
                $stmt->bindValue(':USA_IDUSERADMIN', $USA_IDUSERADMIN, PDO::PARAM_STR);
                $stmt->execute();
                $this->ARRAY_AGENDAATIVIDADES = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }          
        }

        public function getContratoInfoBySearch($search)
        {          
                // Verifica se a conexão já foi estabelecida
                if(!$this->pdo){$this->conexao();}
            
            try{           
                $sql = "SELECT *
                                FROM VW_TABLE_GESTAO_CONTRATO
                                WHERE GEC_STCONTRATO <> 'INATIVO' AND 
                                (
                                GEC_IDGESTAO_CONTRATO LIKE :search                                
                                OR PRS_NMNOME LIKE :search
                                OR CLI_NMNAME LIKE :search
                                OR GEC_STCONTRATO LIKE :search
                                OR GEC_DCVALOR LIKE :search
                                OR GEC_DCPERIODOCOBRANCA LIKE :search
                                )
                                ORDER BY GEC_IDGESTAO_CONTRATO ASC";

                $stmt = $this->pdo->prepare($sql);
                $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
                $stmt->execute();
                $this->ARRAY_CONTRATOINFO = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }          
        }


        public function getProductInfo()
        {          
                // Verifica se a conexão já foi estabelecida
                if(!$this->pdo){$this->conexao();}
            
            try{           
                $sql = "SELECT PRS_IDPRODUTO_SERVICO,                                  
                                PRS_NMNOME, 
                                PRS_DCTIPO,
                                PRS_DCINVESTIMENTO,
                                PRS_DCDESCRICAO,
                                PRS_STSTATUS
                                FROM PRS_PRODUTO_SERVICO
                                WHERE PRS_STSTATUS <> 'INATIVO'
                                ORDER BY PRS_NMNOME ASC";

                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
                $this->ARRAY_PRODUCTINFO = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }          
        }

        public function getProductInactiveInfo()
        {          
                // Verifica se a conexão já foi estabelecida
                if(!$this->pdo){$this->conexao();}
            
            try{           
                $sql = "SELECT PRS_IDPRODUTO_SERVICO,                                  
                                PRS_NMNOME, 
                                PRS_DCTIPO,
                                PRS_DCINVESTIMENTO,
                                PRS_DCDESCRICAO,
                                PRS_STSTATUS
                                FROM PRS_PRODUTO_SERVICO
                                WHERE PRS_STSTATUS = 'INATIVO'
                                ORDER BY PRS_NMNOME ASC";

                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
                $this->ARRAY_PRODUCTINFO = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }          
        }

        public function getProductInfoBySearch($search)
        {          
                // Verifica se a conexão já foi estabelecida
                if(!$this->pdo){$this->conexao();}
            
            try{           
                $sql = "SELECT PRS_IDPRODUTO_SERVICO,                                  
                                PRS_NMNOME, 
                                PRS_DCTIPO,
                                PRS_DCINVESTIMENTO,
                                PRS_DCDESCRICAO,
                                PRS_STSTATUS
                                FROM PRS_PRODUTO_SERVICO
                                WHERE PRS_NMNOME LIKE :search
                                OR PRS_DCTIPO LIKE :search
                                OR PRS_DCDESCRICAO LIKE :search
                                OR PRS_STSTATUS LIKE :search
                                ORDER BY PRS_NMNOME ASC";

                $stmt = $this->pdo->prepare($sql);
                $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
                $stmt->execute();
                $this->ARRAY_PRODUCTINFO = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }          
        }

        public function getClientInfoBySearch($search)
        {          
                // Verifica se a conexão já foi estabelecida
                if(!$this->pdo){$this->conexao();}
            
            try{           
                $sql = "SELECT CLI_IDCLIENT,                                  
                                CLI_NMNAME, 
                                CLI_DCEMAIL,
                                CLI_DCCPFCNPJ,
                                CLI_DCRSOCIAL,
                                CLI_DCCITY,
                                CLI_DCSTATE,
                                CLI_STSTATUSPENDING,
                                CLI_STSTATUS
                                FROM CLI_CLIENT
                                WHERE CLI_NMNAME LIKE :search
                                OR CLI_DCEMAIL LIKE :search
                                OR CLI_DCCPFCNPJ LIKE :search
                                OR CLI_DCCITY LIKE :search
                                OR CLI_DCSTATE LIKE :search
                                OR CLI_STSTATUSPENDING LIKE :search
                                OR CLI_STSTATUS LIKE :search";

                $stmt = $this->pdo->prepare($sql);
                $stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
                $stmt->execute();
                $this->ARRAY_CLIENTINFO = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }          
        }

        public function getClientInfoById($ID)
        {          
                // Verifica se a conexão já foi estabelecida
                if(!$this->pdo){$this->conexao();}
            
            try{           
                $sql = "SELECT *
                                FROM CLI_CLIENT
                                WHERE CLI_IDCLIENT = $ID";

                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
                $this->ARRAY_CLIENTINFO = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }          
        }

        
        public function getProductInfoById($ID)
        {          
                // Verifica se a conexão já foi estabelecida
                if(!$this->pdo){$this->conexao();}
            
            try{           
                $sql = "SELECT *
                                FROM PRS_PRODUTO_SERVICO
                                WHERE PRS_IDPRODUTO_SERVICO = $ID
                                ORDER BY PRS_NMNOME ASC";

                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
                $this->ARRAY_PRODUCTINFO = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }          
        }

        public function getAgendaInfoById($ID)
        {          
                // Verifica se a conexão já foi estabelecida
                if(!$this->pdo){$this->conexao();}
            
            try{           
                $sql = "SELECT *
                                FROM AGE_AGENDA
                                WHERE AGE_IDAGENDA = $ID
                                ORDER BY AGE_DCTITULO ASC";

                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
                $this->ARRAY_AGENDAINFO = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }          
        }

        public function getContratoInfoById($ID)
        {          
                // Verifica se a conexão já foi estabelecida
                if(!$this->pdo){$this->conexao();}
            
            try{           
                $sql = "SELECT *
                                FROM GEC_GESTAO_CONTRATO
                                WHERE GEC_IDGESTAO_CONTRATO = '".$ID."'";

                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
                $this->ARRAY_CONTRATOINFO = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }          
        }

        public function getBalancoMensal()
        {          
                // Verifica se a conexão já foi estabelecida
                if(!$this->pdo){$this->conexao();}
            
            try{           
                $sql = "SELECT *
                                FROM BLM_BALANCO_MENSAL
                                ORDER BY BLM_DTFECHAMENTO DESC";

                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
                $this->ARRAY_BALANCOMENSAL = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }          
        }

        public function getListaInfo($USU_IDUSUARIO)
        {          
                // Verifica se a conexão já foi estabelecida
                if(!$this->pdo){$this->conexao();}
            
            try{           
                $sql = "SELECT * FROM LIS_LISTACONVIDADOS WHERE USU_IDUSUARIO = $USU_IDUSUARIO ORDER BY LIS_DCNOME ASC";

                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
                $this->ARRAY_LISTAINFO = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }          
        }

        public function getListaActiveInfo($USU_IDUSUARIO)
        {          
                // Verifica se a conexão já foi estabelecida
                if(!$this->pdo){$this->conexao();}
            
            try{           
                $sql = "SELECT * FROM LIS_LISTACONVIDADOS WHERE (USU_IDUSUARIO = $USU_IDUSUARIO AND LIS_STSTATUS = 'ATIVO') ORDER BY LIS_DCNOME ASC";

                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
                $this->ARRAY_LISTAINFO = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }          
        }

        public function getAgendaAtividadesInfo()
        {          
                // Verifica se a conexão já foi estabelecida
                if(!$this->pdo){$this->conexao();}
            
            try{           
                $sql = "SELECT * FROM VW_AGENDA_ATIVIDADES ORDER BY AGE_DTFIM DESC";

                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
                $this->ARRAY_AGENDAATIVIDADES = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }          
        }

        public function getAgendaAtividadesByIdInfo($USA_IDUSERADMIN)
        {          
                // Verifica se a conexão já foi estabelecida
                if(!$this->pdo){$this->conexao();}
            
            try{           
                $sql = "SELECT * FROM VW_AGENDA_ATIVIDADES WHERE USA_IDUSERADMIN = :USA_IDUSERADMIN ORDER BY AGE_DTFIM DESC";

                $stmt = $this->pdo->prepare($sql);
                $stmt->bindValue(':USA_IDUSERADMIN', $USA_IDUSERADMIN, PDO::PARAM_STR);
                $stmt->execute();
                $this->ARRAY_AGENDAATIVIDADES = $stmt->fetchAll(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }          
        }

        public function getUserInfoList()
        {          
                // Verifica se a conexão já foi estabelecida
                if(!$this->pdo){$this->conexao();}
            
            try{           
                $sql = "SELECT * FROM USA_USERADMIN ORDER BY USA_DCNOME ASC";

                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
                $this->ARRAY_USERINFOLIST = $stmt->fetchall(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }          
        }

        public function getUserInfoById($ID)
        {          
                // Verifica se a conexão já foi estabelecida
                if(!$this->pdo){$this->conexao();}
            
            try{           
                $sql = "SELECT USA_IDUSERADMIN,                                  
                                USA_DCEMAIL, 
                                USA_DCNOME,
                                USA_DCSEXO,
                                USA_DCSENHA
                                FROM USA_USERADMIN WHERE USA_IDUSERADMIN = $ID";

                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
                $this->ARRAY_USERINFOBYID = $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }          
        }

        public function getDescInfo($page,$id)
        {          
                // Verifica se a conexão já foi estabelecida
                if(!$this->pdo){$this->conexao();}
            
            try{            
                $sql = "SELECT PAD_IDPAGEDESCR,                                  
                                PAD_DCTEXT, 
                                PAD_DCTITLE,
                                PAD_NMPAGE
                                FROM PAD_PAGEDESCR
                                WHERE PAD_NMPAGE = '".$page."' AND PAD_IDPAGEDESCR = $id";

                $stmt = $this->pdo->prepare($sql);
                $stmt->execute();
                return $stmt->fetch(PDO::FETCH_ASSOC);
            } catch (PDOException $e) {
                return ["error" => $e->getMessage()];
            }          
        }

        public function updateProspecInfo($PRC_NMNOME, $PRC_DCENDERECO, $PRC_DCMAPS_END, $PRC_NMCONTATO, $PRC_DCTELEFONE, $PRC_DCEMAIL, $PRC_DTVISITA, $PRC_STSTATUS, $PRC_DCOBSERVACOES, $PRC_IDPROSPEC_CLIENTES)
        {    
            
            // Conversão das datas para o formato YYYY-MM-DD
            function convertDate($date) {
                $dateObj = DateTime::createFromFormat('d/m/Y', $date);
                return $dateObj ? $dateObj->format('Y-m-d') : null;  // Retorna null se a data for inválida
            }

            // Converte as datas recebidas do formulário
            $PRC_DTVISITA = convertDate($PRC_DTVISITA);

            // Verifica se a conexão já foi estabelecida
            if (!$this->pdo) {
                $this->conexao();
            }
        
            try {
                $sql = "UPDATE PRC_PROSPEC_CLIENTES 
                        SET 
                        PRC_NMNOME = :PRC_NMNOME, 
                        PRC_DCENDERECO = :PRC_DCENDERECO, 
                        PRC_DCMAPS_END = :PRC_DCMAPS_END, 
                        PRC_NMCONTATO = :PRC_NMCONTATO, 
                        PRC_DCTELEFONE = :PRC_DCTELEFONE, 
                        PRC_DCEMAIL = :PRC_DCEMAIL, 
                        PRC_DTVISITA = :PRC_DTVISITA, 
                        PRC_STSTATUS = :PRC_STSTATUS, 
                        PRC_DCOBSERVACOES = :PRC_DCOBSERVACOES
                        WHERE PRC_IDPROSPEC_CLIENTES = :PRC_IDPROSPEC_CLIENTES";

                $stmt = $this->pdo->prepare($sql);
            
                // Liga os parâmetros aos valores
                $stmt->bindParam(':PRC_NMNOME', $PRC_NMNOME, PDO::PARAM_STR);
                $stmt->bindParam(':PRC_DCENDERECO', $PRC_DCENDERECO, PDO::PARAM_STR);
                $stmt->bindParam(':PRC_DCMAPS_END', $PRC_DCMAPS_END, PDO::PARAM_STR);
                $stmt->bindParam(':PRC_NMCONTATO', $PRC_NMCONTATO, PDO::PARAM_STR);
                $stmt->bindParam(':PRC_DCTELEFONE', $PRC_DCTELEFONE, PDO::PARAM_STR);
                $stmt->bindParam(':PRC_DCEMAIL', $PRC_DCEMAIL, PDO::PARAM_STR);
                $stmt->bindParam(':PRC_DTVISITA', $PRC_DTVISITA, PDO::PARAM_STR);
                $stmt->bindParam(':PRC_STSTATUS', $PRC_STSTATUS, PDO::PARAM_STR);
                $stmt->bindParam(':PRC_DCOBSERVACOES', $PRC_DCOBSERVACOES, PDO::PARAM_STR);
                $stmt->bindParam(':PRC_IDPROSPEC_CLIENTES', $PRC_IDPROSPEC_CLIENTES, PDO::PARAM_STR);                
                $stmt->execute();
            
                // Retorna uma mensagem de sucesso (opcional)
                $this->InsertAlarme("Inserido novo prospec. $PRC_NMNOME","Warning");
                return ["success" => "Prospec inserido com sucesso."];
            } catch (PDOException $e) {
                // Captura e retorna o erro
                $this->InsertAlarme("Erro na função insertProspecInfo. $PRC_NMNOME","High");
                return ["error" => $e->getMessage()];
            }
        }

        public function updateDesc($PAD_DCTITLE, $PAD_DCTEXT, $PAD_IDPAGEDESCR, $PAD_NMPAGE)
        {          
            // Verifica se a conexão já foi estabelecida
            if (!$this->pdo) {
                $this->conexao();
            }
        
            try {
                $sql = "UPDATE PAD_PAGEDESCR 
                        SET PAD_DCTEXT = :PAD_DCTEXT, 
                            PAD_DCTITLE = :PAD_DCTITLE 
                        WHERE PAD_IDPAGEDESCR = :PAD_IDPAGEDESCR AND PAD_NMPAGE = :PAD_NMPAGE";

                $stmt = $this->pdo->prepare($sql);
            
                // Liga os parâmetros aos valores
                $stmt->bindParam(':PAD_DCTEXT', $PAD_DCTEXT, PDO::PARAM_STR);
                $stmt->bindParam(':PAD_DCTITLE', $PAD_DCTITLE, PDO::PARAM_STR);
                $stmt->bindParam(':PAD_IDPAGEDESCR', $PAD_IDPAGEDESCR, PDO::PARAM_INT);
                $stmt->bindParam(':PAD_NMPAGE', $PAD_NMPAGE, PDO::PARAM_STR);
            
                $stmt->execute();
            
                // Retorna uma mensagem de sucesso (opcional)
                return ["success" => "Descrição atualizada com sucesso."];
            } catch (PDOException $e) {
                // Captura e retorna o erro
                $this->InsertAlarme("Erro na função updateDesc.","High");
                return ["error" => $e->getMessage()];
            }
        }

        public function updateClientInfo($CLI_NMNAME, $CLI_DCCPFCNPJ, $CLI_DCRSOCIAL, $CLI_DCEMAIL, $CLI_DCTEL1, $CLI_DCTEL2, $CLI_DCADDRESS, $CLI_DCSTATE, $CLI_DCCITY, $CLI_DCOBS, $CLI_STSTATUS, $ID, $CLI_DCCEP, $CLI_DCBAIRRO)
        {          
            // Verifica se a conexão já foi estabelecida
            if (!$this->pdo) {
                $this->conexao();
            }

            try {
                $sql = "UPDATE CLI_CLIENT
                        SET CLI_NMNAME = :CLI_NMNAME,
                        CLI_DCCPFCNPJ = :CLI_DCCPFCNPJ,
                        CLI_DCRSOCIAL = :CLI_DCRSOCIAL,
                        CLI_DCEMAIL = :CLI_DCEMAIL,
                        CLI_DCTEL1 = :CLI_DCTEL1,
                        CLI_DCTEL2 = :CLI_DCTEL2,
                        CLI_DCADDRESS = :CLI_DCADDRESS,
                        CLI_DCSTATE = :CLI_DCSTATE,
                        CLI_DCCITY = :CLI_DCCITY,
                        CLI_DCOBS = :CLI_DCOBS,
                        CLI_STSTATUS = :CLI_STSTATUS,
                        CLI_DCCEP = :CLI_DCCEP,
                        CLI_DCBAIRRO = :CLI_DCBAIRRO
                        WHERE CLI_IDCLIENT = :CLI_IDCLIENT";
                        
                $stmt = $this->pdo->prepare($sql);
            
                // Liga os parâmetros aos valores
                $stmt->bindParam(':CLI_NMNAME', $CLI_NMNAME, PDO::PARAM_STR);
                $stmt->bindParam(':CLI_DCCPFCNPJ', $CLI_DCCPFCNPJ, PDO::PARAM_STR);
                $stmt->bindParam(':CLI_DCRSOCIAL', $CLI_DCRSOCIAL, PDO::PARAM_STR);
                $stmt->bindParam(':CLI_DCEMAIL', $CLI_DCEMAIL, PDO::PARAM_STR);
                $stmt->bindParam(':CLI_DCTEL1', $CLI_DCTEL1, PDO::PARAM_STR);
                $stmt->bindParam(':CLI_DCTEL2', $CLI_DCTEL2, PDO::PARAM_STR);
                $stmt->bindParam(':CLI_DCADDRESS', $CLI_DCADDRESS, PDO::PARAM_STR);
                $stmt->bindParam(':CLI_DCSTATE', $CLI_DCSTATE, PDO::PARAM_STR);
                $stmt->bindParam(':CLI_DCCITY', $CLI_DCCITY, PDO::PARAM_STR);
                $stmt->bindParam(':CLI_DCOBS', $CLI_DCOBS, PDO::PARAM_STR);
                $stmt->bindParam(':CLI_STSTATUS', $CLI_STSTATUS, PDO::PARAM_STR);
                $stmt->bindParam(':CLI_IDCLIENT', $ID, PDO::PARAM_STR);
                $stmt->bindParam(':CLI_DCCEP', $CLI_DCCEP, PDO::PARAM_STR);
                $stmt->bindParam(':CLI_DCBAIRRO', $CLI_DCBAIRRO, PDO::PARAM_STR); 
                
                $stmt->execute();
            
                // Retorna uma mensagem de sucesso (opcional)
                return "Cliente atualizado com sucesso.";
            } catch (PDOException $e) {
                // Captura e retorna o erro
                $this->InsertAlarme("Erro na função updateClientInfo. $CLI_NMNAME","High");
                return "Erro ao atualizar o Cliente.";
            }
        }

        public function updateProductInfo($PRS_NMNOME, $PRS_DCTIPO, $PRS_DCINVESTIMENTO, $PRS_STSTATUS, $PRS_DCDESCRICAO, $ID)
        {          
            // Verifica se a conexão já foi estabelecida
            if (!$this->pdo) {
                $this->conexao();
            }
            
            try {
                $sql = "UPDATE PRS_PRODUTO_SERVICO 
                        SET PRS_NMNOME = :PRS_NMNOME,
                        PRS_DCTIPO = :PRS_DCTIPO,
                        PRS_DCINVESTIMENTO = :PRS_DCINVESTIMENTO,
                        PRS_STSTATUS = :PRS_STSTATUS,
                        PRS_DCDESCRICAO = :PRS_DCDESCRICAO
                        WHERE PRS_IDPRODUTO_SERVICO = :PRS_IDPRODUTO_SERVICO";

                $stmt = $this->pdo->prepare($sql);
            
                // Liga os parâmetros aos valores
                $stmt->bindParam(':PRS_NMNOME', $PRS_NMNOME, PDO::PARAM_STR);
                $stmt->bindParam(':PRS_DCTIPO', $PRS_DCTIPO, PDO::PARAM_STR);
                $stmt->bindParam(':PRS_DCINVESTIMENTO', $PRS_DCINVESTIMENTO, PDO::PARAM_STR);
                $stmt->bindParam(':PRS_DCDESCRICAO', $PRS_DCDESCRICAO, PDO::PARAM_STR);
                $stmt->bindParam(':PRS_STSTATUS', $PRS_STSTATUS, PDO::PARAM_STR);
                $stmt->bindParam(':PRS_IDPRODUTO_SERVICO', $ID, PDO::PARAM_STR);

                $stmt->execute();
            
                return ["success" => "Produto atualizado com sucesso."];
            } catch (PDOException $e) {
                // Captura e retorna o erro
                $this->InsertAlarme("Erro na função updateProductInfo. $PRS_NMNOME","High");
                return ["error" => $e->getMessage()];
            }
        }

        public function updateClientFinStatus($CLI_IDCLIENT, $CLI_STSTATUSPENDING)
        {          
            // Verifica se a conexão já foi estabelecida
            if (!$this->pdo) {
                $this->conexao();
            }
            
            try {
                $sql = "UPDATE CLI_CLIENT 
                        SET CLI_STSTATUSPENDING = :CLI_STSTATUSPENDING
                        WHERE CLI_IDCLIENT = :CLI_IDCLIENT";

                $stmt = $this->pdo->prepare($sql);
            
                // Liga os parâmetros aos valores
                $stmt->bindParam(':CLI_STSTATUSPENDING', $CLI_STSTATUSPENDING, PDO::PARAM_STR);
                $stmt->bindParam(':CLI_IDCLIENT', $CLI_IDCLIENT, PDO::PARAM_STR);

                $stmt->execute();
            
                return ["success" => "Cliente atualizado com sucesso."];
            } catch (PDOException $e) {
                // Captura e retorna o erro
                $this->InsertAlarme("Erro na função updateClientFinStatus.","High");
                return ["error" => $e->getMessage()];
            }
        }

        public function updateContratoInfo($GEC_IDGESTAO_CONTRATO,
        $CLI_IDCLIENT, 
        $PRS_IDPRODUTO_SERVICO, 
        $GEC_DTINICONTRATO, 
        $GEC_DTENDCONTRATO, 
        $GEC_STCONTRATO, 
        $GEC_DCPERIODOCOBRANCA, 
        $GEC_DCFORMAPAGAMENTO, 
        $GEC_DCEMAILCOBRANCA, 
        $GEC_DCTELEFONECOBRANCA, 
        $GEC_DCDESCRICAO,
        $GEC_DTCONTRATACAO, 
        $GEC_DTPRAZOENTREGA, 
        $GEC_DCPERIODO_CARENCIA, 
        $GEC_DCDESCONTO, 
        $GEC_DCPERIODO_DESCONTO, 
        $GEC_DTVENCIMENTO, 
        $GEC_DCPARCELAMENTO, 
        $GEC_DCVALOR)
        {          

            // Conversão das datas para o formato YYYY-MM-DD
            function convertDate($date) {
                $dateObj = DateTime::createFromFormat('d/m/Y', $date);
                return $dateObj ? $dateObj->format('Y-m-d') : null;  // Retorna null se a data for inválida
            }

            // Converte as datas recebidas do formulário
            $GEC_DTINICONTRATO = convertDate($GEC_DTINICONTRATO);
            $GEC_DTENDCONTRATO = convertDate($GEC_DTENDCONTRATO);
            $GEC_DTCONTRATACAO = convertDate($GEC_DTCONTRATACAO );
            $GEC_DTPRAZOENTREGA = convertDate($GEC_DTPRAZOENTREGA);
            $GEC_DTVENCIMENTO = convertDate($GEC_DTVENCIMENTO );

            // Verifica se a conexão já foi estabelecida
            if (!$this->pdo) {
                $this->conexao();
            }
            try {
                $sql = "UPDATE GEC_GESTAO_CONTRATO SET GEC_DTINICONTRATO = :GEC_DTINICONTRATO,
                                        GEC_DTENDCONTRATO = :GEC_DTENDCONTRATO,
                                        GEC_STCONTRATO = :GEC_STCONTRATO,
                                        GEC_DCPERIODOCOBRANCA = :GEC_DCPERIODOCOBRANCA,
                                        GEC_DCFORMAPAGAMENTO = :GEC_DCFORMAPAGAMENTO,
                                        GEC_DCEMAILCOBRANCA = :GEC_DCEMAILCOBRANCA,
                                        GEC_DCTELEFONECOBRANCA = :GEC_DCTELEFONECOBRANCA,
                                        GEC_DCDESCRICAO = :GEC_DCDESCRICAO,
                                        GEC_DTCONTRATACAO = :GEC_DTCONTRATACAO,
                                        GEC_DTPRAZOENTREGA = :GEC_DTPRAZOENTREGA,
                                        GEC_DCPERIODO_CARENCIA = :GEC_DCPERIODO_CARENCIA,
                                        GEC_DCDESCONTO = :GEC_DCDESCONTO,
                                        GEC_DCPERIODO_DESCONTO = :GEC_DCPERIODO_DESCONTO,
                                        GEC_DTVENCIMENTO = :GEC_DTVENCIMENTO,
                                        GEC_DCPARCELAMENTO = :GEC_DCPARCELAMENTO,
                                        GEC_DCVALOR = :GEC_DCVALOR
                                    WHERE GEC_IDGESTAO_CONTRATO = :GEC_IDGESTAO_CONTRATO";

                $stmt = $this->pdo->prepare($sql);

            
                // Liga os parâmetros aos valores
                $stmt->bindParam(':GEC_IDGESTAO_CONTRATO', $GEC_IDGESTAO_CONTRATO, PDO::PARAM_STR);
                $stmt->bindParam(':GEC_DTINICONTRATO', $GEC_DTINICONTRATO, PDO::PARAM_STR);
                $stmt->bindParam(':GEC_DTENDCONTRATO', $GEC_DTENDCONTRATO, PDO::PARAM_STR);
                $stmt->bindParam(':GEC_STCONTRATO', $GEC_STCONTRATO, PDO::PARAM_STR);
                $stmt->bindParam(':GEC_DCPERIODOCOBRANCA', $GEC_DCPERIODOCOBRANCA, PDO::PARAM_STR);
                $stmt->bindParam(':GEC_DCFORMAPAGAMENTO', $GEC_DCFORMAPAGAMENTO, PDO::PARAM_STR);
                $stmt->bindParam(':GEC_DCEMAILCOBRANCA', $GEC_DCEMAILCOBRANCA, PDO::PARAM_STR);
                $stmt->bindParam(':GEC_DCTELEFONECOBRANCA', $GEC_DCTELEFONECOBRANCA, PDO::PARAM_STR);
                $stmt->bindParam(':GEC_DCDESCRICAO', $GEC_DCDESCRICAO, PDO::PARAM_STR);
                $stmt->bindParam(':GEC_DTCONTRATACAO', $GEC_DTCONTRATACAO, PDO::PARAM_STR);
                $stmt->bindParam(':GEC_DTPRAZOENTREGA', $GEC_DTPRAZOENTREGA, PDO::PARAM_STR);
                $stmt->bindParam(':GEC_DCPERIODO_CARENCIA', $GEC_DCPERIODO_CARENCIA, PDO::PARAM_STR);
                $stmt->bindParam(':GEC_DCDESCONTO', $GEC_DCDESCONTO, PDO::PARAM_STR);
                $stmt->bindParam(':GEC_DCPERIODO_DESCONTO', $GEC_DCPERIODO_DESCONTO, PDO::PARAM_STR);
                $stmt->bindParam(':GEC_DTVENCIMENTO', $GEC_DTVENCIMENTO, PDO::PARAM_STR);
                $stmt->bindParam(':GEC_DCPARCELAMENTO', $GEC_DCPARCELAMENTO, PDO::PARAM_STR);
                $stmt->bindParam(':GEC_DCVALOR', $GEC_DCVALOR, PDO::PARAM_STR);
                
                $stmt->execute();
            
                // Retorna uma mensagem de sucesso (opcional)
                return ["success" => "Contrato atualizado com sucesso1."];
            } catch (PDOException $e) {
                // Captura e retorna o erro
                $this->InsertAlarme("Erro na função updateContratoInfo. $GEC_IDGESTAO_CONTRATO","High");
                return ["error" => $e->getMessage()];
            }
        }

        public function insertProspecInfo($PRC_NMNOME, $PRC_DCENDERECO, $PRC_DCMAPS_END, $PRC_NMCONTATO, $PRC_DCTELEFONE, $PRC_DCEMAIL, $PRC_DTVISITA, $PRC_STSTATUS, $PRC_DCOBSERVACOES)
        {    
            
            // Conversão das datas para o formato YYYY-MM-DD
            function convertDate($date) {
                $dateObj = DateTime::createFromFormat('d/m/Y', $date);
                return $dateObj ? $dateObj->format('Y-m-d') : null;  // Retorna null se a data for inválida
            }

            // Converte as datas recebidas do formulário
            $PRC_DTVISITA = convertDate($PRC_DTVISITA);

            // Verifica se a conexão já foi estabelecida
            if (!$this->pdo) {
                $this->conexao();
            }
        
            try {
                $sql = "INSERT INTO PRC_PROSPEC_CLIENTES 
                        (PRC_NMNOME, PRC_DCENDERECO, PRC_DCMAPS_END, PRC_NMCONTATO, PRC_DCTELEFONE, PRC_DCEMAIL, PRC_DTVISITA, PRC_STSTATUS, PRC_DCOBSERVACOES) 
                        VALUES (:PRC_NMNOME, :PRC_DCENDERECO, :PRC_DCMAPS_END, :PRC_NMCONTATO, :PRC_DCTELEFONE, :PRC_DCEMAIL, :PRC_DTVISITA, :PRC_STSTATUS, :PRC_DCOBSERVACOES)";

                $stmt = $this->pdo->prepare($sql);
            
                // Liga os parâmetros aos valores
                $stmt->bindParam(':PRC_NMNOME', $PRC_NMNOME, PDO::PARAM_STR);
                $stmt->bindParam(':PRC_DCENDERECO', $PRC_DCENDERECO, PDO::PARAM_STR);
                $stmt->bindParam(':PRC_DCMAPS_END', $PRC_DCMAPS_END, PDO::PARAM_STR);
                $stmt->bindParam(':PRC_NMCONTATO', $PRC_NMCONTATO, PDO::PARAM_STR);
                $stmt->bindParam(':PRC_DCTELEFONE', $PRC_DCTELEFONE, PDO::PARAM_STR);
                $stmt->bindParam(':PRC_DCEMAIL', $PRC_DCEMAIL, PDO::PARAM_STR);
                $stmt->bindParam(':PRC_DTVISITA', $PRC_DTVISITA, PDO::PARAM_STR);
                $stmt->bindParam(':PRC_STSTATUS', $PRC_STSTATUS, PDO::PARAM_STR);
                $stmt->bindParam(':PRC_DCOBSERVACOES', $PRC_DCOBSERVACOES, PDO::PARAM_STR);
                           
                $stmt->execute();
            
                // Retorna uma mensagem de sucesso (opcional)
                $this->InsertAlarme("Inserido novo prospec. $PRC_NMNOME","Warning");
                return ["success" => "Prospec inserido com sucesso."];
            } catch (PDOException $e) {
                // Captura e retorna o erro
                $this->InsertAlarme("Erro na função insertProspecInfo. $PRC_NMNOME","High");
                return ["error" => $e->getMessage()];
            }
        }

        public function insertUserInfo($USU_DCEMAIL, $USU_DCNOME, $USU_DCBLOCO, $USU_DCAPARTAMENTO, $USU_DCNIVEL, $USU_DCSENHA)
        {       
            // Verifica se a conexão já foi estabelecida
            if (!$this->pdo) {
                $this->conexao();
            }
            $now = new DateTime(); 
            $DATA = $now->format('Y-m-d H:i:s');

            try {
                $sql = "INSERT INTO USU_USUARIO 
                        (USU_DCEMAIL, USU_DCNOME, USU_DCBLOCO, USU_DCAPARTAMENTO, USU_DCNIVEL, USU_DCSENHA, USU_DTCADASTRO) 
                        VALUES (:USU_DCEMAIL, :USU_DCNOME, :USU_DCBLOCO, :USU_DCAPARTAMENTO, :USU_DCNIVEL, :USU_DCSENHA, :USU_DTCADASTRO)";

                $stmt = $this->pdo->prepare($sql);
            
                // Liga os parâmetros aos valores
                $stmt->bindParam(':USU_DCEMAIL', $USU_DCEMAIL, PDO::PARAM_STR);
                $stmt->bindParam(':USU_DCNOME', $USU_DCNOME, PDO::PARAM_STR);
                $stmt->bindParam(':USU_DCBLOCO', $USU_DCBLOCO, PDO::PARAM_STR);
                $stmt->bindParam(':USU_DCAPARTAMENTO', $USU_DCAPARTAMENTO, PDO::PARAM_STR);
                $stmt->bindParam(':USU_DCNIVEL', $USU_DCNIVEL, PDO::PARAM_STR);
                $stmt->bindParam(':USU_DCSENHA', $USU_DCSENHA, PDO::PARAM_STR);
                $stmt->bindParam(':USU_DTCADASTRO', $DATA, PDO::PARAM_STR);
            
                $stmt->execute();
           
                // Retorna uma mensagem de sucesso (opcional)
                return ["success" => "Morador cadastrado com sucesso."];
            } catch (PDOException $e) {
                // Captura e retorna o erro
                return ["error" => $e->getMessage()];
            }
        }

        public function updateUserInfo($USU_DCEMAIL, $USU_DCNOME, $USU_DCBLOCO, $USU_DCAPARTAMENTO, $USU_DCNIVEL, $USU_DCSENHA, $USU_IDUSUARIO)
        {       
            // Verifica se a conexão já foi estabelecida
            if (!$this->pdo) {
                $this->conexao();
            }

            try {
                $sql = "UPDATE USU_USUARIO 
                        SET
                        USU_DCEMAIL = :USU_DCEMAIL,
                        USU_DCNOME = :USU_DCNOME,
                        USU_DCBLOCO = :USU_DCBLOCO,
                        USU_DCAPARTAMENTO = :USU_DCAPARTAMENTO,
                        USU_DCNIVEL = :USU_DCNIVEL,
                        USU_DCSENHA = :USU_DCSENHA
                        WHERE USU_IDUSUARIO = :USU_IDUSUARIO";

                $stmt = $this->pdo->prepare($sql);
            
                // Liga os parâmetros aos valores
                $stmt->bindParam(':USU_DCEMAIL', $USU_DCEMAIL, PDO::PARAM_STR);
                $stmt->bindParam(':USU_DCNOME', $USU_DCNOME, PDO::PARAM_STR);
                $stmt->bindParam(':USU_DCBLOCO', $USU_DCBLOCO, PDO::PARAM_STR);
                $stmt->bindParam(':USU_DCAPARTAMENTO', $USU_DCAPARTAMENTO, PDO::PARAM_STR);
                $stmt->bindParam(':USU_DCNIVEL', $USU_DCNIVEL, PDO::PARAM_STR);
                $stmt->bindParam(':USU_DCSENHA', $USU_DCSENHA, PDO::PARAM_STR);
                $stmt->bindParam(':USU_IDUSUARIO', $USU_IDUSUARIO, PDO::PARAM_INT);

            
                $stmt->execute();
           
                // Retorna uma mensagem de sucesso (opcional)
                return ["success" => "Morador atualizado com sucesso."];
            } catch (PDOException $e) {
                // Captura e retorna o erro
                return ["error" => $e->getMessage()];
            }
        }

        public function insertVisitListaInfo($LIS_DCNOME, $USU_IDUSUARIO, $LIS_DCDOCUMENTO, $LIS_STSTATUS)
        {       
            // Verifica se a conexão já foi estabelecida
            if (!$this->pdo) {
                $this->conexao();
            }

            $now = new DateTime(); 
            $DATA = $now->format('Y-m-d H:i:s');

            try {
                $sql = "INSERT INTO LIS_LISTACONVIDADOS 
                        (LIS_DCNOME, USU_IDUSUARIO, LIS_DCDOCUMENTO, LIS_DTCADASTRO, LIS_STSTATUS) 
                        VALUES (:LIS_DCNOME, :USU_IDUSUARIO, :LIS_DCDOCUMENTO, :LIS_DTCADASTRO, :LIS_STSTATUS)";

                $stmt = $this->pdo->prepare($sql);
            
                // Liga os parâmetros aos valores
                $stmt->bindParam(':LIS_DCNOME', $LIS_DCNOME, PDO::PARAM_STR);
                $stmt->bindParam(':USU_IDUSUARIO', $USU_IDUSUARIO, PDO::PARAM_STR);
                $stmt->bindParam(':LIS_DCDOCUMENTO', $LIS_DCDOCUMENTO, PDO::PARAM_STR);
                $stmt->bindParam(':LIS_DTCADASTRO', $DATA, PDO::PARAM_STR);
                $stmt->bindParam(':LIS_STSTATUS', $LIS_STSTATUS, PDO::PARAM_STR);
                
            
                $stmt->execute();
            
                // Retorna uma mensagem de sucesso (opcional)
                return ["success" => "Visitante cadastrado com sucesso."];
            } catch (PDOException $e) {
                // Captura e retorna o erro
                return ["error" => $e->getMessage()];
            }
        }


        public function insertContratoInfo($GEC_IDGESTAO_CONTRATO,
        $CLI_IDCLIENT, 
        $PRS_IDPRODUTO_SERVICO, 
        $GEC_DTINICONTRATO, 
        $GEC_DTENDCONTRATO, 
        $GEC_STCONTRATO, 
        $GEC_DCPERIODOCOBRANCA, 
        $GEC_DCFORMAPAGAMENTO, 
        $GEC_DCEMAILCOBRANCA, 
        $GEC_DCTELEFONECOBRANCA, 
        $GEC_DCDESCRICAO,
        $GEC_DTCONTRATACAO, 
        $GEC_DTPRAZOENTREGA, 
        $GEC_DCPERIODO_CARENCIA, 
        $GEC_DCDESCONTO, 
        $GEC_DCPERIODO_DESCONTO, 
        $GEC_DTVENCIMENTO, 
        $GEC_DCPARCELAMENTO, 
        $GEC_DCVALOR)
        {          

            // Conversão das datas para o formato YYYY-MM-DD
            function convertDate($date) {
                $dateObj = DateTime::createFromFormat('d/m/Y', $date);
                return $dateObj ? $dateObj->format('Y-m-d') : null;  // Retorna null se a data for inválida
            }

            // Converte as datas recebidas do formulário
            $GEC_DTINICONTRATO = convertDate($GEC_DTINICONTRATO);
            $GEC_DTENDCONTRATO = convertDate($GEC_DTENDCONTRATO);
            $GEC_DTCONTRATACAO = convertDate($GEC_DTCONTRATACAO );
            $GEC_DTPRAZOENTREGA = convertDate($GEC_DTPRAZOENTREGA);
            $GEC_DTVENCIMENTO = convertDate($GEC_DTVENCIMENTO );

            // Verifica se a conexão já foi estabelecida
            if (!$this->pdo) {
                $this->conexao();
            }
            try {
                $sql = "INSERT INTO GEC_GESTAO_CONTRATO 
                        (GEC_IDGESTAO_CONTRATO,
                                        CLI_IDCLIENT, 
                                        PRS_IDPRODUTO_SERVICO, 
                                        GEC_DTINICONTRATO, 
                                        GEC_DTENDCONTRATO, 
                                        GEC_STCONTRATO, 
                                        GEC_DCPERIODOCOBRANCA, 
                                        GEC_DCFORMAPAGAMENTO, 
                                        GEC_DCEMAILCOBRANCA, 
                                        GEC_DCTELEFONECOBRANCA, 
                                        GEC_DCDESCRICAO,
                                        GEC_DTCONTRATACAO, 
                                        GEC_DTPRAZOENTREGA, 
                                        GEC_DCPERIODO_CARENCIA, 
                                        GEC_DCDESCONTO, 
                                        GEC_DCPERIODO_DESCONTO, 
                                        GEC_DTVENCIMENTO, 
                                        GEC_DCPARCELAMENTO, 
                                        GEC_DCVALOR) 
                        VALUES (:GEC_IDGESTAO_CONTRATO,
                                :CLI_IDCLIENT, 
                                :PRS_IDPRODUTO_SERVICO, 
                                :GEC_DTINICONTRATO, 
                                :GEC_DTENDCONTRATO, 
                                :GEC_STCONTRATO, 
                                :GEC_DCPERIODOCOBRANCA, 
                                :GEC_DCFORMAPAGAMENTO, 
                                :GEC_DCEMAILCOBRANCA, 
                                :GEC_DCTELEFONECOBRANCA, 
                                :GEC_DCDESCRICAO,
                                :GEC_DTCONTRATACAO, 
                                :GEC_DTPRAZOENTREGA, 
                                :GEC_DCPERIODO_CARENCIA, 
                                :GEC_DCDESCONTO, 
                                :GEC_DCPERIODO_DESCONTO, 
                                :GEC_DTVENCIMENTO, 
                                :GEC_DCPARCELAMENTO, 
                                :GEC_DCVALOR)";

                $stmt = $this->pdo->prepare($sql);
            
                // Liga os parâmetros aos valores
                $stmt->bindParam(':GEC_IDGESTAO_CONTRATO', $GEC_IDGESTAO_CONTRATO, PDO::PARAM_STR);
                $stmt->bindParam(':CLI_IDCLIENT', $CLI_IDCLIENT, PDO::PARAM_STR);
                $stmt->bindParam(':PRS_IDPRODUTO_SERVICO', $PRS_IDPRODUTO_SERVICO, PDO::PARAM_STR);
                $stmt->bindParam(':GEC_DTINICONTRATO', $GEC_DTINICONTRATO, PDO::PARAM_STR);
                $stmt->bindParam(':GEC_DTENDCONTRATO', $GEC_DTENDCONTRATO, PDO::PARAM_STR);
                $stmt->bindParam(':GEC_STCONTRATO', $GEC_STCONTRATO, PDO::PARAM_STR);
                $stmt->bindParam(':GEC_DCPERIODOCOBRANCA', $GEC_DCPERIODOCOBRANCA, PDO::PARAM_STR);
                $stmt->bindParam(':GEC_DCFORMAPAGAMENTO', $GEC_DCFORMAPAGAMENTO, PDO::PARAM_STR);
                $stmt->bindParam(':GEC_DCEMAILCOBRANCA', $GEC_DCEMAILCOBRANCA, PDO::PARAM_STR);
                $stmt->bindParam(':GEC_DCTELEFONECOBRANCA', $GEC_DCTELEFONECOBRANCA, PDO::PARAM_STR);
                $stmt->bindParam(':GEC_DCDESCRICAO', $GEC_DCDESCRICAO, PDO::PARAM_STR);
                $stmt->bindParam(':GEC_DTCONTRATACAO', $GEC_DTCONTRATACAO, PDO::PARAM_STR);
                $stmt->bindParam(':GEC_DTPRAZOENTREGA', $GEC_DTPRAZOENTREGA, PDO::PARAM_STR);
                $stmt->bindParam(':GEC_DCPERIODO_CARENCIA', $GEC_DCPERIODO_CARENCIA, PDO::PARAM_STR);
                $stmt->bindParam(':GEC_DCDESCONTO', $GEC_DCDESCONTO, PDO::PARAM_STR);
                $stmt->bindParam(':GEC_DCPERIODO_DESCONTO', $GEC_DCPERIODO_DESCONTO, PDO::PARAM_STR);
                $stmt->bindParam(':GEC_DTVENCIMENTO', $GEC_DTVENCIMENTO, PDO::PARAM_STR);
                $stmt->bindParam(':GEC_DCPARCELAMENTO', $GEC_DCPARCELAMENTO, PDO::PARAM_STR);
                $stmt->bindParam(':GEC_DCVALOR', $GEC_DCVALOR, PDO::PARAM_STR);
                
                $stmt->execute();

                //insere as parcelas na tabela de controle de liquidação financeira
                $dataVencimento = new DateTime($GEC_DTVENCIMENTO);
                $NUMPARCELA = 1;
                for($x=0; $x < $GEC_DCPARCELAMENTO; $x++)
                {
                    $this->insertListaPagamanto($GEC_IDGESTAO_CONTRATO, $dataVencimento->format('Y-m-d'), $GEC_DCVALOR, $NUMPARCELA);
                    
                    if($GEC_DCPERIODOCOBRANCA == "MENSAL"){$dataVencimento->modify('+1 month');}
                    if($GEC_DCPERIODOCOBRANCA == "TRIMESTRAL"){$dataVencimento->modify('+3 month');}
                    if($GEC_DCPERIODOCOBRANCA == "SEMESTRAL"){$dataVencimento->modify('+6 month');}
                    if($GEC_DCPERIODOCOBRANCA == "ANUAL"){$dataVencimento->modify('+12 month');}                   
                    
                    $NUMPARCELA++;
                }
            
                // Retorna uma mensagem de sucesso (opcional)
                return ["success" => "Contrato inserido com sucesso."];
            } catch (PDOException $e) {
                // Captura e retorna o erro
                $this->InsertAlarme("Erro na função insertContratoInfo. $GEC_IDGESTAO_CONTRATO","High");
                return ["error" => $e->getMessage()];
            }
        }

        public function insertListaPagamanto($GEC_IDGESTAO_CONTRATO, $GEC_DTVENCIMENTO, $LFI_DCVALOR_PARCELA, $LFI_DCNUMPARCELA)
        {          
            // Verifica se a conexão já foi estabelecida
            if (!$this->pdo) {
                $this->conexao();
            }

            // gerador de IOP ORDEM DE PAGAMENTO
            $timestamp = microtime(true);
            $numeroIOP = (int)($timestamp * 10000);
            $numeroIOP = $numeroIOP % 1000000;
            $numeroIOP = str_pad($numeroIOP, 6, '0', STR_PAD_LEFT); //garante 8 digitos
            $numeroAleatorio = rand(10,20);
            $LFI_IDOP = $numeroIOP.$numeroAleatorio;
        
            try {
                $sql = "INSERT INTO LFI_LIQUIDACAOFINANCEIRA 
                        (GEC_IDGESTAO_CONTRATO, LFI_DTVENCIMENTO, LFI_DCVALOR_PARCELA, LFI_DCNUMPARCELA, LFI_IDOP) 
                        VALUES (:GEC_IDGESTAO_CONTRATO, :LFI_DTVENCIMENTO, :LFI_DCVALOR_PARCELA, :LFI_DCNUMPARCELA, :LFI_IDOP)";

                $stmt = $this->pdo->prepare($sql);
            
                // Liga os parâmetros aos valores
                $stmt->bindParam(':GEC_IDGESTAO_CONTRATO', $GEC_IDGESTAO_CONTRATO, PDO::PARAM_STR);
                $stmt->bindParam(':LFI_DTVENCIMENTO', $GEC_DTVENCIMENTO, PDO::PARAM_STR);
                $stmt->bindParam(':LFI_DCVALOR_PARCELA', $LFI_DCVALOR_PARCELA, PDO::PARAM_STR);
                $stmt->bindParam(':LFI_DCNUMPARCELA', $LFI_DCNUMPARCELA, PDO::PARAM_STR);
                $stmt->bindParam(':LFI_IDOP', $LFI_IDOP, PDO::PARAM_STR);
            
                $stmt->execute();

            } catch (PDOException $e) {
                // Captura e retorna o erro
                $this->InsertAlarme("Erro na função insertListaPagamanto. $GEC_IDGESTAO_CONTRATO","High");
                return ["error" => $e->getMessage()];
            }
        }

        public function insertClientInfo($CLI_NMNAME, $CLI_DCCPFCNPJ, $CLI_DCRSOCIAL, $CLI_DCEMAIL, $CLI_DCTEL1, $CLI_DCTEL2, $CLI_DCADDRESS, $CLI_DCSTATE, $CLI_DCCITY, $CLI_DCOBS, $CLI_DCCEP, $CLI_DCBAIRRO)
        {          
            // Verifica se a conexão já foi estabelecida
            if (!$this->pdo) {
                $this->conexao();
            }
            $CLI_STSTATUS = "ATIVO";
            $CLI_DTDATA_INSERT = date('Y-m-d H:i:s'); // Formato: 2024-10-17 08:30:00
            $CLI_STSTATUSPENDING = "Recebido";
            try {
                $sql = "INSERT INTO CLI_CLIENT 
                        (CLI_NMNAME, CLI_DCCPFCNPJ, CLI_DCRSOCIAL, CLI_DCEMAIL, CLI_DCTEL1, CLI_DCTEL2, CLI_DCADDRESS, CLI_DCSTATE, CLI_DCCITY, CLI_DCOBS, CLI_DTDATA_INSERT, CLI_STSTATUSPENDING, CLI_STSTATUS, CLI_DCCEP, CLI_DCBAIRRO) 
                        VALUES (:CLI_NMNAME, :CLI_DCCPFCNPJ, :CLI_DCRSOCIAL, :CLI_DCEMAIL, :CLI_DCTEL1, :CLI_DCTEL2, :CLI_DCADDRESS, :CLI_DCSTATE, :CLI_DCCITY, :CLI_DCOBS, :CLI_DTDATA_INSERT, :CLI_STSTATUSPENDING, :CLI_STSTATUS, :CLI_DCCEP, :CLI_DCBAIRRO)";

                $stmt = $this->pdo->prepare($sql);
            
                // Liga os parâmetros aos valores
                $stmt->bindParam(':CLI_NMNAME', $CLI_NMNAME, PDO::PARAM_STR);
                $stmt->bindParam(':CLI_DCCPFCNPJ', $CLI_DCCPFCNPJ, PDO::PARAM_STR);
                $stmt->bindParam(':CLI_DCRSOCIAL', $CLI_DCRSOCIAL, PDO::PARAM_STR);
                $stmt->bindParam(':CLI_DCEMAIL', $CLI_DCEMAIL, PDO::PARAM_STR);
                $stmt->bindParam(':CLI_DCTEL1', $CLI_DCTEL1, PDO::PARAM_STR);
                $stmt->bindParam(':CLI_DCTEL2', $CLI_DCTEL2, PDO::PARAM_STR);
                $stmt->bindParam(':CLI_DCADDRESS', $CLI_DCADDRESS, PDO::PARAM_STR);
                $stmt->bindParam(':CLI_DCSTATE', $CLI_DCSTATE, PDO::PARAM_STR);
                $stmt->bindParam(':CLI_DCCITY', $CLI_DCCITY, PDO::PARAM_STR);
                $stmt->bindParam(':CLI_DCOBS', $CLI_DCOBS, PDO::PARAM_STR);
                $stmt->bindParam(':CLI_DTDATA_INSERT', $CLI_DTDATA_INSERT, PDO::PARAM_STR);
                $stmt->bindParam(':CLI_STSTATUSPENDING', $CLI_STSTATUSPENDING, PDO::PARAM_STR);
                $stmt->bindParam(':CLI_STSTATUS', $CLI_STSTATUS, PDO::PARAM_STR);
                $stmt->bindParam(':CLI_DCCEP', $CLI_DCCEP, PDO::PARAM_STR);
                $stmt->bindParam(':CLI_DCBAIRRO', $CLI_DCBAIRRO, PDO::PARAM_STR); 
                
                $stmt->execute();
            
                // Retorna uma mensagem de sucesso (opcional)
                return "Cliente cadastrado com sucesso.";
            } catch (PDOException $e) {
                // Captura e retorna o erro
                $this->InsertAlarme("Erro na função insertClientInfo. $CLI_NMNAME","High");
                return "ERRO: Não foi possível cadastrar o cliente.";
            }
        }

        public function insertProductInfo($PRS_NMNOME, $PRS_DCTIPO, $PRS_DCINVESTIMENTO, $PRS_STSTATUS, $PRS_DCDESCRICAO)
        {          
            // Verifica se a conexão já foi estabelecida
            if (!$this->pdo) {
                $this->conexao();
            }
            
            try {
                $sql = "INSERT INTO PRS_PRODUTO_SERVICO 
                        (PRS_NMNOME, PRS_DCTIPO, PRS_DCINVESTIMENTO, PRS_STSTATUS, PRS_DCDESCRICAO) 
                        VALUES (:PRS_NMNOME, :PRS_DCTIPO, :PRS_DCINVESTIMENTO, :PRS_STSTATUS, :PRS_DCDESCRICAO)";

                $stmt = $this->pdo->prepare($sql);
            
                // Liga os parâmetros aos valores
                $stmt->bindParam(':PRS_NMNOME', $PRS_NMNOME, PDO::PARAM_STR);
                $stmt->bindParam(':PRS_DCTIPO', $PRS_DCTIPO, PDO::PARAM_STR);
                $stmt->bindParam(':PRS_DCINVESTIMENTO', $PRS_DCINVESTIMENTO, PDO::PARAM_STR);
                $stmt->bindParam(':PRS_DCDESCRICAO', $PRS_DCDESCRICAO, PDO::PARAM_STR);
                $stmt->bindParam(':PRS_STSTATUS', $PRS_STSTATUS, PDO::PARAM_STR);

                $stmt->execute();
            
                // Retorna uma mensagem de sucesso (opcional)
                $this->InsertAlarme("Novo produto cadastrado. $PRS_NMNOME","Info");
                return ["success" => "Produto inserido com sucesso."];
            } catch (PDOException $e) {
                // Captura e retorna o erro
                $this->InsertAlarme("Erro na função insertProductInfo. $PRS_NMNOME","High");
                return ["error" => $e->getMessage()];
            }
        }
                                        
        public function insertAgendaInfo($AGE_DCTITULO,$AGE_DTINI,$AGE_DTFIM,$AGE_STSTATUS,$AGE_DCDESC,$USA_IDUSERADMIN)
        {          
            // Verifica se a conexão já foi estabelecida
            if (!$this->pdo) {
                $this->conexao();
            }
            
            try {
                $sql = "INSERT INTO AGE_AGENDA 
                        (AGE_DCTITULO,AGE_DTINI,AGE_DTFIM,AGE_STSTATUS,AGE_DCDESC,USA_IDUSERADMIN) 
                        VALUES (:AGE_DCTITULO,:AGE_DTINI,:AGE_DTFIM,:AGE_STSTATUS,:AGE_DCDESC,:USA_IDUSERADMIN)";

                $stmt = $this->pdo->prepare($sql);
            
                // Liga os parâmetros aos valores
                $stmt->bindParam(':AGE_DCTITULO', $AGE_DCTITULO, PDO::PARAM_STR);
                $stmt->bindParam(':AGE_DTINI', $AGE_DTINI, PDO::PARAM_STR);
                $stmt->bindParam(':AGE_DTFIM', $AGE_DTFIM, PDO::PARAM_STR);
                $stmt->bindParam(':AGE_STSTATUS', $AGE_STSTATUS, PDO::PARAM_STR);
                $stmt->bindParam(':AGE_DCDESC', $AGE_DCDESC, PDO::PARAM_STR);
                $stmt->bindParam(':USA_IDUSERADMIN', $USA_IDUSERADMIN, PDO::PARAM_STR);

                $stmt->execute();
            
                // Retorna uma mensagem de sucesso (opcional)
                $this->InsertAlarme("Nova tarefa cadastrada. $AGE_DCTITULO","Info");
                return ["success" => "Tarefa inserida com sucesso."];
            } catch (PDOException $e) {
                // Captura e retorna o erro
                $this->InsertAlarme("Erro na função insertAgendaInfo. $AGE_DCTITULO","High");
                return ["error" => $e->getMessage()];
            }
        }

        public function updateAgendaInfo($AGE_DCTITULO,$AGE_DTINI,$AGE_DTFIM,$AGE_STSTATUS,$AGE_DCDESC,$USA_IDUSERADMIN,$AGE_IDAGENDA)
        {          
            // Verifica se a conexão já foi estabelecida
            if (!$this->pdo) {
                $this->conexao();
            }
            
            try {
                $sql = "UPDATE AGE_AGENDA 
                        SET AGE_DCTITULO = :AGE_DCTITULO,
                        AGE_DTINI = :AGE_DTINI,
                        AGE_DTFIM = :AGE_DTFIM,
                        AGE_STSTATUS = :AGE_STSTATUS,
                        AGE_DCDESC = :AGE_DCDESC,
                        USA_IDUSERADMIN = :USA_IDUSERADMIN
                        WHERE AGE_IDAGENDA = :AGE_IDAGENDA";

                $stmt = $this->pdo->prepare($sql);
            
                // Liga os parâmetros aos valores
                $stmt->bindParam(':AGE_DCTITULO', $AGE_DCTITULO, PDO::PARAM_STR);
                $stmt->bindParam(':AGE_DTINI', $AGE_DTINI, PDO::PARAM_STR);
                $stmt->bindParam(':AGE_DTFIM', $AGE_DTFIM, PDO::PARAM_STR);
                $stmt->bindParam(':AGE_STSTATUS', $AGE_STSTATUS, PDO::PARAM_STR);
                $stmt->bindParam(':AGE_DCDESC', $AGE_DCDESC, PDO::PARAM_STR);
                $stmt->bindParam(':USA_IDUSERADMIN', $USA_IDUSERADMIN, PDO::PARAM_STR);
                $stmt->bindParam(':AGE_IDAGENDA', $AGE_IDAGENDA, PDO::PARAM_STR);

                $stmt->execute();
            
                // Retorna uma mensagem de sucesso (opcional)
                $this->InsertAlarme("Tarefa atualizada. $AGE_DCTITULO","Info");
                return ["success" => "Tarefa atualizada com sucesso."];
            } catch (PDOException $e) {
                // Captura e retorna o erro
                $this->InsertAlarme("Erro na função updateAgendaInfo. $AGE_DCTITULO","High");
                return ["error" => $e->getMessage()];
            }
        }

        public function insertBalancoMes($BLM_DCRECEITA, $BLM_DCDESPESA, $BLM_DCLIQUIDO)
        {          
            // Verifica se a conexão já foi estabelecida
            if (!$this->pdo) {
                $this->conexao();
            }

            $BLM_DTFECHAMENTO = date('Y-m-d H:i:s'); // Formato: 2024-10-17 08:30:00

            try {
                $sql = "INSERT INTO BLM_BALANCO_MENSAL 
                        (BLM_DTFECHAMENTO, BLM_DCRECEITA, BLM_DCDESPESA, BLM_DCLIQUIDO) 
                        VALUES (:BLM_DTFECHAMENTO, :BLM_DCRECEITA, :BLM_DCDESPESA, :BLM_DCLIQUIDO)";

                $stmt = $this->pdo->prepare($sql);
            
                // Liga os parâmetros aos valores
                $stmt->bindParam(':BLM_DTFECHAMENTO', $BLM_DTFECHAMENTO, PDO::PARAM_STR);
                $stmt->bindParam(':BLM_DCRECEITA', $BLM_DCRECEITA, PDO::PARAM_STR);
                $stmt->bindParam(':BLM_DCDESPESA', $BLM_DCDESPESA, PDO::PARAM_STR);
                $stmt->bindParam(':BLM_DCLIQUIDO', $BLM_DCLIQUIDO, PDO::PARAM_STR);
                $stmt->execute();
            
                // Retorna uma mensagem de sucesso (opcional)
                return ["success" => "Balanço inserido com sucesso."];
            } catch (PDOException $e) {
                // Captura e retorna o erro
                $this->InsertAlarme("Erro na função insertBalancoMes. $BLM_DTFECHAMENTO","High");
                return ["error" => $e->getMessage()];
            }
        }

        public function notifyEmail($SUBJECT, $MSG)
        {
            $this->getParameterInfo();

            foreach($this->ARRAY_PARAMETERINFO as $value)
            {
                if($value["CFG_DCPARAMETRO"] == "EMAIL_ALERTAS")
                {
                    $emailTo = $value["CFG_DCVALOR"];
                }
            } 

            // Configurações do e-mail
            $to = $emailTo; 
            $subject = "ATENÇÃO: $SUBJECT";
            $body = "$MSG\n";

            // Adiciona cabeçalhos para o e-mail
            $headers = "From: no-reply@prqdashortensias.com.br\r\n";
            $headers .= "Reply-To: no-reply@prqdashortensias.com.br\r\n";
            $headers .= "Content-Type: text/plain; charset=UTF-8\r\n"; // Define a codificação como UTF-8
            $headers .= "MIME-Version: 1.0\r\n";
            
            mail($to, $subject, $body, $headers);        
        }

        public function notifyUsuarioEmail($SUBJECT, $MSG, $EMAIL)
        {
            $this->getParameterInfo();

            // Configurações do e-mail
            $to = $EMAIL; 
            $subject = "$SUBJECT";
            $body = "$MSG\n";

            // Adiciona cabeçalhos para o e-mail
            $headers = "From: no-reply@prqdashortensias.com.br\r\n";
            $headers .= "Reply-To: no-reply@prqdashortensias.com.br\r\n";
            $headers .= "Content-Type: text/plain; charset=UTF-8\r\n"; // Define a codificação como UTF-8
            $headers .= "MIME-Version: 1.0\r\n";
            
            mail($to, $subject, $body, $headers);        
        }


    }
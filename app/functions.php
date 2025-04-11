
<?php 
        define ("myhost", "localhost");
        define ("segUsr", "segreteria"); //parametri dell'utente segreteria del dbms
        define ("segPsw", "1234");  //parametri dell'utente segreteria del dbms
        define ("docUsr", "docente"); //parametri dell'utente docenti del dbms
        define ("docPsw", "12345");  //parametri dell'utente docenti del dbms
        define ("studUsr", "studente"); //parametri dell'utente studenti del dbms
        define ("studPsw", "123456");  //parametri dell'utente studenti del dbms
        define ("mydb", "unidb_cs");    
    function open_pg_studenti_connection() {
        
        $connection = "host=".myhost." dbname=".mydb." user=".studUsr." password=".studPsw;
        
        return pg_connect($connection);
        
    }
    function open_pg_segreteria_connection() {
        
        $connection = "host=".myhost." dbname=".mydb." user=".segUsr." password=".segPsw;
        
        return pg_connect($connection);
        
    }

    function open_pg_docenti_connection() {
        
        $connection = "host=".myhost." dbname=".mydb." user=".docUsr." password=".docPsw;
        return pg_connect($connection);
        
    }
    
    
    function close_pg_connection($db) {
            
        return pg_close($db);
        
    }

    function login($email, $password, $tipo) {
    
        $logged = null;
    

        if ($tipo == 'Studente'){
            $db = open_pg_studenti_connection();

    
            $sql = "SELECT username, matricola FROM unidb.studente WHERE username = $1 AND password = $2";
        
            $params = array(
                $email,
                $password
            );
        
            $result = pg_prepare($db, "check_student", $sql);
            $result = pg_execute($db, "check_student", $params);
        
            if($row = pg_num_rows($result) > 0){
                $logged = $email;
            }
        
            close_pg_connection($db);


        
            return $logged;

        } else if ($tipo == 'Segreteria'){
            $db = open_pg_segreteria_connection();

    
            $sql = "SELECT username FROM unidb.segreteria WHERE username = $1 AND password = $2";
        
            $params = array(
                $email,
                $password
            );
        
            $result = pg_prepare($db, "check_segret", $sql);
            $result = pg_execute($db, "check_segret", $params);
        
            if($row = pg_num_rows($result) > 0){
                $logged = $email;
            }
        
            close_pg_connection($db);

        
            return $logged;
        } else if ($tipo == 'Docente') {
            $db = open_pg_docenti_connection();


    
            $sql = "SELECT username FROM unidb.docente WHERE username = $1 AND password = $2";
        
            $params = array(
                $email,
                $password
            );
        
            $result = pg_prepare($db, "check_doc", $sql);
            $result = pg_execute($db, "check_doc", $params);


        
            if($row = pg_num_rows($result) > 0){
                $logged = $email;
            }
        
            close_pg_connection($db);


        
            return $logged;
        }

        
    }

    function get_user_studente($username){
        $db = open_pg_studenti_connection();

    
            $sql = "SELECT studente.matricola, studente.nome as nome_studente, studente.cognome, cdl.nome, cdl.codice as id_cdl FROM unidb.studente inner join unidb.cdl on studente.cdl = cdl.codice WHERE username = $1";
        
            $params = array(
                $username,
            );
        
            $result = pg_prepare($db, "check_studente", $sql);
            $result = pg_execute($db, "check_studente", $params);
        
            $row = pg_fetch_array($result, null, PGSQL_ASSOC);
        
            close_pg_connection($db);

            return $row;

    }

    function get_user_docente($username) {
        $db = open_pg_docenti_connection();

    
            $sql = "SELECT id, nome, cognome FROM unidb.docente WHERE username = $1";
        
            $params = array(
                $username
            );
        
            $result = pg_prepare($db, "check_docente", $sql);
            $result = pg_execute($db, "check_docente", $params);
        
            $row = pg_fetch_array($result, null, PGSQL_ASSOC);
        
            close_pg_connection($db);

            return $row;
    }

    
    function get_iscrizioni($matr) {
        $db = open_pg_studenti_connection();

        $sql = "SELECT data_appello, insegnamento, nome FROM unidb.iscrizione_esami_studenti WHERE studente = $1";

        $params = array(
            $matr
        );


        $result = pg_prepare($db, "check_iscrizione", $sql);
        $result = pg_execute($db, "check_iscrizione", $params);

        $iscrizioni = array();

        $cont = 0;
        if ($result)
        {
            while($row = pg_fetch_assoc($result)){
                $nome = $row['nome'];
                $data= $row['data_appello'];
                $insegnamento = $row['insegnamento'];
                $cont++;

                $iscrizioni[$cont] = array($nome, $data, $insegnamento);
            }
        }
        return $iscrizioni;
    }


    function get_cdl() {
        $db = open_pg_studenti_connection();

        $sql = "SELECT codice, nome, tipologia FROM unidb.cdl";

        $result = pg_prepare($db, "cdl_info", $sql);
        $result = pg_execute($db, "cdl_info", array());

        $lista_cdl = array();

        $cont = 0;
        if ($result)
        {
            while($row = pg_fetch_assoc($result)){
                ;
                $codice = $row['codice'];
                $nome= $row['nome'];
                $tipologia = $row['tipologia'];
                if ($tipologia == 'T') {
                    $tipologia = 'Triennale';
                } else {
                    $tipologia = 'Magistrale';
                }
                $cont++;

                $lista_cdl[$cont] = array($codice, $nome, $tipologia);
            }
        }
        return $lista_cdl;
    }


    function get_insegnamenti_cdl($codice_cdl) {
        $db = open_pg_studenti_connection();

        $sql = "SELECT codice, nome, anno, nome_docente, cognome_docente, descrizione FROM unidb.info_cdl WHERE codice_cdl = $1";

        $params = array(
            $codice_cdl
        );


        $result = pg_prepare($db, "cdl_info", $sql);
        $result = pg_execute($db, "cdl_info", $params);

        $lista_insegnamenti = array();

        $cont = 0;
        if ($result)
        {
            while($row = pg_fetch_assoc($result)){
                
                $codice = $row['codice'];
                $nome= $row['nome'];
                $anno = $row['anno'];
                $nome_docente = $row['nome_docente'].' '.$row['cognome_docente'];
                $descrizione = $row['descrizione'];
                $cont++;

                $lista_insegnamenti[$cont] = array($codice, $nome, $anno, $nome_docente, $descrizione);
            }
        }
        return $lista_insegnamenti;
    }

    function get_esami($matricola) {
        $db = open_pg_studenti_connection();

        $sql = "SELECT insegnamento, nome, data_superamento, voto, lode FROM unidb.esame e inner join unidb.insegnamento ON e.insegnamento = insegnamento.codice and e.cdl = insegnamento.cdl
        WHERE data_superamento = (SELECT MAX(data_superamento) FROM unidb.esame e2 WHERE studente = $1 AND e2.cdl = e.cdl AND e2.insegnamento = e.insegnamento)";

        $params = array(
            $matricola
        );


        $result = pg_prepare($db, "esami_fatti", $sql);
        $result = pg_execute($db, "esami_fatti", $params);

        $lista_esami = array();

        $cont = 0;
        if ($result)
        {
            while($row = pg_fetch_assoc($result)){
                
                $insegnamento = $row['insegnamento'];
                $nome= $row['nome'];
                $data_superamento = $row['data_superamento'];
                $voto = $row['voto'];
                $lode = $row['lode'];
                if ($lode == 't' and $voto == 30) {
                    $lode = 'si';
                } else {
                    $lode = '';
                }
                $cont++;

                $lista_esami[$cont] = array($insegnamento, $nome, $data_superamento, $voto, $lode);
            }
        }
        return $lista_esami;
    }

    function get_appelli($cod_cdl, $matricola) {
        $db = open_pg_studenti_connection();

        $sql = "SELECT appelli_nome.data_appello, appelli_nome.insegnamento, appelli_nome.nome, appelli_nome.codice_cdl FROM unidb.appelli_nome WHERE appelli_nome.codice_cdl = $1 AND NOT EXISTS (SELECT * FROM unidb.iscrizione WHERE studente = $2 and iscrizione.data_appello = appelli_nome.data_appello and iscrizione.insegnamento = appelli_nome.insegnamento and iscrizione.cdl = appelli_nome.codice_cdl) ORDER BY appelli_nome.data_appello";
        
        $params = array(
            $cod_cdl,
            $matricola
        );


        $result = pg_prepare($db, "appelli_disponibili", $sql);
        $result = pg_execute($db, "appelli_disponibili", $params);

        $lista_appelli = array();

        $cont = 0;
        if ($result)
        {
            while($row = pg_fetch_assoc($result)){
                

                $giorno = $row['data_appello'];
                $insegnamento= $row['insegnamento'];
                $nome = $row['nome'];
                $codice_cdl = $row['codice_cdl'];
                $cont++;

                $lista_appelli[$cont] = array($giorno, $insegnamento, $nome, $codice_cdl);
            }
        } 

        return $lista_appelli;
    }


    function iscrivi_appello($matricola, $giorno, $cdl, $insegnamento) {
        $db = open_pg_studenti_connection();

        $sql ="INSERT INTO unidb.iscrizione VALUES ($1, $2, $4, $3)";


        $params = array(
            $matricola,
            $giorno,
            $cdl,
            $insegnamento
        );

        $result = pg_prepare($db, "iscrivi", $sql);
        $result = pg_execute($db, "iscrivi", $params);
        if ($result) {
            $msg = 'Iscrizione andata a buon fine';
        } else {
            $msg = "Errore";
        }

        return $msg;
    }
    
    function get_responsabile($id) {
        $db = open_pg_docenti_connection();

        $sql = "SELECT codice, nome, cdl FROM unidb.insegnamento WHERE docente = $1";
        
        $params = array(
            $id
        );


        $result = pg_prepare($db, "responsabile_corsi", $sql);
        $result = pg_execute($db, "responsabile_corsi", $params);

        $lista_insegnamenti = array();

        $cont = 0;
        if ($result)
        {
            while($row = pg_fetch_assoc($result)){

                $codice_insegnamento = $row['codice'];
                $insegnamento= $row['nome'];
                $cdl = $row['cdl'];
                $cont++;

                $lista_insegnamenti[$cont] = array($codice_insegnamento, $insegnamento, $cdl);
            }
        } 

        return $lista_insegnamenti;
    }

    function is_bisestile($anno) {
        $conversione_anno = intval($anno);
        if ($conversione_anno%400==0 || ($conversione_anno%4==00 && !($conversione_anno%100==0))){
            return true;
        }
        return false;
    }

    function get_appelli_passati($id_docente) {
        $db = open_pg_docenti_connection();

        $sql = "SELECT appello.data, appello.insegnamento, insegnamento.nome, appello.cdl FROM unidb.appello INNER JOIN unidb.insegnamento ON appello.insegnamento = insegnamento.codice and appello.cdl = insegnamento.cdl WHERE insegnamento.docente = $1 and appello.data < CURRENT_DATE ORDER BY appello.insegnamento";
        
        $params = array(
            $id_docente
        );


        $result = pg_prepare($db, "appelli_passati", $sql);
        $result = pg_execute($db, "appelli_passati", $params);

        $lista_appelli_passati = array();
        $cont = 0;

        if ($result)
        {
            while($row = pg_fetch_assoc($result)){

                $data_appello = $row['data'];
                $insegnamento= $row['insegnamento'];
                $nome = $row['nome'];
                $cdl = $row['cdl'];
                $cont++;

                $lista_appelli_passati[$cont] = array($data_appello, $insegnamento, $nome, $cdl);
            }
        } 

        return $lista_appelli_passati;

    }

    function get_iscritti($data_appello, $insegnamento, $cdl) {
        $db = open_pg_docenti_connection();

        $sql = "SELECT studente, insegnamento, cdl, data_appello FROM unidb.iscrizione WHERE iscrizione.data_appello = $1 and iscrizione.insegnamento = $2 and iscrizione.cdl = $3";
        
        $params = array(
            $data_appello,
            $insegnamento,
            $cdl
        );


        $result = pg_prepare($db, "iscritti_appello", $sql);
        $result = pg_execute($db, "iscritti_appello", $params);

        $lista_iscrizioni = array();
        $cont = 0;

        if ($result)
        {
            while($row = pg_fetch_assoc($result)){

                $matricola = $row['studente'];
                $insegnamento= $row['insegnamento'];
                $cdl = $row['cdl'];
                $data_appello = $row['data_appello'];
                $cont++;

                $lista_iscrizioni[$cont] = array($matricola, $insegnamento, $cdl, $data_appello);
            }
        } 

        return $lista_iscrizioni;

    }

    function get_voto($matricola, $insegnamento, $cdl, $data) {
        $db = open_pg_docenti_connection();

        $sql = "SELECT studente, voto, lode FROM unidb.esame WHERE studente = $1 and $insegnamento = $2 and cdl = $3 and data_superamento = $4";
        
        $params = array(
            $matricola,
            $insegnamento,
            $cdl,
            $data
        );

        $check = false;
        $result = pg_prepare($db, "esami_registrati", $sql);
        $result = pg_execute($db, "esami_registrati", $params);

        $row = pg_fetch_array($result, null, PGSQL_ASSOC);

        if ($row == null) {
            $check = false;
        } else {
            $check = true;
            $_SESSION['voto'] = $row['voto'];
            $_SESSION['lode'] = $row['lode'];
        }
        return $check;
    }

    function get_studenti_attivi() {
        $db = open_pg_segreteria_connection();

        $sql = "SELECT studente.matricola, studente.nome, studente.cognome, studente.cdl, cdl.nome as nome_cdl FROM unidb.studente inner join unidb.cdl on studente.cdl = cdl.codice ORDER BY studente.matricola";

        $result = pg_prepare($db, "studenti_attivi", $sql);
        $result = pg_execute($db, "studenti_attivi", array());

        $lista_studenti = array();


        $cont = 0;
        if ($result)
        {
            while($row = pg_fetch_assoc($result)){

                $matricola = $row['matricola'];
                $nome_studente= $row['nome'];
                $cognome_studente = $row['cognome'];
                $cdl = $row['cdl'];
                $nome_cdl = $row['nome_cdl'];
                $cont++;

                $lista_studenti[$cont] = array($matricola, $nome_studente, $cognome_studente, $cdl, $nome_cdl);
            }
        }
        return $lista_studenti;


    }

    function carriera_studente_totale($matricola) {
        $db = open_pg_segreteria_connection();

        $sql = "SELECT esame.insegnamento, insegnamento.nome, esame.cdl, esame.data_superamento, esame.voto, esame.lode FROM unidb.insegnamento inner join unidb.esame on insegnamento.codice = esame.insegnamento and insegnamento.cdl = esame.cdl WHERE esame.studente = $1 ORDER BY esame.insegnamento, esame.data_superamento DESC";

        $params = array(
            $matricola
        );


        $result = pg_prepare($db, "carriera_totale", $sql);
        $result = pg_execute($db, "carriera_totale", $params);

        $esami_completi= array();

        $cont = 0;
        if ($result)
        {
            while($row = pg_fetch_assoc($result)){

                $insegnamento= $row['insegnamento'];
                $nome_insegnamento= $row['nome'];
                $cdl = $row['cdl'];
                $data = $row['data_superamento'];
                $voto = $row['voto'];
                $lode = $row['lode'];
                $cont++;

                $esami_completi[$cont] = array($insegnamento, $nome_insegnamento, $cdl, $data, $voto, $lode);
            }
        }
        return $esami_completi;
    }



    function carriera_studente_parziale($matricola) {
        
        $db = open_pg_segreteria_connection();
        
        $sql = "SELECT insegnamento, nome, data_superamento, voto, lode, e.cdl FROM unidb.esame e inner join unidb.insegnamento ON e.insegnamento = insegnamento.codice and e.cdl = insegnamento.cdl
        WHERE data_superamento = (SELECT MAX(data_superamento) FROM unidb.esame e2 WHERE studente = $1 AND e2.cdl = e.cdl AND e2.insegnamento = e.insegnamento) and e.voto >= 18";


        $params = array(
            $matricola
        );


        $result = pg_prepare($db, "carriera_parziale", $sql);
        $result = pg_execute($db, "carriera_parziale", $params);



        $esami_parziali= array();

        $cont = 0;
        if ($result)
        {
            while($row = pg_fetch_assoc($result)){

                $insegnamento= $row['insegnamento'];
                $nome_insegnamento= $row['nome'];
                $cdl = $row['cdl'];
                $data = $row['data_superamento'];
                $voto = $row['voto'];
                $lode = $row['lode'];
                $cont++;

                $esami_parziali[$cont] = array($insegnamento, $nome_insegnamento, $cdl, $data, $voto, $lode);
            }
        }
        return $esami_parziali;
    }


    function get_studenti_storico() {
        $db = open_pg_segreteria_connection();

        $sql = "SELECT storico_studenti.studente, storico_studenti.nome, storico_studenti.cognome, storico_studenti.cdl, cdl.nome as nome_cdl FROM unidb.storico_studenti inner join unidb.cdl on storico_studenti.cdl = cdl.codice ORDER BY storico_studenti.studente";

        $result = pg_prepare($db, "esami_registrati", $sql);
        $result = pg_execute($db, "esami_registrati", array());

        $lista_studenti_storico = array();


        $cont = 0;
        if ($result)
        {
            while($row = pg_fetch_assoc($result)){

                $matricola = $row['studente'];
                $nome_studente= $row['nome'];
                $cognome_studente = $row['cognome'];
                $cdl = $row['cdl'];
                $nome_cdl = $row['nome_cdl'];
                $cont++;

                $lista_studenti_storico[$cont] = array($matricola, $nome_studente, $cognome_studente, $cdl, $nome_cdl);
            }
        }
        return $lista_studenti_storico;
    }

    function storico_studente_totale($matricola) {
        $db = open_pg_segreteria_connection();

        $sql = "SELECT storico_esami.insegnamento, insegnamento.nome, storico_esami.cdl, storico_esami.data_superamento, storico_esami.voto, storico_esami.lode FROM unidb.insegnamento inner join unidb.storico_esami on insegnamento.codice = storico_esami.insegnamento and insegnamento.cdl = storico_esami.cdl WHERE storico_esami.studente = $1 ORDER BY storico_esami.insegnamento, storico_esami.data_superamento DESC";

        $params = array(
            $matricola
        );


        $result = pg_prepare($db, "storico_totale", $sql);
        $result = pg_execute($db, "storico_totale", $params);

        $storico_completi= array();

        $cont = 0;
        if ($result)
        {
            while($row = pg_fetch_assoc($result)){

                $insegnamento= $row['insegnamento'];
                $nome_insegnamento= $row['nome'];
                $cdl = $row['cdl'];
                $data = $row['data_superamento'];
                $voto = $row['voto'];
                $lode = $row['lode'];
                $cont++;

                $storico_completi[$cont] = array($insegnamento, $nome_insegnamento, $cdl, $data, $voto, $lode);
            }
        }
        return $storico_completi;
    }


    function storico_studente_parziale($matricola) {
        
        $db = open_pg_segreteria_connection();
        
        $sql = "SELECT insegnamento, nome, data_superamento, voto, lode, e.cdl FROM unidb.storico_esami e inner join unidb.insegnamento ON e.insegnamento = insegnamento.codice and e.cdl = insegnamento.cdl
        WHERE data_superamento = (SELECT MAX(data_superamento) FROM unidb.storico_esami e2 WHERE studente = $1 AND e2.cdl = e.cdl AND e2.insegnamento = e.insegnamento) and e.voto >= 18";


        $params = array(
            $matricola
        );


        $result = pg_prepare($db, "storico_parziale", $sql);
        $result = pg_execute($db, "storico_parziale", $params);



        $storico_parziali= array();

        $cont = 0;
        if ($result)
        {
            while($row = pg_fetch_assoc($result)){

                $insegnamento= $row['insegnamento'];
                $nome_insegnamento= $row['nome'];
                $cdl = $row['cdl'];
                $data = $row['data_superamento'];
                $voto = $row['voto'];
                $lode = $row['lode'];
                $cont++;

                $storico_parziali[$cont] = array($insegnamento, $nome_insegnamento, $cdl, $data, $voto, $lode);
            }
        }
        return $storico_parziali;
    }
    
    function get_docenti() {
        $db = open_pg_segreteria_connection();

        $sql = "SELECT id, nome, cognome FROM unidb.docente ORDER BY id";

        $result = pg_prepare($db, "docenti", $sql);
        $result = pg_execute($db, "docenti", array());

        $lista_docenti = array();


        $cont = 0;
        if ($result)
        {
            while($row = pg_fetch_assoc($result)){

                $id = $row['id'];
                $nome = $row['nome'];
                $cognome = $row['cognome'];
                $cont++;

                $lista_docenti[$cont] = array($id, $nome, $cognome);
            }
        }
        return $lista_docenti;
    }

    function get_corsi_responsabile($id) {
        $db = open_pg_segreteria_connection();

        $sql = "SELECT insegnamento.codice, insegnamento.nome, insegnamento.cdl, cdl.nome as nome_cdl, anno FROM unidb.insegnamento inner join unidb.cdl on insegnamento.cdl = cdl.codice WHERE insegnamento.docente = $1";

        $params = array(
            $id
        );


        $result = pg_prepare($db, "responsabile", $sql);
        $result = pg_execute($db, "responsabile", $params);

        $lista_corsi = array();


        $cont = 0;
        if ($result)
        {
            while($row = pg_fetch_assoc($result)){

                $codice = $row['codice'];
                $nome_insegnamento = $row['nome'];
                $codice_cdl = $row['cdl'];
                $nome_cdl = $row['nome_cdl'];
                $anno = $row['anno'];
                $cont++;

                $lista_corsi[$cont] = array($codice, $nome_insegnamento, $codice_cdl, $nome_cdl, $anno);
            }
        }
        return $lista_corsi;
    }

    function elimina_studente($matricola) {
        $db = open_pg_segreteria_connection();

        $sql = "DELETE FROM unidb.studente WHERE studente.matricola = $1";

        $params = array(
            $matricola
        );


        $result = pg_prepare($db, "elimina_studente", $sql);
        $result = pg_execute($db, "elimina_studente", $params);

        if ($result) {
            $msg = 'Eliminazione andata a buon fine';
        } else {
            $msg = pg_last_error($db);
        }
        return $msg;
    }

    function elimina_docente($id) {
        $db = open_pg_segreteria_connection();

        $sql = "DELETE FROM unidb.docente WHERE docente.id = $1";

        $params = array(
            $id
        );


        $result = pg_prepare($db, "elimina_docente", $sql);
        $result = pg_execute($db, "elimina_docente", $params);

        if ($result) {
            $msg = 'Eliminazione andata a buon fine';
        } else {
            $msg = pg_last_error($db);
        }
        return $msg;
    }


    function get_cdl_segreteria() {
        $db = open_pg_segreteria_connection();

        $sql = "SELECT codice, nome, tipologia FROM unidb.cdl";

        $result = pg_prepare($db, "cdl_info_segreteria", $sql);
        $result = pg_execute($db, "cdl_info_segreteria", array());

        $lista_cdl = array();

        $cont = 0;
        if ($result)
        {
            while($row = pg_fetch_assoc($result)){
                ;
                $codice = $row['codice'];
                $nome= $row['nome'];
                $tipologia = $row['tipologia'];
                if ($tipologia == 'T') {
                    $tipologia = 'Triennale';
                } else {
                    $tipologia = 'Magistrale';
                }
                $cont++;

                $lista_cdl[$cont] = array($codice, $nome, $tipologia);
            }
        }
        return $lista_cdl;
    }

    function get_insegnamenti_cdl_segreteria($codice_cdl) {
        $db = open_pg_segreteria_connection();

        $sql = "SELECT codice, nome, anno, nome_docente, cognome_docente, descrizione FROM unidb.info_cdl WHERE codice_cdl = $1";

        $params = array(
            $codice_cdl
        );


        $result = pg_prepare($db, "cdl_info_segreteria", $sql);
        $result = pg_execute($db, "cdl_info_segreteria", $params);

        $lista_insegnamenti = array();

        $cont = 0;
        if ($result)
        {
            while($row = pg_fetch_assoc($result)){
                
                $codice = $row['codice'];
                $nome= $row['nome'];
                $anno = $row['anno'];
                $nome_docente = $row['nome_docente'].' '.$row['cognome_docente'];
                $descrizione = $row['descrizione'];
                $cont++;

                $lista_insegnamenti[$cont] = array($codice, $nome, $anno, $nome_docente, $descrizione);
            }
        }
        return $lista_insegnamenti;
    }

    function elimina_insegnamento($cod_insegnamento, $cod_cdl) {
        $db = open_pg_segreteria_connection();

        $sql = "DELETE FROM unidb.insegnamento WHERE insegnamento.codice = $1 and insegnamento.cdl = $2";

        $params = array(
            $cod_insegnamento,
            $cod_cdl
        );


        $result = pg_prepare($db, "elimina_insegnamento", $sql);
        $result = pg_execute($db, "elimina_insegnamento", $params);

        if ($result) {
            $msg = 'Eliminazione andata a buon fine';
        } else {
            $msg = pg_last_error($db);
        }
        return $msg;
    }

    function elimina_cdl($cod_cdl) {
        $db = open_pg_segreteria_connection();

        $sql = "DELETE FROM unidb.cdl WHERE cdl.codice = $1";

        $params = array(
            $cod_cdl
        );


        $result = pg_prepare($db, "elimina_cdl", $sql);
        $result = pg_execute($db, "elimina_cdl", $params);

        if ($result) {
            $msg = 'Eliminazione andata a buon fine';
        } else {
            $msg = pg_last_error($db);
        }
        return $msg;
    }

    function get_iscritti_cdl($cod_cdl) {
        $db = open_pg_segreteria_connection();

        $sql = "SELECT matricola, nome, cognome FROM unidb.studente WHERE studente.cdl = $1";

        $params = array(
            $cod_cdl
        );


        $result = pg_prepare($db, "iscritti_cdl", $sql);
        $result = pg_execute($db, "iscritti_cdl", $params);

        $lista_studenti = array();

        $cont = 0;
        if ($result)
        {
            while($row = pg_fetch_assoc($result)){
                
                $matricola = $row['matricola'];
                $nome= $row['nome'];
                $cognome = $row['cognome'];
                $cont++;

                $lista_studenti[$cont] = array($matricola, $nome, $cognome);
            }
        }
        return $lista_studenti;
    }

    function get_appelli_docente($id_docente) {
        $db = open_pg_docenti_connection();

        $sql = "SELECT appello.data, appello.insegnamento, insegnamento.nome, appello.cdl FROM unidb.appello inner join unidb.insegnamento on appello.insegnamento = insegnamento.codice and appello.cdl = insegnamento.cdl WHERE insegnamento.docente = $1 and appello.data > CURRENT_DATE";
        
        $params = array(
            $id_docente
        );


        $result = pg_prepare($db, "appelli_docente", $sql);
        $result = pg_execute($db, "appelli_docente", $params);

        $lista_appelli = array();
        $cont = 0;

        if ($result)
        {
            while($row = pg_fetch_assoc($result)){

                $data = $row['data'];
                $insegnamento= $row['insegnamento'];
                $nome = $row['nome'];
                $cdl = $row['cdl'];
                $cont++;

                $lista_appelli[$cont] = array($data, $insegnamento, $nome, $cdl);
            }
        } 

        return $lista_appelli;

    }

    function elimina_appello($data, $cod_insegnamento, $cod_cdl) {
        $db = open_pg_docenti_connection();

        $sql = "DELETE FROM unidb.appello WHERE appello.data = $1 and appello.insegnamento = $2 and appello.cdl = $3";
        
        $params = array(
            $data,
            $cod_insegnamento,
            $cod_cdl
        );


        $result = pg_prepare($db, "elimina_appello", $sql);
        $result = pg_execute($db, "elimina_appello", $params);
        
        if ($result) {
            $msg = 'Eliminazione andata a buon fine';
        } else {
            $msg = pg_last_error($db);
        }
        return $msg;

    }

?>
--
-- Name: unidb; Type: SCHEMA; Schema: -;
--

CREATE SCHEMA unidb;


--
-- Name: tipologie_cdl; Type: DOMAIN; Schema: unidb;
--

CREATE DOMAIN unidb.tipologie_cdl AS varchar(1) 
	CONSTRAINT tipo_cdl_check CHECK(VALUE IN ('T', 'M'));


--SET default_tablespace = '';


--
-- Name: segreteria; Type: TABLE; Schema: unidb;
--

CREATE TABLE unidb.segreteria (
    username varchar(50) NOT NULL,
    password varchar(100) NOT NULL
);

--
-- Name: docente; Type: TABLE; Schema: unidb;
--

CREATE TABLE unidb.docente (
	id varchar(10) NOT NULL UNIQUE,
	nome varchar(50) NOT NULL,
	cognome varchar(50) NOT NULL,
    username varchar(50) NOT NULL ,
    password varchar(100) NOT NULL
);

--
-- Name: insegnamento; Type: TABLE; Schema: unidb;
--

CREATE TABLE unidb.insegnamento (
    codice varchar(10) NOT NULL,
    cdl varchar(10) NOT NULL,
    nome varchar(100) NOT NULL,
    anno integer NOT NULL,
    docente varchar(10),
    descrizione text
);


--
-- Name: appello; Type: TABLE; Schema: unidb;
--

CREATE TABLE unidb.appello (
    "data" date NOT NULL,
    insegnamento varchar(10) NOT NULL,
    cdl varchar(10) NOT NULL
);

--
-- Name: cdl; Type: TABLE; Schema: unidb;
--

CREATE TABLE unidb.cdl (
	codice varchar(10) NOT NULL,
    nome varchar(50) NOT NULL,
    tipologia unidb.tipologie_cdl NOT NULL,
    UNIQUE(nome, tipologia)
);

--
-- Name: studente; Type: TABLE; Schema: unidb;
--

CREATE TABLE unidb.studente (
    matricola varchar(10) NOT NULL UNIQUE,
    nome varchar(50) NOT NULL,
    cognome varchar(50) NOT NULL,
    cdl varchar(10) NOT null,
    username varchar(50) NOT NULL ,
    password varchar(100) NOT NULL
);

--
-- Name: esame; Type: TABLE; Schema. unidb;
--

CREATE TABLE unidb.esame (
    studente varchar(10) NOT NULL,
    insegnamento varchar(10) NOT NULL,
    cdl varchar(10) NOT NULL,
    data_superamento date NOT NULL,
    voto integer NOT NULL,
    lode boolean NOT NULL
);


--
-- Name: propedeuticità; Type: TABLE; Schema. unidb;
--

CREATE TABLE unidb.propedeuticità (
	insegnamento varchar(10) NOT NULL,
	cdl varchar(10) NOT NULL,
	propedeuticità varchar(10) NOT NULL,
	cdl_propedeuticità varchar(10) NOT NULL
);


--
-- Name: iscrizione; Type: TABLE; Schema: unidb;
--

CREATE TABLE unidb.iscrizione (
    studente varchar(10) NOT NULL,
    data_appello date NOT NULL,
    insegnamento varchar(10) NOT NULL,
    cdl varchar(10) NOT NULL
    -- is_iscritto boolean -> non penso serva perchè in questa relazione ci saranno le iscrizioni e basta non anche gli studenti
    -- non iscritti
);

--
-- Name: storico_studenti; Type: TABLE; Schema: unidb;
--

CREATE TABLE unidb.storico_studenti (
    studente varchar(10) NOT NULL,
    nome varchar(50) NOT NULL,
    cognome varchar(50) NOT NULL,
    cdl varchar(10) NOT null,
    data_fine_percorso date NOT NULL
);


--
-- Name: storico_esami; Type: TABLE; Schema: unidb;
--

create table unidb.storico_esami (
	studente varchar(10) NOT NULL,
	insegnamento varchar(10) NOT NULL,
    cdl varchar(10) NOT NULL,
    data_superamento date NOT NULL,
    voto integer NOT NULL,
    lode boolean NOT NULL
);



--
-- Name: segreteria segreteria_pkey; Type: CONSTRAINT; Schema: unidb;
--

ALTER TABLE ONLY unidb.segreteria
	ADD CONSTRAINT segreteria_pkey PRIMARY KEY (username);


--
-- Name: docente docente_pkey; Type: CONSTRAINT; Schema: unidb;
--

ALTER TABLE ONLY unidb.docente
    ADD CONSTRAINT docente_pkey PRIMARY KEY(username);


--
-- Name: cdl cdl_pkey; Type: CONSTRAINT; Schema: unidb;
--
   
ALTER TABLE ONLY unidb.cdl
    ADD CONSTRAINT cdl_pkey PRIMARY KEY (codice);

   
--
-- Name: studente studente_pkey; Type: CONSTRAINT; Schema: unidb;
--
 
ALTER TABLE ONLY unidb.studente
    ADD CONSTRAINT studente_pkey PRIMARY KEY (username);   
   
   
--
-- Name: insegnamento insegnamento_pkey; Type: CONSTRAINT; Schema: unidb;
--
   
ALTER TABLE ONLY unidb.insegnamento
    ADD CONSTRAINT insegnamento_pkey PRIMARY KEY (codice, cdl);

   
--
-- Name: appello appello_pkey; Type: CONSTRAINT; Schema: unidb;
--
ALTER TABLE ONLY unidb.appello
    ADD CONSTRAINT appello_pkey PRIMARY KEY ("data", insegnamento, cdl);
   
--
-- Name: esame esame_pkey; Type: CONSTRAINT; Schema: unidb;
--
   
ALTER TABLE ONLY unidb.esame
    ADD CONSTRAINT esame_pkey PRIMARY KEY (studente, insegnamento, cdl, data_superamento);

   
--
-- Name: storico_studenti storico_studenti_pkey; Type: CONSTRAINT; Schema: unidb;
--
   
ALTER TABLE ONLY unidb.storico_studenti
    ADD CONSTRAINT storico_studenti_pkey PRIMARY KEY (studente);
   
   
--
-- Name: iscrizione iscrizione_pkey; Type: CONSTRAINT; Schema: unidb;
--   
   
ALTER TABLE ONLY unidb.iscrizione
    ADD CONSTRAINT iscrizione_pkey PRIMARY KEY (studente, data_appello, insegnamento, cdl);  
   
   
--
-- Name: storico_esami storico_esami_pkey; Type: CONSTRAINT; Schema: unidb;
--    
   
ALTER TABLE ONLY unidb.storico_esami
	ADD CONSTRAINT storico_esami_pkey PRIMARY KEY (studente, insegnamento, cdl, data_superamento);


--
-- Name: propedeuticità propedeuticità_pkey; Type: CONSTRAINT; Schema: unidb;
-- 

ALTER TABLE ONLY unidb.propedeuticità
	ADD CONSTRAINT propedeuticità_pkey PRIMARY KEY (insegnamento, cdl, propedeuticità, cdl_propedeuticità);


--
-- Name: insegnamento insegnamento_cdl_fk; Type: FK CONSTRAINT; Schema: unidb;
--     
   

ALTER TABLE ONLY unidb.insegnamento
    ADD CONSTRAINT insegnamento_cdl_fk FOREIGN KEY (cdl) references unidb.cdl(codice) ON UPDATE CASCADE ON DELETE CASCADE;
   
   
--
-- Name: insegnamento insegnamento_id_docente_fk; Type: FK CONSTRAINT; Schema: unidb;
-- 
 
ALTER TABLE ONLY unidb.insegnamento
    ADD CONSTRAINT insegnamento_id_docente_fk FOREIGN KEY (docente) REFERENCES unidb.docente(id) ON UPDATE CASCADE ON DELETE CASCADE; 
   
   
   
--
-- Name: appello appello_codice_insegnamento_fk; Type: FK CONSTRAINT; Schema: unidb;
-- 
   
ALTER TABLE ONLY unidb.appello
    ADD CONSTRAINT appello_codice_insegnamento_cdl_fk FOREIGN KEY (insegnamento, cdl) REFERENCES unidb.insegnamento(codice, cdl) ON UPDATE CASCADE ON DELETE CASCADE;
   

--
-- Name: studente studente_codice_cdl_fk; Type: FK CONSTRAINT; Schema: unidb;
-- 
   
ALTER TABLE ONLY unidb.studente
    ADD CONSTRAINT studente_codice_cdl_fk FOREIGN KEY (cdl) REFERENCES unidb.cdl(codice) ON UPDATE CASCADE ON DELETE CASCADE;
   

--
-- Name: esame esame_matricola_studente_fk; Type: FK CONSTRAINT; Schema: unidb;
-- 
ALTER TABLE ONLY unidb.esame
    ADD CONSTRAINT esame_matricola_studente_fk FOREIGN KEY (studente) REFERENCES unidb.studente(matricola) ON UPDATE CASCADE ON DELETE CASCADE;  
   

--
-- Name: esame esame_codice_insegnamento_fk; Type: FK CONSTRAINT; Schema: unidb;
-- 
   
ALTER TABLE ONLY unidb.esame
    ADD CONSTRAINT esame_codice_insegnamento_cdl_fk FOREIGN KEY (insegnamento, cdl) REFERENCES unidb.insegnamento(codice, cdl) ON UPDATE CASCADE ON DELETE CASCADE;
   

--
-- Name: iscrizione iscrizione_matricola_studente_fk; Type: FK CONSTRAINT; Schema: unidb;
--  
   
ALTER TABLE ONLY unidb.iscrizione
    ADD CONSTRAINT iscrizione_matricola_studente_fk FOREIGN KEY (studente) REFERENCES unidb.studente(matricola) ON UPDATE CASCADE ON DELETE CASCADE;
   
--
-- Name: iscrizione iscrizione_data_appello_fk; Type: FK CONSTRAINT; Schema: unidb;
--  
   
ALTER TABLE ONLY unidb.iscrizione
    ADD CONSTRAINT iscrizione_data_appello_insegnamento_cdl_fk FOREIGN KEY (data_appello, insegnamento, cdl) REFERENCES unidb.appello("data", insegnamento, cdl) ON UPDATE CASCADE ON DELETE CASCADE;

   
--
-- Name: propedeuticità insegnamento_cdl_fk; Type: FK CONSTRAINT; Schema: unidb;
--  
   
   
ALTER TABLE ONLY unidb.propedeuticità
    ADD CONSTRAINT insegnamento_cdl_fk FOREIGN KEY (insegnamento, cdl) REFERENCES unidb.insegnamento(codice, cdl) ON UPDATE CASCADE ON DELETE CASCADE;
   


--
-- Name: propedeuticità propedeuticità_insegnamento_cdl_fk; Type: FK CONSTRAINT; Schema: unidb;
--  
ALTER TABLE ONLY unidb.propedeuticità
    ADD CONSTRAINT propedeuticità_insegnamento_cdl_fk FOREIGN KEY (propedeuticità, cdl_propedeuticità) REFERENCES unidb.insegnamento(codice, cdl) ON UPDATE CASCADE ON DELETE CASCADE;
   
   
   

--
-- Name: insegnamento check_anno_insegnamento; Type: CONSTRAINT; Schema: unidb;
--
ALTER TABLE ONLY unidb.insegnamento
ADD CONSTRAINT check_anno_insegnamento CHECK (anno >= 1 and anno <= 3); 


--
-- Name: esame chk_voto_esame; Type: CONSTRAINT; Schema: unidb;
--
ALTER TABLE ONLY unidb.esame
ADD CONSTRAINT chk_voto_esame CHECK (voto >= 0 and voto <= 30);
   
 
insert into unidb.segreteria values ('s1@me.it', '123');
insert into unidb.segreteria values ('s2@me.it', 'abc');
insert into unidb.docente values ('001', 'Stefano', 'Lavori', 'sl@uni.it', 'ac');
insert into unidb.docente values ('002', 'Giorgio', 'Baci', 'gb@uni.it', 'cc');
insert into unidb.docente values ('003', 'Renato', 'Lettiere', 'rl@uni.it', 'ap');
insert into unidb.docente values ('004', 'Alice', 'Cremonesi', 'ac@me.it', 'ag');
insert into unidb.cdl values ('001', 'informatica', 'T');
insert into unidb.cdl values ('002', 'matematica', 'T');
insert into unidb.cdl values ('003', 'geologia', 'T');
insert into unidb.cdl values ('004', 'finanza', 'M');
insert into unidb.cdl values ('005', 'fisica', 'T');
insert into unidb.cdl values ('006', 'test', 'T');
insert into unidb.insegnamento values ('001', '006', 'test_insegnamento', 1, '001', null);
insert into unidb.studente values ('0001', 'Sasha', 'Petko', '001', 'sp@me.it', 'sp');
insert into unidb.studente values ('0002', 'Elon', 'Musk', '002', 'em@me.it', 'em');
insert into unidb.studente values ('0003', 'Bill', 'Gates', '004', 'bg@me.it', 'bg');
insert into unidb.insegnamento values ('001', '001', 'matematica del continuo', 1, '002', null);
insert into unidb.insegnamento values ('002', '001', 'programmazione 1', 1, '001', null);
insert into unidb.insegnamento values ('003', '001', 'algoritmi e strutture dati', 2, '003', null);
insert into unidb.insegnamento values ('001', '004', 'statistica', 2, '002', null);
insert into unidb.insegnamento values ('002', '004', 'econometria', 1, '004', null);
insert into unidb.esame values ('0001', '001', '001', '2022-01-25', 24, 'n');
insert into unidb.esame values ('0003', '001', '001', '2022-01-25', 29, 'n');
insert into unidb.esame values ('0003', '002', '001', '2022-01-25', 27, 'n');
insert into unidb.appello values ('2023-06-15', '002', '001');
insert into unidb.appello values ('2023-04-27', '002', '004');
insert into unidb.propedeuticità values ('003', '001', '002', '001');
insert into unidb.propedeuticità values ('003', '001', '001', '001');

   
   
   
-- trigger per il controllo della lode se il voto non è pari a 30
create or replace function unidb.check_assegnamento_lode() returns
        trigger as $$
declare
valore_voto unidb.esame.voto%TYPE := new.voto;
begin

if valore_voto <> 30 and new.lode = true then
raise exception 'Non può essere aggiunta la lode se il voto non è pari a 30';
return null;
else
return new;
end if;
end;
$$ language 'plpgsql';


create or replace trigger voto_lode_trigger
before insert or update on unidb.esame
for each row
execute function unidb.check_assegnamento_lode();
   
   
   

-- trigger per il controllo sull'inserimento di appelli in giorni precedenti a quello corrente
create or replace function unidb.check_appello_data_corrente() returns
	trigger as $$
declare
data_appello date := new."data";
begin
	
if CURRENT_DATE > data_appello then
raise exception 'Non è possibile aggiungere appelli con data precedente a quella corrente';
return null;
else
return new;
end if;
end;
$$ language 'plpgsql';


create or replace trigger appello_data_corrente_trigger
before insert or update on unidb.appello
for each row
execute function unidb.check_appello_data_corrente();
 

  

-- trigger per il controllo sull'inserimento di un esame in giorni successivi a quello corrente
create or replace function unidb.check_esame_data_futura() returns
	trigger as $$
declare
valore_data unidb.esame.data_superamento%type := new.data_superamento;
begin
	
if CURRENT_DATE < valore_data then
raise exception 'Non è possibile registrare esami con data di superamento successiva a quella corrente';
return null;
else
return new;
end if;
end;
$$ language 'plpgsql';

create or replace trigger esame_data_superamento_trigger
before insert or update on unidb.esame
for each row
execute function unidb.check_esame_data_futura();


-- trigger per storico studenti per tenere traccia degli studenti eliminati
create or replace function unidb.mantieni_studenti_eliminati() returns 
	trigger as $$
begin
	insert into unidb.storico_studenti values(old.matricola,old.nome,old.cognome,old.cdl,CURRENT_DATE);
	insert into unidb.storico_esami
		select * from unidb.esame where esame.studente = old.matricola;
return old;
	
end;
$$ language 'plpgsql';

create or replace trigger studenti_eliminati_trigger 
before delete on unidb.studente
for each row execute function unidb.mantieni_studenti_eliminati();


-- trigger per controllare che un esame può essere aggiunto solo se lo studente era iscritto all'appello
create or replace function unidb.check_iscrizione() returns
	trigger as $$
declare
giorno_appello date := new.data_superamento;
matricola_studente unidb.studente.matricola%type := new.studente;
begin 
	perform *
	from unidb.iscrizione
	where iscrizione.studente = matricola_studente and data_appello = giorno_appello;
if not found then
raise exception 'Lo studente non era iscritto al corrispondente appello';
return null;
else
return new;
end if;
end;
$$ language 'plpgsql';

create or replace trigger aggiunta_esame_trigger
before insert or update on unidb.esame
for each row execute function unidb.check_iscrizione();


-- trigger per controllare se un corso magistrale ha insegnamenti nel giusto range di anni
create or replace function unidb.check_tipologia_anno() returns 
	trigger as $$
declare
tipologia_corso unidb.cdl.tipologia%type;
begin 
	select tipologia into tipologia_corso
	from unidb.cdl
	where cdl.codice = new.cdl;
if tipologia_corso = 'M' and new.anno = 3 then 
raise exception 'Impossibile aggiungere questo insegnamento perchè appartiene ad un corso magistrale';
return null;
else
return new;
end if;
end;
$$ language 'plpgsql';

create or replace trigger tipologia_anno_trigger
before insert or update on unidb.insegnamento
for each row execute function unidb.check_tipologia_anno();


-- trigger per il controllo dell'isrizione a esami con propedeuticità
create or replace function unidb.check_propedeuticità() returns 
	trigger as $$
declare
f record;
begin
	for f in select propedeuticità, cdl_propedeuticità from unidb.propedeuticità 
	where propedeuticità.insegnamento = new.insegnamento and propedeuticità.cdl = new.cdl
	loop 
	perform *
	from unidb.esame
	where esame.data_superamento = 
	(select max(data_superamento) from unidb.esame where esame.studente = new.studente and esame.insegnamento = f.propedeuticità and esame.cdl = f.cdl_propedeuticità)
	and esame.voto >= 18;

	if not found then
	raise exception 'Propedeuticità non superate';
	return null;
	end if;
	end loop;
	return new;
end;
$$ language 'plpgsql';


create or replace trigger propedeuticità_trigger
before insert or update on unidb.iscrizione
for each row execute function unidb.check_propedeuticità();


-- trigger per il conteggio dei responsabili del corso 
create or replace function unidb.check_responsabile() returns 
	trigger as $$
declare 
num_responsabile integer;
begin 
	select count(codice) into num_responsabile
	from unidb.insegnamento
	where insegnamento.docente = new.docente;
	if num_responsabile = 3 then
	raise exception 'Non è possibile aggiungere questo responsabile perchè è già responsabile di 3 insegnamenti';
	return null;
	else
	return new;
	end if;
end;
$$ language 'plpgsql';
	
	
create or replace trigger responsabile_trigger
before insert or update on unidb.insegnamento
for each row execute function unidb.check_responsabile();

	

-- trigger per il controllo della matricola dello studente da aggiungere
create or replace function unidb.check_matricole_studenti() returns trigger
as $$
declare 
num integer := 0;
begin 
 SELECT count(*) INTO num FROM unidb.storico_studenti where studente = new.matricola;
 IF num > 0 then
 raise exception 'Non è possibile usare matricole usate in passato';
 return null;
 end if;
 return new;
end;
$$ language 'plpgsql';

create or replace trigger matricola_passata_studente_trigger
before insert or update on unidb.studente
for each row execute function unidb.check_matricole_studenti();



-- trigger appelli nello stesso giorno
create or replace function unidb.check_appelli_stesso_giorno() returns trigger
as $$
declare 
num integer := 0;
begin 
 select count(*) into num
 from unidb.appello inner join unidb.insegnamento on appello.insegnamento = insegnamento.codice
 where appello."data" = new."data" and appello.cdl = new.cdl and insegnamento.anno = (select anno from unidb.insegnamento where insegnamento.codice = new.insegnamento and insegnamento.cdl = new.cdl);
 if num != 0 then
 raise exception 'Appello di un insegnamento dello stesso cdl e dello stesso anno già presente in questa data';
 return null;
else
return new;
 end if;
end;
$$ language 'plpgsql';

create or replace trigger appelli_insegnamenti_stesso_giorno_trigger
before insert or update on unidb.appello
for each row execute function unidb.check_appelli_stesso_giorno();


create or replace view unidb.iscrizione_esami_studenti as
select iscrizione.studente, iscrizione.data_appello, iscrizione.insegnamento, insegnamento.nome
from unidb.iscrizione inner join unidb.insegnamento on iscrizione.insegnamento = insegnamento.codice and iscrizione.cdl = insegnamento.cdl
where (DATE(iscrizione.data_appello) > CURRENT_DATE);



-- vista per avere un'anagrafica completa dei corsi di laurea con i loro insegnamenti
create or replace view unidb.info_cdl as
select cdl.codice as codice_cdl, cdl.nome as nome_cdl, cdl.tipologia, insegnamento.codice, insegnamento.nome, insegnamento.anno, docente.nome as nome_docente, docente.cognome as cognome_docente, insegnamento.descrizione
from unidb.cdl inner join unidb.insegnamento on cdl.codice = insegnamento.cdl inner join unidb.docente on insegnamento.docente = docente.id;



create or replace view unidb.appelli_nome as
select "data" as data_appello, insegnamento, nome, appello.cdl as codice_cdl
from unidb.appello inner join unidb.insegnamento on appello.insegnamento = insegnamento.codice and appello.cdl = insegnamento.cdl
where appello."data" >= CURRENT_DATE;


create user segreteria with password '1234';
grant connect on database unidb_cs to segreteria;
grant usage on schema unidb to segreteria;
GRANT SELECT, INSERT, UPDATE, DELETE ON unidb.studente TO segreteria;
GRANT SELECT, INSERT, UPDATE, DELETE ON unidb.docente TO segreteria;
GRANT SELECT, INSERT, UPDATE, DELETE ON unidb.cdl TO segreteria;
GRANT SELECT, INSERT, UPDATE, DELETE ON unidb.segreteria TO segreteria;
GRANT SELECT, INSERT, UPDATE, DELETE ON unidb.insegnamento TO segreteria;
GRANT SELECT, INSERT, UPDATE, DELETE ON unidb.propedeuticità TO segreteria;
GRANT SELECT, INSERT ON unidb.storico_studenti TO segreteria;
GRANT SELECT, INSERT ON unidb.storico_esami TO segreteria;
GRANT SELECT ON unidb.info_cdl TO segreteria;



create user docente with password '12345';
grant connect on database unidb_cs to docente;
grant usage on schema unidb to docente;
GRANT SELECT, INSERT, UPDATE, DELETE ON unidb.docente TO docente;
GRANT SELECT, INSERT, UPDATE, DELETE ON unidb.esame TO docente;
GRANT SELECT, INSERT, UPDATE, DELETE ON unidb.appello TO docente;
GRANT SELECT ON unidb.insegnamento TO docente;
GRANT SELECT ON unidb.iscrizione TO docente;
GRANT SELECT ON unidb.propedeuticità TO docente;



create user studente with password '123456';
grant connect on database unidb_cs to studente;
grant usage on schema unidb to studente;
GRANT SELECT, INSERT, UPDATE, DELETE ON unidb.studente TO studente;
GRANT SELECT, INSERT, DELETE ON unidb.iscrizione TO studente;
GRANT SELECT ON unidb.esame TO studente;
GRANT SELECT ON unidb.appello TO studente;
GRANT SELECT ON unidb.insegnamento TO studente;
GRANT SELECT ON unidb.cdl TO studente;
GRANT SELECT ON unidb.propedeuticità TO studente;
GRANT SELECT ON unidb.storico_studenti TO studente;
GRANT SELECT ON unidb.appelli_nome TO studente;
GRANT SELECT ON unidb.info_cdl TO studente;
GRANT SELECT ON unidb.iscrizione_esami_studenti TO studente;
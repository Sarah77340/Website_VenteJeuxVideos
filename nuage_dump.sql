--
-- PostgreSQL database dump
--

-- Dumped from database version 9.5.19
-- Dumped by pg_dump version 11.7 (Debian 11.7-0+deb10u1)

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- Name: acheter; Type: TABLE; Schema: public; Owner: dilien.oeuvrard
--

CREATE TABLE public.acheter (
    pseudo character varying(50) NOT NULL,
    titre character varying(50) NOT NULL,
    note integer,
    commentaire character varying(1000),
    date_achat date
);


ALTER TABLE public.acheter OWNER TO "dilien.oeuvrard";

--
-- Name: ami; Type: TABLE; Schema: public; Owner: dilien.oeuvrard
--

CREATE TABLE public.ami (
    pseudo1 character varying(50) NOT NULL,
    pseudo2 character varying(50) NOT NULL
);


ALTER TABLE public.ami OWNER TO "dilien.oeuvrard";

--
-- Name: appartient; Type: TABLE; Schema: public; Owner: dilien.oeuvrard
--

CREATE TABLE public.appartient (
    titre character varying(50) NOT NULL,
    type_jeux character varying(50) NOT NULL
);


ALTER TABLE public.appartient OWNER TO "dilien.oeuvrard";

--
-- Name: atteindre; Type: TABLE; Schema: public; Owner: dilien.oeuvrard
--

CREATE TABLE public.atteindre (
    code character(6) NOT NULL,
    pseudo character varying(50) NOT NULL,
    d_atteint date
);


ALTER TABLE public.atteindre OWNER TO "dilien.oeuvrard";

--
-- Name: jeux; Type: TABLE; Schema: public; Owner: dilien.oeuvrard
--

CREATE TABLE public.jeux (
    titre character varying(50) NOT NULL,
    prix double precision,
    desc_jeux character varying(5000),
    d_sortie date,
    age_req integer,
    nom_dev character varying(50) NOT NULL,
    nom_edit character varying(50) NOT NULL
);


ALTER TABLE public.jeux OWNER TO "dilien.oeuvrard";

--
-- Name: chiffre_affaire; Type: VIEW; Schema: public; Owner: dilien.oeuvrard
--

CREATE VIEW public.chiffre_affaire AS
 SELECT jeux.nom_edit,
    sum(jeux.prix) AS sum
   FROM (public.acheter
     JOIN public.jeux USING (titre))
  GROUP BY jeux.nom_edit;


ALTER TABLE public.chiffre_affaire OWNER TO "dilien.oeuvrard";

--
-- Name: entreprise; Type: TABLE; Schema: public; Owner: dilien.oeuvrard
--

CREATE TABLE public.entreprise (
    nom character varying(50) NOT NULL,
    pays character varying(50)
);


ALTER TABLE public.entreprise OWNER TO "dilien.oeuvrard";

--
-- Name: genre; Type: TABLE; Schema: public; Owner: dilien.oeuvrard
--

CREATE TABLE public.genre (
    type_jeux character varying(50) NOT NULL
);


ALTER TABLE public.genre OWNER TO "dilien.oeuvrard";

--
-- Name: joueur; Type: TABLE; Schema: public; Owner: dilien.oeuvrard
--

CREATE TABLE public.joueur (
    pseudo character varying(50) NOT NULL,
    mdp character varying(200) NOT NULL,
    nom character varying(50) NOT NULL,
    prenom character varying(50) NOT NULL,
    email character varying(150) NOT NULL,
    argent integer,
    d_nais date
);


ALTER TABLE public.joueur OWNER TO "dilien.oeuvrard";

--
-- Name: partager; Type: TABLE; Schema: public; Owner: dilien.oeuvrard
--

CREATE TABLE public.partager (
    pseudo character varying(50) NOT NULL,
    titre character varying(50) NOT NULL,
    pseudo_ami character varying(50)
);


ALTER TABLE public.partager OWNER TO "dilien.oeuvrard";

--
-- Name: nombre_prets; Type: VIEW; Schema: public; Owner: dilien.oeuvrard
--

CREATE VIEW public.nombre_prets AS
 SELECT jeux.nom_edit,
    count(jeux.nom_edit) AS count
   FROM (public.partager
     JOIN public.jeux USING (titre))
  GROUP BY jeux.nom_edit;


ALTER TABLE public.nombre_prets OWNER TO "dilien.oeuvrard";

--
-- Name: nombre_ventes; Type: VIEW; Schema: public; Owner: dilien.oeuvrard
--

CREATE VIEW public.nombre_ventes AS
 SELECT jeux.nom_edit,
    count(jeux.nom_edit) AS count
   FROM (public.acheter
     JOIN public.jeux USING (titre))
  GROUP BY jeux.nom_edit;


ALTER TABLE public.nombre_ventes OWNER TO "dilien.oeuvrard";

--
-- Name: notation_moyenne; Type: VIEW; Schema: public; Owner: dilien.oeuvrard
--

CREATE VIEW public.notation_moyenne AS
 SELECT jeux.nom_edit,
    avg(acheter.note) AS avg
   FROM (public.acheter
     JOIN public.jeux USING (titre))
  GROUP BY jeux.nom_edit;


ALTER TABLE public.notation_moyenne OWNER TO "dilien.oeuvrard";

--
-- Name: succes; Type: TABLE; Schema: public; Owner: dilien.oeuvrard
--

CREATE TABLE public.succes (
    code character(6) NOT NULL,
    intitule character varying(100),
    texte character varying(2000),
    titre character varying(50) NOT NULL
);


ALTER TABLE public.succes OWNER TO "dilien.oeuvrard";

--
-- Name: total_succes; Type: VIEW; Schema: public; Owner: dilien.oeuvrard
--

CREATE VIEW public.total_succes AS
 SELECT jeux.nom_edit,
    succes.titre,
    count(*) AS count
   FROM (public.succes
     JOIN public.jeux USING (titre))
  GROUP BY jeux.nom_edit, succes.titre;


ALTER TABLE public.total_succes OWNER TO "dilien.oeuvrard";

--
-- Data for Name: acheter; Type: TABLE DATA; Schema: public; Owner: dilien.oeuvrard
--

COPY public.acheter (pseudo, titre, note, commentaire, date_achat) FROM stdin;
Dareb	League of legends	18	Jeu cool, mais un conseil, pour être le meilleur il ne faut pas se laver.	2021-12-19
Dareb	Minecraft	14	Un jeu de cube coollll	2021-12-19
Dareb	Warface	12	Bizarre Bizarre	2021-12-19
Michou	Among us	19	bon jeu pour jouer entre amis	2021-12-19
Michou	Apex legends	14	Comme fortnite mais sans les constructions... 	2021-12-19
Michou	Minecraft	20	Le jeu de mon enfance !!! 	2021-12-19
Michou	Valorant	17	AHHHH ce jeu est trop addictif	2021-12-19
Dilien	Among us	14	Moyen, les serveurs bugent tout le temps	2021-12-19
Dilien	Minecraft	16	SUPPERR jeu avec de SUBERRR SERVEURS	2021-12-19
Dilien	Pubg	19	Battle Royal originel comme le titan	2021-12-19
Dilien	Warface	11	Moyen	2021-12-19
Sarah	Minecraft	\N	\N	2021-12-19
\.


--
-- Data for Name: ami; Type: TABLE DATA; Schema: public; Owner: dilien.oeuvrard
--

COPY public.ami (pseudo1, pseudo2) FROM stdin;
Dilien	Sarah
Sarah	Dilien
Dilien	Dareb
Dareb	Dilien
Dilien	Lucas
Lucas	Dilien
Lucas	Dareb
Dareb	Lucas
Lucas	Mickazboub
Mickazboub	Lucas
Michou	Sarah
Sarah	Michou
Michou	Dilien
Dilien	Michou
Michou	Dareb
Dareb	Michou
TEST	Dilien
Dilien	TEST
TEST	Sarah
Sarah	TEST
\.


--
-- Data for Name: appartient; Type: TABLE DATA; Schema: public; Owner: dilien.oeuvrard
--

COPY public.appartient (titre, type_jeux) FROM stdin;
Valorant	Tir
Warface	Tir
League of legends	Rpg
Call of duty warfare	Tir
Fortnite	Battleroyal
Apex legends	Battleroyal
Pubg	Battleroyal
\.


--
-- Data for Name: atteindre; Type: TABLE DATA; Schema: public; Owner: dilien.oeuvrard
--

COPY public.atteindre (code, pseudo, d_atteint) FROM stdin;
MINE01	Dilien	2021-05-12
\.


--
-- Data for Name: entreprise; Type: TABLE DATA; Schema: public; Owner: dilien.oeuvrard
--

COPY public.entreprise (nom, pays) FROM stdin;
Microsoft	Etats-Unis
Epic Games	Etats-Unis
Riot Games	Etats-Unis
Respawn Entertainment	Etats-Unis
Electronic Arts	Etats-Unis
InnerSloth	Etats-Unis
Blackwood Games	Ukraine
Crytek	Allemagne
Tencent games	Chine
Activision	Etats-Unis
\.


--
-- Data for Name: genre; Type: TABLE DATA; Schema: public; Owner: dilien.oeuvrard
--

COPY public.genre (type_jeux) FROM stdin;
Tir
Rpg
Ambiance
Battleroyal
\.


--
-- Data for Name: jeux; Type: TABLE DATA; Schema: public; Owner: dilien.oeuvrard
--

COPY public.jeux (titre, prix, desc_jeux, d_sortie, age_req, nom_dev, nom_edit) FROM stdin;
Minecraft	19.9899999999999984	Survie	2011-11-18	7	Microsoft	Microsoft
Valorant	0	Tir	2020-06-02	16	Riot Games	Riot Games
Warface	0	Tir	2013-11-21	16	Blackwood Games	Crytek
League of legends	0	Rpg	2009-10-27	3	Riot Games	Riot Games
Among us	3.99000000000000021	Ambiance	2018-06-15	9	InnerSloth	InnerSloth
Fortnite	0	Battleroyal	2017-07-21	12	Epic Games	Epic Games
Apex legends	0	Battleroyal	2019-02-04	16	Respawn Entertainment	Electronic Arts
Pubg	29.9899999999999984	Battleroyal	2016-07-30	18	Tencent games	Tencent games
Call of duty warfare	44.8999999999999986	Tir	2003-10-29	12	Activision	Activision
\.


--
-- Data for Name: joueur; Type: TABLE DATA; Schema: public; Owner: dilien.oeuvrard
--

COPY public.joueur (pseudo, mdp, nom, prenom, email, argent, d_nais) FROM stdin;
admin	8c6976e5b5410415bde908bd4dee15dfb167a9c873fc4bb8a81f6f2ab448a918	admin	admin	admin@admin.com	0	2021-12-17
Mickazboub	978767e50202fc8b4cfe773faa7950819c85092c7c5a3dddb603bd16cfe4f901	zboub	Micka	mickazboub@gmail.com	0	2013-06-17
Lucas	7cadab457ad8d811f134612436daaa5e5914b20dc2502865f714035b0f267680	Zaverio	Lucas	lulu.zaverio@gmail.com	300	2002-07-22
Mimola	a665a45920422f9d417e4867efdc4fb8a04a1f3fff1fa07e998e86f7f7a27ae3	Nguyen	Sarah	sarah@test.fr	200	2001-11-20
TEST	9f86d081884c7d659a2feaa0c55ad015a3bf4f1b2b0b822cd15d6c15b0f00a08	TEST1	TEST2	test@gmail.com	76	2002-06-23
SpiderMan	c9344c5f1079f7ce9b007e604829f7e8e4516e9132e098ebd58e2cc7f2a5fd4c	Man	Spider	spiderman@gmail.com	100	2021-12-15
Dareb	6bae7a4269f1985253115fba2265336cc31dfe7fd525d8f0e718a9b2d888be25	b	Dare	dareb@gmail.com	5	1991-11-07
Michou	7e98ee275aa8e04e2890cbe0523156c8512530b1afa1493dcc0a7eb302a5651f	ou	Mich	michou@gmail.com	756	1994-02-23
Dilien	37b1ed8e4e2e023ac6cd6d9b9c0da9821deb25a72626e0a222a57a3a16d53ab6	Oeuvrard	Dilien	dilienoeuvrard@gmail.com	212	2002-06-23
Sarah	d233633d9524e84c71d6fe45eb3836f8919148e4a5fc2234cc9e6494ec0f11c2	Nguyen	Sarah	sarahnguyen@gmail.tw	110	1680-07-11
\.


--
-- Data for Name: partager; Type: TABLE DATA; Schema: public; Owner: dilien.oeuvrard
--

COPY public.partager (pseudo, titre, pseudo_ami) FROM stdin;
Dareb	League of legends	Dilien
Dareb	Minecraft	Michou
Michou	Among us	Sarah
\.


--
-- Data for Name: succes; Type: TABLE DATA; Schema: public; Owner: dilien.oeuvrard
--

COPY public.succes (code, intitule, texte, titre) FROM stdin;
MINE01	Casser un bloc	Pour débloquer ce succès il vous suffit de casser un bloc.	Minecraft
MINE02	Finir le jeu	Vous devez battre le dragon.	Minecraft
MINE03	Dormir dans un lit	Vous devez craft un lit puis dormir dedans.	Minecraft
FORT01	Tuer un joueur	Dans le mode battle royal, vous devez tuer un joueur	Fortnite
FORT02	Gagner une partie	Dans le mode battle royal, vous devez gagner une partie	Fortnite
\.


--
-- Name: acheter cle_acheter; Type: CONSTRAINT; Schema: public; Owner: dilien.oeuvrard
--

ALTER TABLE ONLY public.acheter
    ADD CONSTRAINT cle_acheter PRIMARY KEY (pseudo, titre);


--
-- Name: ami cle_ami; Type: CONSTRAINT; Schema: public; Owner: dilien.oeuvrard
--

ALTER TABLE ONLY public.ami
    ADD CONSTRAINT cle_ami PRIMARY KEY (pseudo1, pseudo2);


--
-- Name: appartient cle_appartient; Type: CONSTRAINT; Schema: public; Owner: dilien.oeuvrard
--

ALTER TABLE ONLY public.appartient
    ADD CONSTRAINT cle_appartient PRIMARY KEY (titre, type_jeux);


--
-- Name: atteindre cle_atteindre; Type: CONSTRAINT; Schema: public; Owner: dilien.oeuvrard
--

ALTER TABLE ONLY public.atteindre
    ADD CONSTRAINT cle_atteindre PRIMARY KEY (code, pseudo);


--
-- Name: partager cle_partager; Type: CONSTRAINT; Schema: public; Owner: dilien.oeuvrard
--

ALTER TABLE ONLY public.partager
    ADD CONSTRAINT cle_partager PRIMARY KEY (pseudo, titre);


--
-- Name: entreprise entreprise_pkey; Type: CONSTRAINT; Schema: public; Owner: dilien.oeuvrard
--

ALTER TABLE ONLY public.entreprise
    ADD CONSTRAINT entreprise_pkey PRIMARY KEY (nom);


--
-- Name: genre genre_pkey; Type: CONSTRAINT; Schema: public; Owner: dilien.oeuvrard
--

ALTER TABLE ONLY public.genre
    ADD CONSTRAINT genre_pkey PRIMARY KEY (type_jeux);


--
-- Name: jeux jeux_pkey; Type: CONSTRAINT; Schema: public; Owner: dilien.oeuvrard
--

ALTER TABLE ONLY public.jeux
    ADD CONSTRAINT jeux_pkey PRIMARY KEY (titre);


--
-- Name: joueur joueur_pkey; Type: CONSTRAINT; Schema: public; Owner: dilien.oeuvrard
--

ALTER TABLE ONLY public.joueur
    ADD CONSTRAINT joueur_pkey PRIMARY KEY (pseudo);


--
-- Name: succes succes_pkey; Type: CONSTRAINT; Schema: public; Owner: dilien.oeuvrard
--

ALTER TABLE ONLY public.succes
    ADD CONSTRAINT succes_pkey PRIMARY KEY (code);


--
-- Name: acheter acheter_pseudo_fkey; Type: FK CONSTRAINT; Schema: public; Owner: dilien.oeuvrard
--

ALTER TABLE ONLY public.acheter
    ADD CONSTRAINT acheter_pseudo_fkey FOREIGN KEY (pseudo) REFERENCES public.joueur(pseudo);


--
-- Name: acheter acheter_titre_fkey; Type: FK CONSTRAINT; Schema: public; Owner: dilien.oeuvrard
--

ALTER TABLE ONLY public.acheter
    ADD CONSTRAINT acheter_titre_fkey FOREIGN KEY (titre) REFERENCES public.jeux(titre);


--
-- Name: ami ami_pseudo1_fkey; Type: FK CONSTRAINT; Schema: public; Owner: dilien.oeuvrard
--

ALTER TABLE ONLY public.ami
    ADD CONSTRAINT ami_pseudo1_fkey FOREIGN KEY (pseudo1) REFERENCES public.joueur(pseudo);


--
-- Name: ami ami_pseudo2_fkey; Type: FK CONSTRAINT; Schema: public; Owner: dilien.oeuvrard
--

ALTER TABLE ONLY public.ami
    ADD CONSTRAINT ami_pseudo2_fkey FOREIGN KEY (pseudo2) REFERENCES public.joueur(pseudo);


--
-- Name: appartient appartient_titre_fkey; Type: FK CONSTRAINT; Schema: public; Owner: dilien.oeuvrard
--

ALTER TABLE ONLY public.appartient
    ADD CONSTRAINT appartient_titre_fkey FOREIGN KEY (titre) REFERENCES public.jeux(titre);


--
-- Name: appartient appartient_type_jeu_fkey; Type: FK CONSTRAINT; Schema: public; Owner: dilien.oeuvrard
--

ALTER TABLE ONLY public.appartient
    ADD CONSTRAINT appartient_type_jeu_fkey FOREIGN KEY (type_jeux) REFERENCES public.genre(type_jeux);


--
-- Name: atteindre atteindre_code_fkey; Type: FK CONSTRAINT; Schema: public; Owner: dilien.oeuvrard
--

ALTER TABLE ONLY public.atteindre
    ADD CONSTRAINT atteindre_code_fkey FOREIGN KEY (code) REFERENCES public.succes(code);


--
-- Name: atteindre atteindre_pseudo_fkey; Type: FK CONSTRAINT; Schema: public; Owner: dilien.oeuvrard
--

ALTER TABLE ONLY public.atteindre
    ADD CONSTRAINT atteindre_pseudo_fkey FOREIGN KEY (pseudo) REFERENCES public.joueur(pseudo);


--
-- Name: jeux jeux_nom_dev_fkey; Type: FK CONSTRAINT; Schema: public; Owner: dilien.oeuvrard
--

ALTER TABLE ONLY public.jeux
    ADD CONSTRAINT jeux_nom_dev_fkey FOREIGN KEY (nom_dev) REFERENCES public.entreprise(nom) ON UPDATE CASCADE;


--
-- Name: jeux jeux_nom_edit_fkey; Type: FK CONSTRAINT; Schema: public; Owner: dilien.oeuvrard
--

ALTER TABLE ONLY public.jeux
    ADD CONSTRAINT jeux_nom_edit_fkey FOREIGN KEY (nom_edit) REFERENCES public.entreprise(nom) ON UPDATE CASCADE;


--
-- Name: partager partager_pseudo_fkey; Type: FK CONSTRAINT; Schema: public; Owner: dilien.oeuvrard
--

ALTER TABLE ONLY public.partager
    ADD CONSTRAINT partager_pseudo_fkey FOREIGN KEY (pseudo) REFERENCES public.joueur(pseudo);


--
-- Name: partager partager_titre_fkey; Type: FK CONSTRAINT; Schema: public; Owner: dilien.oeuvrard
--

ALTER TABLE ONLY public.partager
    ADD CONSTRAINT partager_titre_fkey FOREIGN KEY (titre) REFERENCES public.jeux(titre);


--
-- Name: succes succes_titre_fkey; Type: FK CONSTRAINT; Schema: public; Owner: dilien.oeuvrard
--

ALTER TABLE ONLY public.succes
    ADD CONSTRAINT succes_titre_fkey FOREIGN KEY (titre) REFERENCES public.jeux(titre) ON UPDATE CASCADE;


--
-- Name: SCHEMA public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


--
-- PostgreSQL database dump complete
--


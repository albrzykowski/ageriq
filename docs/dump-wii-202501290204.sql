--
-- PostgreSQL database dump
--

-- Dumped from database version 17.2 (Debian 17.2-1.pgdg120+1)
-- Dumped by pg_dump version 17.0

-- Started on 2025-01-29 02:04:52

SET statement_timeout = 0;
SET lock_timeout = 0;
SET idle_in_transaction_session_timeout = 0;
SET transaction_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SELECT pg_catalog.set_config('search_path', '', false);
SET check_function_bodies = false;
SET xmloption = content;
SET client_min_messages = warning;
SET row_security = off;

--
-- TOC entry 4 (class 2615 OID 2200)
-- Name: public; Type: SCHEMA; Schema: -; Owner: pg_database_owner
--

CREATE SCHEMA public;


ALTER SCHEMA public OWNER TO pg_database_owner;

--
-- TOC entry 3372 (class 0 OID 0)
-- Dependencies: 4
-- Name: SCHEMA public; Type: COMMENT; Schema: -; Owner: pg_database_owner
--

COMMENT ON SCHEMA public IS 'standard public schema';


--
-- TOC entry 849 (class 1247 OID 16398)
-- Name: fullerton_test_name; Type: TYPE; Schema: public; Owner: postgres
--

CREATE TYPE public.fullerton_test_name AS ENUM (
    'chair_stand',
    'arm_curl',
    'six_min_walk',
    'two_min_step',
    'chair_sit_and_reach',
    'back_scratch',
    'eight_ft_up_and_go'
);


ALTER TYPE public.fullerton_test_name OWNER TO postgres;

--
-- TOC entry 846 (class 1247 OID 16392)
-- Name: sex; Type: TYPE; Schema: public; Owner: postgres
--

CREATE TYPE public.sex AS ENUM (
    'M',
    'F'
);


ALTER TYPE public.sex OWNER TO postgres;

SET default_tablespace = '';

SET default_table_access_method = heap;

--
-- TOC entry 217 (class 1259 OID 16413)
-- Name: fullerton_test; Type: TABLE; Schema: public; Owner: postgres
--

CREATE TABLE public.fullerton_test (
    test_name character varying(20) NOT NULL,
    test_code public.fullerton_test_name NOT NULL,
    sex public.sex NOT NULL,
    min_age integer NOT NULL,
    max_age integer NOT NULL,
    min_ref numeric(10,2) NOT NULL,
    max_ref numeric(10,2) NOT NULL,
    min_ref_imp numeric(10,2),
    max_ref_imp numeric(10,2),
    test character varying(50),
    CONSTRAINT fullerton_test_max_age_check CHECK (((max_age >= 60) AND (max_age <= 94))),
    CONSTRAINT fullerton_test_max_ref_check CHECK (((max_ref >= ('-1000'::integer)::numeric) AND (max_ref <= (1000)::numeric))),
    CONSTRAINT fullerton_test_max_ref_imp_check CHECK (((max_ref_imp >= ('-1000'::integer)::numeric) AND (max_ref_imp <= (1000)::numeric))),
    CONSTRAINT fullerton_test_min_age_check CHECK (((min_age >= 60) AND (min_age <= 94))),
    CONSTRAINT fullerton_test_min_ref_check CHECK (((min_ref >= ('-1000'::integer)::numeric) AND (min_ref <= (1000)::numeric))),
    CONSTRAINT fullerton_test_min_ref_imp_check CHECK (((min_ref_imp >= ('-1000'::integer)::numeric) AND (min_ref_imp <= (1000)::numeric)))
);


ALTER TABLE public.fullerton_test OWNER TO postgres;

--
-- TOC entry 3366 (class 0 OID 16413)
-- Dependencies: 217
-- Data for Name: fullerton_test; Type: TABLE DATA; Schema: public; Owner: postgres
--

COPY public.fullerton_test (test_name, test_code, sex, min_age, max_age, min_ref, max_ref, min_ref_imp, max_ref_imp, test) FROM stdin;
Chair stand	chair_stand	F	60	64	12.00	17.00	\N	\N	\N
Chair stand	chair_stand	F	65	69	11.00	16.00	\N	\N	\N
Chair stand	chair_stand	F	70	74	10.00	15.00	\N	\N	\N
Chair stand	chair_stand	F	75	79	10.00	15.00	\N	\N	\N
Chair stand	chair_stand	F	80	84	9.00	14.00	\N	\N	\N
Chair stand	chair_stand	F	85	89	8.00	13.00	\N	\N	\N
Chair stand	chair_stand	F	90	94	4.00	11.00	\N	\N	\N
Arm curl	arm_curl	F	60	64	13.00	19.00	\N	\N	\N
Arm curl	arm_curl	F	65	69	12.00	18.00	\N	\N	\N
Arm curl	arm_curl	F	70	74	12.00	17.00	\N	\N	\N
Arm curl	arm_curl	F	75	79	11.00	17.00	\N	\N	\N
Arm curl	arm_curl	F	80	84	10.00	16.00	\N	\N	\N
Arm curl	arm_curl	F	85	89	10.00	15.00	\N	\N	\N
Arm curl	arm_curl	F	90	94	8.00	13.00	\N	\N	\N
6-Min Walk	six_min_walk	F	60	64	498.35	603.50	545.00	660.00	\N
6-Min Walk	six_min_walk	F	65	69	457.20	580.60	500.00	635.00	\N
6-Min Walk	six_min_walk	F	70	74	438.91	562.40	480.00	615.00	\N
6-Min Walk	six_min_walk	F	75	79	393.19	534.90	430.00	585.00	\N
6-Min Walk	six_min_walk	F	80	84	352.04	493.80	385.00	540.00	\N
6-Min Walk	six_min_walk	F	85	89	310.90	466.30	340.00	510.00	\N
6-Min Walk	six_min_walk	F	90	94	251.46	402.30	275.00	440.00	\N
2-Min Step	two_min_step	F	60	64	75.00	107.00	\N	\N	\N
2-Min Step	two_min_step	F	65	69	73.00	107.00	\N	\N	\N
2-Min Step	two_min_step	F	70	74	68.00	101.00	\N	\N	\N
2-Min Step	two_min_step	F	75	79	68.00	100.00	\N	\N	\N
2-Min Step	two_min_step	F	80	84	60.00	91.00	\N	\N	\N
2-Min Step	two_min_step	F	85	89	55.00	85.00	\N	\N	\N
2-Min Step	two_min_step	F	90	94	44.00	72.00	\N	\N	\N
Chair Sit-&-Rich	chair_sit_and_reach	F	60	64	-1.27	12.70	-0.50	5.00	\N
Chair Sit-&-Rich	chair_sit_and_reach	F	65	69	-1.27	11.40	-0.50	4.50	\N
Chair Sit-&-Rich	chair_sit_and_reach	F	70	74	-2.54	10.20	-1.00	4.00	\N
Chair Sit-&-Rich	chair_sit_and_reach	F	75	79	-3.81	8.90	-1.50	3.50	\N
Chair Sit-&-Rich	chair_sit_and_reach	F	80	84	-5.08	7.60	-2.00	3.00	\N
Chair Sit-&-Rich	chair_sit_and_reach	F	85	89	-6.35	6.40	-2.50	2.50	\N
Chair Sit-&-Rich	chair_sit_and_reach	F	90	94	-11.43	2.50	-4.50	1.00	\N
Back Scratch	back_scratch	F	60	64	-7.62	3.80	-3.00	1.50	\N
Back Scratch	back_scratch	F	65	69	-8.89	3.80	-3.50	1.50	\N
Back Scratch	back_scratch	F	70	74	-10.16	2.50	-4.00	1.00	\N
Back Scratch	back_scratch	F	75	79	-12.70	1.30	-5.00	0.50	\N
Back Scratch	back_scratch	F	80	84	-13.97	0.00	-5.50	0.00	\N
Back Scratch	back_scratch	F	85	89	-17.78	-2.50	-7.00	-1.00	\N
Back Scratch	back_scratch	F	90	94	-20.32	-2.50	-8.00	-1.00	\N
8-Ft Up-&-Go	eight_ft_up_and_go	F	60	64	6.00	4.40	\N	\N	\N
8-Ft Up-&-Go	eight_ft_up_and_go	F	65	69	6.40	4.80	\N	\N	\N
8-Ft Up-&-Go	eight_ft_up_and_go	F	70	74	7.10	4.90	\N	\N	\N
8-Ft Up-&-Go	eight_ft_up_and_go	F	75	79	7.40	5.20	\N	\N	\N
8-Ft Up-&-Go	eight_ft_up_and_go	F	80	84	8.70	5.70	\N	\N	\N
8-Ft Up-&-Go	eight_ft_up_and_go	F	85	89	9.60	6.20	\N	\N	\N
8-Ft Up-&-Go	eight_ft_up_and_go	F	90	94	11.50	7.30	\N	\N	\N
Chair stand	chair_stand	M	60	64	14.00	19.00	\N	\N	\N
Chair stand	chair_stand	M	65	69	12.00	18.00	\N	\N	\N
Chair stand	chair_stand	M	70	74	12.00	17.00	\N	\N	\N
Chair stand	chair_stand	M	75	79	11.00	17.00	\N	\N	\N
Chair stand	chair_stand	M	80	84	10.00	15.00	\N	\N	\N
Chair stand	chair_stand	M	85	89	8.00	14.00	\N	\N	\N
Chair stand	chair_stand	M	90	94	7.00	12.00	\N	\N	\N
Arm curl	arm_curl	M	60	64	16.00	22.00	\N	\N	\N
Arm curl	arm_curl	M	65	69	15.00	21.00	\N	\N	\N
Arm curl	arm_curl	M	70	74	14.00	21.00	\N	\N	\N
Arm curl	arm_curl	M	75	79	13.00	19.00	\N	\N	\N
Arm curl	arm_curl	M	80	84	13.00	19.00	\N	\N	\N
Arm curl	arm_curl	M	85	89	11.00	17.00	\N	\N	\N
Arm curl	arm_curl	M	90	94	10.00	14.00	\N	\N	\N
6-Min Walk	six_min_walk	M	60	64	557.78	672.10	610.00	735.00	\N
6-Min Walk	six_min_walk	M	65	69	512.06	640.10	560.00	700.00	\N
6-Min Walk	six_min_walk	M	70	74	498.35	621.80	545.00	680.00	\N
6-Min Walk	six_min_walk	M	75	79	429.77	585.20	470.00	640.00	\N
6-Min Walk	six_min_walk	M	80	84	406.91	553.20	445.00	605.00	\N
6-Min Walk	six_min_walk	M	85	89	347.47	521.20	380.00	570.00	\N
6-Min Walk	six_min_walk	M	90	94	278.89	457.20	305.00	500.00	\N
2-Min Step	two_min_step	M	60	64	87.00	115.00	\N	\N	\N
2-Min Step	two_min_step	M	65	69	86.00	116.00	\N	\N	\N
2-Min Step	two_min_step	M	70	74	80.00	110.00	\N	\N	\N
2-Min Step	two_min_step	M	75	79	73.00	109.00	\N	\N	\N
2-Min Step	two_min_step	M	80	84	71.00	103.00	\N	\N	\N
2-Min Step	two_min_step	M	85	89	59.00	91.00	\N	\N	\N
2-Min Step	two_min_step	M	90	94	52.00	86.00	\N	\N	\N
Chair Sit-&-Rich	chair_sit_and_reach	M	60	64	-6.35	10.20	-2.50	4.00	\N
Chair Sit-&-Rich	chair_sit_and_reach	M	65	69	-7.62	7.60	-3.00	3.00	\N
Chair Sit-&-Rich	chair_sit_and_reach	M	70	74	-8.89	6.40	-3.50	2.50	\N
Chair Sit-&-Rich	chair_sit_and_reach	M	75	79	-10.16	5.10	-4.00	2.00	\N
Chair Sit-&-Rich	chair_sit_and_reach	M	80	84	-13.97	3.80	-5.50	1.50	\N
Chair Sit-&-Rich	chair_sit_and_reach	M	85	89	-13.97	1.30	-5.50	0.50	\N
Chair Sit-&-Rich	chair_sit_and_reach	M	90	94	-16.51	-1.30	-6.50	-0.50	\N
Back Scratch	back_scratch	M	60	64	-16.51	0.00	-6.50	0.00	\N
Back Scratch	back_scratch	M	65	69	-19.05	-2.50	-7.50	-1.00	\N
Back Scratch	back_scratch	M	70	74	-20.32	-2.50	-8.00	-1.00	\N
Back Scratch	back_scratch	M	75	79	-22.86	-5.10	-9.00	-2.00	\N
Back Scratch	back_scratch	M	80	84	-24.13	-5.10	-9.50	-2.00	\N
Back Scratch	back_scratch	M	85	89	-25.40	-7.60	-10.00	-3.00	\N
Back Scratch	back_scratch	M	90	94	-26.67	-10.20	-10.50	-4.00	\N
8-Ft Up-&-Go	eight_ft_up_and_go	M	60	64	5.60	3.80	\N	\N	\N
8-Ft Up-&-Go	eight_ft_up_and_go	M	65	69	5.70	4.30	\N	\N	\N
8-Ft Up-&-Go	eight_ft_up_and_go	M	70	74	6.00	4.20	\N	\N	\N
8-Ft Up-&-Go	eight_ft_up_and_go	M	75	79	7.20	4.60	\N	\N	\N
8-Ft Up-&-Go	eight_ft_up_and_go	M	80	84	7.60	5.20	\N	\N	\N
8-Ft Up-&-Go	eight_ft_up_and_go	M	85	89	8.90	5.30	\N	\N	\N
8-Ft Up-&-Go	eight_ft_up_and_go	M	90	94	10.00	6.20	\N	\N	\N
\.


-- Completed on 2025-01-29 02:04:52

--
-- PostgreSQL database dump complete
--


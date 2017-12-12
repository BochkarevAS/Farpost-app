CREATE DATABASE farpost
  WITH OWNER = postgres
       ENCODING = 'UTF8'
       TABLESPACE = pg_default
       LC_COLLATE = 'Russian_Russia.1251'
       LC_CTYPE = 'Russian_Russia.1251'
       CONNECTION LIMIT = -1;


CREATE TABLE public.image
(
  id integer NOT NULL DEFAULT nextval('image_id_seq'::regclass),
  img text,
  uid integer,
  date timestamp with time zone NOT NULL DEFAULT now(),
  CONSTRAINT image_pkey PRIMARY KEY (id)
)

CREATE TABLE public.users
(
  id integer NOT NULL DEFAULT nextval('users_id_seq'::regclass),
  password text,
  email text,
  code text,
  date timestamp with time zone NOT NULL DEFAULT now(),
  CONSTRAINT users_pkey PRIMARY KEY (id)
)
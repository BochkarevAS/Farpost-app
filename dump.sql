CREATE DATABASE frame
  WITH OWNER = postgres
       ENCODING = 'UTF8'
       TABLESPACE = pg_default
       LC_COLLATE = 'Russian_Russia.1251'
       LC_CTYPE = 'Russian_Russia.1251'
       CONNECTION LIMIT = -1;

-- Table: public.users

-- DROP TABLE public.users;

CREATE TABLE public.users
(
  id serial,
  nickname text,
  email text,
  password text,
  avatar text,
  token text,
  is_confirmed boolean,
  role text,
  created_at timestamp with time zone NOT NULL DEFAULT now(),
  updated_at timestamp with time zone NOT NULL DEFAULT now()
)
WITH (
  OIDS=FALSE
);
ALTER TABLE public.users
  OWNER TO postgres;

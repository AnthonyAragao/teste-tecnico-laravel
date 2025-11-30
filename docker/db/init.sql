DO
$$
BEGIN
   IF NOT EXISTS (
      SELECT FROM pg_database WHERE datname = 'teste'
   ) THEN
      PERFORM dblink_exec('dbname=postgres', 'CREATE DATABASE teste');
   END IF;
END
$$;

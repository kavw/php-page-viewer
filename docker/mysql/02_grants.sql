CREATE USER '{{user}}'@'%' IDENTIFIED WITH mysql_native_password BY '{{pass}}';
GRANT ALL ON `{{db}}`.* TO '{{user}}'@'%';

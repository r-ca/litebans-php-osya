<?php

class EnvSettings extends Settings {
    public function __construct($connect = true) {
        parent::__construct(false);
        $this->database = getenv("MYSQL_DATABASE");
        $this->username = getenv("MYSQL_USERNAME");
        $this->password = getenv("MYSQL_PASSWORD");
        $this->table_prefix = getenv("LITEBANS_TABLE_PREFIX");

        $this->init_tables();

        if ($connect) $this->connect();
    }
}

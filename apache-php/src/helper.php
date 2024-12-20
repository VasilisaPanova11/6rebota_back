<?php
const
host = 'db',
dbUser = 'user',
password = 'password',
db = 'appDb';

function openMysqli(): mysqli
{
    return new mysqli(
        host, dbUser, password, db
    );
}
<?php

  // change path to match location of database
  $dsn = 'sqlite:/path/to/sqlite/database.db';
  try {                    
    $db = new PDO($dsn);
  } catch (Exception $e) {    
    $error = $e->getMessage();
  }

  $loginRedirectURL = 'https://example.com';
  
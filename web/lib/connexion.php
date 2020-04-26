<?php
/***********************************************************************************
 *
 *  connexion.php : contient la classe pour la connexion à la base de données
 *
 ***********************************************************************************/

class Connexion extends mysqli  {
  private static $instance;

  public function __construct() {
    parent::__construct(BDD_HOST, BDD_LOGIN, BDD_MDP, BDD_DATABASE);
  }

  public static function getBD() {
    if(self::$instance === null){
      self::$instance = new Connexion();
      if (self::$instance->connect_errno)
        throw new Exception('<pre>'.__FILE__."\r\n".__LINE__."\r\n".__METHOD__."\r\n".self::$instance->connect_error.'</pre>');
      if (self::$instance->query("SET NAMES 'utf8'") === false)
        throw new Exception('<pre>'.__FILE__."\r\n".__LINE__."\r\n".__METHOD__."\r\n".self::$instance->error.'</pre>');
      if (self::$instance->query("SET SESSION sql_mode = 'NO_ENGINE_SUBSTITUTION'") === false)
        throw new Exception('<pre>'.__FILE__."\r\n".__LINE__."\r\n".__METHOD__."\r\n".self::$instance->error.'</pre>');
    }
    return self::$instance;
  }
}


?>

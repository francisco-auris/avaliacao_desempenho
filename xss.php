<?php

$ldap_server = "cbpsrv1.cobap.com.br";
$dominio = "@cobap"; //Dominio local ou global
$user = "estagioti".$dominio;
$ldap_porta = "389";
$ldap_pass   = 'Pacel@2016';
$ldapcon = ldap_connect($ldap_server, $ldap_porta) or die("Could not connect to LDAP server.");
if ($ldapcon){
// binding to ldap server
//$ldapbind = ldap_bind($ldapconn, $user, $ldap_pass);
$bind = ldap_bind($ldapcon, $user, $ldap_pass);
// verify binding
$dn 	= "CN=Users,DC=cobap,DC=com,DC=br";
//$filter		= "(&(objectClass=user)(!(userAccountControl:1.2.840.113556.1.4.803:=2)))";
$filter = "(|(samaccountname=estagioti))";

 $sr	= ldap_search($ldapcon, $dn, $filter) or die ("erro");
   echo "Search result is " . $sr . "<br />";

   echo "Number of entires returned is " . ldap_count_entries($ldapcon, $sr) . "<br />";

   echo "Getting entries ...<p>";
   $info = ldap_get_entries($ldapcon, $sr);
   echo "Data for " . $info["count"] . " items returned:<p>";

   for ($i=0; $i<$info["count"]; $i++) {
       echo "dn is: " . $info[$i]["dn"] . "<br />";
       echo "first cn entry is: " . $info[$i]["cn"][0] . "<br />";
       echo "first type is: " . $info[$i]["dc"][0] . "<br /><hr />";
   }

   echo "Closing connection";
   ldap_close($ds);


if ($bind) {
echo "LDAP bind successful…";
print_r($bind);
} else {
echo "LDAP bind failed…";
}
}

?>
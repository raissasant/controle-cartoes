<?php
$ldap_host = "10.0.2.1"; // OU use "agroaraca.local" se necessário
$ldap_port = 389; // Use 636 se for LDAPS
$ldap_user = "Administrador@agroaraca.local";
$ldap_password = "SenhaDoAdministrador";

$ldap_conn = ldap_connect($ldap_host, $ldap_port);

if (!$ldap_conn) {
    die("❌ Erro: Não foi possível conectar ao servidor LDAP.");
}

ldap_set_option($ldap_conn, LDAP_OPT_PROTOCOL_VERSION, 3);
ldap_set_option($ldap_conn, LDAP_OPT_REFERRALS, 0);

$ldap_bind = @ldap_bind($ldap_conn, $ldap_user, $ldap_password);

if ($ldap_bind) {
    echo "✅ Sucesso: Conectado ao LDAP com sucesso!";
} else {
    echo "❌ Erro: Não foi possível autenticar. Verifique usuário e senha.";
}

ldap_close($ldap_conn);

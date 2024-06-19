<?php

/*La funzione esc($str) viene utilizzata per effettuare l'escape di una stringa $str per prevenire attacchi di tipo SQL injection. Utilizza la funzione mysqli_real_escape_string() per proteggere la stringa e htmlspecialchars() per evitare attacchi XSS (Cross-Site Scripting). È importante notare che questa funzione fa riferimento ad una variabile globale $conn, che presuma sia un oggetto di connessione al database MySQL.

La condizione if (! defined('ROOT_URL')) { die; } viene utilizzata per impedire l'accesso diretto al file. Se la costante ROOT_URL non è definita, il codice termina l'esecuzione con die.

La funzione esc_html($str) è simile a esc($str), ma si limita a effettuare l'escape HTML di una stringa senza coinvolgere il database.

La funzione shorten($str) accetta una stringa $str e restituisce una versione abbreviata di essa, limitata ai primi 30 caratteri, seguiti da tre punti di sospensione.

La funzione random_string() genera una stringa casuale di lunghezza 20 utilizzando la funzione md5() combinata con un numero casuale generato da mt_rand(), quindi estrae i primi 20 caratteri della stringa ottenuta.

*/
function esc( $str ) {

    global $conn;
    return mysqli_real_escape_string($conn, htmlspecialchars($str));
}
  // Prevent from direct access
  if (! defined('ROOT_URL')) {
    die;
  }

  function esc_html($str) {
    return htmlspecialchars($str);
  }

  function shorten($str) {
    return substr($str, 0, 30) . '...';
  }

  function random_string(){
    return substr(md5(mt_rand()), 0, 20);
  }
<?php
$lifetime = 60 * 60 * 24 * 7;
session_name('dm_registration');
session_set_cookie_params([
    'lifetime' => $lifetime,
    'path' => '/data-module/',
    'httponly' => true,
]);
session_start();

$form = $_SESSION['form'] ?? [];

if (empty($form)) {
    header('Location: registry-data.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['confirm'])) {
        $_SESSION['registered'][] = $form;
        $_SESSION['message'] = 'Registrazione completata.';
        unset($_SESSION['form']);
        header('Location: registry-data.php');
        exit;
    } elseif (isset($_POST['edit1'])) {
        header('Location: registry-data.php');
        exit;
    } elseif (isset($_POST['edit2'])) {
        header('Location: contact-data.php');
        exit;
    }
}
?>
<!doctype html>
<html lang="it">
<head><meta charset="utf-8"><title>Riepilogo</title></head>
<body>
<h2>Riepilogo</h2>
<?php if (!empty($_SESSION['message'])): ?>
    <p style="color:green;"><?php echo htmlspecialchars($_SESSION['message']); unset($_SESSION['message']); ?></p>
<?php endif; ?>
<table border="1" cellpadding="6">
    <tr><th>Nome</th><td><?php echo htmlspecialchars($form['nome'] ?? ''); ?></td></tr>
    <tr><th>Cognome</th><td><?php echo htmlspecialchars($form['cognome'] ?? ''); ?></td></tr>
    <tr><th>Data di nascita</th><td><?php echo htmlspecialchars($form['data_nascita'] ?? ''); ?></td></tr>
    <tr><th>Email</th><td><?php echo htmlspecialchars($form['email'] ?? ''); ?></td></tr>
    <tr><th>Telefono</th><td><?php echo htmlspecialchars($form['telefono'] ?? ''); ?></td></tr>
    <tr><th>Indirizzo</th><td><?php echo htmlspecialchars($form['indirizzo'] ?? ''); ?></td></tr>
</table>

<form method="post" action="">
    <button name="edit1" type="submit">Modifica anagrafica</button>
    <button name="edit2" type="submit">Modifica contatto</button>
    <button name="confirm" type="submit">Conferma e salva</button>
</form>

<p><a href="registry-data.php">Nuova compilazione</a> | <a href="logout.php">Logout</a></p>
</body>
</html> 
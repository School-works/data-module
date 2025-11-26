<?php
$lifetime = 60 * 60 * 24 * 7;
session_name('dm_registration');
session_set_cookie_params([
    'lifetime' => $lifetime,
    'path' => '/data-module/',
    'httponly' => true,
]);
session_start();

$errors = [];
$form = $_SESSION['form'] ?? ['nome'=>'','cognome'=>'','data_nascita'=>''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $cognome = trim($_POST['cognome'] ?? '');
    $data_nascita = trim($_POST['data_nascita'] ?? '');

    if ($nome === '') $errors[] = 'Nome obbligatorio.';
    if ($cognome === '') $errors[] = 'Cognome obbligatorio.';

    if (empty($errors)) {
        $_SESSION['form'] = array_merge($_SESSION['form'] ?? [], [
            'nome' => $nome,
            'cognome' => $cognome,
            'data_nascita' => $data_nascita,
        ]);
        header('Location: contact-data.php');
        exit;
    } else {
        $form = ['nome'=>$nome,'cognome'=>$cognome,'data_nascita'=>$data_nascita];
    }
}
?>
<!doctype html>
<html lang="it">
<head><meta charset="utf-8"><title>Step 1 - Dati anagrafici</title></head>
<body>
<h2>Step 1 - Dati anagrafici</h2>
<?php if ($errors): ?>
    <ul style="color:red;"><?php foreach ($errors as $e) echo '<li>'.htmlspecialchars($e).'</li>'; ?></ul>
<?php endif; ?>
<form method="post" action="">
    <label>Nome: <input type="text" name="nome" value="<?php echo htmlspecialchars($form['nome']); ?>" required></label><br>
    <label>Cognome: <input type="text" name="cognome" value="<?php echo htmlspecialchars($form['cognome']); ?>" required></label><br>
    <label>Data di nascita: <input type="date" name="data_nascita" value="<?php echo htmlspecialchars($form['data_nascita']); ?>"></label><br>
    <button type="submit">Prossimo</button>
</form>
<p><a href="summary.php">Vai al riepilogo (se già compilato)</a> | <a href="contact-data.php">Vai a contatto</a></p>
<p><a href="logout.php">Azzera sessione / Logout</a></p>
</body>
</html>
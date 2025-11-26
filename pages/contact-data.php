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
$form = $_SESSION['form'] ?? ['email'=>'','telefono'=>'','indirizzo'=>''];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $telefono = trim($_POST['telefono'] ?? '');
    $indirizzo = trim($_POST['indirizzo'] ?? '');

    if ($email === '') $errors[] = 'Email obbligatoria.';
    if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = 'Email non valida.';

    if (empty($errors)) {
        $_SESSION['form'] = array_merge($_SESSION['form'] ?? [], [
            'email' => $email,
            'telefono' => $telefono,
            'indirizzo' => $indirizzo,
        ]);
        header('Location: summary.php');
        exit;
    } else {
        $form = ['email'=>$email,'telefono'=>$telefono,'indirizzo'=>$indirizzo];
    }
}
?>
<!doctype html>
<html lang="it">
<head><meta charset="utf-8"><title>Dati di contatto</title></head>
<body>
<h2>Dati di contatto</h2>
<?php if ($errors): ?>
    <ul style="color:red;"><?php foreach ($errors as $e) echo '<li>'.htmlspecialchars($e).'</li>'; ?></ul>
<?php endif; ?>
<form method="post" action="">
    <label>Email: <input type="email" name="email" value="<?php echo htmlspecialchars($form['email']); ?>" required></label><br>
    <label>Telefono: <input type="text" name="telefono" value="<?php echo htmlspecialchars($form['telefono']); ?>"></label><br>
    <label>Indirizzo: <input type="text" name="indirizzo" value="<?php echo htmlspecialchars($form['indirizzo']); ?>"></label><br>
    <button type="submit">Prossimo</button>
    <a href="registry-data.php"><button type="button">Indietro</button></a>
</form>
<p><a href="summary.php">Vai al riepilogo</a></p>
<p><a href="logout.php">Logout</a></p>
</body>
</html>
<?php /* Recibe $error desde AuthController */ ?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Ingreso · Minimarket Mass</title>
<style>
  *{box-sizing:border-box;font-family:'Segoe UI',Arial,sans-serif;margin:0;padding:0}
  body{min-height:100vh;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,#0066B3,#004F8C)}
  .login{background:#fff;width:340px;border-radius:14px;padding:32px 28px;box-shadow:0 18px 45px rgba(0,0,0,.25)}
  .logo{display:block;text-align:center;background:#0066B3;color:#fff;font-weight:800;font-size:20px;letter-spacing:1px;padding:8px 0;border-radius:8px;margin-bottom:18px}
  label{display:block;font-size:13px;font-weight:600;margin:14px 0 5px}
  input{width:100%;padding:11px 13px;border:1px solid #d7dde6;border-radius:8px;font-size:14px}
  input:disabled{background:#f0f0f0;cursor:not-allowed;color:#aaa}
  button{width:100%;margin-top:20px;padding:12px;border:none;border-radius:8px;background:#0066B3;color:#fff;font-size:15px;font-weight:700;cursor:pointer}
  button:disabled{background:#a0b8cc;cursor:not-allowed}
  .error{background:#fef2f2;border:1px solid #f3c2c2;color:#b91c1c;font-size:13px;padding:10px 12px;border-radius:8px;margin-bottom:8px}
  .bloqueado{background:#fff3cd;border:1px solid #f59e0b;color:#92400e;font-size:14px;padding:16px;border-radius:8px;margin-bottom:12px;text-align:center}
  .bloqueado strong{display:block;font-size:16px;margin-bottom:6px}
  .hint{margin-top:16px;text-align:center;font-size:12px;color:#94a1b2}
</style>
</head>
<body>
  <div class="login">
    <span class="logo">MASS</span>

    <?php $bloqueado = ($_SESSION['intentos_fallidos'] ?? 0) >= 3; ?>

    <?php if ($bloqueado): ?>
      <div class="bloqueado">
        <strong>🔒 Acceso bloqueado</strong>
        Demasiados intentos fallidos.<br>Reinicia el navegador para continuar.
      </div>
    <?php elseif (!empty($error)): ?>
      <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" action="index.php?accion=procesar-login">
      <label>Usuario</label>
      <input type="text" name="username" autofocus
             value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"
             <?= $bloqueado ? 'disabled' : '' ?>>

      <label>Contraseña</label>
      <input type="password" name="password"
             <?= $bloqueado ? 'disabled' : '' ?>>

      <button type="submit" <?= $bloqueado ? 'disabled' : '' ?>>
        <?= $bloqueado ? 'Bloqueado' : 'Ingresar' ?>
      </button>
    </form>

    <?php if (!$bloqueado): ?>
      <p class="hint">Demo: cajero01 / admin123</p>
    <?php endif; ?>
  </div>
</body>
</html>
<?php
spl_autoload_register(function($class){
    $paths = [__DIR__ . '/app/core/' . $class . '.php', __DIR__ . '/app/controllers/' . $class . '.php', __DIR__ . '/app/models/' . $class . '.php'];
    foreach ($paths as $p) if (file_exists($p)) { require_once $p; return; }
});

// Composer autoload (for external libraries, e.g., PhpSpreadsheet)
$composerAutoload = __DIR__ . '/vendor/autoload.php';
if (file_exists($composerAutoload)) { require_once $composerAutoload; }

// Run migrations on startup (idempotent)
function run_migrations(){
    $pdo = Database::pdo();
    $sql = file_get_contents(__DIR__ . '/database/migrations.sql');
    if ($sql === false) { return; }
    // Execute statement-by-statement and ignore benign idempotency errors
    $statements = array_filter(array_map('trim', explode(';', $sql)), function($s){ return $s !== ''; });
    foreach ($statements as $stmtSql) {
        $stmtSql = trim($stmtSql);
        if ($stmtSql === '' || strpos($stmtSql, '--') === 0) { continue; }
        try {
            $pdo->exec($stmtSql);
        } catch (Throwable $se) {
            $msg = $se->getMessage();
            $benign = (
                stripos($msg, 'Duplicate') !== false ||
                stripos($msg, 'already exists') !== false ||
                stripos($msg, 'check that column/key exists') !== false ||
                stripos($msg, 'no such index') !== false ||
                stripos($msg, 'errno: 121') !== false // duplicate key/constraint
            );
            if ($benign) { continue; }
            throw $se;
        }
    }
}

run_migrations();

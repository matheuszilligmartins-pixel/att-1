<?php
declare(strict_types=1);
session_start();

function loadEnv(string $path): void {
    if (!is_file($path)) return;
    foreach (file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        $line = trim($line);
        if ($line === '' || str_starts_with($line, '#') || !str_contains($line, '=')) continue;
        [$key, $value] = explode('=', $line, 2);
        $_ENV[trim($key)] = trim($value);
    }
}
loadEnv(__DIR__ . '/.env');

function envv(string $key, string $default = ''): string {
    return (string)($_ENV[$key] ?? $default);
}
$dsn = 'mysql:host=' . envv('DB_HOST', '127.0.0.1') . ';port=' . envv('DB_PORT', '3306') .
       ';dbname=' . envv('DB_NAME', 'soul_society_store') . ';charset=utf8mb4';
try {
    $pdo = new PDO($dsn, envv('DB_USER', 'root'), envv('DB_PASS', ''), [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    exit('Não foi possível conectar ao banco. Confira o arquivo .env e importe database/schema.sql.');
}
function e(?string $value): string { return htmlspecialchars($value ?? '', ENT_QUOTES, 'UTF-8'); }
function money(float|string $value): string { return 'R$ ' . number_format((float)$value, 2, ',', '.'); }
function redirect(string $url): never { header('Location: ' . $url); exit; }
function csrfToken(): string {
    if (empty($_SESSION['csrf'])) $_SESSION['csrf'] = bin2hex(random_bytes(32));
    return $_SESSION['csrf'];
}
function verifyCsrf(): void {
    if ($_SERVER['REQUEST_METHOD'] === 'POST' &&
        !hash_equals($_SESSION['csrf'] ?? '', $_POST['csrf'] ?? '')) {
        http_response_code(419); exit('Solicitação inválida. Atualize a página e tente novamente.');
    }
}
function currentUser(): ?array { return $_SESSION['user'] ?? null; }
function requireLogin(): void { if (!currentUser()) redirect('../login.php'); }
function requireAdmin(): void {
    if (!currentUser() || currentUser()['role'] !== 'admin') {
        http_response_code(403); exit('Acesso restrito à administração.');
    }
}

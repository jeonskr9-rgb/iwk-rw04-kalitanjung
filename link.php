<?php
/**
 * Script untuk membuat symlink di Shared Hosting (seperti InfinityFree)
 * Akses file ini dari browser: http://domain-anda.com/link.php
 */

$target = __DIR__ . '/storage/app/public';

// Karena isi public sudah dipindah ke root (htdocs), kita TIDAK BISA menggunakan nama 'storage' 
// untuk symlink karena nama folder 'storage' sudah ada (folder inti Laravel).
// Jadi kita menamainya 'storage_link'.
$link = __DIR__ . '/storage_link';

if (file_exists($link)) {
    echo "<h3 style='color:orange;'>Symlink sudah ada atau nama folder bentrok!</h3>";
} else {
    try {
        if (symlink($target, $link)) {
            echo "<h3 style='color:green;'>✅ SUKSES: Symlink berhasil dibuat!</h3>";
            echo "<p>Folder target: $target</p>";
            echo "<p>Symlink dibuat di: $link</p>";
            echo "<br><p><b>PENTING:</b> Karena nama symlink adalah 'storage_link', pastikan Anda menyesuaikan di <code>config/filesystems.php</code>:<br>";
            echo "<code>'root' => public_path('storage_link'),</code><br>";
            echo "<code>'url' => env('APP_URL').'/storage_link',</code></p>";
        } else {
            echo "<h3 style='color:red;'>❌ GAGAL: Fungsi symlink() mungkin diblokir oleh hosting.</h3>";
        }
    } catch (Exception $e) {
        echo "<h3 style='color:red;'>❌ ERROR: " . $e->getMessage() . "</h3>";
    }
}

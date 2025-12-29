<?php
define('ALLOWED_ACCESS', true);
require_once __DIR__ . '/../includes/paths.php';
require_once $project_root . 'includes/session.php';
require_once $project_root . 'languages/language.php'; // Include language detection

// Handle download request if submitted
if (isset($_GET['file'])) {
    // Immediately clear any existing output buffers
    while (ob_get_level())
        ob_end_clean();

    $file = basename($_GET['file']);
    $path = $project_root . 'download/files/' . $file;

    if (file_exists($path)) {
        header('Content-Description: File Transfer');
        if (pathinfo($path, PATHINFO_EXTENSION) === 'torrent') {
            header('Content-Type: application/x-bittorrent');
        } else {
            header('Content-Type: application/octet-stream');
        }
        header('Content-Disposition: attachment; filename="' . $file . '"');
        header('Content-Length: ' . filesize($path));
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        readfile($path);
        exit;
    } else {
        $_SESSION['download_error'] = translate('download_error_file_not_found', 'File not found');
        header("Location: {$base_path}download/woltk.php");
        exit;
    }
}

include_once $project_root . 'includes/header.php';
?>
<link rel="stylesheet" href="<?php echo $base_path; ?>assets/css/download/index.css">
<title><?php echo $site_title_name . " " . translate('download_title', 'Download'); ?></title>

<style>
    :root {
        --bg-download: url('<?php echo $base_path; ?>img/backgrounds/bg-download.jpg');
    }
</style>
<div class="main-content">
    <div class="container wow-decoration">
        <h1><?php echo translate('download_title_h1', 'Choose a file to download'); ?></h1>

        <?php if (isset($_SESSION['download_error'])): ?>
            <div class="error"><?php echo htmlspecialchars($_SESSION['download_error'], ENT_QUOTES, 'UTF-8'); ?></div>
            <?php unset($_SESSION['download_error']); ?>
        <?php endif; ?>

        <div class="file-info">
            <p><i class="fas fa-file-archive"></i>
                <?php echo translate('download_file_name', 'Wrath of the Lich King Client'); ?></p>
            <p><i class="fas fa-download"></i> <?php echo translate('download_file_size', 'Size'); ?>: <?php
                echo file_exists($project_root . 'download/files/RichardsFunHouse_3.3.5a.zip') ?
                    round(filesize($project_root . 'download/files/RichardsFunHouse_3.3.5a.zip') / (1024 * 1024), 2) . ' MB' :
                    translate('download_size_unknown', 'Unknown');
                ?></p>
            <p><i class="fas fa-exclamation-triangle"></i>
                <?php echo translate('download_space_required', 'Requires 35GB free space'); ?></p>
        </div>

        <form method="get" action="<?php echo $base_path; ?>download/">
            <input type="hidden" name="file" value="RichardsFunHouse_3.3.5a.zip">
            <button type="submit" class="download-button">
                <i class="fas fa-dragon"></i> <?php echo translate('download_button', 'DOWNLOAD NOW'); ?>
            </button>
        </form>

        <form method="get" action="<?php echo $base_path; ?>download/" style="margin-top: 10px;">
            <input type="hidden" name="file" value="RichardsFunHouse_3.3.5a.torrent">
            <button type="submit" class="download-button" style="background-color: #2b79c2;">
                <i class="fas fa-seedling"></i> <?php echo translate('download_torrent_button', 'DOWNLOAD TORRENT'); ?>
            </button>
        </form>

        <div style="margin-top: 10px;">
            <a href="magnet:?xt=urn:btih:1aefd8bc0fb333815e84c452f6b78a7d027aa512&dn=RichardsFunHouse_3.3.5a.zip&tr=udp%3A%2F%2Ftracker.opentrackr.org%3A1337%2Fannounce&tr=udp%3A%2F%2Ftracker.internetwarriors.net%3A1337%2Fannounce&tr=udp%3A%2F%2Fopen.stealth.si%3A80%2Fannounce"
                class="download-button"
                style="background-color: #a62424; text-decoration: none; display: inline-block; width: 100%; box-sizing: border-box; text-align: center;">
                <i class="fas fa-magnet"></i> MAGNET LINK
            </a>
        </div>
    </div>
</div>

<?php include_once $project_root . 'includes/footer.php'; ?>
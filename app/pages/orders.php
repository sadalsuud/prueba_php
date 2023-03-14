<?php
require_once '../lib/core.lib.php';
require_once '../lib/common/header.php';
?>

<main class="container-fluid p-5 bg-light">
    <?php
    $GPC['type'] = 'list-orders';
    require_once './orders_async.php';
    ?>
</main>

<?php require_once '../lib/common/footer.php'; ?>

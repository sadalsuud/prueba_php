<?php
require_once '../lib/core.lib.php';
require_once '../lib/common/header.php';
?>

<script src="<?php echo DOMAIN_ROOT; ?>assets/js/orders.js"></script>

<main class="container-fluid p-5 bg-light">
    <?php 
    $GPC['type'] = 'list-orders'; 
    require_once './orders_async.php';
    ?>
</main>

<?php require_once '../lib/common/footer.php'; ?>

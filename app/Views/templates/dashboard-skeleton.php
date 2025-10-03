<!doctype html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="robots" content="noindex">

    <title>dashboard</title>

    <link rel="stylesheet" href="<?=base_url('resources/css/admin.css')?>">



</head>
<body>


<?= $this->include('templates/dashboard-sidebar') ?>

<main>


    <?= $this->include('templates/dashboard-header') ?>


    <div class="main-content">

        <?= $this->renderSection('content') ?>

    </div>

</main>


</body>

<!--javascript yang diperlukan untuk semua dashboard-->
<script src="<?=base_url("resources/js/dashboard.js")?>" defer></script>
<script src="<?=base_url("resources/js/modal.js")?>" defer></script>
<script src="<?=base_url("resources/js/axios.min.js")?>" defer></script>




</html>


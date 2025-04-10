<?php

include $this->resolve('partials/_header.php'); ?>

<!-- Start Main Content Area -->
<section class="container mx-auto mt-12 p-4 bg-white shadow-md border border-gray-200 rounded">
    <h1 class="text-3xl font-bold mb-4">About PHPiggy</h1>
    <p class="text-gray-700 mb-4">
        <?php
        echo e('<script>alert("Hello, World!");</script>'); ?>
    </p>
</section>
<!-- End Main Content Area -->


<?php
include $this->resolve('partials/_footer.php'); ?>

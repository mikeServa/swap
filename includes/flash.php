<?php

/* var_dump($_SESSION); */
if (!function_exists('set_flash')) {
    function set_flash($message, $type ='success')
    {
        $_SESSION['notification']['message'] = $message;
        $_SESSION['notification']['type'] = $type;
    }
}

if (isset($_SESSION['notification']['message'])) : ?>



    <div class="text-center m-5 m-auto alert alert-<?= $_SESSION['notification']['type'] ?> alert-dismissible fade show m-auto" role="alert" style="width: 70%; top:70px;">
        <!-- message -->
        <h4>

            <i class=" 
        <?php if ($_SESSION['notification']['type'] == 'success') echo 'bi bi-hand-thumbs-up' ?>
        <?php if ($_SESSION['notification']['type'] == 'danger') echo 'bi bi-emoji-frown-fill' ?>
        <?php if ($_SESSION['notification']['type'] == 'warning') echo 'bi-cone-striped' ?>
        <?php if ($_SESSION['notification']['type'] == 'info') echo 'bi bi-exclamation-lg' ?>
        
        
        "></i>
            <?= $_SESSION['notification']['message'] ?>
        </h4>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <!--Pour que le message ne s'affcihe qu'une seule fois  -->
    <?php $_SESSION['notification'] = []; ?>

<?php endif;

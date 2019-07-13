<body>
<main class="main">
    <div class="statistic-tmpl starpages-template">
        <div class="container">
            <section class="maincontent-starpages maincontent-users">
                <section class="title">
                    <h1 class="title__item legals-title">USERS</h1>
                </section>
                <div class="current-choice">
                    <span class="selected">photos</span>
                    <a href="#" class="drop" id="custom-dropdown">
                        <img src="/templates/C23/img/icons/arrow-down.svg" alt="select">
                    </a>
                </div>
                <div class="users-photos-wrap">
                <?php foreach ($users as $user): ?>
                    <?php if (!empty($user->user_photo)): ?>
                        <?php if ($user->photo_reject == true): ?>
                          <div class="photo-wrap-item testimonial-photo">
                        <?php else: ?>
                          <div class="photo-wrap-item delete-photo">
                        <?php endif; ?>
                         <img src="/users/<?= $user->id ?>/<?= $user->user_photo ?>" data-name="<?= $user->first_name ?>" data-id="<?= $user->id ?>" alt="photo-user" class="users-photo-item">
                        </div>
                        <?php endif ?>
                <?php endforeach; ?>
                    </div>
                    <ul class="pagination">
                        <?php for ($i=1;$i<=$count/20;$i+=1): ?>
                            <li><a href="?offset=<?= $i ?>" class="active-page"><?= $i ?></a></li>
                        <?php endfor; ?>
                    </ul>
            </section>
        </div>
    </div>
</main>
<!-- MODAL -->
<div class="popup-premium popup-photos">
    <div class="popup-premium-container">
        <button class="popup-premium-close"><img src="/templates/C23/img/icons/close.svg" alt="close"></button>
        <h4 class="photos-title">Christopher Nolan</h4>
                <img id="append-image" src="img/photo-user.png" alt="Christopher">
        <div class="btns-wrap">
            <button class="button-simple btn-testimonial" data-status="1">testimonial</button>
            <button class="button-simple btn-reject" data-status="0">REJECT</button>
        </div>
        <button class="button-orange" id="btn-save">save</button>
    </div>
</div>
<!-- ./MODAL -->
<?php
$this->registerJsFile('/templates/C23/js/app.js');
?>
</body>

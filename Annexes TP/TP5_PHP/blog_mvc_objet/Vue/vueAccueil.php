<?php $this->titre = "Mon Blog";  ?>

<?php foreach ($billets as $billet):
    ?>
    <article>
        <header>
            <a href="<?= "index.php?action=billet&id=" . $billet['id'] ?>">
                <h1 class="titreBillet">
                    <?= $billet['titre'] ?>
                </h1>
            </a>
            <!-- Sous chaque article on affihce un boutton de suppression -->
            <form action="index.php?action=supprimer" method="post">
                <input type="submit" value="Supprimer">
                <!-- On passe l'id en post avec un field caché -->
                <input type="hidden" name="id" value="<?= $billet['id'] ?>">
            </form>
            <time>
                <?= $billet['date'] ?>
            </time>
        </header>
        <p>
            <?= $billet['contenu'] ?>
        </p>
    </article>
    <hr />
<?php endforeach; ?>
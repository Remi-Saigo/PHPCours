<div class="container">
<div class="row justify-content-center">
<div class="col-12 col-md-10">

<?php
$article = null;
$commentaires = [];

if (isset($_GET['article']) && is_numeric($_GET['article'])) {
    $article = (int) $_GET['article'];
}

if (!$article) {
    echo "<p class='text-danger'>Aucun article sélectionné</p>";
    exit;
}

$sql = $dbh->prepare("
    SELECT subject, content, publishdate, images
    FROM Article
    WHERE id = :id
");
$sql->bindParam(':id', $article, PDO::PARAM_INT);
$sql->execute();
$row = $sql->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    echo "<p class='text-danger'>Cet article n'existe pas</p>";
    exit;
}

if (
    isset($_SESSION['role']) &&
    $_SESSION['role'] === 'Admin' &&
    isset($_POST['delete_comment']) &&
    isset($_POST['comment_id'])
) {
    $commentId = (int) $_POST['comment_id'];

    $sqlDelete = $dbh->prepare("
        DELETE FROM Commentaire
        WHERE id = :id
    ");
    $sqlDelete->bindParam(':id', $commentId, PDO::PARAM_INT);
    $sqlDelete->execute();

    echo "<div class='alert alert-success'>Commentaire supprimé</div>";
}

echo '<h1 class="mb-3">' . htmlspecialchars($row['subject']) . '</h1>';

echo '
<div class="card mb-4">
    <img src="images/' . htmlspecialchars($row['images']) . '" class="card-img-top" alt="">
    <div class="card-body">
        <p class="card-text">' . nl2br(htmlspecialchars($row['content'])) . '</p>
    </div>
    <div class="card-footer text-muted">
        ' . $row['publishdate'] . '
    </div>
</div>';

if (isset($_SESSION['login'], $_SESSION['id'], $_POST['Valider'])) {

    $Titre = trim($_POST['Titre'] ?? '');
    $Contenu = trim($_POST['Commentaire'] ?? '');

    if ($Titre !== '' && $Contenu !== '') {

        $DatePublication = date('Y-m-d H:i:s');
        $Modere = 0;

        $sqlcomment = $dbh->prepare("
            INSERT INTO Commentaire
            (Titre, Contenu, DatePublication, idarticle, iduser, Modere)
            VALUES
            (:Titre, :Contenu, :DatePublication, :idarticle, :iduser, :Modere)
        ");

        $sqlcomment->bindParam(':Titre', $Titre);
        $sqlcomment->bindParam(':Contenu', $Contenu);
        $sqlcomment->bindParam(':DatePublication', $DatePublication);
        $sqlcomment->bindParam(':idarticle', $article, PDO::PARAM_INT);
        $sqlcomment->bindParam(':iduser', $_SESSION['id'], PDO::PARAM_INT);
        $sqlcomment->bindParam(':Modere', $Modere, PDO::PARAM_INT);

        if ($sqlcomment->execute()) {
            echo "<div class='alert alert-success'>Commentaire posté</div>";
        } else {
            echo "<div class='alert alert-danger'>Erreur lors de l'ajout</div>";
        }
    } else {
        echo "<div class='alert alert-warning'>Tous les champs sont obligatoires</div>";
    }
}

if (isset($_SESSION['login'])) {
    echo '
    <button class="btn btn-outline-primary mb-3"
            data-bs-toggle="collapse"
            data-bs-target="#formCommentaire">
        Ajouter un commentaire
    </button>

    <div class="collapse" id="formCommentaire">
        <div class="card mb-4">
            <div class="card-body">
                <h5>Ajouter un commentaire</h5>

                <form method="post" action="index.php?page=LireArticle&article=' . $article . '">
                    <div class="mb-3">
                        <label class="form-label">Titre</label>
                        <input type="text" name="Titre" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Commentaire</label>
                        <textarea name="Commentaire" class="form-control" rows="4" required></textarea>
                    </div>

                    <button type="submit" name="Valider" class="btn btn-primary">
                        Envoyer
                    </button>
                </form>
            </div>
        </div>
    </div>';
} else {
    echo "<p><em>Connectez-vous pour commenter</em></p>";
}

$sqlsel = $dbh->prepare("
    SELECT
        c.id,
        c.Titre,
        c.Contenu,
        c.DatePublication,
        u.name,
        u.surname
    FROM Commentaire c
    JOIN User u ON c.iduser = u.id
    WHERE c.idarticle = :idarticle
    ORDER BY c.DatePublication DESC
");
$sqlsel->bindParam(':idarticle', $article, PDO::PARAM_INT);
$sqlsel->execute();
$commentaires = $sqlsel->fetchAll(PDO::FETCH_ASSOC);

echo "<h3 class='mt-4'>Commentaires</h3>";

if (!empty($commentaires)) {
    foreach ($commentaires as $comment) {
        echo '
        <div class="card mb-2">
            <div class="card-body">
                <h5>' . htmlspecialchars($comment['Titre']) . '</h5>
                <p>' . nl2br(htmlspecialchars($comment['Contenu'])) . '</p>

                <small class="text-muted">
                    Posté par <strong>' .
                    htmlspecialchars($comment['name']) . ' ' .
                    htmlspecialchars($comment['surname']) .
                    '</strong> le ' . $comment['DatePublication'] . '
                </small>';

        if (isset($_SESSION['role']) && $_SESSION['role'] === 'Admin') {
            echo '
            <form method="post" class="mt-2"
                  onsubmit="return confirm(\'Supprimer ce commentaire ?\')">
                <input type="hidden" name="comment_id" value="' . $comment['id'] . '">
                <button type="submit"
                        name="delete_comment"
                        class="btn btn-sm btn-danger">
                    Supprimer
                </button>
            </form>';
        }

        echo '
            </div>
        </div>';
    }
} else {
    echo "<p>Aucun commentaire pour le moment</p>";
}
?>

</div>

<div class="col-12 col-md-4 text-center">
    <strong>PUB</strong>
</div>

</div>
</div>

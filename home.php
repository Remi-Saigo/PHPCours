<div class="container">
<div class="row justify-content-center">
<div class="col-12 col-md-10">
<h1>MIAOUUUUUUU</h1>
<div class="row row-cols-1 row-cols-md-4 g-4">
<?php
$sql = 'SELECT subject, content, publishdate, images, id FROM Article ORDER BY publishdate desc';
foreach ($dbh->query($sql) as $row) {
  echo '
  <div class="col d-flex justify-content-center">
    <div class="card" style="width: 18rem;">
      <img src="images/' . $row['images'] . '" class="card-img-top" alt="">
      <div class="card-body text-center">
        <h5 class="card-title">' . htmlspecialchars($row['subject']) . '</h5>
        <p class="card-text">' . mb_substr($row['content'], 0, 100) . '...</p>
        <a class="btn btn-outline-primary"
           href="index.php?page=LireArticle&article=' . $row['id'] . '">
           Lire la suite
        </a>
      </div>
      <div class="card-footer text-center">
        ' . $row['publishdate'] . '
      </div>
    </div>
  </div>';
}


?>
</div>
</div>
</div>
</div>
</div>
</div>
<h1 class = "text-danger text-center">Contact</h1>
<h2 class = "text-dark text-center">adressemaildecontact@gmail.com</h2>
<h2 class = "text-dark text-center">12 rue des Lilas </h2>
<p>Dijon</p>
<h2 class = "text-dark text-center">Remouille Proyouille</h2>
<?php
if (isset($_POST["Valider"])) {
    //var_dump($_POST);
    $emailC = $_POST["AdresseMailC"];
    $subjectC = htmlentities($_POST["SujetC"]);
    $contenuC = htmlentities(nl2br($_POST["ContenuC"]));

    if (strlen($subjectC) > 50) {
        echo 'diminuez la taille de votre sujet';
        $validsubject = false;
    } else {
        $validsubject = true;
    }

    if ($validsubjec = true || !empty($contenuC)) {

        $publishdate = date("Y-m-d H:i:s");
        $sql = $dbh->prepare("INSERT INTO Contact(`subject`, `email`, `content` ) VALUES (:subject, :email, :content)");
        $sql->bindParam(':subject', $subjectC, PDO::PARAM_STR);
        $sql->bindParam(':content', $contenuC, PDO::PARAM_STR);
        $sql->bindParam(':email', $emailC, PDO::PARAM_STR);
        $r = $sql->execute();
        if ($r) {
            echo "Message Posté";
        } else {
            echo "Echec de L'envoi";
        }
    }
}
?>

<form action="index.php?page=contact" method="post">
  <h1 class = "text-danger text-center">Nous Envoyer Un Message</h1>
  <div>
      <label for="exampleInputEmail1" class="form-label mt-4">Votre Adresse Mail</label>
      <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter Email" name="AdresseMailC">
    </div>
    <div>
      <label for="exampleInputSubject" class="form-label mt-4">Subject</label>
      <input type="text" class="form-control" id="exampleInputSubject" aria-describedby="SubjectHelp" placeholder="Enter Subject" name="SujetC">
    </div>
    <div>
      <label for="exampleInputContent" class="form-label mt-4">Contenu</label>
      <textarea type="text" autocomplete="off" class="form-control" id="exampleContent" aria-describedby="ContentHelp" placeholder="Enter Message" name="ContenuC" rows="20" cols="30"></textarea>
    </div>
    <div>
      <button name="Valider" type="submit" class="btn btn-primary m-4">Envoyer</button>
    </div>
</form>
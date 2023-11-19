<?php
    session_start();

?>

<style>
    body
    {
        text-align: center;
    }
</style>

<body background="https://123cartes.com/wp-content/uploads/2016/05/carte-joyeux-anniversaire-confettis.jpg" style="background-size: cover; background-repeat: no-repeat; background-position: center center;">
<form method="POST" action="jeu.php">

    <label for="debut"><span style="background-color: white;"> Entrez le nom des 2 joueurs : </span></label>

<?php
    if(isset($_COOKIE['j1']) && isset($_COOKIE['j2'])) // pour remettre le nom des joueurs
    {
        echo '<input type="text" name="j1" id="j1" placeholder="Joueur 1" value='.$_COOKIE['j1'].'>';
        echo '<input type="text" name="j2" id="j2" placeholder="Joueur 2" value='.$_COOKIE['j2'].'>';
    }
    else
    {
        echo '<input type="text" name="j1" id="j1" placeholder="Joueur 1" value="">';
        echo '<input type="text" name="j2" id="j2" placeholder="Joueur 2" value="">';
    }
?>

    <br><br>
    <label><span style="background-color: white;">Couleur du joueur 1 : </span></label>
    <input type="radio" name="c1" id="c1" placeholder="Couleur J1" value="Jaune" checked=true>
    <label for="Jaune"><span style="background-color: white;">Doré</span></label>
    <input type="radio" name="c1" id="c1" placeholder="Couleur J1" value="Rouge">
    <label for="Rouge"><span style="background-color: white;">Écarlate</span></label><br>
    <label><span style="background-color: white;">Le joueur 2 sera l'autre couleur ;) </span></label><br>
    <br>
    <label><span style="background-color: white;">Hauteur :</span> </label>
    <input type="number" name="haut" id="haut" placeholder="Hauteur" value=6>
    <label><span style="background-color: white;">Largeur :</span> </label>
    <input type="number" name="larg" id="larg" placeholder="Largeur" value=7>
    <br><br>
    <button name="start" type="submit"><img src="IMAGES/OK.png"></button>

</form>

<br><br>
<iframe width="560" height="315" src="https://www.youtube.com/embed/BKg0qn65f2Y?autoplay=1" frameborder="0" allowfullscreen></iframe>
</body>
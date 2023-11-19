<?php

    session_start();

    // vérifier qu'une partie existe, si les joueurs et le plateau sont existants, on les charge
    if (isset($_POST['j1']) && !empty($_POST['j1']) && isset($_SESSION['j1']) && !empty($_SESSION['j1']))
    {
        if($_SESSION['j1']!=$_POST['j1'] || $_SESSION['j2']!=$_POST['j2'])
        {
            session_unset();
            session_destroy();
            session_start();
        }

        if(isset($_SESSION['plateau']) && !empty($_SESSION['plateau']))
        {
            if(count($_SESSION['plateau'])!=$_POST['haut'] || count($_SESSION['plateau'][0])!=$_POST['larg'])
            {
                session_unset();
                session_destroy();
                session_start();
            }
        }
    }

?>

<style>
    button
    {
        border: none;
        background-color: transparent;
    }

    body
    {
        text-align: center;
    }
</style>

<body background="https://img.freepik.com/premium-photo/white-wall-clean-cement-background-textured-blank-copy-space_24076-674.jpg?w=2000" style="background-size: cover; background-repeat: no-repeat; background-position: center center;">


<?php
    
    if(isset($_SESSION['plateau'])) // pour lancer le jingle de démarrage
    {}
    
    else echo "<audio autoplay><source src='SFX/START.wav' type='audio/wav'></audio>";

    $Tio_Salamanca="Ding ding ding ding"; // allez regarder Breaking Bad ;)

    $vide="Vide"; // au cas où j'ai décidé de changer les noms
    $jaune="Jaune"; // peut facilement changer les couleurs en mettant d'autre .png et les couleurs
    $rouge="Rouge";

    if (isset($_SESSION['cur']) && !empty($_SESSION['cur'])) // récupère le joueur courant
        $cur=$_SESSION['cur'];

    else $cur=1; // le joueur dont c'est son tour

    if (isset($_POST['j1']) && !empty($_POST['j1'])) // même principe que pour le cur
    {
        $j1 = $_POST['j1'];
        $_SESSION['j1'] = $j1;
        setcookie("j1", $j1, time()+86400, null, null, false, true);
    }
    else if(isset($_SESSION['j1']) && !empty($_SESSION['j1'])) // etc...
        $j1=$_SESSION['j1'];

    else
    {
        $j1="J1";
        $_SESSION['j1'] = $j1;
        setcookie("j1", $j1, time()+86400, null, null, false, true);
    }

    if (isset($_POST['j2']) && !empty($_POST['j2']))
    {
        $j2 = $_POST['j2'];
        $_SESSION['j2'] = $j2;
        setcookie("j2", $j2, time()+86400, null, null, false, true);
    }

    else if(isset($_SESSION['j2']) && !empty($_SESSION['j2']))
        $j2=$_SESSION['j2'];

    else
    {
        $j2="J2";
        $_SESSION['j2'] = $j2;
        setcookie("j2", $j2, time()+86400, null, null, false, true);
    }

    if(isset($_POST['c1']) && !empty($_POST['c1'])) // un commentaire
    {
        if($_POST['c1']=="Jaune")
        {
            $_SESSION['c1']=$c1="Jaune";
            $_SESSION['c2']=$c2="Rouge";
        }
        else
        {
            $_SESSION['c2']=$c2="Jaune";
            $_SESSION['c1']=$c1="Rouge";
        }
    }

    else
    {
        $c1=$_SESSION['c1'];
        $c2=$_SESSION['c2'];
    }

    if (isset($_SESSION['plateau']) && !empty($_SESSION['plateau'])) // récupère le tableau
        $plateau = $_SESSION['plateau'];

    else 
    {
        $plateau;
        initGame(); // sinon on le créer
    }

    function initGame() // sert à localement récupérer les variables passés dans le form
    {
        // vérifier l'intégrité des données entrées dans le formulaire
        if($_POST['larg']!=7 && $_POST['haut']!=6 && $_POST['larg']>=4 && $_POST['haut']>=4)
        {
            $GLOBALS['plateau']=array();
            for($i=0; $i<$_POST['haut']; $i++)
            {
                for($j=0; $j<$_POST['larg']; $j++)
                    $GLOBALS['plateau'][$i][$j]=$GLOBALS['vide'];
            }
        }

        else
        {
            $GLOBALS['plateau']=array();
            for($i=0; $i<6; $i++)
            {
                for($j=0; $j<7; $j++)
                    $GLOBALS['plateau'][$i][$j]=$GLOBALS['vide'];
            }
        }
        $_SESSION['plateau']=$GLOBALS['plateau'];
    }

    function afficheIndex() // le bouton pour revenir à l'index, car il n'y a pas d'AJAX
    {
        echo '<form method=POST action="index.php"><strong><button name="retour" type="submit" value="retour"><img src="IMAGES/RESET.png"</strong></button></form>';
        echo '<br><br>';
    }

    function affichePlateau() // même moi je ne sais pas ce que ça fait
    {
        echo "<form method='POST' action='jeu.php'>"; // on utilise un form pour que les boutons envoient le num de la ligne à traiter
        for($i=count($_SESSION['plateau'])-1; $i>=0; $i--)
        {
            echo "<table>";
            for($j=0; $j<count($_SESSION['plateau'][0]); $j++)
            {
                $act=$_SESSION['plateau'][$i][$j];
                $jw=$j+1;
                // on crée des boutons qui ont tous le même nom, mais leurs valeurs correspondent à la colonne
                // du bouton, utile pour savoir où placer le jeton
                echo "<button name='cel' type='submit' style='display: inline-block; border: none; padding: 0; margin: 0;' value='$jw'><img src='IMAGES/$act.png'></button>";
            }
            echo '</table>';
        }
        echo '</form>';
    }

    function afficheResultat() // même moi je ne sais pas ce que ça fait, oui c'est du copier-coller
    {
        for($i=count($_SESSION['plateau'])-1; $i>=0; $i--)
        {
            echo "<table>";
            for($j=0; $j<count($_SESSION['plateau'][0]); $j++)
            {
                $act=$_SESSION['plateau'][$i][$j];
                $jw=$j+1;
                // on affiche le plateau mais sans rendre l'interraction possible entre les joueurs et le jeu
                echo "<img name='cel' type='submit' style='display: inline-block; border: none; padding: 0; margin: 0;' src='IMAGES/$act.png'>";
            }
            echo '</table>';
        }
    }

    function afficheNom() // tout est dans le nom, haha
    {
        $joueur="";

        if($GLOBALS['cur']==1)
            $joueur=$GLOBALS['j1'];

        else $joueur=$GLOBALS['j2'];
        
        echo "<label>C'est au tour de : </label><strong>$joueur</strong><br><br>";
    }

    function youWin() // La partie de gagnant le détermine - a dit Yoda
    {
        $win=null; // renvoie nul si il n'y a pas de gagnant
        for($i=0; $i<count($_SESSION['plateau']); $i++)
        {
            for($j=0; $j<count($_SESSION['plateau'][0]); $j++)
            {
                // toutes les conditions pour vérifier s'il y a un alignement, RIP la complexité
                if($_SESSION['plateau'][$i][$j]!=$GLOBALS['vide'])
                {
                    if($j<=count($_SESSION['plateau'][0])-4)
                    {
                        if  (   
                                $_SESSION['plateau'][$i][$j]==$_SESSION['plateau'][$i][$j+1] &&
                                $_SESSION['plateau'][$i][$j]==$_SESSION['plateau'][$i][$j+2] &&
                                $_SESSION['plateau'][$i][$j]==$_SESSION['plateau'][$i][$j+3]
                            )
                            $win=$_SESSION['plateau'][$i][$j];

                    }

                    if($i<=count($_SESSION['plateau'])-4)
                    {
                        if  (
                                $_SESSION['plateau'][$i][$j]==$_SESSION['plateau'][$i+1][$j] &&
                                $_SESSION['plateau'][$i][$j]==$_SESSION['plateau'][$i+2][$j] &&
                                $_SESSION['plateau'][$i][$j]==$_SESSION['plateau'][$i+3][$j]
                            )
                            $win=$_SESSION['plateau'][$i][$j];
                    }

                    if($i<=count($_SESSION['plateau'])-4 && $j<=count($_SESSION['plateau'][0])-4)
                    {
                        if  (
                                $_SESSION['plateau'][$i][$j]==$_SESSION['plateau'][$i+1][$j+1] &&
                                $_SESSION['plateau'][$i][$j]==$_SESSION['plateau'][$i+2][$j+2] &&
                                $_SESSION['plateau'][$i][$j]==$_SESSION['plateau'][$i+3][$j+3]
                            )
                            $win=$_SESSION['plateau'][$i][$j];
                    }

                    if($i>=3 && $j<=count($_SESSION['plateau'][0])-4)
                    {
                        if  (
                                $_SESSION['plateau'][$i][$j]==$_SESSION['plateau'][$i-1][$j+1] &&
                                $_SESSION['plateau'][$i][$j]==$_SESSION['plateau'][$i-2][$j+2] &&
                                $_SESSION['plateau'][$i][$j]==$_SESSION['plateau'][$i-3][$j+3]
                            )
                            $win=$_SESSION['plateau'][$i][$j];
                    }  
                }
            }
        }
        return $win;
    }

    function debug($truc)
    {   // le debug le plus fainéant du monde, flemme d'écrire var_dump C: (smiley qui rigole)
        var_dump($truc);
    }

    if(isset($_POST["cel"]) && !empty($_POST["cel"]))
    {
        // $file = fopen("00_log.txt", "w");
        // fwrite($file, $_POST["cel"]); c'était le debug pour voir si le numéro de ligne cliqué était le bon

        $col=$_POST["cel"]-1; // il a fallu décaler de 1, car value='0' ne semblait pas marcher

        $place=count($GLOBALS['plateau'])-1;

        while($place>=0 && $GLOBALS['plateau'][$place][$col]==$GLOBALS['vide'])
            $place--;

        if($place==count($GLOBALS['plateau'])-1){/* ne rien faire */}

        else
        {
            echo "<audio autoplay><source src='SFX/JETON.wav' type='audio/wav'></audio>";
            if($GLOBALS['cur']==1) // le move est réussi, on change de joueur
            {
                $GLOBALS['cur']=2;
                $_SESSION['plateau'][$place+1][$col]=$GLOBALS['c1']; // on met, à la bonne case, la couleur du joueur
            }
                    
            else
            {
                $GLOBALS['cur']=1;
                $_SESSION['plateau'][$place+1][$col]=$GLOBALS['c2']; // on met, à la bonne case, la couleur du joueur encore
            }
        }
    }
    unset($_POST); // au cas où pour ne pas avoir de POST des boutons, mais semble inutile
    $_SESSION['cur']=$GLOBALS['cur']; // stocker dans la SESSION le nouveau joueur qui doit jouer
?>

<?php

    afficheIndex();
    function phpToSql()
    {
        $co=mysqli_connect("localhost", "root", "", "Puissance_4");

        if (!isset($co))
            exit("ÉCHEC : ".mysqli_connect_error());

        $clePrimaire=rand();

        $j1=$_SESSION['j1'];
        $j2=$_SESSION['j2'];
        $w=$_SESSION['cur']==1 ? $j2 : $j1;
        $bleauta=serialize($_SESSION['plateau']);

        $sql="INSERT INTO partie(Identifiant, J1, J2, Gagnant, Plateau) VALUES ('$clePrimaire', '$j1', '$j2', '$w', '$bleauta')";

        if (mysqli_query($co, $sql))
            echo "<br><br><strong>Enregistrement réussi dans la base de données !</strong>";

        else exit("ÉCHEC : ".mysqli_error($co));

        mysqli_close($co);
    }

    if(youWin()!=null)
    {
        $joueur=$_SESSION['cur']==1 ? $_SESSION['j2'] : $_SESSION['j1'];
        echo "<strong>$joueur a gagné.</strong><br><br>";

        echo "<audio autoplay><source src='SFX/WIN.wav' type='audio/wav'></audio>";
        afficheResultat();

        $message=$_SESSION['cur']==1 ? $_SESSION['j2'] : $_SESSION['j1'];
        echo "<script>alert('$message a gagné !!!');</script>"; // output the alert message as HTML code

        phpToSql();
        session_unset();
        session_destroy();
    }
    
    else
    {
        afficheNom();
        affichePlateau();
    }

?>

</body>
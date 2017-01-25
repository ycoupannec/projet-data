// le lien pour la solution : https://openclassrooms.com/courses/creer-un-moteur-de-recherche-avec-sphinx-et-php
// C'est un exemple, il faut installer Sphinx avant et le configurer j'ai pas encore réussi à le faire fonctionner
<?php
    require 'api/sphinxapi.php';

    // Le quatrième paramètre sert à dire à MySQL que l'on va communiquer des données encodées en UTF-8
    $db = new PDO('mysql:host=localhost;dbname=newssdz', 'root', '', array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES \'UTF8\''));
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $sphinx = new SphinxClient;

    $sphinx->SetServer('localhost', 3312);
    $sphinx->SetConnectTimeout(1);

    $resultat = $sphinx->Query('navigateur', 'news');

    $ids = array_keys($resultat['matches']);
    $query = $db->query('SELECT news.titre, categories.nom AS cat_nom FROM news LEFT JOIN categories ON news.categorie = categories.id WHERE news.id IN('.implode(',', $ids).')');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr">
    <head>
        <meta http-equiv="Content-type" content="text/html; charset=UTF-8" />
        <title>Premier essai de l'API PHP de Sphinx</title>
    </head>

    <body>
        <p><?php echo $res['total_found']; ?> résultats ont été trouvés en <?php echo $res['time']; ?>s.</p>
        <table style="width:100%; text-align:center; margin: auto;">
            <tr><th>Titre</th><th>Catégorie</th></tr>
<?php
    while ($news = $query->fetch(PDO::FETCH_ASSOC))
    {
        echo '<tr><td>', $news['titre'], '</td><td>', $news['cat_nom'], '</td></tr>', "\n";
    }
?>
	    </table>
    </body>
</html>

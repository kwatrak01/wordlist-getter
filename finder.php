<form action="finder.php" method="get">
    <input type="text" name="letter" id="letter" placeholder="Na jaką literę chcesz słówka?" value="<?= isset($_GET['letter']) ? $_GET['letter'] : '' ?>">
    <input type="number" name="page" id="page" placeholder="Z której strony chcesz słówka?" min="1" value="<?= isset($_GET['page']) ? $_GET['page'] : '' ?>">
    <button type="submit">Szukaj</button>
</form>
<?php

require_once('simple_html_dom.php');

if (isset($_GET['letter']) && isset($_GET['page'])) {
    $html = file_get_html("https://ling.pl/slownik/polsko-angielski/slowa/{$_GET['letter']}/{$_GET['page']}");

    $result = $html->find("div[class=col-md-4] > a[href*=/slownik/polsko-angielski/]");

    $i = 0;
    foreach ($result as $r) {

        echo $r->plaintext . "<br>";

        $i++;
    }

    $pagination = $html->find("ul[class=pagination] > li");
    echo "<ul>";
    foreach ($pagination as $p) {
        $next = $p->first_child()->plaintext;

        $p->first_child()->href = "/finder.php?letter={$_GET['letter']}&page={$next}";
        echo $p;
    }
    echo "</ul>";
}
?>

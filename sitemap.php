<?php
include './php/db/settings.php';
include './php/db/checkedDb.php';

$querySelectUser = $db->prepare('select * from `users`');
				$querySelectUser->execute();
				$getResultListUser = $querySelectUser->get_result();
                $numRows = $getResultListUser->num_rows;

header("Content-Type: text/xml;charset=utf-8");  
$date = date('c'); 

echo '<?xml version="1.0" encoding="UTF-8"?>'; 
echo '<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';  

echo '<url>';  
echo '<loc>https://scn-ural.ru</loc>';  
echo '<lastmod>'.$date.'</lastmod>';    
echo '<changefreq>monthly</changefreq>'; 
echo '<priority>0.8</priority>'; 
echo '</url>';  

if ($numRows > 0) {
while ($result = mysqli_fetch_array($getResultListUser)) {
    echo '<url>';  
        echo '<loc>https://scn-ural.ru/users/id'.$result['id'].'/sitemap.php</loc>';  
        echo '<lastmod>'.$date.'</lastmod>';
        echo '<changefreq>monthly</changefreq>'; 
        echo '<priority>0.8</priority>'; 
    echo '</url>';  
}
}

echo '</urlset>';  
?>

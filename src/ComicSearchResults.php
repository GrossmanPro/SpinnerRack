<?php

require_once 'Setup.php';

$keyword = filter_input(INPUT_POST, 'keyword', FILTER_SANITIZE_SPECIAL_CHARS);

$sql = "SELECT * FROM ComicSearchView "
        . "WHERE Story LIKE ? "
        . "OR Notes LIKE ? "
        . "OR Name LIKE ? "
        . "OR Publisher LIKE ?";
$params = array_fill(0, 4, '%' . $keyword . '%');
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

//Array ( 
//[0] => Array ( [Id] => 177 [Name] => Blargh [TitleId] => 149 [Issue] => 1 [Year] => 1970 [Month] => 1 [Story] => The Coming of Blargh [Notes] => [Stars] => 1 [HardCopy] => 1 [WantList] => 0 [Publisher] => Dark Horse [PublisherId] => 198 [Volume] => 1 ) 
//[1] => Array ( [Id] => 211 [Name] => Blargh [TitleId] => 149 [Issue] => 2 [Year] => 1980 [Month] => 6 [Story] => Blargh returns [Notes] => He returns. Or it. Or she? [Stars] => 5 [HardCopy] => 0 [WantList] => 0 [Publisher] => Dark Horse [PublisherId] => 198 [Volume] => 1 ) 
//[2] => Array ( [Id] => 214 [Name] => Blargh [TitleId] => 149 [Issue] => 3 [Year] => 1988 [Month] => 6 [Story] => Blargh 3 story [Notes] => blargh 3 notes [Stars] => 3 [HardCopy] => 1 [WantList] => 1 [Publisher] => Dark Horse [PublisherId] => 198 [Volume] => 1 ) 
//[3] => Array ( [Id] => 218 [Name] => Blargh [TitleId] => 149 [Issue] => 100 [Year] => 1988 [Month] => 8 [Story] => 100 Blarghs is 100 Too Many! [Notes] => Not very special anniversary issue [Stars] => 1 [HardCopy] => 1 [WantList] => 0 [Publisher] => Dark Horse [PublisherId] => 198 [Volume] => 1 ) )

print drawHeader('Results');

?>
<div class="container p-4">    
    <p class="h4">Results</p>
    <table id="searchResults" class="table table-sm table-bordered">
        <thead>
        <th>&nbsp;</th>
        <th>Title</th>
        <th>Vol</th>
        <th>Issue</th>
        <th>Story</th>
        <th>Rating</th>
        </thead>
        <tbody>
            <?php
            $rows = '';
            foreach ($results as $r) {
                $rows .= '<tr>';
                $rows .= '<td>&nbsp;</td>';
                $rows .= '<td>' . $r['Name'] . '</td>';
                $rows .= '<td>' . $r['Volume'] . '</td>';
                $rows .= '<td>' . $r['Issue'] . '</td>';
                $rows .= '<td>' . $r['Story'] . '</td>';
                $rows .= '<td>' . $r['Stars'] . '</td>';
                $rows .= '</tr>';
            }
            
            print $rows;
            ?>
        </tbody>
    </table>
</div>
<?php
print drawFooter(array('ComicSearchResults-01.js'));

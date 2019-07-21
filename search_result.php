<?php
// Include the database config file
require_once 'dbConfig.php';

// If the search form is submitted
$searchKeyword = $queryCondition = '';
if(isset($_POST['searchSubmit'])){
    $searchKeyword = $_POST['keyword'];
    if(!empty($searchKeyword)){
		$wordsAry = explode(" ", $searchKeyword);
		$wordsCount = count($wordsAry);
		$queryCondition = " WHERE ";
		for($i=0;$i<$wordsCount;$i++) {
			$queryCondition .= "title LIKE '%" . $wordsAry[$i] . "%' OR content LIKE '%" . $wordsAry[$i] . "%'";
			if($i!=$wordsCount-1) {
				$queryCondition .= " OR ";
			}
		}
	
        
    }
}

// Get matched records from the database
$result = $db->query("SELECT * FROM posts $queryCondition ORDER BY id DESC");

// Highlight words in text
function highlight_keywords($text, $keyword) {
		$wordsArray = explode(" ", $keyword);
		$wordsCount = count($wordsArray);
		
		for($i=0;$i<$wordsCount;$i++) {
			$highlighted_text = "<span style='font-weight:bold;background-color: #F9F902;'>$wordsArray[$i]</span>";
			$text = str_ireplace($wordsArray[$i], $highlighted_text, $text);
		}

		return $text;
	}

if($result->num_rows > 0){
    while($row = $result->fetch_assoc()){
        $title = !empty($searchKeyword)?highlight_keywords($row['title'], $searchKeyword):$row['title'];
        $content = !empty($searchKeyword)?highlight_keywords($row['content'], $searchKeyword):$row['content'];


?>
<div class="list-item">
    <h4><?php echo $title; ?></h4>
    <p><?php echo $content; ?></p>
</div>
<?php } }else{ ?>
<p>No post(s) found...</p>
<?php } ?>
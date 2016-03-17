<?php
class EnglishDefinitions{
	private
		$word,
		$baseDefinitions,
		$baseTranslation,
		$definitions = array(),
		$example,
		$translation,
		$lesson,
		$book;
		
	public function EnglishDefinitions($lesson, $book){
		global $configs;
		$this->baseDefinitions = $configs['baseDefinitions'];
		$this->baseTranslation = $configs['baseTranslation'];
		$this->lesson = $lesson;
		$this->book   = $book;
		$this->showTitleAll();
	}

	private function goTranslate($server){
		$this->translation = 'carro';
	}
	
	private function goDefinitions(){
		$this->definitions[1] = 'Tesde de definição 1 Tesde de definição 1 Tesde de definição 1 Tesde de definição 1 Tesde de definição 1 Tesde de definição 1 Tesde de definição 1 Tesde de definição 1 Tesde de definição 1 Tesde de definição 1 Tesde de definição 1 Tesde de definição 1 Tesde de definição 1 ';
		$this->definitions[2] = 'Tesde de definição 2';
		$this->definitions[3] = 'Tesde de definição 3';
	}
	
	private function goExample(){
		$this->example = 'to fill a cupboard with books; The news filled him with joy.';
	}
	
	private function openDivBox(){
		echo "<div id=\"boxWord\">";
	}
	
	private function closeDivBox(){
		echo "</div>";
	}
	
	private function showHeader(){
		echo "<div id=\"title\">";
		echo strtoupper($this->word);
		echo "</div>";
	}
	
	private function showDefinitions(){
		global $configs;
		$this->goDefinitions();
		echo "<div id=\"definitions\">";
		echo "<OL>";
		for($i=1; $i<=$configs['definitionsNum']; $i++){
			if(!empty($this->definitions[$i])){
				echo "<LI>".$this->definitions[$i]."</LI>";
			}
		}
		echo "</OL>";
		echo "</div>";
	}
	
	private function showTranslate(){
		$this->goTranslate('google');
		echo "<div id=\"translateTitle\">(";
		echo $this->translation;
		echo ")</div>";
	}
	
	private function showExample(){
		$this->goExample();
		echo "<div id=\"example\">";
			echo "<div id=\"exampleTitle\">";
			echo "Example: ";
			echo "</div>";
			echo "<p>";
			echo $this->example;
			echo "</p>";
		echo "</div>";
	}
	
	private function showTitleAll(){
		$date = date('d/m/y');
		echo "<div id=\"titleAll\">";
		echo "Book ".$this->book." Lesson ".$this->lesson." - $date";
		echo "</div>";
	}
	
	private function showTitleVerbs(){
		echo "<div id=\"titleSectionVerbs\">";
		echo "Verbs";
		echo "</div>";
	}
	
	private function showTitleVocabulary(){
		echo "<div id=\"titleSectionVocabulary\">";
		echo "Vocabulary";
		echo "</div>";
	}
	
	private function showTitleExpressions(){
		echo "<div id=\"titleSectionExpressions\">";
		echo "Expressions";
		echo "</div>";
	}
	
	private function transformArray($string){
		$array = explode(';', $string);
		$i = 0;
		foreach($array as $item){
			$item = str_replace('\\', '', $item);
			if(eregi(' ', $item)){
				$item = str_replace(' ', '%20', $item);
			}
			$novoArray[$i++] = $item;
		}
		return array_diff($novoArray, array(''));
	}
	
	public function showVocabulary($vocabulary){
		$vocabulary = $this->transformArray($vocabulary);
		$this->showTitleVocabulary();
		$this->openDivBox();
		echo "<div id=\"vocabulary\">";
		echo "<OL>";
			foreach($vocabulary as $itemVocabulary){
				$this->translateThisWord($itemVocabulary, 'google');
				$this->defineThisWord($itemVocabulary);
			}
		echo "</OL>";
		echo "</div>";
		$this->closeDivBox();
	}
	
	public function showExpressions($expressions){
		$expressions = $this->transformArray($expressions);
		$this->showTitleExpressions();
		$this->openDivBox();
		echo "<div id=\"expressions\">";
		echo "<OL>";
			foreach($expressions as $expression){
				$this->translateThisWord($expression, 'google');
			}
		echo "</OL>";
		echo "</div>";
		$this->closeDivBox();
	}

	public function showVerbs($verbs){
		$verbs = $this->transformArray($verbs);
		$this->showTitleVerbs();
		foreach($verbs as $verb){
			$this->allAboultThisWord($verb);
		}
	}
	
	public function allAboultThisWord($word){
		$this->word = $word;
		if(eregi('%20', $this->word)){
			$this->word = str_replace('%20', ' ', $this->word);
		}
			$this->openDivBox();
			$this->showHeader();
			$this->showTranslate();
			$this->showDefinitions();
			$this->showExample();
		$this->closeDivBox();
	}
	
	public function translateThisWord($word, $server){
		$this->word = $word;
		$this->goTranslate($server);
		if(eregi('%20', $this->word)){
			$this->word = str_replace('%20', ' ', $this->word);
		}
		echo '<LI>&nbsp;&nbsp;<b>'.strtoupper($this->word).'</b> (<i>'.$this->translation."</i>)</LI>";
	}
	
	public function defineThisWord($word){
		$this->word = $word;
		$this->goDefinitions();
		if(eregi('%20', $this->word)){
			$this->word = str_replace('%20', ' ', $this->word);
		}
		echo '<div id="definitionWord">'.$this->definitions[1]."</div>";
	}
	
	public function saveHtml(){
		global $configs;
		$html = ob_get_flush();
		$html = str_replace('<link href="./css/ec.css" rel="stylesheet" type="text/css" />', '<link href="../css/ec.css" rel="stylesheet" type="text/css" />', $html);
		$url  = $configs['dirHtml'].'/lesson'.date('d-m');
		$urlCompleta = $url.'.html';
		$i    = 1;
		while(file_exists($urlCompleta)){
			$urlCompleta = $url.'_'.$i++.'.html';
		}
		$fp   = fopen($urlCompleta, 'w+');
		fputs($fp, $html);
		fclose($fp);
	}
}
?>
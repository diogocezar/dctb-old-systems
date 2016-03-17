<?php
/** 
* SpeceBraid
*
* Esta classe é responsavel gerar relatórios em PDF utilizando como base a classe FPDF
*
* @author xg0rd0 <xgordo@gmail.com> 
* @version 0.0.1
* @copyright Copyright © 2007
* @access public
* @package database
*/

class ReportPDF extends FPDF{

	/**
	* Atributos
	*/
	private 
		$cell_width,
		$cell_height,
		$size_cells,
		$font,
		$font_size,
		$decoration,
		
		$header_title,
		$header_font,
		$header_font_decoration,
		$header_font_size,
		$header_border,
		$header_width,
		$header_height,
		$header_space_bottom,
		$header_space_cell,
		
		$footer_title,
		$footer_font,
		$footer_font_decoration,
		$footer_font_size,
		$footer_border,
		$footer_width,
		$footer_height,
		$footer_space_bottom,
		$footer_space_cell,
		$footer_color;
		
	static
		$space_x;
		
	public
		$debug = -1;
		
	/**
	* Construtor
	* __start_ReportPDF()
	*/
	function __start_ReportPDF($title, $footer='Página', $font='Arial', $decoration='', $fontSize=10, $cellWidth=40, $cellHeight=5){
		$this->AliasNbPages();
		$this->Open();
		$this->chanceHeaderTitle($title);
		$this->chanceFooterTitle($footer);
		$this->AddPage();
		
		$this->setFont($font);
		$this->setDecoration($decoration);
		$this->setFont_size($fontSize);
		$this->setSpace_x(0);
		$this->setCell_width($cellWidth);
		$this->setCell_height($cellHeight);
		
		$this->SetFont($this->getFont(), $this->getDecoration(), $this->getFont_size());
	}
	
	function styleHeader($font='Arial', $decoration='B', $fontSize=10, $border=1, $width=100, $height=10, $spaceBottom=15, $spaceCell=45){
		$this->setHeader_font($font);
		$this->setHeader_font_decoration($decoration);
		$this->setHeader_font_size($fontSize);
		$this->setHeader_border($border);
		$this->setHeader_width($width);
		$this->setHeader_height($height);
		$this->setHeader_space_bottom($spaceBottom);
		$this->setHeader_space_cell($spaceCell);		
	}
	
	function styleFooter($font='Arial', $decoration='I', $fontSize=9, $border=0, $width=0, $height=10, $spaceCell=-15, $color=128){
		$this->setFooter_font($font);
		$this->setFooter_font_decoration($decoration);
		$this->setFooter_font_size($fontSize);
		$this->setFooter_border($border);
		$this->setFooter_width($width);
		$this->setFooter_height($height);
		$this->setFooter_space_cell($spaceCell);
		$this->setFooter_color($color);
	}
		
	function Header(){
		$header_title           = $this->getHeader_title();
		$header_font            = $this->getHeader_font();
		$header_font_decoration = $this->getHeader_font_decoration();
		$header_font_size       = $this->getHeader_font_size();
		$header_border          = $this->getHeader_border();
		$header_width           = $this->getHeader_width();
		$header_height          = $this->getHeader_height();
		$header_space_bottom    = $this->getHeader_space_bottom();
		$header_space_cell      = $this->getHeader_space_cell();

		$this->SetFont($header_font, $header_font_decoration, $header_font_size);
		$this->Cell($header_space_cell);
		$this->Cell($header_width,$header_height,utf8_decode($header_title),$header_border,0,'C');
		$this->Ln($header_space_bottom);
	}
	
	function Footer(){
		$footer_title           = $this->getFooter_title();
		$footer_font            = $this->getFooter_font();
		$footer_font_decoration = $this->getFooter_font_decoration();
		$footer_font_size       = $this->getFooter_font_size();
		$footer_border          = $this->getFooter_border();
		$footer_width           = $this->getFooter_width();
		$footer_height          = $this->getFooter_height();
		$footer_space_cell      = $this->getFooter_space_cell();
		$footer_color           = $this->getFooter_color();
		
		$this->SetY($footer_space_cell);
		$this->SetFont($footer_font,$footer_font_decoration,$footer_font_size);
		$this->SetTextColor($footer_color);
		$this->Cell($footer_width,$footer_height,utf8_decode($footer_title." ").$this->PageNo().'/{nb}',$footer_border,0,'C');
	}
	
	function chanceHeaderTitle($headerTitle){
		$this->header_title = $headerTitle;
	}
	
	function chanceFooterTitle($footerTitle){
		$this->footer_title = $footerTitle;
	}
	
	function printTitles($titles){
		if(is_array($titles)){
			$this->turnOnDecoration('B');
			$i = 0;
			foreach($titles as $key => $value){
				$this->makeCell(utf8_decode($key), $value);
				$this->size_cells[$i++] = $value;
			}
			$this->clearSpace();
			$this->turnOffDecoration();
		}
	}
	
	function printLines($line){
		if(is_array($line)){
			$this->ln();
			$i = 0;
			foreach($line as $value){
				$this->makeCell($value, $this->size_cells[$i++]);
			}
			$this->clearSpace();
		}
	}
	
	function makeCell($txt, $spaceText, $border = 1){
		$width   = $this->cell_width;
		$height  = $this->cell_height;
		$this->space_x = $this->space_x + $spaceText;
		$this->Cell($width, $height, $txt, $border);
		$this->SetX($this->space_x);
	}
	
	function clearSpace(){
		$this->space_x = 0;
	}
	
	function turnOnDecoration($decoration){
		$this->SetFont($this->getFont(), $decoration, $this->getFont_size());
	}
	
	function turnOffDecoration(){
		$this->SetFont($this->getFont(), '', $this->getFont_size());
	}
	
	function __call($metodo, $parametros){
		if (substr($metodo, 0, 3) == 'set') {
			$var = substr(strtolower(preg_replace('/([a-z])([A-Z])/', "$1_$2", $metodo)), 4);
			$this->$var = $parametros[0];
			if(empty($parametros[1])){
				$this->__toFillGeneric();
			}
		}
		elseif (substr($metodo, 0, 3) == 'get'){
			$var = substr(strtolower(preg_replace('/([a-z])([A-Z])/', "$1_$2", $metodo)), 4);
			return $this->$var;
		}
	}
}
?>
<?
/* *******************************************************************************************************
MODUL NAME 			: 
FILE NAME 			: excel.func.php
AUTHOR				: 
VERSION				: 1.0
MODIFICATION DOC	:
DESCRIPTION			: Functions to handle string operation
***************************************************************************************************** */
include_once("application/libraries/Classes/PHPExcel.php");
// $this->load->library('Classes/PHPExcel');

function StyleExcel($id)
{
	$style=array();
	if($id ==1)
	{
		//style default tengah
		$style = array(
			'borders' => array(
				'allborders' => array(

					'style' => PHPExcel_Style_Border::BORDER_THIN
				)				
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			)
		);
	}
	elseif($id ==2)
	{
		$style = array(
			'borders' => array(
				'allborders' => array(
					'style' => PHPExcel_Style_Border::BORDER_THIN,
					'type' => PHPExcel_Style_Fill::FILL_SOLID,
					'color' => array(
						'rgb' => 'FFFFFF'
					)	
				)

			),
			'fill' => array(
				'type' => PHPExcel_Style_Fill::FILL_SOLID,
				'color' => array('rgb' => '335593')
			),
			'font'  => array(
				'color' => array('rgb' => 'FFFFFF')
				
			),
			'alignment' => array(
				'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
			)		
		);
	}

    return $style;
}

 

?>